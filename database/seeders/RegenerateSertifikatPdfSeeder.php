<?php

namespace Database\Seeders;

use App\Models\Sertifikat;
use App\Services\Admin\SertifikatService;
use Illuminate\Database\Seeder;

class RegenerateSertifikatPdfSeeder extends Seeder
{
    public function run(): void
    {
        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $this->command?->warn('DomPDF tidak tersedia, seeder PDF dibatalkan.');
            return;
        }

        $sertifikats = Sertifikat::with([
            'pendaftaran.peserta',
            'pendaftaran.kegiatan.kegiatanPelatihan.jadwalPelatihan',
            'pendaftaran.kegiatan.kegiatanSertifikasi.jadwalSertifikasi',
        ])
            ->orderBy('id')
            ->get();

        if ($sertifikats->isEmpty()) {
            $this->command?->warn('Tidak ada data sertifikat untuk diregenerasi.');
            return;
        }

        $count = 0;
        $sertifikatService = app(SertifikatService::class);

        foreach ($sertifikats as $sertifikat) {
            if (!$sertifikat->pendaftaran || !$sertifikat->pendaftaran->peserta || !$sertifikat->pendaftaran->kegiatan) {
                continue;
            }

            $sertifikatService->regeneratePdf($sertifikat);
            $count++;

            $this->command?->line("{$sertifikat->nomor_sertifikat} diregenerasi.");
        }

        $this->command?->info("Selesai meregenerasi {$count} file PDF sertifikat.");
    }
}
