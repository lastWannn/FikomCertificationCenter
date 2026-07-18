<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;

class Kategori extends Model
{
    use HasHashid;

    protected $table = 'kategori';

    protected $fillable = ['nama_kategori'];

    public function pelatihan()
    {
        return $this->hasMany(Pelatihan::class, 'kategori_id');
    }

    public function sertifikasi()
    {
        return $this->hasMany(Sertifikasi::class, 'kategori_id');
    }
}
