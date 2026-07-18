<?php
namespace App\Services\Admin;

use App\Models\{JadwalSertifikasi, Kegiatan, KegiatanSertifikasi};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JadwalSertifikasiService
{
    public function store(int $sertifikasiId, array $data): JadwalSertifikasi
    {
        return JadwalSertifikasi::create(array_merge(
            collect($data)->only(['nama_kegiatan','nama_jenis_biaya','nominal_biaya','kuota_peserta','untuk_peserta','tgl_batas_daftar','tgl_pelaksanaan','jam_mulai','jam_selesai'])->toArray(),
            ['sertifikasi_id' => $sertifikasiId]
        ));
    }

    public function update(JadwalSertifikasi $jadwal, array $data): JadwalSertifikasi
    {
        $jadwal->update(
            collect($data)->only(['nama_kegiatan','nama_jenis_biaya','nominal_biaya','kuota_peserta','untuk_peserta','tgl_batas_daftar','tgl_pelaksanaan','jam_mulai','jam_selesai'])->toArray()
        );
        return $jadwal->fresh();
    }

    public function delete(JadwalSertifikasi $jadwal): void
    {
        if ($jadwal->kegiatanSertifikasi) {
            throw new \RuntimeException('Jadwal tidak bisa dihapus karena sudah aktif sebagai kegiatan.');
        }
        $jadwal->delete();
    }

    public function aktifkan(JadwalSertifikasi $jadwal): Kegiatan
    {
        if ($jadwal->kegiatanSertifikasi) {
            throw new \RuntimeException('Jadwal ini sudah aktif sebagai kegiatan.');
        }
        return DB::transaction(function() use ($jadwal) {
            $kegiatan = Kegiatan::create(['jenis_kegiatan'=>'sertifikasi','qr_token'=>Str::random(32)]);
            KegiatanSertifikasi::create(['kegiatan_id'=>$kegiatan->id,'jadwal_sertifikasi_id'=>$jadwal->id]);

            if ($jadwal->nominal_biaya !== null) {
                \App\Models\BiayaKegiatan::create([
                    'kegiatan_id' => $kegiatan->id,
                    'nama_jenis'  => $jadwal->nama_jenis_biaya ?? 'Umum',
                    'nominal'     => $jadwal->nominal_biaya,
                ]);
            }

            return $kegiatan;
        });
    }

    public function nonaktifkan(JadwalSertifikasi $jadwal): void
    {
        $ks = $jadwal->kegiatanSertifikasi;
        if (!$ks) throw new \RuntimeException('Jadwal ini belum aktif.');
        if ($ks->kegiatan->pendaftaran()->count() > 0) {
            throw new \RuntimeException('Kegiatan tidak bisa dinonaktifkan karena sudah ada peserta.');
        }
        DB::transaction(function() use ($ks) {
            $ks->kegiatan()->delete();
            $ks->delete();
        });
    }
}
