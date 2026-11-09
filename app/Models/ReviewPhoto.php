<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewPhoto extends Model
{
    protected $table = 'review_photos';

    protected $fillable = [
        'review_id',
        'foto',
    ];

    public function review(): BelongsTo
    {
        return $this->belongsTo(
            Review::class,
            'review_id',
            'id'
        );
    }
}