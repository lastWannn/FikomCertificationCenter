<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Instruktur extends Authenticatable
{
    protected $table = 'instruktur';

    protected $fillable = [
        'no_identitas',
        'nama',
        'alamat',
        'email',
        'kelamin',
        'no_hp',
        'keahlian',
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
