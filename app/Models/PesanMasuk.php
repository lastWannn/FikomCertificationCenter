<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanMasuk extends Model
{
    protected $table = 'pesan_masuk';

    protected $fillable = [
        'nama',
        'email',
        'pesan',
        'status',
    ];
}
