<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Moderasi Review - CiwiExplore</title><link rel="stylesheet" href="{{ asset('css/ciwiexplore.css') }}"></head>
<body>
<header class="dashboard-header"><a class="brand white" href="{{ url('/') }}">Ciwi<span>Explore</span></a><div class="dash-user"><a href="{{ route('dashboard.admin') }}">Dashboard</a><form method="POST" action="{{ route('logout') }}">@csrf<button>Logout</button></form></div></header>
<main class="page-shell"><div class="form-page-head"><p class="eyebrow dark">Dashboard Admin</p><h1>Moderasi Review</h1><p>Kelola review yang masuk sebelum ditampilkan pada halaman destinasi.</p></div>
@if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
<div class="moderation-list">
@forelse($reviews as $review)
<article class="moderation-card"><div><div class="review-head"><div class="avatar">{{ strtoupper(substr($review->user->name ?? 'U',0,1)) }}</div><div><strong>{{ $review->user->name ?? 'Pengguna' }}</strong><span>{{ $review->created_at->diffForHumans() }}</span></div></div><h3>{{ $review->destinasi->nama_destinasi ?? '-' }}</h3><div class="review-stars">{{ str_repeat('★',$review->rating) }}{{ str_repeat('☆',5-$review->rating) }}</div><p>{{ $review->komentar }}</p><span class="status {{ $review->status }}">{{ ucfirst($review->status) }}</span></div>
<div class="moderation-actions">@if($review->status !== 'approved')<form method="POST" action="{{ route('admin.reviews.approve',$review) }}">@csrf @method('PATCH')<button class="btn btn-primary">Setujui</button></form>@endif @if($review->status !== 'rejected')<form method="POST" action="{{ route('admin.reviews.reject',$review) }}"> @method('PATCH')<button class="btn btn-danger">Tolak</button></form>@endif</div></article>
@empty<div class="empty-state">Belum ada review.</div>@endforelse
</div></main></body></html>
