<?php
namespace App\Rules;

use App\Models\{Admin, Peserta};
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Satu email cuma boleh dipakai oleh satu role (admin/peserta/instruktur).
 * Mencegah ambiguitas: email yang sama terdaftar di dua tabel role
 * membuat guard login (admin > peserta > instruktur) berebut siapa yang login duluan.
 */
class UniqueEmailAcrossRoles implements ValidationRule
{
    /**
     * @param  string   $exceptTable  Tabel milik record yang sedang diedit ('admins'|'peserta'|'instruktur'), null jika create baru
     * @param  int|null $exceptId     ID record yang dikecualikan dari pengecekan tabel $exceptTable
     */
    public function __construct(
        private ?string $exceptTable = null,
        private ?int $exceptId = null,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Cek Admin
        $adminQ = Admin::where('email', $value);
        if ($this->exceptTable === 'admins' && $this->exceptId) {
            $adminQ->where('id', '!=', $this->exceptId);
        }
        if ($adminQ->exists()) {
            $fail('Email sudah terdaftar sebagai akun Admin.');
            return;
        }

        // 2. Cek Peserta (hanya akun AKTIF dan TERVERIFIKASI yang memblokir pendaftaran baru)
        $pesertaQ = Peserta::whereNull('deleted_at')
            ->where('email', $value)
            ->whereNotNull('email_verified_at');
        if ($this->exceptTable === 'peserta' && $this->exceptId) {
            $pesertaQ->where('id', '!=', $this->exceptId);
        }
        if ($pesertaQ->exists()) {
            $fail('Email ini sudah terdaftar dan terverifikasi. Silakan masuk ke akun Anda.');
            return;
        }
    }
}
