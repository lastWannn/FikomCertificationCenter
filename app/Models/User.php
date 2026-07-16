<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User — Default Laravel (dipertahankan, tidak digunakan secara aktif)
 *
 * FCC menggunakan sistem autentikasi multi-guard dengan tabel terpisah:
 *   - App\Models\Admin      → tabel `admins`,    guard `admin`
 *   - App\Models\Peserta    → tabel `peserta`,   guard `peserta`
 *   - App\Models\Instruktur → tabel `instruktur`, guard `instruktur`
 *
 * Model ini dipertahankan untuk:
 *   - Kompatibilitas internal Laravel (beberapa komponen mereferensikannya)
 *   - Factory & testing (UserFactory.php)
 *   - Kemungkinan penggunaan fitur Laravel lain di masa mendatang
 *
 * CATATAN: Tabel `users` di database TIDAK dibuat (lihat migration
 * 0001_01_01_000000_create_users_table.php yang telah diperbarui).
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
