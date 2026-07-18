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
            throw new \RuntimeException('Peserta masih memiliki pendaftaran aktif dan tidak bisa dihapus.');
        }
        $peserta->delete();
    }

    public function resetPassword(Peserta $peserta): string
    {
        $newPass = Str::random(10);
        $peserta->update(['password' => Hash::make($newPass)]);
        try {
            Mail::to($peserta->email)->send(new ResetPassword($peserta->nama, $newPass));
        } catch (\Exception $e) {
            Log::warning('Email reset password gagal: '.$e->getMessage());
        }
        return $newPass;
    }
}
