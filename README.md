# CiwiExplore – Sistem Informasi Pariwisata Ciwidey dan Rancabali

CiwiExplore merupakan aplikasi berbasis web yang dikembangkan untuk membantu masyarakat memperoleh informasi mengenai destinasi wisata di wilayah Ciwidey dan Rancabali. Aplikasi ini menyediakan informasi destinasi wisata serta fasilitas pengelolaan data bagi pengelola dan administrator.

## 1. Tujuan Proyek

Proyek ini bertujuan untuk:
- Mempermudah pengunjung memperoleh informasi destinasi wisata.
- Menyediakan informasi destinasi wisata secara terstruktur.
- Membantu pengelola dalam mengelola informasi destinasi.
- Memudahkan administrator mengelola pengguna dan moderasi review.

## 2. Fitur Utama

### pengunjung
- Melihat daftar destinasi wisata.
- Melihat detail informasi destinasi.
- Menjelajahi daftar destinasi menggunakan pagination.
- Mengakses fitur yang tersedia sesuai hak akses pengunjung.

### Pengelola
- Mengakses dashboard pengelola.
- Melihat data destinasi yang dikelola.
- Menambahkan destinasi.
- Mengubah informasi destinasi.
- Menghapus destinasi sesuai hak akses.

### Administrator
- Mengakses dashboard admin.
- Mengelola data pengguna.
- Memeriksa dan memoderasi review.
- Memantau informasi pada dashboard.

## 3. Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| Laravel | Framework pengembangan aplikasi |
| PHP | Bahasa pemrograman backend |
| MySQL | Sistem manajemen basis data |
| HTML | Struktur halaman web |
| CSS | Pengaturan tampilan aplikasi |
| JavaScript | Interaksi pada halaman web |
| XAMPP | Lingkungan server lokal |
| Git dan GitHub | Pengelolaan versi dan repositori kode |

## 4. Persyaratan Sistem

Sebelum menjalankan proyek, pastikan perangkat telah memiliki:
- PHP dengan versi yang kompatibel dengan proyek Laravel.
- Composer.
- MySQL atau XAMPP.
- Node.js dan NPM apabila diperlukan oleh proses build frontend.
- Git.
- Browser modern.

## 5. Instalasi dan Menjalankan Proyek

### Langkah 1 – Clone Repository

```bash
git clone URL_REPOSITORY_GITHUB
```

Ganti `URL_REPOSITORY_GITHUB` dengan alamat repository CiwiExplore.

### Langkah 2 – Masuk ke Folder Proyek

```bash
cd ciwiexplore-web
```

### Langkah 3 – Instal Dependensi PHP

```bash
composer install
```

### Langkah 4 – Membuat File Environment

```bash
cp .env.example .env
```

Pada Windows, file `.env.example` juga dapat disalin secara manual menjadi `.env`.

### Langkah 5 – Membuat Application Key

```bash
php artisan key:generate
```

### Langkah 6 – Mengatur Database

Buat database MySQL dengan nama:

```text
ciwiexplore_db
```

Kemudian sesuaikan konfigurasi database pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ciwiexplore_db
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password dengan konfigurasi MySQL pada perangkat masing-masing.

### Langkah 7 – Menjalankan Migration

```bash
php artisan migrate
```

Jika repository menyediakan seeder yang memang diperlukan, jalankan seeder sesuai petunjuk proyek:

```bash
php artisan db:seed
```

Jangan menjalankan perintah tersebut pada database yang sudah berisi data penting tanpa memahami dampaknya.

### Langkah 8 – Menjalankan Aplikasi

```bash
php artisan serve
```

Buka alamat berikut pada browser:

```text
http://127.0.0.1:8000
```

## 6. Struktur Folder

Struktur folder utama proyek Laravel:

```text
ciwiexplore-web/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── css/
│   └── images/
├── resources/
│   └── views/
├── routes/
│   └── web.php
├── docs/
├── .env.example
├── composer.json
└── README.md
```

## 7. Hak Akses Pengguna

CiwiExplore memiliki tiga role utama:
- `pengunjung`
- `pengelola`
- `admin`

Setiap role memiliki hak akses yang berbeda. Sistem autentikasi dan middleware digunakan untuk membatasi akses halaman berdasarkan role pengguna.

## 8. Dokumentasi

Dokumentasi proyek disimpan pada folder `docs/`, yang mencakup:
- Bug Log.
- Testing Report.
- Security Testing.
- Regression Testing.
- User Manual.
- Technical Documentation.
- Deployment Guide.
- Materi Presentasi.

## 9. Status Proyek

CiwiExplore berada pada tahap Sprint 4 – Finalization & Release Candidate.

Tahap ini berfokus pada:
- Perbaikan bug.
- Pengujian keamanan.
- Pengujian regresi.
- Dokumentasi.
- Persiapan deployment.
- Persiapan demonstrasi aplikasi.

## 10. Tim Pengembang

**Proyek:** CiwiExplore  
**Anggota Tim:**
- Galih Pratama
- Andri Surya Permana

---

