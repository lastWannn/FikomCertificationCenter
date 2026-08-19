<?php

namespace Database\Seeders;

use App\Models\Sertifikat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RegenerateSertifikatPdfSeeder extends Seeder
{
    public function run(): void
    {
        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $this->command?->warn('DomPDF tidak tersedia, seeder PDF dibatalkan.');
            return;
        }

        $sertifikats = Sertifikat::with(['pendaftaran.peserta', 'pendaftaran.kegiatan'])
            ->orderBy('id')
            ->get();

        if ($sertifikats->isEmpty()) {
            $this->command?->warn('Tidak ada data sertifikat untuk diregenerasi.');
            return;
        }

        $outputDir = storage_path('app/public/sertifikat-cetak');
        File::ensureDirectoryExists($outputDir);

        $count = 0;
        foreach ($sertifikats as $sertifikat) {
            if (!$sertifikat->pendaftaran || !$sertifikat->pendaftaran->peserta || !$sertifikat->pendaftaran->kegiatan) {
                continue;
            }

            $safeNomor = str_replace(['/', '\\'], '-', $sertifikat->nomor_sertifikat);
            $fileName = "sertifikat-{$safeNomor}.pdf";
            $filePath = $outputDir . DIRECTORY_SEPARATOR . $fileName;

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.sertifikat-pdf', [
                'sertifikat' => $sertifikat,
            ])->setPaper('a4', 'landscape');

            File::put($filePath, $pdf->output());

            $sertifikat->forceFill([
                'file_sertifikat' => 'sertifikat-cetak/' . $fileName,
            ])->save();

            $count++;
            $this->command?->line("✅ {$sertifikat->nomor_sertifikat} -> {$fileName}");
        }

        $this->command?->info("Selesai meregenerasi {$count} file PDF sertifikat.");
    }
}
