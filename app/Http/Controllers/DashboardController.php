<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    // Dashboard Pengunjung
    public function pengunjung()
    {
        return view('dashboard.pengunjung');
    }

    // Dashboard Pengelola
    public function pengelola()
{
    $mulai       = now()->subDays(6)->startOfDay();
    $idPengelola = optional(auth()->user()->pengelola)->id_pengelola;

    $base = ActivityLog::where('created_at', '>=', $mulai)
        ->where(function ($q) use ($idPengelola) {
            $q->where(function ($q) use ($idPengelola) {
                $q->where('aksi', 'review')
                ->whereHas('destinasi', fn ($d) => $d->where('id_pengelola', $idPengelola));
            })->orWhere(function ($q) {
                $q->where('aksi', 'login')->where('user_id', auth()->id());
            });
        });

    $rows = (clone $base)
        ->selectRaw('DATE(created_at) as tanggal, aksi, COUNT(*) as total')
        ->groupBy('tanggal', 'aksi')
        ->get();

    $aktivitas = collect(range(6, 0))->map(function ($i) use ($rows) {
        $tgl = now()->subDays($i);
        $key = $tgl->toDateString();

        return [
            'label'  => $tgl->translatedFormat('D, d M'),
            'login'  => $rows->where('tanggal', $key)->where('aksi', 'login')->sum('total'),
            'review' => $rows->where('tanggal', $key)->where('aksi', 'review')->sum('total'),
        ];
    });

    $aktivitasTerbaru = (clone $base)->with(['user', 'destinasi'])->latest()->take(15)->get();

    return view('dashboard.pengelola', compact('aktivitas', 'aktivitasTerbaru'));
}

    // Dashboard Admin
    public function admin()
    {
        $mulai = now()->subDays(6)->startOfDay();

    $rows = ActivityLog::where('created_at', '>=', $mulai)
        ->selectRaw('DATE(created_at) as tanggal, aksi, COUNT(*) as total')
        ->groupBy('tanggal', 'aksi')
        ->get();

    $aktivitas = collect(range(6, 0))->map(function ($i) use ($rows) {
        $tgl = now()->subDays($i);
        $key = $tgl->toDateString();

        return [
            'label'  => $tgl->translatedFormat('D, d M'),
            'login'  => $rows->where('tanggal', $key)->where('aksi', 'login')->sum('total'),
            'review' => $rows->where('tanggal', $key)->where('aksi', 'review')->sum('total'),
        ];
    });

    $aktivitasTerbaru = ActivityLog::with(['user', 'destinasi'])
        ->where('created_at', '>=', $mulai)
        ->latest()
        ->take(15)
        ->get();

    return view('dashboard.admin', compact('aktivitas', 'aktivitasTerbaru'));
    }
}