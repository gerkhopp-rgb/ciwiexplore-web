<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - CiwiExplore</title>
    <link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}">
</head>
<body class="profile-page">

    <section class="profile-heading">
    <h1>Profil Saya</h1>
    <p>Kelola informasi akun dan keamanan akun CiwiExplore.</p>
</section>

<section class="profile-identity">
    <div class="profile-avatar">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>

    <div class="profile-identity-info">
        <h2>{{ $user->name }}</h2>
        <p>{{ $user->email }}</p>

        <span class="profile-role">
            {{ ucfirst($user->role) }}
        </span>
    </div>
</section>

        @if (session('success'))
            <div class="profile-alert success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="profile-alert error">
                <strong>Periksa kembali data berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="profile-card">
            <div class="profile-card-heading">
                <h2>Informasi Akun</h2>
                <span class="profile-role">{{ ucfirst($user->role) }}</span>
            </div>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="profile-field">
                    <label for="name">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                    >
                </div>

                <div class="profile-field">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                    >
                </div>

                @if ($user->role === 'pengelola')
                    <hr>

                    <h3>Informasi Usaha</h3>

                    <div class="profile-field">
                        <label for="nama_usaha">Nama Usaha</label>
                        <input
                            type="text"
                            id="nama_usaha"
                            name="nama_usaha"
                            value="{{ old('nama_usaha', $pengelola->nama_usaha ?? '') }}"
                            required
                        >
                    </div>

                    <div class="profile-field">
                        <label for="no_telepon">Nomor Telepon</label>
                        <input
                            type="text"
                            id="no_telepon"
                            name="no_telepon"
                            value="{{ old('no_telepon', $pengelola->no_telepon ?? '') }}"
                        >
                    </div>

                    <div class="profile-field">
                        <label for="alamat">Alamat Usaha</label>
                        <textarea
                            id="alamat"
                            name="alamat"
                            rows="3"
                            required
                        >{{ old('alamat', $pengelola->alamat ?? '') }}</textarea>
                    </div>
                @endif

                <button type="submit" class="profile-button">
                    Simpan Perubahan
                </button>
            </form>
        </section>

        <section class="profile-card">
            <h2>Keamanan Akun</h2>
            <p class="profile-description">
                Gunakan password yang kuat dan jangan membagikannya kepada orang lain.
            </p>

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="profile-field">
                    <label for="current_password">Password Lama</label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        required
                    >
                </div>

                <div class="profile-field">
                    <label for="password">Password Baru</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                    >
                </div>

                <div class="profile-field">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                    >
                </div>

                <button type="submit" class="profile-button secondary">
                    Ubah Password
                </button>
            </form>
        </section>
    </main>

</body>
</html>
