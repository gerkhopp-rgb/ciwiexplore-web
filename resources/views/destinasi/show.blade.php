<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $destinasi->nama_destinasi }} - CiwiExplore
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

        <a
            class="active"
            href="{{ route('destinasi.index') }}"
        >
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
         PESAN SUCCESS
    ========================== -->

    @if(session('success'))

        <div class="alert success">
            {{ session('success') }}
        </div>

    @endif



    @php

        /*
        |--------------------------------------------------------------------------
        | GAMBAR DESTINASI
        |--------------------------------------------------------------------------
        | Gambar sementara ditentukan berdasarkan nama destinasi.
        | Ini digunakan sebagai fallback jika destinasi belum memiliki
        | gambar yang tersimpan di database.
        |
        */

        $gambarDestinasi = [

            'Kawah Putih' => 'kawah.jpeg',

            'Situ Patenggang' => 'patenggang.jpeg',

            'Glamping Lakeside' => 'ciwidey.jpg',

            'Ranca Upas' => 'ciwidey.jpg',

        ];


        /*
        |--------------------------------------------------------------------------
        | GAMBAR DEFAULT
        |--------------------------------------------------------------------------
        */

        $gambar = $gambarDestinasi[
            $destinasi->nama_destinasi
        ] ?? 'ciwidey.jpg';

    @endphp



    <!-- =========================
         DETAIL DESTINASI
    ========================== -->

    <div class="detail-grid">


        <!-- FOTO DESTINASI -->

        <div class="detail-image">

            @if($destinasi->gambar)

                <img
                    src="{{ asset('storage/' . $destinasi->gambar) }}"
                    alt="{{ $destinasi->nama_destinasi }}"
                >

            @else

                <img
                    src="{{ asset('images/' . $gambar) }}"
                    alt="{{ $destinasi->nama_destinasi }}"
                >

            @endif

        </div>



        <!-- INFORMASI DESTINASI -->

        <div class="detail-info">


            <!-- KATEGORI -->

            <span class="badge">

                {{
                    $destinasi->kategori->nama_kategori
                    ?? 'Alam'
                }}

            </span>



            <!-- NAMA DESTINASI -->

            <h1>
                {{ $destinasi->nama_destinasi }}
            </h1>



            <!-- LOKASI -->

            <p class="location">

                📍 {{ $destinasi->alamat }}

            </p>



            <!-- RATING -->

            <div class="detail-rating">

                <span>★</span>

                {{ number_format(
                    $ratingRataRata,
                    1
                ) }}

                <small>
                    ({{ number_format($jumlahReview) }} review)
                </small>

            </div>



            <!-- HARGA -->

            <div class="detail-price">

                <small>
                    Harga Tiket
                </small>

                <strong>

                    Rp
                    {{ number_format(
                        $destinasi->harga,
                        0,
                        ',',
                        '.'
                    ) }}

                    / orang

                </strong>

            </div>



            <!-- DESKRIPSI -->

            <div class="detail-section">

                <h3>
                    Deskripsi
                </h3>

                <p>
                    {{ $destinasi->deskripsi }}
                </p>

            </div>



            <!-- FASILITAS -->

            <div class="detail-section">

                <h3>
                    Fasilitas
                </h3>


                <div class="facility-list">

                    @foreach(
                        preg_split(
                            '/[,;]+/',
                            $destinasi->fasilitas
                            ?? 'Mushola, Kuliner, Parkir'
                        )
                        as $f
                    )

                        @if(trim($f))

                            <span>
                                ✓ {{ trim($f) }}
                            </span>

                        @endif

                    @endforeach

                </div>

            </div>



            <!-- TOMBOL -->

            <div class="detail-actions">


                @auth

                    <a
                        class="btn btn-primary"
                        href="#review-form"
                    >
                        Beri Rating & Review
                    </a>

                @else

                    <a
                        class="btn btn-primary"
                        href="{{ route('login') }}"
                    >
                        Beri Rating & Review
                    </a>

                @endauth


                <a
                    class="btn btn-outline"
                    href="{{ route('destinasi.index') }}"
                >
                    Kembali
                </a>


            </div>

        </div>

    </div>



    <!-- =========================
         RATING & REVIEW
    ========================== -->

    <section class="review-section">


        <div class="section-heading">

            <div>

                <p class="eyebrow dark">
                    CiwiExplore
                </p>

                <h2>
                    Rating & Review ({{ $jumlahReview }})
                </h2>

            </div>

        </div>



        <!-- =========================
             RINGKASAN RATING
        ========================== -->

        <div class="rating-summary">


            <!-- RATING BESAR -->

            <div class="rating-big">

                <strong>
                    {{ number_format(
                        $ratingRataRata,
                        1
                    ) }}
                </strong>

                <div class="stars">
                    ★★★★★
                </div>

                <span>
                    {{ $jumlahReview }} review
                </span>

            </div>



            <!-- DISTRIBUSI RATING -->

            <div class="rating-bars">


                @for($i = 5; $i >= 1; $i--)

                    @php

                        $count =
                            $distribusiRating[$i] ?? 0;

                        $percent =
                            $jumlahReview
                            ? round(
                                ($count / $jumlahReview) * 100
                            )
                            : 0;

                    @endphp


                    <div class="bar-row">

                        <span>
                            {{ $i }} ★
                        </span>


                        <div class="bar">

                            <i
                                style="
                                    width: {{ $percent }}%
                                "
                            ></i>

                        </div>


                        <small>
                            {{ $percent }}%
                        </small>

                    </div>

                @endfor


            </div>

        </div>



        <!-- =========================
             DAFTAR REVIEW
        ========================== -->

        <div class="review-list">


            @forelse(
                $destinasi->reviews
                    ->where('status', 'approved')
                as $review
            )


                <article class="review-card">


                    <div class="review-head">


                        <!-- AVATAR -->

                        <div class="avatar">

                            {{
                                strtoupper(
                                    substr(
                                        $review->user->name ?? 'U',
                                        0,
                                        1
                                    )
                                )
                            }}

                        </div>



                        <!-- USER -->

                        <div>

                            <strong>

                                {{
                                    $review->user->name
                                    ?? 'Pengguna'
                                }}

                            </strong>


                            <span>

                                {{
                                    $review->created_at
                                        ->diffForHumans()
                                }}

                            </span>

                        </div>



                        <!-- BINTANG -->

                        <b class="review-stars">

                            {{
                                str_repeat(
                                    '★',
                                    $review->rating
                                )
                            }}

                            {{
                                str_repeat(
                                    '☆',
                                    5 - $review->rating
                                )
                            }}

                        </b>


                    </div>



                    <!-- KOMENTAR -->

                    <p>
                        {{ $review->komentar }}
                    </p>



                    <!-- =========================
                         FOTO REVIEW
                    ========================== -->

                    @if($review->photos->count() > 0)

                        <div
                            class="review-photo-list"
                            style="
                                display: flex;
                                gap: 10px;
                                flex-wrap: wrap;
                                margin-top: 15px;
                            "
                        >

                            @foreach($review->photos as $photo)

                                <img
                                    src="{{ asset('storage/' . $photo->foto) }}"
                                    alt="Foto review {{ $review->user->name ?? 'Pengguna' }}"
                                    style="
                                        width: 120px;
                                        height: 90px;
                                        object-fit: cover;
                                        border-radius: 8px;
                                        border: 1px solid #ddd;
                                        cursor: pointer;
                                    "
                                    onclick="window.open(
                                        this.src,
                                        '_blank'
                                    )"
                                >

                            @endforeach

                        </div>

                    @endif



                    <!-- SENTIMENT -->

                    @if($review->sentiment)

                        <span
                            class="sentiment {{ $review->sentiment }}"
                        >

                            {{
                                ucfirst(
                                    $review->sentiment
                                )
                            }}

                        </span>

                    @endif


                </article>


            @empty


                <div class="empty-state">

                    Belum ada review yang disetujui.

                </div>


            @endforelse


        </div>



        <!-- =========================
             FORM REVIEW
        ========================== -->

        @auth

            <div
                class="review-form-card"
                id="review-form"
            >


                <h3>
                    Beri Rating & Review
                </h3>


                <p class="muted">
                    Berikan rating untuk destinasi ini
                </p>



                <form
                    method="POST"
                    action="{{
                        route(
                            'review.store',
                            $destinasi
                        )
                    }}"
                    class="form-stack"
                    enctype="multipart/form-data"
                >

                    @csrf



                    <!-- RATING -->

                    <label>
                        Rating (1-5)
                    </label>


                    <select
                        name="rating"
                        required
                    >

                        <option value="">
                            Pilih rating
                        </option>

                        <option value="5">
                            ★★★★★ 5
                        </option>

                        <option value="4">
                            ★★★★☆ 4
                        </option>

                        <option value="3">
                            ★★★☆☆ 3
                        </option>

                        <option value="2">
                            ★★☆☆☆ 2
                        </option>

                        <option value="1">
                            ★☆☆☆☆ 1
                        </option>

                    </select>



                    <!-- REVIEW -->

                    <label>
                        Tulisan review anda...
                    </label>


                    <textarea
                        name="komentar"
                        maxlength="1000"
                        rows="5"
                        placeholder="Ceritakan pengalamanmu..."
                        required
                    ></textarea>



                    <!-- =========================
                         UPLOAD FOTO REVIEW
                    ========================== -->

                    <div class="review-photo-upload">

                        <label
                            for="review_photos"
                            class="upload-placeholder"
                            style="
                                cursor: pointer;
                                display: block;
                            "
                        >

                            📷

                            <strong>
                                Upload Foto (opsional)
                            </strong>

                            <br>

                            <small>
                                Pilih foto atau klik untuk Upload Foto
                                (maks 3 foto)
                            </small>

                        </label>


                        <input
                            type="file"
                            id="review_photos"
                            name="review_photos[]"
                            accept=".jpg,.jpeg,.png,.webp"
                            multiple
                            style="display: none;"
                        >


                        <!-- PREVIEW FOTO -->

                        <div
                            id="review-photo-preview"
                            style="
                                display: flex;
                                gap: 10px;
                                flex-wrap: wrap;
                                margin-top: 15px;
                            "
                        ></div>

                    </div>



                    <!-- KIRIM -->

                    <button
                        class="btn btn-primary"
                        type="submit"
                    >
                        Kirim Review
                    </button>


                </form>

            </div>

        @endauth


    </section>


</main>


<!-- =========================
     JAVASCRIPT UPLOAD FOTO
========================== -->

<script>

    const reviewPhotosInput =
        document.getElementById('review_photos');

    const reviewPhotoPreview =
        document.getElementById('review-photo-preview');


    if (
        reviewPhotosInput &&
        reviewPhotoPreview
    ) {

        reviewPhotosInput.addEventListener(
            'change',
            function () {

                reviewPhotoPreview.innerHTML = '';


                const files =
                    Array.from(this.files);


                /*
                |--------------------------------------------------------------------------
                | MAKSIMAL 3 FOTO
                |--------------------------------------------------------------------------
                */

                if (files.length > 3) {

                    alert(
                        'Maksimal 3 foto yang dapat dipilih.'
                    );

                    this.value = '';

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | CEK SETIAP FILE
                |--------------------------------------------------------------------------
                */

                for (const file of files) {


                    /*
                    |--------------------------------------------------------------------------
                    | MAKSIMAL 2 MB
                    |--------------------------------------------------------------------------
                    */

                    if (
                        file.size >
                        2 * 1024 * 1024
                    ) {

                        alert(
                            'Setiap foto maksimal berukuran 2 MB.'
                        );

                        this.value = '';

                        reviewPhotoPreview.innerHTML = '';

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | HARUS GAMBAR
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !file.type.startsWith(
                            'image/'
                        )
                    ) {

                        alert(
                            'File yang dipilih harus berupa gambar.'
                        );

                        this.value = '';

                        reviewPhotoPreview.innerHTML = '';

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PREVIEW
                    |--------------------------------------------------------------------------
                    */

                    const reader =
                        new FileReader();


                    reader.onload =
                        function (event) {

                            const img =
                                document.createElement(
                                    'img'
                                );


                            img.src =
                                event.target.result;


                            img.style.width =
                                '120px';

                            img.style.height =
                                '90px';

                            img.style.objectFit =
                                'cover';

                            img.style.borderRadius =
                                '8px';

                            img.style.border =
                                '1px solid #ddd';


                            reviewPhotoPreview
                                .appendChild(img);

                        };


                    reader.readAsDataURL(file);

                }

            }
        );

    }

</script>


</body>

</html>