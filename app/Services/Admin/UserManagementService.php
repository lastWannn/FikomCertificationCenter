<?php
namespace App\Services\Admin;

use App\Models\Peserta;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\{Hash, Mail, Log};
use Illuminate\Support\Str;

class UserManagementService
{
    public function toggleStatus(Peserta $peserta, string $status): void
    {
        if (!in_array($status, ['aktif','nonaktif','ditangguhkan'])) {
            throw new \InvalidArgumentException('Status tidak valid.');
        }
        $peserta->update(['status_akun' => $status]);
    }

    public function hapus(Peserta $peserta): void
    {
        if ($peserta->pendaftaran()->whereIn('status_pendaftaran',['terdaftar'])->count()) {
            throw new \RuntimeException('Peserta masih memiliki pendaftaran aktif. Selesaikan atau batalkan pendaftaran terlebih dahulu sebelum menghapus akun.');
        }
        $peserta->delete();
    }

    public function resetPassword(Peserta $peserta): string
    {
        $newPass = Str::random(10);
        $peserta->update(['password' => Hash::make($newPass)]);
        
        // Dispatch email reset password di background OS process (0 ms latency untuk admin)
        \App\Helpers\AsyncMail::dispatch('reset_pass', $peserta->id, $newPass);
        
        return $newPass;
    }
}
