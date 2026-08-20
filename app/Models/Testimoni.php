<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimoni extends Model
{
    protected $table = 'testimoni';
    protected $fillable = ['peserta_id', 'nama', 'rating', 'keterangan', 'kata', 'foto', 'status'];

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function scopeDipublikasikan($query)
    {
        return $query->where('status', 'dipublikasikan');
    }
}

