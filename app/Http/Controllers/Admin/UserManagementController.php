<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    // Menampilkan daftar pengguna
    public function index(Request $request)
    {
        $query = User::query();

        // Pencarian nama atau email
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // Menampilkan halaman edit pengguna
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Menyimpan perubahan pengguna
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => [
                'required',
                Rule::in(['admin', 'pengelola', 'pengunjung']),
            ],
        ]);

        // Admin tidak boleh mengubah role akunnya sendiri
        if (
            $user->id === Auth::id() &&
            $validated['role'] !== $user->role
        ) {
            return back()->withErrors([
                'role' => 'Kamu tidak dapat mengubah role akun sendiri.',
            ])->withInput();
        }

        // Lindungi Admin aktif terakhir agar tidak kehilangan akses
        if (
            $user->role === 'admin' &&
            $user->status === 'aktif' &&
            $validated['role'] !== 'admin'
        ) {
            $activeAdmins = User::where('role', 'admin')
                ->where('status', 'aktif')
                ->count();

            if ($activeAdmins <= 1) {
                return back()->withErrors([
                    'role' => 'Role Admin terakhir tidak dapat diubah.',
                ])->withInput();
            }
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Mengaktifkan atau menonaktifkan akun
    public function toggleStatus(User $user)
    {
        // Admin tidak boleh menonaktifkan akunnya sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Kamu tidak dapat menonaktifkan akun sendiri.');
        }

        // Lindungi Admin aktif terakhir
        if (
            $user->role === 'admin' &&
            $user->status === 'aktif'
        ) {
            $activeAdmins = User::where('role', 'admin')
                ->where('status', 'aktif')
                ->count();

            if ($activeAdmins <= 1) {
                return back()->with(
                    'error',
                    'Admin aktif terakhir tidak dapat dinonaktifkan.'
                );
            }
        }

        $user->status = $user->status === 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $user->save();

        $message = $user->status === 'aktif'
            ? 'Akun berhasil diaktifkan.'
            : 'Akun berhasil dinonaktifkan.';

        return back()->with('success', $message);
    }
}
