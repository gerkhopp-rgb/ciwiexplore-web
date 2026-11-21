
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manajemen Pengguna</h2>
    <p>Kelola akun pengunjung, pengelola, dan admin CiwiExplore.</p>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.users.index') }}">
        <input
            type="text"
            name="search"
            placeholder="Cari nama atau email..."
            value="{{ request('search') }}"
        >

        <select name="role">
            <option value="">Semua Role</option>
            <option value="admin" @selected(request('role') === 'admin')>Admin</option>
            <option value="pengelola" @selected(request('role') === 'pengelola')>Pengelola</option>
            <option value="pengunjung" @selected(request('role') === 'pengunjung')>Pengunjung</option>
        </select>

        <select name="status">
            <option value="">Semua Status</option>
            <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
        </select>

        <button type="submit">Cari / Filter</button>
        <a href="{{ route('admin.users.index') }}">Reset</a>
    </form>

    <br>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ ucfirst($user->status) }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}">
                            Edit
                        </a>

                        <form
                            action="{{ route('admin.users.toggle-status', $user->id) }}"
                            method="POST"
                            style="display:inline"
                            onsubmit="return confirm('Yakin ingin mengubah status akun ini?')"
                        >
                            @csrf
                            @method('PATCH')

                            <button type="submit">
                                {{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada pengguna ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>

    {{ $users->links() }}

    <br>
    <a href="/dashboard/admin">Kembali ke Dashboard</a>
</div>
@endsection