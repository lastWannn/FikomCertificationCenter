<?php

namespace Database\Seeders;

use App\Models\{Kegiatan, Pendaftaran, Peserta, Sertifikat};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SiapTerbitSertifikatSeeder extends Seeder
{
    public function run(): void
    {
        $seedEmails = [
            'rizky.pratama@example.com',
            'nabila.salsabila@example.com',
            'fahri.maulana@example.com',
        ];

        $existingPesertaIds = Peserta::withTrashed()->whereIn('email', $seedEmails)->pluck('id');
        $existingPendaftaranIds = Pendaftaran::whereIn('peserta_id', $existingPesertaIds)->pluck('id');

        if ($existingPendaftaranIds->isNotEmpty()) {
            Sertifikat::whereIn('pendaftaran_id', $existingPendaftaranIds)->delete();
            Pendaftaran::whereIn('id', $existingPendaftaranIds)->delete();
        }

        if ($existingPesertaIds->isNotEmpty()) {
            Peserta::withTrashed()->whereIn('id', $existingPesertaIds)->forceDelete();
        }

        $seededFiles = storage_path('app/public/sertifikat-cetak');
        if (File::exists($seededFiles)) {
            foreach (File::files($seededFiles) as $file) {
                File::delete($file->getPathname());
            }
        }

        $kegiatan = Kegiatan::whereNotNull('nama_latar')
            ->where('nama_latar', '!=', '')
            ->get()
            ->first(function ($item) {
                $extension = strtolower(pathinfo($item->nama_latar, PATHINFO_EXTENSION));
                if (!in_array($extension, ['png', 'jpg', 'jpeg', 'webp', 'svg'])) {
                    return false;
                }

                return file_exists(public_path('storage/' . $item->nama_latar))
                    || file_exists(storage_path('app/public/' . $item->nama_latar));
            });

        if (!$kegiatan) {
            $this->command?->warn('Tidak ada kegiatan dengan latar valid untuk seeder sertifikat.');
            return;
        }

        $pesertaList = [
            [
                'nama' => 'Rizky Pratama',
                'email' => 'rizky.pratama@example.com',
                'instansi' => 'Universitas Muslim Indonesia',
                'kelamin' => 'L',
                'no_hp' => '081234560001',
                'alamat' => 'Jl. Perintis Kemerdekaan, Makassar',
            ],
            [
                'nama' => 'Nabila Salsabila',
                'email' => 'nabila.salsabila@example.com',
                'instansi' => 'Fakultas Ilmu Komputer UMI',
                'kelamin' => 'P',
                'no_hp' => '081234560002',
                'alamat' => 'Jl. Urip Sumoharjo, Makassar',
            ],
            [
                'nama' => 'Fahri Maulana',
                'email' => 'fahri.maulana@example.com',
                'instansi' => 'PT Digital Nusantara',
                'kelamin' => 'L',
                'no_hp' => '081234560003',
                'alamat' => 'Jl. Andi Pangeran Pettarani, Makassar',
            ],
        ];

        $count = 0;

        foreach ($pesertaList as $index => $data) {
            $peserta = Peserta::updateOrCreate(
                ['email' => $data['email']],
                [
                    'nama' => $data['nama'],
                    'instansi' => $data['instansi'],
                    'kelamin' => $data['kelamin'],
                    'no_hp' => $data['no_hp'],
                    'alamat' => $data['alamat'],
                    'password' => Hash::make('password'),
                    'status_akun' => 'aktif',
                    'email_verified_at' => now(),
                ]
            );

            $pendaftaran = Pendaftaran::firstOrCreate(
                [
                    'peserta_id' => $peserta->id,
                    'kegiatan_id' => $kegiatan->id,
                ],
                [
                    'biaya_kegiatan_id' => $kegiatan->biaya()->first()?->id,
                    'tgl_daftar' => now()->subDays(14 - $index),
                    'status_pendaftaran' => 'terdaftar',
                    'status_kehadiran' => 'hadir',
                    'qr_token' => Str::random(32),
                ]
            );

            Sertifikat::updateOrCreate(
                ['pendaftaran_id' => $pendaftaran->id],
                [
                    'nomor_sertifikat' => Sertifikat::generateNomor($kegiatan->id, $pendaftaran->id),
                    'tgl_terbit' => now()->subDays(1 + $index),
                    'gambar_latar' => $kegiatan->nama_latar,
                ]
            );

            $count++;
            $this->command?->line("✅ {$data['nama']} siap diterbitkan sertifikatnya.");
        }

        $this->command?->info("Selesai membuat {$count} peserta yang siap diterbitkan sertifikat.");
    }
}
