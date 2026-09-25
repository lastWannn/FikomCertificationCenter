<?php
namespace App\Services\Admin;

use App\Models\Pelatihan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class PelatihanService
{
    public function create(array $data): Pelatihan
    {
        if (isset($data['fasilitas_input'])) {
            $deskripsiText = trim($data['isi'] ?? '');
            $fasilitasText = trim($data['fasilitas_input']);
            if (!empty($fasilitasText)) {
                $lines = array_filter(array_map('trim', explode("\n", $fasilitasText)));
                $formattedLines = array_map(function($line) {
                    return preg_match('/^[\-\*\+\•]\s*/u', $line) ? $line : '- ' . $line;
                }, $lines);
                $data['isi'] = $deskripsiText . "\n\n--- Fasilitas ---\n" . implode("\n", $formattedLines);
            } else {
                $data['isi'] = $deskripsiText;
            }
        }

        $pelData = collect($data)->only(['kode', 'judul', 'isi', 'kategori_id', 'prasyarat_id', 'link_materi'])->toArray();
        if (isset($data['gambar']) && $data['gambar'] instanceof UploadedFile) {
            $pelData['gambar'] = \App\Helpers\ImageHelper::compressToWebp($data['gambar'], 'pelatihan');
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
        if (isset($data['fasilitas_input'])) {
            $deskripsiText = trim($data['isi'] ?? '');
            $fasilitasText = trim($data['fasilitas_input']);
            if (!empty($fasilitasText)) {
                $lines = array_filter(array_map('trim', explode("\n", $fasilitasText)));
                $formattedLines = array_map(function($line) {
                    return preg_match('/^[\-\*\+\•]\s*/u', $line) ? $line : '- ' . $line;
                }, $lines);
                $data['isi'] = $deskripsiText . "\n\n--- Fasilitas ---\n" . implode("\n", $formattedLines);
            } else {
                $data['isi'] = $deskripsiText;
            }
        }

        $pelData = collect($data)->only(['kode', 'judul', 'isi', 'kategori_id', 'prasyarat_id', 'link_materi'])->toArray();
        if (isset($data['gambar']) && $data['gambar'] instanceof UploadedFile) {
            $pelData['gambar'] = \App\Helpers\ImageHelper::compressToWebp($data['gambar'], 'pelatihan');
        }
        $pelatihan->update($pelData);

        // Update the latest jadwal if schedule data is provided
        if (isset($data['tgl_pelaksanaan']) || isset($data['tgl_batas_daftar']) || isset($data['jam_mulai']) || isset($data['jam_selesai']) || isset($data['kuota_peserta'])) {
            $latestJadwal = $pelatihan->jadwal()->latest()->first();
            if ($latestJadwal) {
                $jadwalData = [];
                if (isset($data['tgl_pelaksanaan'])) $jadwalData['tgl_pelaksanaan'] = $data['tgl_pelaksanaan'];
                if (isset($data['tgl_batas_daftar'])) $jadwalData['tgl_batas_daftar'] = $data['tgl_batas_daftar'];
                if (isset($data['jam_mulai'])) $jadwalData['jam_mulai'] = $data['jam_mulai'];
                if (isset($data['jam_selesai'])) $jadwalData['jam_selesai'] = $data['jam_selesai'];
                if (isset($data['kuota_peserta'])) $jadwalData['kuota_peserta'] = $data['kuota_peserta'];
                
                $latestJadwal->update($jadwalData);
            }
        }

        return $pelatihan->fresh();
    }

    public function delete(Pelatihan $pelatihan): void
    {
        foreach ($pelatihan->jadwal as $j) {
            $kp = $j->kegiatanPelatihan;
            if ($kp && $kp->kegiatan && $kp->kegiatan->pendaftaran()->count() > 0) {
                throw new \RuntimeException('Pelatihan "' . $pelatihan->judul . '" tidak dapat dihapus karena jadwal ' . ($j->nama_kegiatan ?? $pelatihan->judul) . ' sudah memiliki peserta terdaftar.');
            }
        }

        DB::transaction(function () use ($pelatihan) {
            // Delete associated materi & persyaratan
            $pelatihan->materi()->delete();
            $pelatihan->persyaratan()->delete();

            // Delete associated jadwal and non-active kegiatan
            foreach ($pelatihan->jadwal as $j) {
                $kp = $j->kegiatanPelatihan;
                if ($kp) {
                    $keg = $kp->kegiatan;
                    if ($keg) {
                        $keg->biaya()->delete();
                        $keg->delete();
                    }
                    $kp->delete();
                }
                $j->delete();
            }

            // Delete pelatihan
            $pelatihan->delete();
        });
    }
}
