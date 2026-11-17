<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(
        Request $request,
        Destinasi $destinasi
    ) {
        // SECURITY: Hanya pengunjung yang boleh mengirim review
        if (!Auth::check() || Auth::user()->role !== 'pengunjung') {
            abort(403, 'Hanya pengunjung yang dapat mengirim review.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:10|max:1000',
            'review_photos' => 'nullable|array|max:3',
            'review_photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
    'rating.required'   => 'Rating wajib dipilih.',
    'rating.integer'    => 'Rating harus berupa angka bulat.',
    'rating.min'        => 'Rating minimal 1.',
    'rating.max'        => 'Rating maksimal 5.',
    'komentar.required' => 'Komentar ulasan wajib diisi.',
    'komentar.min'      => 'Komentar ulasan minimal harus terdiri dari 10 karakter.',
]);

        

        // SENTIMENT
        $rating = $validated['rating'];

        if ($rating >= 4) {
            $sentiment = 'positif';
        } elseif ($rating == 3) {
            $sentiment = 'netral';
        } else {
            $sentiment = 'negatif';
        }

        // SIMPAN REVIEW
        $review = Review::create([
            'user_id' => Auth::id(),
            'id_destinasi' => $destinasi->id_destinasi,
            'rating' => $rating,
            'komentar' => $validated['komentar'],
            'status' => 'pending',
            'sentiment' => $sentiment,
        ]);

        // SIMPAN FOTO REVIEW
        if ($request->hasFile('review_photos')) {
            foreach ($request->file('review_photos') as $photo) {
                $path = $photo->store('review-photos', 'public');

                $review->photos()->create([
                    'foto' => $path,
                ]);
            }
        }

        return back()->with(
            'success',
            'Review berhasil dikirim dan menunggu moderasi admin.'
        );
    }
}
