<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasHashid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peserta extends Authenticatable
{
    use HasHashid, SoftDeletes, Notifiable;

    protected $table    = 'peserta';
    protected $fillable = [
        'nama','alamat','email','pending_email','kelamin','instansi','no_hp','foto','password',
        'status_akun','email_verified_at','remember_token',
    ];
    protected $hidden = ['password','remember_token'];
    protected $casts  = [
        'password'           => 'hashed',
        'email_verified_at'  => 'datetime',
    ];

    public function pendaftaran(): HasMany {
        return $this->hasMany(Pendaftaran::class);
    }
    public function pendaftaranAktif(): HasMany {
        return $this->hasMany(Pendaftaran::class)->where('status_pendaftaran','terdaftar');
    }
    public function getStatusAkunAttribute(mixed $value): string {
        return $value ?? 'aktif';
    }
    public function isAktif(): bool { return ($this->status_akun ?? 'aktif') === 'aktif'; }
}
