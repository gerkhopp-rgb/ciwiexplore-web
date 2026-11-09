<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function show()
    {
        $user = Auth::user();

        // Ambil data pengelola jika role adalah pengelola
        $pengelola = $user->role === 'pengelola'
            ? $user->pengelola
            : null;

        return view('profile.show', compact('user', 'pengelola'));
    }


    // Memperbarui informasi profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        // Perbarui nama dan email akun
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Jika pengelola, perbarui informasi usaha
        if ($user->role === 'pengelola') {

            $dataPengelola = $request->validate([
                'nama_usaha' => ['required', 'string', 'max:100'],
                'no_telepon' => ['nullable', 'string', 'max:20'],
                'alamat' => ['required', 'string', 'max:255'],
            ]);

            $user->pengelola()->updateOrCreate(
                ['id_user' => $user->id],
                [
                    'nama_usaha' => $dataPengelola['nama_usaha'],
                    'no_telepon' => $dataPengelola['no_telepon'] ?? null,
                    'alamat' => $dataPengelola['alamat'],
                ]
            );
        }

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }


    // Memperbarui password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'current_password.current_password' =>
                'Password lama yang kamu masukkan salah.',

            'password.min' =>
                'Password baru minimal 8 karakter.',

            'password.confirmed' =>
                'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Password berhasil diperbarui.');
    }
}