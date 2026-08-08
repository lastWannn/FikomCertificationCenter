<?php
namespace App\Services\Admin;

use App\Models\{JadwalPelatihan, Kegiatan, KegiatanPelatihan};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JadwalPelatihanService
{
    public function store(int $pelatihanId, array $data): JadwalPelatihan
    {
        $biayaSetup = $this->prepareBiayaSetup($data);
        return JadwalPelatihan::create(array_merge(
            collect($data)->only(['nama_kegiatan','kuota_peserta','untuk_peserta','tgl_batas_daftar','tgl_pelaksanaan','jam_mulai','jam_selesai'])->toArray(),
            ['pelatihan_id' => $pelatihanId, 'biaya_setup' => $biayaSetup]
        ));
    }

    public function update(JadwalPelatihan $jadwal, array $data): JadwalPelatihan
    {
        $biayaSetup = $this->prepareBiayaSetup($data);
        $jadwal->update(array_merge(
            collect($data)->only(['nama_kegiatan','kuota_peserta','untuk_peserta','tgl_batas_daftar','tgl_pelaksanaan','jam_mulai','jam_selesai'])->toArray(),
            ['biaya_setup' => $biayaSetup]
        ));

        // Sync to active Kegiatan if exists
        $kp = $jadwal->kegiatanPelatihan;
        if ($kp && $kegiatan = $kp->kegiatan) {
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
            $status = request('status');
            if (!$status) {
                $status = request()->boolean('langsung_aktifkan') ? 'public' : 'public';
            }
            $kegiatan = Kegiatan::create([
                'jenis_kegiatan' => 'pelatihan',
                'status'         => in_array($status, ['draf','comingsoon','public']) ? $status : 'public',
                'qr_token'       => Str::random(32),
            ]);
            KegiatanPelatihan::create([
                'kegiatan_id'          => $kegiatan->id,
                'jadwal_pelatihan_id'  => $jadwal->id,
            ]);

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
}
