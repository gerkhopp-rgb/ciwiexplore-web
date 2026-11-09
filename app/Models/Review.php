<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'id_destinasi',
        'rating',
        'komentar',
        'status',
        'sentiment',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function destinasi(): BelongsTo
    {
        return $this->belongsTo(
            Destinasi::class,
            'id_destinasi',
            'id_destinasi'
        );
    }
    public function photos(): HasMany
{
    return $this->hasMany(
        ReviewPhoto::class,
        'review_id',
        'id'
    );
}
}