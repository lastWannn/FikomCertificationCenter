<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_user', 'no_identitas', 'alamat', 'jenis_kelamin', 'no_hp', 'keahlian'])]
class InstrukturDetail extends Model
{
    protected $table = 'instruktur_detail';

    protected $primaryKey = 'id_user';

    public $incrementing = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
