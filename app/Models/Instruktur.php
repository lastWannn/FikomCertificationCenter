<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasHashid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instruktur extends Authenticatable
{
    use HasHashid;
    use Notifiable;
    protected $table    = 'instruktur';
    protected $fillable = ['no_identitas','nama','alamat','email','kelamin','no_hp','keahlian','password'];
    protected $hidden   = ['password','remember_token'];
    protected $casts    = ['password'=>'hashed'];
    public function pelatihan(): HasMany { return $this->hasMany(Pelatihan::class); }
}
