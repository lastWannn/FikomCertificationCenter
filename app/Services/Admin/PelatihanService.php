<?php
namespace App\Services\Admin;

use App\Models\Pelatihan;
use Illuminate\Http\UploadedFile;

class PelatihanService
{
    public function create(array $data): Pelatihan
    {
        $pelData = collect($data)->only(['kode', 'judul', 'isi', 'kategori_id', 'instruktur_id', 'link_materi'])->toArray();
        if (isset($data['gambar']) && $data['gambar'] instanceof UploadedFile) {
            $pelData['gambar'] = $data['gambar']->store('pelatihan', 'public');
        }
        
        $pelatihan = Pelatihan::create($pelData);
        
        // Handle initial material if present
        if (!empty($data['judul_materi'])) {
            $matData = [
                'pelatihan_id' => $pelatihan->id,
                'judul_materi' => $data['judul_materi'],
                'urutan' => 1,
            ];
            // Provide a default jam_pelajaran since it's required in MateriPelatihan
            $matData['jam_pelajaran'] = 1;

            if (isset($data['file_materi']) && $data['file_materi'] instanceof UploadedFile) {
                $matData['file_materi'] = $data['file_materi']->store('materi/pelatihan', 'public');
            } elseif (!empty($data['link_materi'])) {
                $matData['file_materi'] = $data['link_materi'];
            }
            \App\Models\MateriPelatihan::create($matData);
        }
        
        // Handle initial schedule if present
        if (!empty($data['tgl_pelaksanaan'])) {
            $biayaSetup = [];
            if (!empty($data['nama_jenis_biaya']) && is_array($data['nama_jenis_biaya'])) {
                foreach ($data['nama_jenis_biaya'] as $index => $nama) {
                    $nominal = $data['nominal_biaya'][$index] ?? 0;
                    if (!empty($nama) && $nominal !== null && $nominal !== '') {
                        $biayaSetup[] = ['nama' => $nama, 'nominal' => (float) $nominal];
                    }
                }
            }

            $jadwalData = [
                'pelatihan_id' => $pelatihan->id,
                'nama_kegiatan' => $data['jadwal_nama_kegiatan'] ?? null,
                'biaya_setup' => empty($biayaSetup) ? null : $biayaSetup,
                'kuota_peserta' => $data['kuota_peserta'] ?? 20,
                'untuk_peserta' => $data['untuk_peserta'] ?? 'LP',
                'tgl_batas_daftar' => $data['tgl_batas_daftar'] ?? $data['tgl_pelaksanaan'],
                'tgl_pelaksanaan' => $data['tgl_pelaksanaan'],
                'jam_mulai' => $data['jam_mulai'] ?? '08:00',
                'jam_selesai' => $data['jam_selesai'] ?? '12:00',
            ];
            $jadwal = \App\Models\JadwalPelatihan::create($jadwalData);

            if (isset($data['langsung_aktifkan']) && $data['langsung_aktifkan']) {
                $kegiatan = \App\Models\Kegiatan::create([
                    'jenis_kegiatan' => 'pelatihan',
                    'qr_token' => \Illuminate\Support\Str::random(32)
                ]);
                \App\Models\KegiatanPelatihan::create([
                    'kegiatan_id' => $kegiatan->id,
                    'jadwal_pelatihan_id' => $jadwal->id
                ]);
            }
        }
        
        return $pelatihan;
    }

    public function update(Pelatihan $pelatihan, array $data): Pelatihan
    {
        if (isset($data['gambar']) && $data['gambar'] instanceof UploadedFile) {
            $data['gambar'] = $data['gambar']->store('pelatihan', 'public');
        }
        unset($data['_token'], $data['_method']);
        $pelatihan->update($data);
        return $pelatihan->fresh();
    }

    public function delete(Pelatihan $pelatihan): void
    {
        $pelatihan->delete();
    }
}
