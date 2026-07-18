<?php

namespace App\Services\Admin;

use App\Models\Kegiatan;

class KegiatanService
{
    public function delete(Kegiatan $kegiatan): void
    {
        if ($kegiatan->pendaftaran()->whereIn('status_pendaftaran', ['terdaftar', 'menunggu_verifikasi'])->count() > 0) {
            throw new \RuntimeException('Kegiatan tidak bisa dihapus. Masih ada peserta aktif.');
        }
        $kegiatan->delete();
    }

    public function toggleBiaya(Kegiatan $kegiatan): void
    {
        $kegiatan->biaya()->delete();
    }
}
