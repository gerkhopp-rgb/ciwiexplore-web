<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Destinasi - CiwiExplore</title>

    <link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}">
</head>

<body>

<header class="site-header">

    <a class="brand" href="{{ url('/') }}">
        Ciwi<span>Explore</span>
    </a>

    <nav class="nav">

        <a href="{{ url('/') }}">
            Beranda
        </a>

        <a class="active" href="{{ route('destinasi.index') }}">
            Destinasi
        </a>

        <a href="{{ url('/#kategori') }}">
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
                    :
                    (
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

            <a class="nav-register" href="{{ route('register') }}">
                Daftar
            </a>

        @endauth

    </nav>

</header>


<main class="page-shell">


    <!-- =========================
         JUDUL HALAMAN
    ========================== -->

    <div class="page-title">

        <p class="eyebrow dark">
            Ciwidey - Rancabali
        </p>

        <h1>
            Destinasi Wisata
        </h1>

        <p>
            Temukan tempat wisata yang ingin kamu kunjungi.
        </p>

    </div>


    <!-- =========================
         SEARCH & FILTER
    ========================== -->


     <form method="GET" class="filter-bar">

        <select name="urutkan" onchange="this.form.submit()">
    <option value="terbaru" @selected(request('urutkan') !== 'rating')>Urutkan: Terbaru</option>
    <option value="rating" @selected(request('urutkan') === 'rating')>Urutkan: Rating Tertinggi</option>
</select>

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama destinasi..."
        >

        <select name="kategori">

            <option value="">
                Semua kategori
            </option>

            @foreach($kategori as $item)

                <option
                    value="{{ $item->id }}"
                    @selected(request('kategori') == $item->id)
                >
                    {{ $item->nama_kategori }}
                </option>

            @endforeach

        </select>

        <button
            class="btn btn-primary"
            type="submit"
        >
            Cari
        </button>

    </form>




    <!-- =========================
         PESAN SUCCESS
    ========================== -->

    @if(session('success'))

        <div class="alert success">
            {{ session('success') }}
        </div>

    @endif


    <!-- =========================
         DAFTAR DESTINASI
    ========================== -->

    <div class="destination-grid">

        @forelse($destinasi as $item)

            @php

                /*
                |--------------------------------------------------------------------------
                | HITUNG RATING
                |--------------------------------------------------------------------------
                */
                $avg   = number_format($item->rating_rata_rata ?? 0, 1);
$total = $item->jumlah_review ?? 0;


                /*
                |--------------------------------------------------------------------------
                | GAMBAR DEFAULT
                |--------------------------------------------------------------------------
                */

                $gambarDestinasi = [

                    'Kawah Putih' => 'kawah.jpeg',

                    'Situ Patenggang' => 'patenggang.jpeg',

                    'Glamping Lakeside' => 'glamping.jpg',

                    'Ranca Upas' => 'ciwidey.jpg',

                ];


                /*
                |--------------------------------------------------------------------------
                | GAMBAR DESTINASI
                |--------------------------------------------------------------------------
                |
                | Jika database memiliki gambar hasil upload,
                | gunakan gambar tersebut.
                |
                | Jika belum ada, gunakan gambar default.
                |
                */

                $gambarDefault =
                    $gambarDestinasi[
                        $item->nama_destinasi
                    ] ?? 'ciwidey.jpg';

            @endphp


            <!-- =========================
                 CARD DESTINASI
            ========================== -->

            <article class="destination-card">


                <!-- FOTO -->

                @if($item->gambar)

                    <img
                        src="{{ asset('storage/' . $item->gambar) }}"
                        alt="{{ $item->nama_destinasi }}"
                    >

                @else

                    <img
                        src="{{ asset('images/' . $gambarDefault) }}"
                        alt="{{ $item->nama_destinasi }}"
                    >

                @endif


                <!-- ISI CARD -->

                <div class="destination-body">


                    <!-- KATEGORI -->

                    <span class="badge">

                        {{
                            $item->kategori->nama_kategori
                            ?? 'Wisata'
                        }}

                    </span>


                    <!-- NAMA -->

                    <h3>
                        {{ $item->nama_destinasi }}
                    </h3>


                    <!-- LOKASI -->

                    <p class="location">

                        📍 {{ $item->alamat }}

                    </p>


                    <!-- RATING -->

                    <div class="rating">
                        <b>★ {{ $avg }}</b>
                        <span>({{ $total }})</span>
                    </div>
                    
                    
                    <!-- HARGA -->

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


                    <!-- DETAIL -->

                    <a
                        class="btn btn-outline full"
                        href="{{ route(
                            'destinasi.show',
                            $item
                        ) }}"
                    >

                        Lihat Detail

                    </a>


                    <!-- =========================
                         TOMBOL KELOLA
                    ========================== -->

                    @auth

                        @if(
                            auth()->user()->role === 'admin'
                            ||
                            (
                                auth()->user()->role === 'pengelola'
                                &&
                                $item->id_pengelola ===
                                optional(auth()->user()->pengelola)->id_pengelola
                            )
                        )

                            <div
                                style="
                                    display: flex;
                                    gap: 10px;
                                    margin-top: 10px;
                                "
                            >

                                <!-- EDIT -->

                                <a
                                    href="{{ route(
                                        'destinasi.edit',
                                        $item
                                    ) }}"
                                    class="btn btn-primary"
                                    style="flex: 1; text-align: center;"
                                >
                                    Edit
                                </a>


                                <!-- HAPUS -->

                                <form
                                    action="{{ route(
                                        'destinasi.destroy',
                                        $item
                                    ) }}"
                                    method="POST"
                                    style="flex: 1;"
                                    onsubmit="return confirm(
                                        'Yakin ingin menghapus destinasi ini?'
                                    );"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-outline"
                                        style="width: 100%;"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        @endif

                    @endauth


                </div>

            </article>


        @empty


            <!-- =========================
                 JIKA DATA KOSONG
            ========================== -->

            <div class="empty-state">

                Belum ada destinasi yang sesuai.

            </div>


        @endforelse

    </div>


    <!-- =========================
         PAGINATION
    ========================== -->

    <div class="pagination-wrap">

        {{ $destinasi->links() }}

    </div>


</main>

</body>

</html>