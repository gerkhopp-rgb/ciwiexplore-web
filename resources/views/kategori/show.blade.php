<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $kategori->nama_kategori }} - CiwiExplore
    </title>

    <link
        rel="stylesheet"
        href="{{ asset('css/ciwiexplore.css') }}"
    >

</head>


<body>


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
         HEADER KATEGORI
    ========================== -->

    <div class="page-title">

        <p class="eyebrow dark">
            Kategori Wisata
        </p>

        <h1>
            {{ $kategori->nama_kategori }}
        </h1>

        <p>

            {{
                $kategori->deskripsi
                ?: 'Temukan berbagai destinasi wisata dalam kategori ini.'
            }}

        </p>

    </div>



    <!-- =========================
         DESTINASI DALAM KATEGORI
    ========================== -->

    <div class="destination-grid">


        @forelse($kategori->destinasi as $item)


            @php

                $approved =
                    $item->reviews
                        ->where(
                            'status',
                            'approved'
                        );


                $avg =
                    $approved->count()
                    ? number_format(
                        $approved->avg('rating'),
                        1
                    )
                    : '0.0';


                /*
                |--------------------------------------------------------------------------
                | GAMBAR DESTINASI
                |--------------------------------------------------------------------------
                */

                $gambarDestinasi = [

                    'Kawah Putih'
                        => 'ciwidey.jpg',

                    'Situ Patenggang'
                        => 'patenggang.jpeg',

                    'Glamping Lakeside'
                        => 'ciwidey.jpg',

                    'Ranca Upas'
                        => 'ciwidey.jpg',

                ];


                $gambar =
                    $gambarDestinasi[
                        $item->nama_destinasi
                    ]
                    ?? 'ciwidey.jpg';

            @endphp



            <article class="destination-card">


                <img
                    src="{{ asset(
                        'images/' . $gambar
                    ) }}"
                    alt="{{ $item->nama_destinasi }}"
                >


                <div class="destination-body">


                    <span class="badge">

                        {{
                            $item->kategori
                                ->nama_kategori
                            ?? 'Wisata'
                        }}

                    </span>


                    <h3>

                        {{ $item->nama_destinasi }}

                    </h3>


                    <p class="location">

                        📍 {{ $item->alamat }}

                    </p>


                    <div class="rating">

                        ⭐

                        <b>
                            {{ $avg }}
                        </b>

                        <span>

                            ({{
                                $approved->count()
                            }}
                            review)

                        </span>

                    </div>


                    <p class="price">

                        Rp
                        {{ number_format(
                            $item->harga,
                            0,
                            ',',
                            '.'
                        ) }}

                        / orang

                    </p>


                    <a
                        class="btn btn-outline full"
                        href="{{ route(
                            'destinasi.show',
                            $item
                        ) }}"
                    >

                        Lihat Detail

                    </a>


                </div>

            </article>


        @empty


            <div class="empty-state">

                Belum ada destinasi
                dalam kategori ini.

            </div>


        @endforelse


    </div>



    <!-- KEMBALI -->

    <div class="detail-actions">

        <a
            class="btn btn-outline"
            href="{{ route('kategori.index') }}"
        >
            ← Kembali ke Kategori
        </a>

    </div>


</main>


</body>

</html>