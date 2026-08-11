<?php
namespace App\Services\Admin;

use App\Models\{Sertifikat, Pendaftaran, Kegiatan};
use Illuminate\Http\UploadedFile;

class SertifikatService
{
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
        return Sertifikat::updateOrCreate(
            ['pendaftaran_id' => $pendaftaran->id],
            [
                'nomor_sertifikat' => Sertifikat::generateNomor($pendaftaran->kegiatan_id, $pendaftaran->id),
                'tgl_terbit'       => $tglTerbit,
                'gambar_latar'     => $pendaftaran->kegiatan->nama_latar,
            ]
        );
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
                'gambar_latar'     => $kegiatan->nama_latar,
            ]);
            $count++;
        }
        return $count;
    }
}
