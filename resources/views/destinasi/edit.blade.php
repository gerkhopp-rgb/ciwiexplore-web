<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Destinasi - CiwiExplore</title>

    <link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}">
</head>

<body>

<header class="site-header">

    <a class="brand" href="{{ url('/') }}">
        Ciwi<span>Explore</span>
    </a>

    <nav class="nav">

        <a href="{{ route('dashboard.pengelola') }}">
            Dashboard
        </a>

        <a class="active" href="{{ route('destinasi.index') }}">
            Destinasi
        </a>

        <a href="{{ route('destinasi.index') }}">
            Kembali
        </a>

    </nav>

</header>


<main class="page-shell narrow">

    <div class="form-page-head">

        <p class="eyebrow dark">
            CiwiExplore
        </p>

        <h1>
            Edit Destinasi
        </h1>

        <p>
            Perbarui informasi destinasi wisata.
        </p>

    </div>


    {{-- Pesan error --}}

    @if($errors->any())

        <div class="alert error">

            @foreach($errors->all() as $e)

                <div>
                    {{ $e }}
                </div>

            @endforeach

        </div>

    @endif


    {{-- Pesan berhasil --}}

    @if(session('success'))

        <div class="alert success">
            {{ session('success') }}
        </div>

    @endif


    {{-- FORM EDIT --}}

    <form
        method="POST"
        action="{{ route('destinasi.update', $destinasi) }}"
        class="big-form"
        enctype="multipart/form-data"
    >

        @csrf

        @method('PUT')


        <div class="form-grid">


            {{-- NAMA DESTINASI --}}

            <div>

                <label for="nama_destinasi">
                    Nama Destinasi
                </label>

                <input
                    type="text"
                    id="nama_destinasi"
                    name="nama_destinasi"
                    value="{{ old('nama_destinasi', $destinasi->nama_destinasi) }}"
                    placeholder="Masukan nama destinasi"
                    required
                >

            </div>


            {{-- KATEGORI --}}

            <div>

                <label for="id_kategori">
                    Pilih kategori
                </label>

                <select
                    id="id_kategori"
                    name="id_kategori"
                    required
                >

                    <option value="">
                        Pilih kategori
                    </option>

                    @foreach($kategori as $k)

                        <option
                            value="{{ $k->id }}"
                            @selected(
                                old(
                                    'id_kategori',
                                    $destinasi->id_kategori
                                ) == $k->id
                            )
                        >

                            {{ $k->nama_kategori }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- HARGA --}}

            <div>

                <label for="harga">
                    Masukan harga tiket
                </label>

                <input
                    type="number"
                    id="harga"
                    name="harga"
                    value="{{ old('harga', $destinasi->harga) }}"
                    placeholder="25000"
                    min="0"
                    required
                >

            </div>


            {{-- ALAMAT --}}

            <div>

                <label for="alamat">
                    Masukan lokasi
                </label>

                <input
                    type="text"
                    id="alamat"
                    name="alamat"
                    value="{{ old('alamat', $destinasi->alamat) }}"
                    placeholder="Alamat destinasi"
                    required
                >

            </div>
            
{{-- JAM BUKA --}}
<div>
    <label for="jam_buka">
        Jam buka
    </label>

    <input
        type="time"
        id="jam_buka"
        name="jam_buka"
        value="{{ old('jam_buka', $destinasi->jam_buka ? \Carbon\Carbon::parse($destinasi->jam_buka)->format('H:i') : '') }}"
        required
    >
</div>

{{-- JAM TUTUP --}}
<div>
    <label for="jam_tutup">
        Jam tutup
    </label>

    <input
        type="time"
        id="jam_tutup"
        name="jam_tutup"
        value="{{ old('jam_tutup', $destinasi->jam_tutup ? \Carbon\Carbon::parse($destinasi->jam_tutup)->format('H:i') : '') }}"
        required
    >
</div>



            {{-- DESKRIPSI --}}

            <div class="full-span">

                <label for="deskripsi">
                    Deskripsi destinasi
                </label>

                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="5"
                    placeholder="Masukan deskripsi destinasi..."
                    required
                >{{ old('deskripsi', $destinasi->deskripsi) }}</textarea>

            </div>


            {{-- FASILITAS --}}

            <div class="full-span">

                <label for="fasilitas">
                    Fasilitas
                </label>

                <input
                    type="text"
                    id="fasilitas"
                    name="fasilitas"
                    value="{{ old('fasilitas', $destinasi->fasilitas) }}"
                    placeholder="Mushola, Kuliner, Parkir"
                >

            </div>


            {{-- FOTO --}}

            <div class="full-span">

                <label for="gambar">
                    Foto Destinasi
                </label>


                {{-- FOTO LAMA --}}

                @if($destinasi->gambar)

                    <div style="margin-bottom: 15px;">

                        <p style="margin-bottom: 8px;">
                            Foto saat ini:
                        </p>

                        <img
                            src="{{ asset('storage/' . $destinasi->gambar) }}"
                            alt="{{ $destinasi->nama_destinasi }}"
                            style="
                                width: 220px;
                                height: 140px;
                                object-fit: cover;
                                border-radius: 10px;
                                display: block;
                            "
                        >

                    </div>

                @else

                    <p style="margin-bottom: 10px;">
                        Belum ada foto untuk destinasi ini.
                    </p>

                @endif


                {{-- INPUT FOTO BARU --}}

                <div class="upload-placeholder large">

                    <label
                        for="gambar"
                        style="cursor: pointer; display: block;"
                    >

                        <strong>
                            Pilih foto baru
                        </strong>

                        <br>

                        <small>
                            Klik untuk mengunggah
                        </small>

                        <br>

                        <small>
                            Format JPG, PNG, WEBP — Maksimal 2 MB
                        </small>

                    </label>

                    <input
                        type="file"
                        id="gambar"
                        name="gambar"
                        accept=".jpg,.jpeg,.png,.webp"
                        style="margin-top: 15px;"
                    >

                </div>


                <small style="display: block; margin-top: 8px;">
                    Kosongkan jika tidak ingin mengganti foto.
                </small>

            </div>


            {{-- LATITUDE --}}

            <div>

                <label for="latitude">
                    Latitude
                </label>

                <input
                    type="text"
                    id="latitude"
                    name="latitude"
                    value="{{ old('latitude', $destinasi->latitude) }}"
                    placeholder="-7.xxxxx"
                >

            </div>


            {{-- LONGITUDE --}}

            <div>

                <label for="longitude">
                    Longitude
                </label>

                <input
                    type="text"
                    id="longitude"
                    name="longitude"
                    value="{{ old('longitude', $destinasi->longitude) }}"
                    placeholder="107.xxxxx"
                >

            </div>


        </div>


        {{-- BUTTON --}}

        <div class="form-actions">

            <a
                class="btn btn-outline"
                href="{{ route('destinasi.show', $destinasi) }}"
            >
                Batal
            </a>

            <button
                class="btn btn-primary"
                type="submit"
            >
                Simpan Perubahan
            </button>

        </div>


    </form>

</main>

</body>

</html>