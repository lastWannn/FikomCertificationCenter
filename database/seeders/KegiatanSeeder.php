<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelatihan;
use App\Models\Sertifikasi;
use App\Models\JadwalPelatihan;
use App\Models\JadwalSertifikasi;
use App\Models\Kegiatan;
use App\Models\KegiatanPelatihan;
use App\Models\KegiatanSertifikasi;
use App\Models\BiayaKegiatan;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelatihanWeb = Pelatihan::where('kode', 'PL-001')->first();
        $pelatihanGit = Pelatihan::where('kode', 'PL-002')->first();
        $sertifikasiMtcna = Sertifikasi::where('kode', 'SR-001')->first();

        // 1. Kegiatan Pelatihan Web Dev (Berbayar)
        if ($pelatihanWeb) {
            $jadwal1 = JadwalPelatihan::firstOrCreate(
                ['nama_kegiatan' => 'Batch 1 - Web Dev Dasar'],
                [
                    'pelatihan_id' => $pelatihanWeb->id,
                    'kuota_peserta' => 30,
                    'untuk_peserta' => 'LP',
                    'tgl_batas_daftar' => now()->addDays(7)->format('Y-m-d'),
                    'tgl_pelaksanaan' => now()->addDays(14)->format('Y-m-d'),
                    'jam_mulai' => '09:00:00',
                    'jam_selesai' => '15:00:00',
                ]
            );

            $latarFile = file_exists(storage_path('app/public/latar-sertifikat/temp_bg.jpg')) ? 'latar-sertifikat/temp_bg.jpg' : null;

            $kegiatan1 = Kegiatan::firstOrCreate(
                ['jenis_kegiatan' => 'pelatihan', 'id' => 1],
                ['nama_latar' => $latarFile]
            );
            
            KegiatanPelatihan::firstOrCreate([
                'kegiatan_id' => $kegiatan1->id,
                'jadwal_pelatihan_id' => $jadwal1->id
            ]);

            BiayaKegiatan::firstOrCreate(['kegiatan_id' => $kegiatan1->id, 'nama_jenis' => 'Mahasiswa FIKOM UMI', 'nominal' => 150000]);
            BiayaKegiatan::firstOrCreate(['kegiatan_id' => $kegiatan1->id, 'nama_jenis' => 'Dosen/Pegawai UMI, Alumni UMI, Mahasiswa Umum', 'nominal' => 250000]);
            BiayaKegiatan::firstOrCreate(['kegiatan_id' => $kegiatan1->id, 'nama_jenis' => 'Umum', 'nominal' => 350000]);
        }

        // 2. Kegiatan Workshop Git (Gratis)
        if ($pelatihanGit) {
            $jadwal2 = JadwalPelatihan::firstOrCreate(
                ['nama_kegiatan' => 'Workshop Git & GitHub 2026'],
                [
                    'pelatihan_id' => $pelatihanGit->id,
                    'kuota_peserta' => 50,
                    'untuk_peserta' => 'LP',
                    'tgl_batas_daftar' => now()->addDays(5)->format('Y-m-d'),
                    'tgl_pelaksanaan' => now()->addDays(10)->format('Y-m-d'),
                    'jam_mulai' => '13:00:00',
                    'jam_selesai' => '16:00:00',
                ]
            );

            $kegiatan2 = Kegiatan::firstOrCreate(
                ['jenis_kegiatan' => 'pelatihan', 'id' => 2],
                ['nama_latar' => $latarFile]
            );
            
            KegiatanPelatihan::firstOrCreate([
                'kegiatan_id' => $kegiatan2->id,
                'jadwal_pelatihan_id' => $jadwal2->id
            ]);
            // Tanpa Biaya -> Gratis
        }

        // 3. Kegiatan Sertifikasi MTCNA
        if ($sertifikasiMtcna) {
            $jadwal3 = JadwalSertifikasi::firstOrCreate(
                ['nama_kegiatan' => 'Sertifikasi MTCNA 2026'],
                [
                    'sertifikasi_id' => $sertifikasiMtcna->id,
                    'kuota_peserta' => 20,
                    'untuk_peserta' => 'LP',
                    'tgl_batas_daftar' => now()->addDays(10)->format('Y-m-d'),
                    'tgl_pelaksanaan' => now()->addDays(20)->format('Y-m-d'),
                    'jam_mulai' => '08:00:00',
                    'jam_selesai' => '17:00:00',
                ]
            );

            $kegiatan3 = Kegiatan::firstOrCreate(
                ['jenis_kegiatan' => 'sertifikasi', 'id' => 3],
                ['nama_latar' => $latarFile]
            );

            KegiatanSertifikasi::firstOrCreate([
                'kegiatan_id' => $kegiatan3->id,
                'jadwal_sertifikasi_id' => $jadwal3->id
            ]);

            BiayaKegiatan::firstOrCreate(['kegiatan_id' => $kegiatan3->id, 'nama_jenis' => 'Mahasiswa FIKOM UMI', 'nominal' => 400000]);
            BiayaKegiatan::firstOrCreate(['kegiatan_id' => $kegiatan3->id, 'nama_jenis' => 'Dosen/Pegawai UMI, Alumni UMI, Mahasiswa Umum', 'nominal' => 600000]);
            BiayaKegiatan::firstOrCreate(['kegiatan_id' => $kegiatan3->id, 'nama_jenis' => 'Umum', 'nominal' => 800000]);
        }
    }
}
