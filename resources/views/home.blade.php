<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CiwiExplore - Jelajahi Ciwidey & Rancabali</title>
    <link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}">
</head>
<body>
<header class="site-header">
    <a class="brand" href="{{ url('/') }}">Ciwi<span>Explore</span></a>
    <nav class="nav">
        <a class="active" href="{{ url('/') }}">Beranda</a>
        <a href="{{ route('destinasi.index') }}">Destinasi</a>
        <a href="#kategori">Kategori</a>
        <a href="#tentang">Tentang</a>
        @auth
            <a href="{{ auth()->user()->role === 'admin' ? route('dashboard.admin') : (auth()->user()->role === 'pengelola' ? route('dashboard.pengelola') : route('dashboard.pengunjung')) }}">Dashboard</a>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a class="nav-register" href="{{ route('register') }}">Daftar</a>
        @endauth
    </nav>
</header>

<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <p class="eyebrow">Ciwidey - Rancabali, Bandung</p>
        <h1>Jelajahi Keindahan<br>Alam Ciwidey & Rancabali</h1>
        <p>Temukan berbagai destinasi wisata menarik, mulai dari alam, kuliner hingga budaya dalam satu platform.</p>
        <div class="hero-search">
            <form action="{{ route('destinasi.index') }}" method="GET">
                <input name="search" placeholder="Cari destinasi wisata...">
                <button type="submit">Cari</button>
            </form>
        </div>
    </div>
</section>

<section class="section" id="kategori">
    <div class="section-heading">
        <div>
            <p class="eyebrow dark">Kategori</p>
            <h2>Temukan Wisata Sesuai Minatmu</h2>
        </div>
    </div>
    <div class="category-grid">
        <a class="category-card" href="{{ route('destinasi.index', ['kategori' => 1]) }}"><div class="category-icon">🌿</div><strong>Alam</strong><span>Wisata alam</span></a>
        <a class="category-card" href="{{ route('destinasi.index', ['kategori' => 2]) }}"><div class="category-icon">🍜</div><strong>Kuliner</strong><span>Kuliner lokal</span></a>
        <a class="category-card" href="{{ route('destinasi.index', ['kategori' => 3]) }}"><div class="category-icon">⛺</div><strong>Camping</strong><span>Tempat berkemah</span></a>
        <a class="category-card" href="{{ route('destinasi.index', ['kategori' => 4]) }}"><div class="category-icon">👨‍👩‍👧</div><strong>Keluarga</strong><span>Liburan keluarga</span></a>
        <a class="category-card" href="{{ route('destinasi.index', ['kategori' => 5]) }}"><div class="category-icon">🏡</div><strong>Penginapan</strong><span>Tempat menginap</span></a>
    </div>
</section>

<section class="section soft" id="destinasi-populer">
    <div class="section-heading">
        <div>
            <p class="eyebrow dark">Destinansi Populer</p>
            <h2>Destinasi Favorit di Ciwidey & Rancabali</h2>
        </div>
        <a class="text-link" href="{{ route('destinasi.index') }}">Lihat semua →</a>
    </div>
    <div class="destination-grid">
        <article class="destination-card">
            <img src="{{ asset('images/kawah.jpeg') }}" alt="Kawah Putih">
            <div class="destination-body">
                <span class="badge">Alam</span>
                <h3>Kawah Putih</h3>
                <p class="location">📍 Rancabali</p>
                <div class="rating">★ <b>4.7</b> <span>(1.2k)</span></div>
            </div>
        </article>
        <article class="destination-card">
            <img src="{{ asset('images/glamping.jpg') }}" alt="Glamping Lakeside">
            <div class="destination-body">
                <span class="badge">Penginapan</span>
                <h3>Glamping Lakeside</h3>
                <p class="location">📍 Rancabali</p>
                <div class="rating">★ <b>4.6</b> <span>(856)</span></div>
            </div>
        </article>
        <article class="destination-card">
            <img src="{{ asset('images/patenggang.jpeg') }}" alt="Situ Patenggang">
            <div class="destination-body">
                <span class="badge">Alam</span>
                <h3>Situ Patenggang</h3>
                <p class="location">📍 Ciwidey</p>
                <div class="rating">★ <b>4.5</b> <span>(932)</span></div>
            </div>
        </article>
    </div>
</section>

<section class="cta-section" id="tentang">
    <div>
        <p class="eyebrow">CiwiExplore</p>
        <h2>Ayo Jelajahi Ciwidey-Rancabali</h2>
        <p>Rasakan pengalaman berwisata yang tak terlupakan bersama CiwiExplore.</p>
        <a class="btn btn-light" href="{{ route('destinasi.index') }}">Mulai Sekarang</a>
    </div>
</section>

<footer class="footer">
    <strong>CiwiExplore</strong>
    <span>Platform Review & Rating Wisata Lokal Ciwidey-Rancabali</span>
</footer>
</body>
</html>
