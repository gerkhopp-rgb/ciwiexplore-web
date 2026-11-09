<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengunjung - CiwiExplore</title>

    <link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}">
</head>

<body class="visitor-dashboard">

    {{-- HEADER --}}
    <header class="dashboard-header">
        <a class="brand white" href="{{ url('/') }}">
            Ciwi<span>Explore</span>
        </a>

        <div class="dash-user">
            <span>{{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>


    <div class="dashboard-layout">

        {{-- NAVIGASI MOBILE --}}
        <nav class="mobile-dashboard-nav">

            <a class="side-active" href="{{ route('dashboard.pengunjung') }}">
                ▣ Dashboard
            </a>

            <a href="{{ route('destinasi.index') }}">
                ▦ Destinasi
            </a>

            <a href="{{ route('destinasi.index') }}">
                🗂 Kategori
            </a>

          <a href="{{ route('profile.show') }}">
    ◉ Profil Saya
</a>

        </nav>


        {{-- SIDEBAR DESKTOP --}}
        <aside class="sidebar">

            <a class="side-active" href="{{ route('dashboard.pengunjung') }}">
                ▣ Dashboard
            </a>

            <a href="{{ route('destinasi.index') }}">
                ▦ Jelajahi Destinasi
            </a>

            <a href="{{ route('destinasi.index') }}">
                🗂 Kategori Wisata
            </a>

            <a href="{{ url('/profil') }}">
                ◉ Profil Saya
            </a>

        </aside>


        {{-- KONTEN UTAMA --}}
        <main class="dash-main">

            <p class="eyebrow dark">Dashboard Pengunjung</p>

            <h1>
                Selamat datang, {{ auth()->user()->name }}
            </h1>

            <p class="visitor-description">
                Temukan destinasi wisata menarik di Ciwidey dan Rancabali,
                berikan rating, serta bagikan pengalaman wisatamu.
            </p>


            {{-- KARTU SELAMAT DATANG --}}
            <section class="welcome-card">

                <div>
                    <p class="eyebrow dark">Jelajahi Ciwidey</p>

                    <h2>Mulai Petualangan Wisatamu!</h2>

                    <p>
                        Temukan tempat wisata, lihat informasi destinasi,
                        dan baca pengalaman pengunjung lainnya.
                    </p>

                    <a href="{{ route('destinasi.index') }}"
                       class="btn btn-primary">
                        Jelajahi Destinasi
                    </a>
                </div>

            </section>


            {{-- KONTEN DASHBOARD --}}
            <div class="dashboard-grid">

                {{-- DESTINASI POPULER --}}
                <section class="dashboard-panel">

                    <div class="panel-head">
                        <h3>Destinasi Populer</h3>

                        <a href="{{ route('destinasi.index') }}">
                            Lihat Semua
                        </a>
                    </div>

                    <a href="{{ route('destinasi.index') }}" class="dash-list">
                        <span>Kawah Putih</span>
                        <b>Jelajahi →</b>
                    </a>

                    <a href="{{ route('destinasi.index') }}" class="dash-list">
                        <span>Glamping Lakeside</span>
                        <b>Jelajahi →</b>
                    </a>

                    <a href="{{ route('destinasi.index') }}" class="dash-list">
                        <span>Situ Patenggang</span>
                        <b>Jelajahi →</b>
                    </a>

                </section>


                {{-- MENU CEPAT --}}
                <section class="dashboard-panel">

                    <h3>Menu Cepat</h3>

                    <div class="quick-grid">

                        <a href="{{ route('destinasi.index') }}">
                            🔎 Cari Destinasi
                        </a>

                        <a href="{{ route('destinasi.index') }}">
                            ⭐ Rating & Review
                        </a>

                        <a href="{{ route('destinasi.index') }}">
                            📍 Lokasi Wisata
                        </a>

                        <a href="{{ route('destinasi.index') }}">
                            🗂 Kategori Wisata
                        </a>

                    </div>

                </section>

            </div>

        </main>

    </div>

</body>
</html>