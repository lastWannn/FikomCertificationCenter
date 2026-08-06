<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table    = 'admins';
    protected $fillable = ['nama', 'email', 'password', 'role'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['password' => 'hashed'];

    public function informasi(): HasMany
    {
        return $this->hasMany(Informasi::class);
    }

    public function isSuperAdmin(): bool
    {
        return ($this->role ?? 'admin') === 'super_admin';
    }

    public function getRoleLabelAttribute(): string
    {
        return $this->isSuperAdmin() ? 'Super Admin' : 'Admin';
    }
}
