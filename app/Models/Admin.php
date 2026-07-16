<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $table    = 'admins';
    protected $fillable = ['nama','email','password'];
    protected $hidden   = ['password','remember_token'];
    protected $casts    = ['password'=>'hashed'];
    public function informasi(): HasMany { return $this->hasMany(Informasi::class); }
}
