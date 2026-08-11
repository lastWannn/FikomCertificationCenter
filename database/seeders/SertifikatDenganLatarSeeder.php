<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\{Peserta, Kegiatan, Pendaftaran, Sertifikat};

class SertifikatDenganLatarSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cari kegiatan yang SUDAH punya latar gambar (file valid)
        $kegiatanDenganLatar = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
        ])->get()->filter(function ($k) {
            if (empty($k->nama_latar)) return false;
            $ext = strtolower(pathinfo($k->nama_latar, PATHINFO_EXTENSION));
            if (!in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'svg'])) return false;
            return file_exists(public_path('storage/' . $k->nama_latar))
                || file_exists(storage_path('app/public/' . $k->nama_latar));
        })->values();

        if ($kegiatanDenganLatar->isEmpty()) {
            $this->command->warn('Tidak ada kegiatan dengan file latar sertifikat yang valid. Seeder dibatalkan.');
            return;
        }

        $this->command->info('Ditemukan ' . $kegiatanDenganLatar->count() . ' kegiatan dengan latar valid.');

        // 2. Ambil 3 kegiatan unik berdasarkan judul (hindari duplikat jadwal)
        $uniqueKegiatan = $kegiatanDenganLatar->unique(fn($k) => $k->judul)->take(3)->values();

        // 3. Daftar peserta dummy
        $pesertaList = [
            [
                'nama'     => 'Budi Santoso',
                'email'    => 'budi.santoso@example.com',
                'instansi' => 'Fakultas Ilmu Komputer UMI',
                'kelamin'  => 'L',
                'no_hp'    => '081355667788',
                'alamat'   => 'Jl. Boulevard, Makassar',
            ],
            [
                'nama'     => 'Dewi Lestari',
                'email'    => 'dewi.lestari@example.com',
                'instansi' => 'Universitas Muslim Indonesia',
                'kelamin'  => 'P',
                'no_hp'    => '085244556677',
                'alamat'   => 'Jl. Hertasning, Makassar',
            ],
            [
                'nama'     => 'Andi Firmansyah',
                'email'    => 'andi.firmansyah@example.com',
                'instansi' => 'PT Digital Nusantara',
                'kelamin'  => 'L',
                'no_hp'    => '081299001122',
                'alamat'   => 'Jl. Pengayoman, Makassar',
            ],
        ];

        $sertifikatCount = 0;

        foreach ($pesertaList as $idx => $data) {
            // Buat atau temukan akun peserta
            $peserta = Peserta::firstOrCreate(
                ['email' => $data['email']],
                [
                    'nama'              => $data['nama'],
                    'instansi'          => $data['instansi'],
                    'kelamin'           => $data['kelamin'],
                    'no_hp'             => $data['no_hp'],
                    'alamat'            => $data['alamat'],
                    'password'          => Hash::make('password'),
                    'status_akun'       => 'aktif',
                    'email_verified_at' => now(),
                ]
            );

            // Daftarkan peserta ke setiap kegiatan yang punya latar
            foreach ($uniqueKegiatan as $kIdx => $kegiatan) {
                $pendaftaran = Pendaftaran::firstOrCreate(
                    [
                        'peserta_id'  => $peserta->id,
                        'kegiatan_id' => $kegiatan->id,
                    ],
                    [
                        'biaya_kegiatan_id'  => $kegiatan->biaya()->first()?->id,
                        'tgl_daftar'         => now()->subDays(20 - $idx),
                        'status_pendaftaran' => 'terdaftar',
                        'status_kehadiran'   => 'hadir',
                        'qr_token'           => Str::random(32),
                    ]
                );

                // Terbitkan sertifikat
                $sertifikat = Sertifikat::updateOrCreate(
                    ['pendaftaran_id' => $pendaftaran->id],
                    [
                        'nomor_sertifikat' => Sertifikat::generateNomor($kegiatan->id, $pendaftaran->id),
                        'tgl_terbit'       => now()->subDays(3 - $kIdx),
                        'gambar_latar'     => $kegiatan->nama_latar,
                    ]
                );

                $sertifikatCount++;
                $this->command->line("  ✅ {$data['nama']} → {$kegiatan->judul} (Latar: ✓)");
            }
        }

        $this->command->info("\n🎉 Selesai! {$sertifikatCount} sertifikat berhasil diterbitkan dengan latar gambar.");
        $this->command->info('   Login peserta: email salah satu di atas / password: password');
    }
}
