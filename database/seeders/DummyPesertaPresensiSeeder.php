<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Kegiatan;
use App\Models\Peserta;
use App\Models\Pendaftaran;

class DummyPesertaPresensiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pilih kegiatan target (default: ID 35 atau kegiatan sertifikasi/pelatihan aktif terbaru)
        $kegiatan = Kegiatan::find(35) ?? Kegiatan::latest('id')->first();

        if (!$kegiatan) {
            $this->command->error('Tidak ada kegiatan yang ditemukan di database.');
            return;
        }

        $this->command->info("🎯 Menambahkan 30 peserta dummy ke Kegiatan ID: {$kegiatan->id} ({$kegiatan->judul})");

        // 2. Daftar 30 Peserta Dummy
        $pesertaNames = [
            'MUH. FAUZAN',
            'NURSYADANA M',
            'SULFADLY AMIN',
            'MUH. RAIHAN',
            'ASRUL',
            'NUR HIKMA',
            'RIDHA AYU KHAERANY',
            'MUHAMMAD IKRAM GHIFARI',
            'M IQBAL MAULANA',
            'HUSNUL KHATIMAH',
            'ZAHRA SAWAL SUWARDIN',
            'SITI HALIMAH SERANG',
            'FEBRIANTI',
            'NURVANIA SYAKIR',
            'ASTRI ANANDA WULANDARI',
            'MUTIA SALIANTI',
            'HIKMALIA',
            'ATIFA AZZAHIRAH',
            'NUR AZIZAH',
            'PUTRI ANANDA SAGITA',
            'NAYLA ANANDA',
            'WAHYUNI',
            'ANAWAY MARYAM TENRISOMPA',
            'AKHMAD KACHFI',
            'USWATUN HASANAH',
            'GITA SYAFITRA',
            'NUR MAHDANIA',
            'AKRAMUNNISA MUSTAMIN',
            'AUDITA CAHYANI AMIRUDDIN',
            'MUHAMMAD ALDI MAULANA',
        ];

        $biayaId = $kegiatan->biaya()->first()?->id;

        foreach ($pesertaNames as $index => $nama) {
            $slug = Str::slug($nama);
            $email = "{$slug}." . ($index + 1) . "@dummy-student.ac.id";

            // Buat atau dapatkan Peserta
            $peserta = Peserta::firstOrCreate(
                ['email' => $email],
                [
                    'nama'              => $nama,
                    'instansi'          => 'FIKOM UMI',
                    'kelamin'           => ($index % 2 === 0) ? 'L' : 'P',
                    'no_hp'             => '0821' . str_pad($index + 1000, 8, '0', STR_PAD_LEFT),
                    'pekerjaan'         => 'Mahasiswa',
                    'alamat'            => 'Jl. Urip Sumoharjo Km. 5, Makassar',
                    'password'          => Hash::make('password123'),
                    'status_akun'       => 'aktif',
                    'email_verified_at' => now(),
                ]
            );

            // Buat Pendaftaran dengan status 'terdaftar' (agar masuk ke cetak presensi)
            Pendaftaran::updateOrCreate(
                [
                    'peserta_id'  => $peserta->id,
                    'kegiatan_id' => $kegiatan->id,
                ],
                [
                    'biaya_kegiatan_id'  => $biayaId,
                    'tgl_daftar'         => now()->subDays(5)->addMinutes($index),
                    'status_pendaftaran' => 'terdaftar',
                    'status_kehadiran'   => 'belum',
                    'qr_token'           => Str::random(32),
                ]
            );
        }

        $url = route('admin.cetak.presensi', $kegiatan);
        $this->command->info("✅ Berhasil menambahkan 30 peserta dummy!");
        $this->command->info("📄 Cetak Presensi dapat dibuka di URL: {$url}");
    }
}
