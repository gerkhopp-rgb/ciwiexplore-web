<?php

namespace App\Http\Controllers;

use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::with('destinasi')
            ->orderBy('nama_kategori')
            ->get();

        return view(
            'kategori.index',
            compact('kategori')
        );
    }

    public function show(Kategori $kategori)
    {
        $kategori->load([
            'destinasi.kategori',
            'destinasi.reviews',
        ]);

        return view(
            'kategori.show',
            compact('kategori')
        );
    }
}