<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Kategori - CiwiExplore</title>

    <link
        rel="stylesheet"
        href="{{ asset('css/ciwiexplore.css') }}"
    >

</head>


<body>


<!-- =========================
     NAVBAR
========================= -->

<header class="site-header">

    <a
        class="brand"
        href="{{ url('/') }}"
    >
        Ciwi<span>Explore</span>
    </a>


    <nav class="nav">

        <a href="{{ url('/') }}">
            Beranda
        </a>

        <a href="{{ route('destinasi.index') }}">
            Destinasi
        </a>

        <a
            class="active"
            href="{{ route('kategori.index') }}"
        >
            Kategori
        </a>

        <a href="{{ url('/#tentang') }}">
            Tentang
        </a>


        @auth

            <a href="
                {{
                    auth()->user()->role === 'admin'
                    ? route('dashboard.admin')
                    : (
                        auth()->user()->role === 'pengelola'
                        ? route('dashboard.pengelola')
                        : route('dashboard.pengunjung')
                    )
                }}
            ">
                Dashboard
            </a>

        @else

            <a href="{{ route('login') }}">
                Login
            </a>

            <a
                class="nav-register"
                href="{{ route('register') }}"
            >
                Daftar
            </a>

        @endauth

    </nav>

</header>



<main class="page-shell">


    <!-- =========================
         JUDUL
    ========================== -->

    <div class="page-title">

        <p class="eyebrow dark">
            Ciwidey - Rancabali
        </p>

        <h1>
            Kategori Wisata
        </h1>

        <p>
            Temukan wisata sesuai dengan minatmu.
        </p>

    </div>



    <!-- =========================
         KATEGORI
    ========================== -->

    <div class="category-page-grid">


        @forelse($kategori as $item)


            @php

                $namaKategori =
                    strtolower(
                        trim(
                            $item->nama_kategori
                        )
                    );


                /*
                |--------------------------------------------------------------------------
                | ICON KATEGORI
                |--------------------------------------------------------------------------
                */

                $icon = match(true) {

                    str_contains(
                        $namaKategori,
                        'alam'
                    ) => '🌿',

                    str_contains(
                        $namaKategori,
                        'kuliner'
                    ) => '🍜',

                    str_contains(
                        $namaKategori,
                        'camping'
                    ) => '⛺',

                    str_contains(
                        $namaKategori,
                        'keluarga'
                    ) => '👨‍👩‍👧‍👦',

                    str_contains(
                        $namaKategori,
                        'penginapan'
                    ) => '🏡',

                    default => '📍',

                };


                $jumlahDestinasi =
                    $item->destinasi->count();

            @endphp



            <a
                href="{{ route(
                    'kategori.show',
                    $item
                ) }}"
                class="category-page-card"
            >


                <div class="category-icon">

                    {{ $icon }}

                </div>


                <h2>

                    {{ $item->nama_kategori }}

                </h2>


                <p>

                    {{
                        $item->deskripsi
                        ?: 'Jelajahi berbagai destinasi menarik dalam kategori ini.'
                    }}

                </p>


                <span class="category-count">

                    {{ $jumlahDestinasi }}

                    destinasi

                </span>


                <span class="category-link">

                    Lihat Destinasi →

                </span>


            </a>


        @empty


            <div class="empty-state">

                Belum ada kategori wisata.

            </div>


        @endforelse


    </div>



    <!-- =========================
         CTA
    ========================== -->

    <section class="category-cta">

        <div>

            <p class="eyebrow">
                CiwiExplore
            </p>

            <h2>
                Jelajahi Wisata Ciwidey-Rancabali
            </h2>

            <p>
                Temukan tempat menarik berdasarkan
                kategori wisata yang kamu sukai.
            </p>

            <a
                href="{{ route('destinasi.index') }}"
                class="btn btn-primary"
            >
                Lihat Semua Destinasi
            </a>

        </div>

    </section>


</main>


</body>

</html>