<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');


/*
|--------------------------------------------------------------------------
| LOGIN, REGISTER, DAN LOGOUT
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Halaman login
   Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

    // Proses login
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    // Halaman register
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    // Proses register
    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');

});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| KATEGORI
|--------------------------------------------------------------------------
*/

Route::get('/kategori', [KategoriController::class, 'index'])
    ->name('kategori.index');

Route::get('/kategori/{kategori}', [KategoriController::class, 'show'])
    ->name('kategori.show');


/*
|--------------------------------------------------------------------------
| DASHBOARD DAN FITUR PENGGUNA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFIL PENGGUNA
    |--------------------------------------------------------------------------
    */

    Route::get('/profil', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::put('/profil', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');

  // Dashboard Pengunjung
Route::get('/dashboard/pengunjung', function () {
    return view('dashboard.pengunjung');
})
->middleware(['auth', 'role:pengunjung'])  
->name('dashboard.pengunjung');

// Dashboard Pengelola
Route::get('/dashboard/pengelola', function () {
    return view('dashboard.pengelola');
})
->middleware(['auth', 'role:pengelola'])  
->name('dashboard.pengelola');

// Dashboard Admin
Route::get('/dashboard/admin', function () {
    return view('dashboard.admin');
})
->middleware(['auth', 'role:admin']) 
->name('dashboard.admin');


    /*
    |--------------------------------------------------------------------------
    | DESTINASI - DAPAT DIAKSES PENGGUNA LOGIN
    |--------------------------------------------------------------------------
    */

    Route::get('/destinasi', [DestinasiController::class, 'index'])
        ->name('destinasi.index');

        Route::middleware('role:pengelola,admin')->group(function () {

        Route::get('/destinasi/create', [DestinasiController::class, 'create'])
            ->name('destinasi.create');

        Route::post('/destinasi', [DestinasiController::class, 'store'])
            ->name('destinasi.store');

        Route::get('/destinasi/{destinasi}/edit', [DestinasiController::class, 'edit'])
            ->name('destinasi.edit');

        Route::put('/destinasi/{destinasi}', [DestinasiController::class, 'update'])
            ->name('destinasi.update');

        Route::delete('/destinasi/{destinasi}', [DestinasiController::class, 'destroy'])
            ->name('destinasi.destroy');
    });

    
// Manajemen akun pengguna khusus Admin
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/users', [UserManagementController::class, 'index'])
        ->name('users.index');

    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])
        ->name('users.edit');

    Route::put('/users/{user}', [UserManagementController::class, 'update'])
        ->name('users.update');

    Route::patch('/users/{user}/status', [UserManagementController::class, 'toggleStatus'])
        ->name('users.toggle-status');
});



    Route::get('/destinasi/{destinasi}', [DestinasiController::class, 'show'])
        ->name('destinasi.show');






    /*
    |--------------------------------------------------------------------------
    | REVIEW PENGUNJUNG
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/destinasi/{destinasi}/review',
        [ReviewController::class, 'store']
    )
    ->middleware('role:pengunjung')
    ->name('review.store');


    /*
    |--------------------------------------------------------------------------
    | MODERASI REVIEW - KHUSUS ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        Route::get(
            '/admin/reviews',
            [AdminReviewController::class, 'index']
        )->name('admin.reviews.index');

        Route::patch(
            '/admin/reviews/{review}/approve',
            [AdminReviewController::class, 'approve']
        )->name('admin.reviews.approve');

        Route::patch(
            '/admin/reviews/{review}/reject',
            [AdminReviewController::class, 'reject']
        )->name('admin.reviews.reject');
    });

});