<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Kategori;
use App\Models\Pengelola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DestinasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
{
    $query = Destinasi::with([
            'kategori',
            'pengelola',
        ])
        ->withAvg('reviews', 'rating')  
        ->withCount('reviews');        

    if ($request->filled('search')) {
        $query->where(
            'nama_destinasi',
            'like',
            '%' . $request->search . '%'
        );
    }

    if ($request->filled('kategori')) {
        $query->where('id_kategori', $request->kategori);
    }

    // PENGURUTAN
    if ($request->urutkan === 'rating') {
        $query->orderByDesc('reviews_avg_rating')
              ->orderByDesc('reviews_count');
    } else {
        $query->latest('id_destinasi');
    }

    $destinasi = $query
        ->paginate(9)
        ->withQueryString();

    $kategori = Kategori::orderBy('nama_kategori')->get();

    return view(
        'destinasi.index',
        compact('destinasi', 'kategori')
    );
}
    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
   public function create()
    {
        $this->onlyManager();

        $kategori = Kategori::orderBy('nama_kategori')->get();

        $pengelola = Pengelola::where('status', 'aktif')->get();

        return view(
            'destinasi.create',
            compact('kategori', 'pengelola')
        );
    }
    

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $this->onlyManager();

        $user = Auth::user();

        $rules = [
            'id_kategori' => 'required|exists:kategoris,id',
            'nama_destinasi' => 'required|string|max:150',
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i',
            'fasilitas' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        if ($user->role === 'admin') {
            $rules['id_pengelola'] =
                'required|exists:pengelola,id_pengelola';
        }

        $validated = $request->validate($rules);

        if ($user->role === 'admin') {
            $pengelola = Pengelola::where(
                'id_pengelola',
                $validated['id_pengelola']
            )
                ->where('status', 'aktif')
                ->first();

            if (!$pengelola) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'id_pengelola' =>
                            'Pengelola tidak ditemukan atau tidak aktif.',
                    ]);
            }
        } else {
            $pengelola = Pengelola::where(
                'id_user',
                $user->id
            )
                ->where('status', 'aktif')
                ->first();

            if (!$pengelola) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'id_pengelola' =>
                            'Akun ini belum memiliki data pengelola aktif.',
                    ]);
            }
        }

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request
                ->file('gambar')
                ->store('destinasi', 'public');
        }

        $validated['id_pengelola'] = $pengelola->id_pengelola;

        Destinasi::create($validated);

        return redirect()
            ->route('destinasi.index')
            ->with('success', 'Destinasi berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(Destinasi $destinasi)
    {
        $destinasi->load([
            'kategori',
            'pengelola',
            'reviews.user',
            'reviews.photos',
        ]);

        $approvedReviews = $destinasi->reviews
            ->where('status', 'approved');

        $jumlahReview = $approvedReviews->count();

        $ratingRataRata = $jumlahReview > 0
            ? round($approvedReviews->avg('rating'), 1)
            : 0;

        $distribusiRating = [];

        for ($i = 5; $i >= 1; $i--) {
            $distribusiRating[$i] = $approvedReviews
                ->where('rating', $i)
                ->count();
        }

        return view(
            'destinasi.show',
            compact(
                'destinasi',
                'jumlahReview',
                'ratingRataRata',
                'distribusiRating'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Destinasi $destinasi)
    {
        $this->canManageDestination($destinasi);

        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view(
            'destinasi.edit',
            compact('destinasi', 'kategori')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        Destinasi $destinasi
    ) {
        $this->canManageDestination($destinasi);

        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategoris,id',
            'nama_destinasi' => 'required|string|max:150',
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i',
            'fasilitas' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if (
                $destinasi->gambar &&
                Storage::disk('public')->exists($destinasi->gambar)
            ) {
                Storage::disk('public')->delete($destinasi->gambar);
            }

            $validated['gambar'] = $request
                ->file('gambar')
                ->store('destinasi', 'public');
        }

        $destinasi->update($validated);

        return redirect()
            ->route('destinasi.show', $destinasi)
            ->with('success', 'Destinasi berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy(Destinasi $destinasi)
    {
        $this->canManageDestination($destinasi);

        if (
            $destinasi->gambar &&
            Storage::disk('public')->exists($destinasi->gambar)
        ) {
            Storage::disk('public')->delete($destinasi->gambar);
        }

        $destinasi->delete();

        return redirect()
            ->route('destinasi.index')
            ->with('success', 'Destinasi berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | ROLE CHECK
    |--------------------------------------------------------------------------
    */
    private function onlyManager()
    {
        abort_unless(
            Auth::check() &&
            in_array(Auth::user()->role, ['pengelola', 'admin']),
            403
        );
    }

    /*
    |--------------------------------------------------------------------------
    | OWNERSHIP CHECK
    |--------------------------------------------------------------------------
    */
    private function canManageDestination(Destinasi $destinasi)
    {
        abort_unless(Auth::check(), 403);

        $user = Auth::user();

        // Admin boleh mengelola semua destinasi.
        if ($user->role === 'admin') {
            return;
        }

        // Selain pengelola tidak boleh mengelola destinasi.
        if ($user->role !== 'pengelola') {
            abort(403);
        }

        $pengelola = Pengelola::where(
            'id_user',
            $user->id
        )->first();

        abort_unless(
            $pengelola &&
            (int) $destinasi->id_pengelola ===
                (int) $pengelola->id_pengelola,
            403
        );
    }
}
