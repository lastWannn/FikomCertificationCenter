<?php
namespace App\Services\Admin;

use App\Models\{JadwalPelatihan, Kegiatan, KegiatanPelatihan};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JadwalPelatihanService
{
    public function store(int $pelatihanId, array $data): JadwalPelatihan
    {
        return JadwalPelatihan::create(array_merge(
            collect($data)->only(['kuota_peserta','untuk_peserta','tgl_batas_daftar','tgl_pelaksanaan','jam_mulai','jam_selesai'])->toArray(),
            ['pelatihan_id' => $pelatihanId]
        ));
    }

    public function update(JadwalPelatihan $jadwal, array $data): JadwalPelatihan
    {
        $jadwal->update(
            collect($data)->only(['kuota_peserta','untuk_peserta','tgl_batas_daftar','tgl_pelaksanaan','jam_mulai','jam_selesai'])->toArray()
        );
        return $jadwal->fresh();
    }

    public function delete(JadwalPelatihan $jadwal): void
    {
        if ($jadwal->kegiatanPelatihan) {
            throw new \RuntimeException('Jadwal tidak bisa dihapus karena sudah aktif sebagai kegiatan.');
        }
        $jadwal->delete();
    }

    public function aktifkan(JadwalPelatihan $jadwal): Kegiatan
    {
        if ($jadwal->kegiatanPelatihan) {
            throw new \RuntimeException('Jadwal ini sudah aktif sebagai kegiatan.');
        }
        return $this->buatKegiatan($jadwal);
    }

    public function nonaktifkan(JadwalPelatihan $jadwal): void
    {
        $kp = $jadwal->kegiatanPelatihan;
        if (!$kp) throw new \RuntimeException('Jadwal ini belum aktif.');

        if ($kp->kegiatan->pendaftaran()->count() > 0) {
            throw new \RuntimeException('Kegiatan tidak bisa dinonaktifkan karena sudah ada peserta yang mendaftar.');
        }
        DB::transaction(function() use ($kp) {
            $kp->kegiatan()->delete();
            $kp->delete();
        });
    }

    private function buatKegiatan(JadwalPelatihan $jadwal): Kegiatan
    {
        return DB::transaction(function() use ($jadwal) {
            $kegiatan = Kegiatan::create([
                'jenis_kegiatan' => 'pelatihan',
                'qr_token'       => Str::random(32),
            ]);
            KegiatanPelatihan::create([
                'kegiatan_id'          => $kegiatan->id,
                'jadwal_pelatihan_id'  => $jadwal->id,
            ]);
            return $kegiatan;
        });
    }
}
