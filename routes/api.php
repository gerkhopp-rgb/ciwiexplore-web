
<?php

use App\Models\Destinasi;
use App\Models\Pengelola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API USER
|--------------------------------------------------------------------------
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


/*
|--------------------------------------------------------------------------
| API LOGIN
|--------------------------------------------------------------------------
*/

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah.',
        ], 401);
    }

    $user = Auth::user();

    if (!in_array($user->role, ['pengelola', 'admin'])) {
        Auth::logout();

        return response()->json([
            'success' => false,
            'message' => 'Akun tidak memiliki akses API pengelola.',
        ], 403);
    }

    $token = $user->createToken(
        'ciwiexplore-api'
    )->plainTextToken;

    Auth::logout();

    return response()->json([
        'success' => true,
        'message' => 'Login API berhasil.',
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role,
        ],
    ], 200);
});


/*
|--------------------------------------------------------------------------
| API DAFTAR DESTINASI
|--------------------------------------------------------------------------
*/

Route::get('/destinasi', function () {
    $destinasi = Destinasi::with([
        'kategori',
        'pengelola',
    ])
        ->orderBy('nama_destinasi')
        ->get();

    return response()->json([
        'success' => true,
        'message' => 'Data destinasi berhasil diambil.',
        'data' => $destinasi,
    ], 200);
});


/*
|--------------------------------------------------------------------------
| API DETAIL DESTINASI
|--------------------------------------------------------------------------
*/

Route::get('/destinasi/{id}', function ($id) {
    $destinasi = Destinasi::with([
        'kategori',
        'pengelola',
        'reviews' => function ($query) {
            $query->where('status', 'approved');
        },
        'reviews.user',
        'reviews.photos',
    ])->find($id);

    if (!$destinasi) {
        return response()->json([
            'success' => false,
            'message' => 'Destinasi tidak ditemukan.',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Detail destinasi berhasil diambil.',
        'data' => $destinasi,
    ], 200);
});


/*
|--------------------------------------------------------------------------
| API TAMBAH DESTINASI
|--------------------------------------------------------------------------
*/

Route::post('/destinasi', function (Request $request) {
    $user = $request->user();

    // Hanya pengelola yang boleh menambahkan destinasi.
    if (!$user || $user->role !== 'pengelola') {
        return response()->json([
            'success' => false,
            'message' => 'Hanya pengelola yang dapat menambahkan destinasi.',
        ], 403);
    }

    // Ambil data pengelola berdasarkan akun yang login.
    $pengelola = Pengelola::where(
        'id_user',
        $user->id
    )->first();

    if (!$pengelola) {
        return response()->json([
            'success' => false,
            'message' => 'Akun ini belum memiliki data pengelola.',
        ], 403);
    }

    // Validasi data yang dikirim.
    $validated = $request->validate([
        'id_kategori' => 'required|exists:kategoris,id',
        'nama_destinasi' => 'required|string|max:150',
        'alamat' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'harga' => 'required|numeric|min:0',
        'jam_buka' => 'required|date_format:H:i',
        'jam_tutup' => 'required|date_format:H:i',
        'fasilitas' => 'nullable|string',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // Simpan gambar jika disertakan.
    if ($request->hasFile('gambar')) {
        $validated['gambar'] = $request
            ->file('gambar')
            ->store('destinasi', 'public');
    }

    // Pengelola ditentukan dari token, bukan dari input pengguna.
    $validated['id_pengelola'] = $pengelola->id_pengelola;

    $destinasi = Destinasi::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Destinasi berhasil ditambahkan.',
        'data' => $destinasi->load([
            'kategori',
            'pengelola',
        ]),
    ], 201);
})->middleware('auth:sanctum');