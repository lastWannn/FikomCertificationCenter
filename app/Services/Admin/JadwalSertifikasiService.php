<?php
namespace App\Services\Admin;

use App\Models\{JadwalSertifikasi, Kegiatan, KegiatanSertifikasi};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JadwalSertifikasiService
{
    public function store(int $sertifikasiId, array $data): JadwalSertifikasi
    {
        $biayaSetup = $this->prepareBiayaSetup($data);
        return JadwalSertifikasi::create(array_merge(
            collect($data)->only(['nama_kegiatan','kuota_peserta','untuk_peserta','tgl_batas_daftar','tgl_pelaksanaan','jam_mulai','jam_selesai'])->toArray(),
            ['sertifikasi_id' => $sertifikasiId, 'biaya_setup' => $biayaSetup]
        ));
    }

    public function update(JadwalSertifikasi $jadwal, array $data): JadwalSertifikasi
    {
        $biayaSetup = $this->prepareBiayaSetup($data);
        $jadwal->update(array_merge(
            collect($data)->only(['nama_kegiatan','kuota_peserta','untuk_peserta','tgl_batas_daftar','tgl_pelaksanaan','jam_mulai','jam_selesai'])->toArray(),
            ['biaya_setup' => $biayaSetup]
        ));

        // Sync to active Kegiatan if exists
        $ks = $jadwal->kegiatanSertifikasi;
        if ($ks && $kegiatan = $ks->kegiatan) {
            $kegiatan->biaya()->delete();
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

        return $jadwal->fresh();
    }

    private function prepareBiayaSetup(array $data): ?array
    {
        $biayaSetup = [];
        if (!empty($data['nama_jenis_biaya']) && is_array($data['nama_jenis_biaya'])) {
            foreach ($data['nama_jenis_biaya'] as $index => $nama) {
                $nominal = $data['nominal_biaya'][$index] ?? 0;
                if (!empty($nama) && $nominal !== null && $nominal !== '') {
                    $biayaSetup[] = ['nama' => $nama, 'nominal' => (float) $nominal];
                }
            }
        }
        return empty($biayaSetup) ? null : $biayaSetup;
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
            $status = request('status');
            if (!$status) {
                $status = request()->boolean('langsung_aktifkan') ? 'public' : 'public';
            }
            $kegiatan = Kegiatan::create([
                'jenis_kegiatan' => 'sertifikasi',
                'status'         => in_array($status, ['draf','comingsoon','public']) ? $status : 'public',
                'qr_token'       => Str::random(32),
            ]);
            KegiatanSertifikasi::create(['kegiatan_id'=>$kegiatan->id,'jadwal_sertifikasi_id'=>$jadwal->id]);

            if (!empty($jadwal->biaya_setup) && is_array($jadwal->biaya_setup)) {
                foreach ($jadwal->biaya_setup as $biaya) {
                    \App\Models\BiayaKegiatan::create([
                        'kegiatan_id' => $kegiatan->id,
                        'nama_jenis'  => $biaya['nama'],
                        'nominal'     => $biaya['nominal'],
                    ]);
                }
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
