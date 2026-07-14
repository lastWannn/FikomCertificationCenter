<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_user', 'alamat', 'jenis_kelamin', 'instansi', 'no_hp'])]
class PesertaDetail extends Model
{
    protected $table = 'peserta_detail';

    protected $primaryKey = 'id_user';

    public $incrementing = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
