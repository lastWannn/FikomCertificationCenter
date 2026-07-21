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
        $checks = [
            'admins'    => fn () => Admin::where('email', $value),
            'peserta'   => fn () => Peserta::where('email', $value),
        ];

        foreach ($checks as $table => $query) {
            $q = $query();
            if ($table === $this->exceptTable && $this->exceptId) {
                $q->where('id', '!=', $this->exceptId);
            }
            if ($q->exists()) {
                $fail('Email sudah digunakan oleh akun lain.');
                return;
            }
        }
    }
}
