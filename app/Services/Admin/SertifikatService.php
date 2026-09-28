<?php
namespace App\Services\Admin;

use App\Models\{Sertifikat, Pendaftaran, Kegiatan};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class SertifikatService
{
    protected static array $bgSrcCache = [];

    public function buildPdfViewData(Sertifikat $sertifikat): array
    {
        $sertifikat->loadMissing([
            'pendaftaran.peserta',
            'pendaftaran.nilai',
            'pendaftaran.kegiatan.kegiatanPelatihan.jadwalPelatihan.pelatihan.materi',
            'pendaftaran.kegiatan.kegiatanSertifikasi.jadwalSertifikasi.sertifikasi.materi',
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
                $bgSrc = $this->getOptimizedPdfBackground($realPath);
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

    /**
     * Get or create high-performance JPEG cache for background image.
     * Dompdf does NOT support WebP natively and takes 8+ seconds to software-convert WebP.
     * Native JPEG embedding via DCTDecode takes < 0.05 seconds!
     */
    public function getOptimizedPdfBackground(string $realPath): ?string
    {
        if (!file_exists($realPath) || !is_file($realPath)) {
            return null;
        }

        if (isset(self::$bgSrcCache[$realPath])) {
            return self::$bgSrcCache[$realPath];
        }

        $ext = strtolower(pathinfo($realPath, PATHINFO_EXTENSION));

        // SVG handling
        if ($ext === 'svg') {
            $src = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($realPath));
            return self::$bgSrcCache[$realPath] = $src;
        }

        // Direct JPEG
        if (in_array($ext, ['jpg', 'jpeg'])) {
            $src = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($realPath));
            return self::$bgSrcCache[$realPath] = $src;
        }

        // Convert WebP / PNG to high-performance JPEG cache for Dompdf native embedding
        $cacheDir = storage_path('app/public/latar-sertifikat/cache');
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }

        $cacheFile = $cacheDir . '/' . md5_file($realPath) . '.jpg';
        if (!file_exists($cacheFile)) {
            if ($ext === 'webp' && function_exists('imagecreatefromwebp')) {
                $img = @imagecreatefromwebp($realPath);
                if ($img) {
                    imagejpeg($img, $cacheFile, 90);
                    imagedestroy($img);
                }
            } elseif ($ext === 'png' && function_exists('imagecreatefrompng')) {
                $img = @imagecreatefrompng($realPath);
                if ($img) {
                    $w = imagesx($img);
                    $h = imagesy($img);
                    $bg = imagecreatetruecolor($w, $h);
                    $white = imagecolorallocate($bg, 255, 255, 255);
                    imagefill($bg, 0, 0, $white);
                    imagecopy($bg, $img, 0, 0, 0, 0, $w, $h);
                    imagejpeg($bg, $cacheFile, 90);
                    imagedestroy($img);
                    imagedestroy($bg);
                }
            }
        }

        if (file_exists($cacheFile)) {
            $src = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($cacheFile));
            return self::$bgSrcCache[$realPath] = $src;
        }

        // Fallback
        $src = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($realPath));
        return self::$bgSrcCache[$realPath] = $src;
    }

    public function regeneratePdf(Sertifikat $sertifikat): void
    {
        @set_time_limit(120);

        $safeNomor = str_replace(['/', '\\'], '-', $sertifikat->nomor_sertifikat);
        $fileName = "sertifikat-{$safeNomor}.pdf";
        $outputDir = storage_path('app/public/sertifikat-cetak');

        File::ensureDirectoryExists($outputDir);

        $pdf = app('dompdf.wrapper')
            ->setPaper('a4', 'landscape')
            ->setOption('isRemoteEnabled', false) // Fast local-only rendering, 0 network latency
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

            Sertifikat::whereHas('pendaftaran', fn($q) => $q->where('kegiatan_id', $k->id))
                ->update([
                    'gambar_latar' => $path,
                    'file_sertifikat' => null,
                ]);
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
                'file_sertifikat'  => null, // On-Demand: Terbit instan (<0.05s). PDF digenerate otomatis saat dilihat/diunduh.
            ]
        );

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
            Sertifikat::create([
                'pendaftaran_id'   => $pd->id,
                'nomor_sertifikat' => Sertifikat::generateNomor($pd->kegiatan_id, $pd->id),
                'tgl_terbit'       => $tglTerbit,
                'gambar_latar'     => $pd->kegiatan->nama_latar,
                'file_sertifikat'  => null, // On-Demand: PDF digenerate otomatis saat dilihat/diunduh
            ]);
            $count++;
        }
        return $count;
    }
}
