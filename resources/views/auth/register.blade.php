<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar - CiwiExplore</title><link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}">
</head>
<body class="auth-page">
<div class="auth-card">
    <a class="brand auth-brand" href="{{ url('/') }}">Ciwi<span>Explore</span></a>
    <h1>Daftar</h1>
    <p class="muted">buat akun baru untuk menjelajah</p>

    @if($errors->any())
        <div class="alert error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
    @endif

    <form method="POST" action="{{ url('/register') }}" class="form-stack">
        @csrf
        <label>Nama Lengkap</label>
        <input name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required>
        <label>Pasword</label>
        <input type="password" name="password" placeholder="Masukkan password" required>
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
        <button class="btn btn-primary full" type="submit">Daftar</button>
    </form>
    <p class="auth-bottom">sudah punya akun? <a href="{{ route('login') }}">login di sini</a></p>
</div>
</body>
</html>
