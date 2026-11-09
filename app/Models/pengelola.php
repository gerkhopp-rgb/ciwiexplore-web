<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Pengelola extends Model
{
    protected $table = 'pengelola';

    protected $primaryKey = 'id_pengelola';

    protected $fillable = [
        'id_user',
        'nama_usaha',
        'no_telepon',
        'alamat',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id'
        );
    }

    public function destinasi(): HasMany
    {
        return $this->hasMany(
            Destinasi::class,
            'id_pengelola',
            'id_pengelola'
        );
    }
}