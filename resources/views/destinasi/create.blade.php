
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Destinasi - CiwiExplore</title>

    <link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}">

    <style>
        .upload-box {
            display: block;
            border: 2px dashed #198754;
            border-radius: 14px;
            padding: 30px;
            text-align: center;
            background: #f8fffb;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .upload-box:hover {
            background: #eefaf3;
        }

        .upload-box input[type="file"] {
            display: none;
        }

        .upload-icon {
            font-size: 42px;
            margin-bottom: 10px;
        }

        .upload-title {
            font-weight: 600;
            color: #198754;
            margin-bottom: 5px;
        }

        .upload-info {
            font-size: 13px;
            color: #777;
        }

        .image-preview {
            display: none;
            margin-top: 20px;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 12px;
            object-fit: cover;
        }

        .image-name {
            margin-top: 8px;
            font-size: 13px;
            color: #555;
        }

        .remove-image {
            margin-top: 10px;
            border: none;
            background: #dc3545;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .remove-image:hover {
            background: #bb2d3b;
        }

        .field-error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

<header class="site-header">
    <a class="brand" href="{{ url('/') }}">
        Ciwi<span>Explore</span>
    </a>

    <nav class="nav">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('dashboard.admin') }}">Dashboard</a>
        @else
            <a href="{{ route('dashboard.pengelola') }}">Dashboard</a>
        @endif

        <a class="active" href="{{ route('destinasi.index') }}">
            Destinasi
        </a>

        <a href="{{ route('destinasi.index') }}">Kembali</a>
    </nav>
</header>

<main class="page-shell narrow">

    <div class="form-page-head">
        <p class="eyebrow dark">CiwiExplore</p>
        <h1>Tambah Destinasi</h1>
        <p>Masukkan informasi destinasi wisata.</p>
    </div>

    @if($errors->any())
        <div class="alert error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('destinasi.store') }}"
        class="big-form"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="form-grid">

           {{-- PILIH PENGELOLA KHUSUS ADMIN --}}
@if(auth()->user()->role === 'admin')
    <div class="full-span">
        <label for="id_pengelola">
            Pilih Pengelola Destinasi
        </label>

        <select
            name="id_pengelola"
            id="id_pengelola"
            required
        >
            <option value="">-- Pilih pengelola --</option>

            @foreach($pengelola as $p)
                <option
                    value="{{ $p->id_pengelola }}"
                    {{ old('id_pengelola') == $p->id_pengelola ? 'selected' : '' }}
                >
                    {{ $p->nama_usaha }}
                </option>
            @endforeach
        </select>

        @error('id_pengelola')
            <div class="field-error">{{ $message }}</div>
        @enderror

        @if($pengelola->isEmpty())
            <p class="field-error">
                Belum ada pengelola aktif. Tambahkan data pengelola
                terlebih dahulu sebelum membuat destinasi.
            </p>
        @endif
    </div>
@endif

            {{-- NAMA DESTINASI --}}
            <div>
                <label for="nama_destinasi">Nama Destinasi</label>
                <input
                    id="nama_destinasi"
                    name="nama_destinasi"
                    value="{{ old('nama_destinasi') }}"
                    placeholder="Masukkan nama destinasi"
                    required
                >
            </div>

            {{-- KATEGORI --}}
            <div>
                <label for="id_kategori">Pilih Kategori</label>
                <select id="id_kategori" name="id_kategori" required>
    <option value="">Pilih kategori</option>

    @foreach($kategori as $k)
        <option
            value="{{ $k->id }}"
            {{ old('id_kategori') == $k->id ? 'selected' : '' }}
        >
            {{ $k->nama_kategori }}
        </option>
    @endforeach
</select>
            </div>

            {{-- HARGA --}}
            <div>
                <label for="harga">Harga tiket (Rupiah)</label>
                <input
                    type="number"
                    id="harga"
                    name="harga"
                    value="{{ old('harga') }}"
                    placeholder="25000"
                    min="0"
                    required
                >
            </div>

            {{-- ALAMAT --}}
            <div>
                <label for="alamat">Lokasi / Alamat</label>
                <input
                    id="alamat"
                    name="alamat"
                    value="{{ old('alamat') }}"
                    placeholder="Alamat destinasi"
                    required
                >
            </div>

            {{-- JAM BUKA --}}
            <div>
                <label for="jam_buka">Jam Buka</label>
                <input
                    type="time"
                    id="jam_buka"
                    name="jam_buka"
                    value="{{ old('jam_buka', '08:00') }}"
                    required
                >
            </div>

            {{-- JAM TUTUP --}}
            <div>
                <label for="jam_tutup">Jam Tutup</label>
                <input
                    type="time"
                    id="jam_tutup"
                    name="jam_tutup"
                    value="{{ old('jam_tutup', '17:00') }}"
                    required
                >
            </div>

            {{-- DESKRIPSI --}}
            <div class="full-span">
                <label for="deskripsi">Deskripsi Destinasi</label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="5"
                    placeholder="Masukkan deskripsi destinasi..."
                    required
                >{{ old('deskripsi') }}</textarea>
            </div>

            {{-- FASILITAS --}}
            <div class="full-span">
                <label for="fasilitas">Fasilitas</label>
                <input
                    id="fasilitas"
                    name="fasilitas"
                    value="{{ old('fasilitas') }}"
                    placeholder="Mushola, kuliner, parkir"
                >
            </div>

            {{-- UPLOAD FOTO --}}
            <div class="full-span">
                <label for="gambar">Upload Foto</label>

                <label for="gambar" class="upload-box" id="uploadBox">
                    <input
                        type="file"
                        name="gambar"
                        id="gambar"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <div id="uploadContent">
                        <div class="upload-icon">📷</div>

                        <div class="upload-title">
                            Klik untuk mengunggah foto
                        </div>

                        <div class="upload-info">
                            Atau pilih file dari komputer
                        </div>

                        <div class="upload-info">
                            JPG, JPEG, PNG, WEBP — Maksimal 2 MB
                        </div>
                    </div>

                    <div class="image-preview" id="imagePreview">
                        <img id="previewImage" src="" alt="Preview Foto">

                        <div class="image-name" id="imageName"></div>

                        <button
                            type="button"
                            class="remove-image"
                            id="removeImage"
                        >
                            Hapus Foto
                        </button>
                    </div>
                </label>

                @error('gambar')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- LATITUDE --}}
            <div>
                <label for="latitude">Latitude</label>
                <input
                    id="latitude"
                    name="latitude"
                    value="{{ old('latitude') }}"
                    placeholder="-7.xxxxx"
                >
            </div>

            {{-- LONGITUDE --}}
            <div>
                <label for="longitude">Longitude</label>
                <input
                    id="longitude"
                    name="longitude"
                    value="{{ old('longitude') }}"
                    placeholder="107.xxxxx"
                >
            </div>

        </div>

        <div class="form-actions">
            <a
                class="btn btn-outline"
                href="{{ route('destinasi.index') }}"
            >
                Batal
            </a>

            <button class="btn btn-primary" type="submit">
                Simpan
            </button>
        </div>
    </form>
</main>

<script>
    const gambarInput = document.getElementById('gambar');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const imageName = document.getElementById('imageName');
    const uploadContent = document.getElementById('uploadContent');
    const removeImage = document.getElementById('removeImage');

    gambarInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2 MB.');
            this.value = '';
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            alert('Gunakan gambar JPG, JPEG, PNG, atau WEBP.');
            this.value = '';
            return;
        }

        imageName.textContent = file.name;

        const reader = new FileReader();

        reader.onload = function (event) {
            previewImage.src = event.target.result;
            imagePreview.style.display = 'block';
            uploadContent.style.display = 'none';
        };

        reader.readAsDataURL(file);
    });

    removeImage.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();

        gambarInput.value = '';
        previewImage.src = '';
        imageName.textContent = '';
        imagePreview.style.display = 'none';
        uploadContent.style.display = 'block';
    });
</script>

</body>
</html>
