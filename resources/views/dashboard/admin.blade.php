<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Dashboard Admin - CiwiExplore</title><link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}"></head>
<body>
<header class="dashboard-header"><a class="brand white" href="{{ url('/') }}">Ciwi<span>Explore</span></a><div class="dash-user"><span>{{ auth()->user()->name }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button>Logout</button></form></div></header>
<div class="dashboard-layout">
    <nav class="mobile-dashboard-nav">
    <a href="{{ route('dashboard.admin') }}">▣ Dashboard</a>
    <a href="{{ route('admin.reviews.index') }}">★ Moderasi Review</a>
    <a href="{{ route('destinasi.index') }}">▦ Kelola Destinasi</a>
    <a href="{{ route('destinasi.create') }}">＋ Tambah Testinasi</a>
    <a href="{{ route('admin.users.index') }}">◉ Manajemen Pengguna</a>
    <a href="{{ route('admin.reviews.index') }}">▣ Moderasi Foto</a>
    <a href="{{ route('admin.reviews.index') }}">▤ Laporan</a>
    <a href="{{ route('destinasi.index') }}">⚙ Pengaturan</a>
     <a href="{{ route('profile.show') }}">
    ◉ Profil Saya
</a>
</nav>
<aside class="sidebar"><a class="side-active" href="{{ route('dashboard.admin') }}">▣ Dashboard</a><a href="{{ route('admin.reviews.index') }}">★ Moderasi Review</a><a href="{{ route('destinasi.index') }}">▦ Kelola Destinasi</a><a href="{{ route('destinasi.create') }}">＋ Tambah Testinasi</a><a href="{{ route('admin.users.index') }}">◉ Manajemen Pengguna</a><a href="{{ route('admin.reviews.index') }}">▣ Moderasi Foto</a><a href="{{ route('admin.reviews.index') }}">▤ Laporan</a><a href="{{ route('destinasi.index') }}">⚙ Pengaturan</a> <a href="{{ route('profile.show') }}">
    ◉ Profil Saya
</a></aside>
<main class="dash-main"><p class="eyebrow dark">Dashboard Admin</p><h1>Selamat datang, {{ auth()->user()->name }}</h1>
<div class="stat-grid four">
<div class="stat-card"><span>Total Pengguna</span><strong>{{ \App\Models\User::count() }}</strong></div>
<div class="stat-card"><span>Total Destinasi</span><strong>{{ \App\Models\Destinasi::count() }}</strong></div>
<div class="stat-card"><span>Total Review</span><strong>{{ \App\Models\Review::count() }}</strong></div>
<div class="stat-card"><span>Review Pending</span><strong>{{ \App\Models\Review::where('status','pending')->count() }}</strong></div>
</div>
<div class="dashboard-grid">
<section class="dashboard-panel"><div class="panel-head"><h3>Review Terbaru</h3><a href="{{ route('admin.reviews.index') }}">Lihat semua</a></div>
@forelse(\App\Models\Review::with(['user','destinasi'])->latest()->take(3)->get() as $r)
<div class="popular-row"><div><strong>{{ $r->user->name ?? 'Pengguna' }}</strong><span>{{ $r->destinasi->nama_destinasi ?? '-' }}</span></div><b>★ {{ $r->rating }}</b><span class="status {{ $r->status }}">{{ ucfirst($r->status) }}</span></div>
@empty <div class="empty-state">Belum ada review.</div>@endforelse
</section>

<section class="dashboard-panel">

    <h3>Aktivitas Pengguna (7 Hari Terakhir)</h3>

    <div class="activity-empty-state">

        <div class="activity-empty-icon">
            <span>▥</span>
        </div>

        <h4>Data aktivitas belum tersedia</h4>

        <p>
            Belum ada data aktivitas pengguna yang dapat
            ditampilkan saat ini.
        </p>

    </div>

</section>

</div></main></div></body></html>
