<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function destinasi(): HasMany
    {
        return $this->hasMany(
            Destinasi::class,
            'id_kategori',
            'id'
        );
    }
}