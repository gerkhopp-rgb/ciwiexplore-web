<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - CiwiExplore</title><link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}">
</head>
<body class="auth-page">
<div class="auth-card">
    <a class="brand auth-brand" href="{{ url('/') }}">Ciwi<span>Explore</span></a>
    <h1></h1>
    <p class="muted">Masuk ke akun anda Untuk melanjutkan</p>

    @if($errors->any())
        <div class="alert error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
    @endif

    <form method="POST" action="{{ url('/login') }}" class="form-stack">
        @csrf
        <label>Email atau username</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required>
        <label>Pasword</label>
        <input type="password" name="password" placeholder="Masukkan password" required>
        <div class="form-row-between">
            <span></span><a href="#" class="small-link">Lupa Pasword?</a>
        </div>
        <button class="btn btn-primary full" type="submit">Login</button>
    </form>

    <div class="or"><span>Atau</span></div>
    <button class="btn google full" type="button">G &nbsp; Login dengan google</button>
    <p class="auth-bottom">Belum punya akun ? <a href="{{ route('register') }}">Daftar disini</a></p>
</div>
</body>
</html>
