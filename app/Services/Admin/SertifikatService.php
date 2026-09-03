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

        $realPath = null;
        if (!empty($gambarLatarPath)) {
            $realPath = public_path('storage/' . $gambarLatarPath);
            if (!file_exists($realPath)) {
                $realPath = storage_path('app/public/' . $gambarLatarPath);
            }
            if (!file_exists($realPath)) {
                $realPath = public_path($gambarLatarPath);
            }
        }

        if (empty($realPath) || !file_exists($realPath)) {
            $realPath = public_path('images/latarsertifikat_default.webp');
        }

        if (file_exists($realPath) && is_file($realPath)) {
            $type = pathinfo($realPath, PATHINFO_EXTENSION);
            $mimeType = $type === 'svg' ? 'svg+xml' : ($type === 'webp' ? 'webp' : $type);
            $bgSrc = 'data:image/' . $mimeType . ';base64,' . base64_encode(file_get_contents($realPath));
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

        if ($sertifikat->exists) {
            $sertifikat->forceFill([
                'file_sertifikat' => 'sertifikat-cetak/' . $fileName,
            ])->save();
        }
    }

    public function uploadLatar(string|int $kegiatanId, UploadedFile $file): string
    {
        $path = \App\Helpers\ImageHelper::compressToWebp($file, 'latar-sertifikat', 90, 2480);

        if (is_string($kegiatanId) && str_starts_with($kegiatanId, 'pelatihan_')) {
            $id = (int) str_replace('pelatihan_', '', $kegiatanId);
            $pel = \App\Models\Pelatihan::find($id);
            if ($pel) {
                $pel->update(['nama_latar' => $path]);
                $matching = Kegiatan::all()->filter(fn($k) => $k->kegiatanPelatihan?->jadwalPelatihan?->pelatihan_id == $id);
                foreach ($matching as $k) {
                    $k->update(['nama_latar' => $path]);
                }
            }
            return $path;
        }

        if (is_string($kegiatanId) && str_starts_with($kegiatanId, 'sertifikasi_')) {
            $id = (int) str_replace('sertifikasi_', '', $kegiatanId);
            $ser = \App\Models\Sertifikasi::find($id);
            if ($ser) {
                $ser->update(['nama_latar' => $path]);
                $matching = Kegiatan::all()->filter(fn($k) => $k->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi_id == $id);
                foreach ($matching as $k) {
                    $k->update(['nama_latar' => $path]);
                }
            }
            return $path;
        }

        $target = Kegiatan::find($kegiatanId);
        if ($target) {
            $targetJudul = trim($target->detail?->judul ?? $target->judul);

            if ($target->jenis_kegiatan === 'pelatihan' && $target->kegiatanPelatihan?->jadwalPelatihan?->pelatihan) {
                $target->kegiatanPelatihan->jadwalPelatihan->pelatihan->update(['nama_latar' => $path]);
            } elseif ($target->jenis_kegiatan === 'sertifikasi' && $target->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi) {
                $target->kegiatanSertifikasi->jadwalSertifikasi->sertifikasi->update(['nama_latar' => $path]);
            }

            // Sync background template across all batch/schedule records with matching title
            $matching = Kegiatan::all()->filter(fn($k) => trim($k->detail?->judul ?? $k->judul) === $targetJudul);
            foreach ($matching as $k) {
                $k->update(['nama_latar' => $path]);
            }
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
