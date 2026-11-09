<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
        return view('dashboard.pengelola');
    }

    // Dashboard Admin
    public function admin()
    {
        return view('dashboard.admin');
    }
}