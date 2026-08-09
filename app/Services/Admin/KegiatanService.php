<?php

namespace App\Services\Admin;

use App\Models\Kegiatan;

class KegiatanService
{
    public function delete(Kegiatan $kegiatan): void
    {
        // Aturan 1: Jika kegiatan SUDAH ADA DI ARSIP, kegiatan BOLEH dihapus permanen (entah ada peserta maupun tidak)
        if ($kegiatan->arsip) {
            $arsip = $kegiatan->arsip;
            $arsip->delete();

            foreach ($kegiatan->pendaftaran as $pendaftaran) {
                $pendaftaran->sertifikat()?->delete();
                $pendaftaran->nilai()->delete();
                $pendaftaran->pembayaran()?->delete();
                $pendaftaran->delete();
            }
            $kegiatan->biaya()?->delete();
            $kegiatan->kegiatanPelatihan()?->delete();
            $kegiatan->kegiatanSertifikasi()?->delete();
            $kegiatan->delete();
            return;
        }

        // Aturan 2: Jika kegiatan TELAH SELESAI (isPassed), penghapusan akan otomatis memindahkannya ke Arsip Kegiatan
        if ($kegiatan->isPassed()) {
            \App\Models\ArsipKegiatan::create([
                'kegiatan_id' => $kegiatan->id,
                'judul'       => $kegiatan->judul,
                'ringkasan'   => 'Kegiatan ' . $kegiatan->judul . ' telah selesai dilaksanakan.',
            ]);
            return;
        }

        // Aturan 3: Jika kegiatan masih berjalan dan belum selesai, cegah penghapusan jika ada peserta aktif
        if ($kegiatan->pendaftaran()->whereIn('status_pendaftaran', ['terdaftar', 'menunggu_verifikasi'])->count() > 0) {
            throw new \RuntimeException('Kegiatan yang sedang berjalan tidak dapat dihapus karena masih ada peserta aktif. Silakan tunggu hingga kegiatan selesai.');
        }

        $kegiatan->delete();
    }

    public function toggleBiaya(Kegiatan $kegiatan): void
    {
        $kegiatan->biaya()->delete();
    }
}
