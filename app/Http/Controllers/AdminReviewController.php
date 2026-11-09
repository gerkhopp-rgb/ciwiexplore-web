<?php

namespace App\Http\Controllers;

use App\Models\Review;

class AdminReviewController extends Controller
{
    public function index()
    {
        $this->onlyAdmin();

        $reviews = Review::with([
            'user',
            'destinasi'
        ])
        ->latest()
        ->get();

        return view(
            'admin.reviews.index',
            compact('reviews')
        );
    }

    public function approve(Review $review)
    {
        $this->onlyAdmin();

        $review->update([
            'status' => 'approved'
        ]);

        return back()->with(
            'success',
            'Review berhasil disetujui.'
        );
    }

    public function reject(Review $review)
    {
        $this->onlyAdmin();

        $review->update([
            'status' => 'rejected'
        ]);

        return back()->with(
            'success',
            'Review berhasil ditolak.'
        );
    }

    private function onlyAdmin()
    {
        abort_unless(
            auth()->check() &&
            auth()->user()->role === 'admin',
            403
        );
    }
}