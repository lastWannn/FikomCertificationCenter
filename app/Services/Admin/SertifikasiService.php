<?php

namespace App\Services\Admin;

use App\Models\Sertifikasi;
use Illuminate\Http\UploadedFile;

class SertifikasiService
{
    public function create(array $data): Sertifikasi
    {
        $sertData = collect($data)->only(['kode', 'judul', 'isi', 'kategori_id'])->toArray();
        if (isset($data['gambar']) && $data['gambar'] instanceof UploadedFile) {
            $sertData['gambar'] = $data['gambar']->store('sertifikasi', 'public');
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
                $matData['file_materi'] = $data['file_materi']->store('materi/sertifikasi', 'public');
            } elseif (!empty($data['link_materi'])) {
                $matData['file_materi'] = $data['link_materi'];
            }
            \App\Models\MateriSertifikasi::create($matData);
        }
        
        // Handle initial schedule if present
        if (!empty($data['tgl_pelaksanaan'])) {
            $jadwalData = [
                'sertifikasi_id' => $sertifikasi->id,
                'nama_kegiatan' => $data['jadwal_nama_kegiatan'] ?? null,
                'nama_jenis_biaya' => $data['nama_jenis_biaya'] ?? null,
                'nominal_biaya' => $data['nominal_biaya'] ?? null,
                'kuota_peserta' => $data['kuota_peserta'] ?? 20,
                'untuk_peserta' => $data['untuk_peserta'] ?? 'LP',
                'tgl_batas_daftar' => $data['tgl_batas_daftar'] ?? $data['tgl_pelaksanaan'],
                'tgl_pelaksanaan' => $data['tgl_pelaksanaan'],
                'jam_mulai' => $data['jam_mulai'] ?? '08:00',
                'jam_selesai' => $data['jam_selesai'] ?? '12:00',
            ];
            $jadwal = \App\Models\JadwalSertifikasi::create($jadwalData);

            if (isset($data['langsung_aktifkan']) && $data['langsung_aktifkan']) {
                $kegiatan = \App\Models\Kegiatan::create([
                    'jenis_kegiatan' => 'sertifikasi',
                    'qr_token' => \Illuminate\Support\Str::random(32)
                ]);
                \App\Models\KegiatanSertifikasi::create([
                    'kegiatan_id' => $kegiatan->id,
                    'jadwal_sertifikasi_id' => $jadwal->id
                ]);
            }
        }
        
        return $sertifikasi;
    }

    public function update(Sertifikasi $sertifikasi, array $data): Sertifikasi
    {
        if (isset($data['gambar']) && $data['gambar'] instanceof UploadedFile) {
            $data['gambar'] = $data['gambar']->store('sertifikasi', 'public');
        }
        unset($data['_token'], $data['_method']);
        $sertifikasi->update($data);
        return $sertifikasi->fresh();
    }

    public function delete(Sertifikasi $sertifikasi): void
    {
        $sertifikasi->delete();
    }
}
