<?php
namespace App\Services\Admin;

use App\Models\{Nilai, Pendaftaran};

class NilaiService
{
    /**
     * FIX BUG: Key format adalah 'pel-{id}' atau 'sert-{id}'
     * 'materi_'.$type.'_id' menghasilkan 'materi_pel_id' yang SALAH.
     * Seharusnya 'materi_pelatihan_id' atau 'materi_sertifikasi_id'.
     */
    public function simpan(Pendaftaran $pendaftaran, array $nilaiArr): int
    {
        $count = 0;
        foreach ($nilaiArr as $key => $nilai) {
            // FIX: parse 'pel-{id}' → type=pelatihan, 'sert-{id}' → type=sertifikasi
            [$prefix, $id] = explode('-', $key, 2);
            $kolom   = $prefix === 'pel' ? 'materi_pelatihan_id' : 'materi_sertifikasi_id';
            $kolom2  = $prefix === 'pel' ? 'materi_sertifikasi_id' : 'materi_pelatihan_id';

            Nilai::updateOrCreate(
                ['pendaftaran_id' => $pendaftaran->id, $kolom => $id],  // FIX: pakai nama kolom lengkap
                ['pendaftaran_id' => $pendaftaran->id, $kolom => $id, $kolom2 => null, 'nilai' => $nilai]
            );
            $count++;
        }
        return $count;
    }

    public function update(Nilai $nilai, float $nilaiVal, ?string $keterangan = null): void
    {
        $nilai->update(['nilai' => $nilaiVal, 'keterangan' => $keterangan]);
    }
}
