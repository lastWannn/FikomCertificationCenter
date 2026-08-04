<?php

namespace App\Services\Admin;

use App\Models\Sertifikasi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SertifikasiService
{
    public function create(array $data): Sertifikasi
    {
        $sertData = collect($data)->only(['kode', 'judul', 'isi', 'kategori_id'])->toArray();
        if (isset($data['gambar']) && $data['gambar'] instanceof UploadedFile) {
            $sertData['gambar'] = \App\Helpers\ImageHelper::compressToWebp($data['gambar'], 'sertifikasi');
        }
        
        $sertifikasi = Sertifikasi::create($sertData);
        
        // Handle initial material if present
        if (!empty($data['judul_materi'])) {
            $matData = [
                'sertifikasi_id' => $sertifikasi->id,
                'judul_materi' => $data['judul_materi'],
                'urutan' => 1,
            ];
            if (isset($data['file_materi']) && $data['file_materi'] instanceof UploadedFile) {
                $matData['file_materi'] = $data['file_materi']->store('materi_sertifikasi', 'public');
            }
            if (!empty($data['link_materi'])) {
                $matData['link_materi'] = $data['link_materi'];
            }
            \App\Models\MateriSertifikasi::create($matData);
        }
        
        // Handle initial schedule if present
        if (!empty($data['kuota_peserta']) || !empty($data['tgl_pelaksanaan'])) {
            $biayaSetup = [];
            if (!empty($data['nama_jenis_biaya']) && is_array($data['nama_jenis_biaya'])) {
                foreach ($data['nama_jenis_biaya'] as $idx => $nama) {
                    $nominal = $data['nominal_biaya'][$idx] ?? 0;
                    if (!empty($nama) && $nominal !== null && $nominal !== '') {
                        $biayaSetup[] = ['nama' => $nama, 'nominal' => (float)$nominal];
                    }
                }
            }

            $tglPelaksanaan = $data['tgl_pelaksanaan'] ?? now()->toDateString();
            $tglBatas = !empty($data['tgl_batas_daftar']) ? $data['tgl_batas_daftar'] : $tglPelaksanaan;

            $jadwalData = [
                'sertifikasi_id'   => $sertifikasi->id,
                'nama_kegiatan'    => $data['jadwal_nama_kegiatan'] ?? null,
                'biaya_setup'      => empty($biayaSetup) ? null : $biayaSetup,
                'kuota_peserta'    => $data['kuota_peserta'] ?? 20,
                'untuk_peserta'    => $data['untuk_peserta'] ?? 'LP',
                'tgl_batas_daftar' => $tglBatas,
                'tgl_pelaksanaan'  => $tglPelaksanaan,
                'jam_mulai'        => $data['jam_mulai'] ?? '08:00',
                'jam_selesai'      => $data['jam_selesai'] ?? '12:00',
            ];
            
            $jadwal = \App\Models\JadwalSertifikasi::create($jadwalData);

            if (isset($data['langsung_aktifkan']) && $data['langsung_aktifkan']) {
                $kegiatan = \App\Models\Kegiatan::create([
                    'jenis_kegiatan' => 'sertifikasi',
                    'qr_token'       => \Illuminate\Support\Str::random(32)
                ]);
                \App\Models\KegiatanSertifikasi::create([
                    'kegiatan_id'            => $kegiatan->id,
                    'jadwal_sertifikasi_id' => $jadwal->id
                ]);

                if (!empty($biayaSetup)) {
                    foreach ($biayaSetup as $b) {
                        \App\Models\BiayaKegiatan::create([
                            'kegiatan_id' => $kegiatan->id,
                            'nama_jenis'  => $b['nama'],
                            'nominal'     => $b['nominal'],
                        ]);
                    }
                }
            }
        }
        
        return $sertifikasi;
    }

    public function update(Sertifikasi $sertifikasi, array $data): Sertifikasi
    {
        if (isset($data['gambar']) && $data['gambar'] instanceof UploadedFile) {
            $data['gambar'] = \App\Helpers\ImageHelper::compressToWebp($data['gambar'], 'sertifikasi');
        }
        unset($data['_token'], $data['_method']);
        $sertifikasi->update($data);
        return $sertifikasi->fresh();
    }

    public function delete(Sertifikasi $sertifikasi): void
    {
        foreach ($sertifikasi->jadwal as $j) {
            $ks = $j->kegiatanSertifikasi;
            if ($ks && $ks->kegiatan && $ks->kegiatan->pendaftaran()->count() > 0) {
                throw new \RuntimeException('Sertifikasi "' . $sertifikasi->judul . '" tidak dapat dihapus karena jadwal ' . ($j->nama_kegiatan ?? $sertifikasi->judul) . ' sudah memiliki peserta terdaftar.');
            }
        }

        DB::transaction(function () use ($sertifikasi) {
            // Delete associated materi
            $sertifikasi->materi()->delete();

            // Delete associated jadwal and non-active kegiatan
            foreach ($sertifikasi->jadwal as $j) {
                $ks = $j->kegiatanSertifikasi;
                if ($ks) {
                    $keg = $ks->kegiatan;
                    if ($keg) {
                        $keg->biaya()->delete();
                        $keg->delete();
                    }
                    $ks->delete();
                }
                $j->delete();
            }

            // Delete sertifikasi
            $sertifikasi->delete();
        });
    }
}
