<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Dashboard Pengelola - CiwiExplore</title><link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}"></head>
<body>
<header class="dashboard-header"><a class="brand white" href="{{ url('/') }}">Ciwi<span>Explore</span></a><div class="dash-user"><span>{{ auth()->user()->name }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button>Logout</button></form></div></header>
<div class="dashboard-layout">
<aside class="sidebar"><a class="side-active" href="{{ route('dashboard.pengelola') }}">▣ Dashboard</a><a href="{{ route('destinasi.index') }}">▦ Kelola Destinasi</a><a href="{{ route('destinasi.create') }}">＋ Tambah Testinasi</a><a href="{{ route('destinasi.index') }}">★ Rating & review</a><a href="{{ route('destinasi.index') }}">✉ Feedback</a><a href="{{ route('profile.show')  }}">◉ Profil</a></aside>
<main class="dash-main">
<p class="eyebrow dark">Dashboard pengelola</p><h1>Selamat datang, {{ auth()->user()->name }}</h1>
<div class="stat-grid">
<div class="stat-card"><span>Total Destinasi</span><strong>{{ \App\Models\Destinasi::where('id_pengelola', optional(auth()->user()->pengelola)->id_pengelola)->count() }}</strong></div>
<div class="stat-card"><span>Total Review</span><strong>{{ \App\Models\Review::whereHas('destinasi', function($q){ $q->where('id_pengelola', optional(auth()->user()->pengelola)->id_pengelola); })->count() }}</strong></div>
<div class="stat-card"><span>Rata-rata Rating</span><strong>{{ number_format(\App\Models\Review::whereHas('destinasi', function($q){ $q->where('id_pengelola', optional(auth()->user()->pengelola)->id_pengelola); })->where('status','approved')->avg('rating') ?? 0, 1) }}</strong></div>
</div>
<div class="dashboard-grid">
<section class="dashboard-panel"><div class="panel-head"><h3>Destinasi Terpopuler</h3><a href="{{ route('destinasi.index') }}">Lihat Detail</a></div>
@forelse(\App\Models\Destinasi::where('id_pengelola', optional(auth()->user()->pengelola)->id_pengelola)->with('reviews')->take(3)->get() as $d)
@php $r=$d->reviews->where('status','approved'); $avg=$r->count()?number_format($r->avg('rating'),1):'0.0'; @endphp
<div class="popular-row"><div><strong>{{ $d->nama_destinasi }}</strong><span>{{ $d->alamat }}</span></div><b>★ {{ $avg }} ({{ $r->count() }})</b><a href="{{ route('destinasi.show',$d) }}">Lihat Detail</a></div>
@empty <div class="empty-state">Belum ada destinasi.</div>@endforelse
</section>

<section class="dashboard-panel">

    <h3>Statistik Pengunjung</h3>

    <div class="activity-empty-state">

        <div class="activity-empty-icon">
            <span>▥</span>
        </div>

        <h4>Data kunjungan belum tersedia</h4>

        <p>
            Belum ada data kunjungan destinasi yang dapat
            ditampilkan saat ini.
        </p>

    </div>

</section>

</div>
</main></div></body></html>
