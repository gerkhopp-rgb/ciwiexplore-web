<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
     protected $fillable = ['user_id', 'aksi', 'id_destinasi'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'id_destinasi', 'id_destinasi');
    }
}
