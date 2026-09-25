<?php
namespace App\Services\Admin;

use App\Models\{Sertifikat, Pendaftaran, Kegiatan};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class SertifikatService
{
    public function buildPdfViewData(Sertifikat $sertifikat): array
    {
        $sertifikat->loadMissing([
            'pendaftaran.peserta',
            'pendaftaran.kegiatan.kegiatanPelatihan.jadwalPelatihan',
            'pendaftaran.kegiatan.kegiatanSertifikasi.jadwalSertifikasi',
        ]);

        $kegiatan = $sertifikat->pendaftaran->kegiatan;
        $gambarLatarPath = $sertifikat->gambar_latar ?? $kegiatan?->nama_latar;
        $bgSrc = null;

        if (empty($gambarLatarPath) || !file_exists(public_path('storage/' . $gambarLatarPath))) {
            $defaultLatar = 'latar-sertifikat/LfPQPcpLb5uKPx2YELbIUgQuIhxbnViaBBACTWv5.webp';
            if (file_exists(storage_path('app/public/' . $defaultLatar))) {
                $gambarLatarPath = $defaultLatar;
            }
        }

        if (!empty($gambarLatarPath)) {
            $realPath = public_path('storage/' . $gambarLatarPath);
            if (!file_exists($realPath)) {
                $realPath = storage_path('app/public/' . $gambarLatarPath);
            }

            if (file_exists($realPath) && is_file($realPath)) {
                $type = pathinfo($realPath, PATHINFO_EXTENSION);
                $mimeType = $type === 'svg' ? 'svg+xml' : ($type === 'webp' ? 'webp' : $type);
                $bgSrc = 'data:image/' . $mimeType . ';base64,' . base64_encode(file_get_contents($realPath));
            }
        }

        return [
            'sertifikat' => $sertifikat,
            'bgSrc' => $bgSrc,
            'tglPelaksanaanFormat' => $kegiatan?->jadwal?->tgl_pelaksanaan?->translatedFormat('d F Y') ?? 'September 12th, 2021',
            'tglTerbitFormat' => $sertifikat->tgl_terbit?->translatedFormat('d F Y') ?? 'September 12th, 2021',
            'layout' => $kegiatan?->layout_settings ?? [],
        ];
    }

    public function regeneratePdf(Sertifikat $sertifikat): void
    {
        $safeNomor = str_replace(['/', '\\'], '-', $sertifikat->nomor_sertifikat);
        $fileName = "sertifikat-{$safeNomor}.pdf";
        $outputDir = storage_path('app/public/sertifikat-cetak');

        File::ensureDirectoryExists($outputDir);

        $pdf = app('dompdf.wrapper')
            ->setPaper('a4', 'landscape')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true)
            ->loadView('admin.cetak.sertifikat-pdf', $this->buildPdfViewData($sertifikat));

        File::put($outputDir . DIRECTORY_SEPARATOR . $fileName, $pdf->output());

        $sertifikat->forceFill([
            'file_sertifikat' => 'sertifikat-cetak/' . $fileName,
        ])->save();
    }

    public function uploadLatar(int $kegiatanId, UploadedFile $file): string
    {
        $path = \App\Helpers\ImageHelper::compressToWebp($file, 'latar-sertifikat', 90, 2480);
        $target = Kegiatan::findOrFail($kegiatanId);
        $targetJudul = trim($target->judul);

        // Sync background template across all batch/schedule records with matching title
        $matching = Kegiatan::all()->filter(fn($k) => trim($k->judul) === $targetJudul);
        foreach ($matching as $k) {
            $k->update(['nama_latar' => $path]);
        }
        return $path;
    }

    public function terbitkan(Pendaftaran $pendaftaran, string $tglTerbit): Sertifikat
    {
        $sertifikat = Sertifikat::updateOrCreate(
            ['pendaftaran_id' => $pendaftaran->id],
            [
                'nomor_sertifikat' => Sertifikat::generateNomor($pendaftaran->kegiatan_id, $pendaftaran->id),
                'tgl_terbit'       => $tglTerbit,
                'gambar_latar'     => $pendaftaran->kegiatan->nama_latar,
            ]
        );

        $this->regeneratePdf($sertifikat);

        return $sertifikat;
    }

    public function terbitkanSemua(Kegiatan $kegiatan, string $tglTerbit): int
    {
        $pendaftaran = Pendaftaran::where('kegiatan_id', $kegiatan->id)
            ->where('status_pendaftaran', 'terdaftar')
            ->whereDoesntHave('sertifikat')
            ->get();

        $count = 0;
        foreach ($pendaftaran as $pd) {
            $cert = Sertifikat::create([
                'pendaftaran_id'   => $pd->id,
                'nomor_sertifikat' => Sertifikat::generateNomor($pd->kegiatan_id, $pd->id),
                'tgl_terbit'       => $tglTerbit,
                'gambar_latar'     => $pd->kegiatan->nama_latar,
            ]);
            $this->regeneratePdf($cert);
            $count++;
        }
        return $count;
    }
}
