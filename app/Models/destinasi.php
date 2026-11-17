<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Destinasi extends Model
{
    protected $table = 'destinasi';

    protected $primaryKey = 'id_destinasi';

    protected $fillable = [
        'id_kategori',
        'id_pengelola',
        'nama_destinasi',
        'gambar',
        'alamat',
        'deskripsi',
        'harga',
        'jam_buka',
        'jam_tutup',
        'fasilitas',
        'latitude',
        'longitude',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(
            Kategori::class,
            'id_kategori',
            'id'
        );
    }

    public function pengelola(): BelongsTo
    {
        return $this->belongsTo(
            Pengelola::class,
            'id_pengelola',
            'id_pengelola'
        );
    }
    public function reviews(): HasMany
{
    return $this->hasMany(Review::class, 'id_destinasi', 'id_destinasi');
}
}