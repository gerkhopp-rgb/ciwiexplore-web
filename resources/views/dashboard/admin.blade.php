<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Dashboard Pengelola - CiwiExplore</title><link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}"></head>
<body>
<header class="dashboard-header"><a class="brand white" href="{{ url('/') }}">Ciwi<span>Explore</span></a><div class="dash-user"><span>{{ auth()->user()->name }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button>Logout</button></form></div></header>
<div class="dashboard-layout">
<aside class="sidebar">
    <a class="side-active" href="{{ route('dashboard.admin') }}">▣ Dashboard</a>
    <a href="{{ route('admin.reviews.index') }}">✓ Moderasi Review</a>
    <a href="{{ route('admin.users.index') }}">☻ Kelola Pengguna</a>
    <a href="{{ route('destinasi.index') }}">▦ Kelola Destinasi</a>
    <a href="{{ route('profile.show') }}">◉ Profil</a>
</aside>
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
<section class="dashboard-panel activity-panel">

    <div class="panel-head">
        <h3>Aktivitas 7 Hari Terakhir</h3>
    </div>

    <div class="activity-stats">
        <div class="activity-stat">
            <span>Total Login</span>
            <strong>{{ $aktivitas->sum('login') }}</strong>
        </div>
        <div class="activity-stat">
            <span>Total Review</span>
            <strong>{{ $aktivitas->sum('review') }}</strong>
        </div>
    </div>

    <div class="activity-table-wrap">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Login</th>
                    <th>Review</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aktivitas as $a)
                    <tr>
                        <td>{{ $a['label'] }}</td>
                        <td>{{ $a['login'] }}</td>
                        <td>{{ $a['review'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>{{ $aktivitas->sum('login') }}</th>
                    <th>{{ $aktivitas->sum('review') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <h4 class="activity-subtitle">Aktivitas Terbaru</h4>

    <div class="activity-feed">
        @forelse($aktivitasTerbaru as $log)
            <div class="activity-item">
                <span class="activity-icon {{ $log->aksi }}">
                    {{ $log->aksi === 'login' ? '◉' : '★' }}
                </span>

                <div class="activity-text">
                    <strong>{{ $log->user->name ?? 'Pengguna' }}</strong>
                    @if($log->aksi === 'login')
                        login ke sistem
                    @else
                        mereview <em>{{ $log->destinasi->nama_destinasi ?? '-' }}</em>
                    @endif
                </div>

                <small>{{ $log->created_at->diffForHumans() }}</small>
            </div>
        @empty
            <div class="empty-state">Belum ada aktivitas minggu ini.</div>
        @endforelse
    </div>

</section>
</main></div></body></html>
