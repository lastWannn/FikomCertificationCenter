<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\{Peserta, Kegiatan, Pendaftaran, Sertifikat};

class PesertaSertifikatSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Dapatkan daftar kegiatan
        $kegiatanList = Kegiatan::all();
        if ($kegiatanList->isEmpty()) {
            return;
        }

        // 2. Daftar Peserta Dummy dengan sertifikat terbit
        $pesertaData = [
            [
                'nama'     => 'Ahmad Fauzi',
                'email'    => 'ahmad.fauzi@example.com',
                'instansi' => 'Fakultas Ilmu Komputer UMI',
                'kelamin'  => 'L',
                'no_hp'    => '081298765432',
                'alamat'   => 'Jl. UMI Perintis Kemerdekaan, Makassar',
            ],
            [
                'nama'     => 'Siti Nurhaliza',
                'email'    => 'siti.nurhaliza@example.com',
                'instansi' => 'Universitas Muslim Indonesia',
                'kelamin'  => 'P',
                'no_hp'    => '085311223344',
                'alamat'   => 'Jl. Urip Sumoharjo, Makassar',
            ],
            [
                'nama'     => 'Rahmat Hidayat',
                'email'    => 'rahmat.hidayat@example.com',
                'instansi' => 'PT Teknologi Nusa Indonesia',
                'kelamin'  => 'L',
                'no_hp'    => '082199887766',
                'alamat'   => 'Jl. AP Pettarani, Makassar',
            ],
            [
                'nama'     => 'Nurul Annisa',
                'email'    => 'nurul.annisa@example.com',
                'instansi' => 'Fakultas Teknik UMI',
                'kelamin'  => 'P',
                'no_hp'    => '085277665544',
                'alamat'   => 'Jl. Sunu, Makassar',
            ],
        ];

        foreach ($pesertaData as $index => $data) {
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

            // Tentukan kegiatan secara berurutan
            $kegiatan = $kegiatanList->get($index % $kegiatanList->count());

            // Buat Pendaftaran
            $pendaftaran = Pendaftaran::firstOrCreate(
                [
                    'peserta_id'  => $peserta->id,
                    'kegiatan_id' => $kegiatan->id,
                ],
                [
                    'biaya_kegiatan_id'   => $kegiatan->biaya()->first()?->id,
                    'tgl_daftar'          => now()->subDays(15),
                    'status_pendaftaran'  => 'terdaftar',
                    'status_kehadiran'    => 'hadir',
                    'qr_token'            => Str::random(32),
                ]
            );

            // Buat Sertifikat
            Sertifikat::updateOrCreate(
                ['pendaftaran_id' => $pendaftaran->id],
                [
                    'nomor_sertifikat' => Sertifikat::generateNomor($kegiatan->id, $pendaftaran->id),
                    'tgl_terbit'       => now()->subDays(2 + $index),
                    'gambar_latar'     => $kegiatan->nama_latar,
                ]
            );
        }
    }
}
