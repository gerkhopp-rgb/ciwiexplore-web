<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =========================
    // REGISTER
    // =========================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengunjung',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/dashboard/pengunjung');
    }

    // =========================
    // LOGIN
    // =========================

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // Periksa status akun
            if ($user->status !== 'aktif') {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')
                    ->withErrors([
                        'email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi Admin.',
                    ]);
            }

            // Membuat session baru setelah login berhasil
            $request->session()->regenerate();

            // Cek role user
            if ($user->role === 'admin') {
                return redirect('/dashboard/admin');
            }

            if ($user->role === 'pengelola') {
                return redirect('/dashboard/pengelola');
            }

            if ($user->role === 'pengunjung') {
                return redirect('/dashboard/pengunjung');
            }

            Auth::logout();

            return redirect('/login')
                ->withErrors([
                    'email' => 'Role akun tidak dikenali.',
                ]);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // =========================
    // LOGOUT
    // =========================

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil logout.');
    }
}
