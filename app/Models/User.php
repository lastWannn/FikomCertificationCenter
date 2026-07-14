<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nama', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function instrukturDetail(): HasOne
    {
        return $this->hasOne(InstrukturDetail::class, 'id_user');
    }

    public function pesertaDetail(): HasOne
    {
        return $this->hasOne(PesertaDetail::class, 'id_user');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isInstruktur(): bool
    {
        return $this->role === 'instruktur';
    }

    public function isPeserta(): bool
    {
        return $this->role === 'peserta';
    }
}
