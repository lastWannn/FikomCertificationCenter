<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kontak;
use App\Models\KontenHalaman;
use App\Models\Mitra;
use App\Models\Informasi;
use App\Models\Rekening;
use App\Models\Admin;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kontak
        Kontak::firstOrCreate(
            ['email' => 'fcc@fikom.umi.ac.id'],
            [
                'alamat' => 'Jl. Urip Sumoharjo No.225, Makassar 90232',
                'telepon' => '(0411) 455 855',
                'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.81691238902!2d119.44747367497746!3d-5.133221994843075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbee2cecc69bcfb%3A0xc6c7b508fbe9da82!2sUniversitas%20Muslim%20Indonesia!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'
            ]
        );

        // 2. Konten Halaman
        $konten = [
            ['beranda', 'Selamat Datang di FCC', 'Platform sertifikasi dan pelatihan profesional FIKOM UMI.'],
            ['tentang_kami', 'Tentang Kami', 'FIKOM Certification Center adalah unit pelaksana Fakultas Ilmu Komputer UMI yang bertugas menyelenggarakan pelatihan dan sertifikasi kompetensi di bidang Teknologi Informasi.'],
            ['visi_misi_tujuan', 'Visi Misi & Tujuan', 'Visi: Menjadi pusat sertifikasi TI terkemuka di Indonesia Timur. <br>Misi: Menyelenggarakan sertifikasi bertaraf nasional dan internasional.'],
            ['tata_cara_pendaftaran', 'Tata Cara Pendaftaran', '1. Buat Akun Peserta.<br>2. Verifikasi Email.<br>3. Pilih Kegiatan dan Daftar.<br>4. Lakukan Pembayaran dan Konfirmasi.']
        ];

        foreach ($konten as [$jenis, $judul, $isi]) {
            KontenHalaman::firstOrCreate(
                ['jenis' => $jenis],
                ['judul' => $judul, 'isi' => $isi]
            );
        }

        // 3. Mitra
        $mitras = [
            ['nama_mitra' => 'Microsoft', 'inisial' => 'MS', 'warna' => '#059669', 'urutan' => 2, 'logo' => 'mitra/microsoft.png'],
            ['nama_mitra' => 'Cisco System', 'inisial' => 'CSC', 'warna' => '#0284C7', 'urutan' => 1, 'logo' => 'mitra/cisco.png'],
            ['nama_mitra' => 'MikroTik', 'inisial' => 'MIK', 'warna' => '#4B5563', 'urutan' => 3, 'logo' => 'mitra/mikrotik.png']
        ];

        foreach ($mitras as $m) {
            Mitra::updateOrCreate(['nama_mitra' => $m['nama_mitra']], $m);
        }

        // 4. Informasi (FAQ dan Pengumuman)
        $admin = Admin::first();
        if ($admin) {
            Informasi::firstOrCreate(
                ['judul' => 'Bagaimana cara mendapatkan sertifikat?'],
                [
                    'admin_id' => $admin->id,
                    'isi' => 'Sertifikat dapat diunduh melalui menu Sertifikat setelah Anda lulus dalam kegiatan.',
                    'jenis' => 'faq'
                ]
            );
            Informasi::firstOrCreate(
                ['judul' => 'Pembukaan Pendaftaran Sertifikasi Batch 1'],
                [
                    'admin_id' => $admin->id,
                    'isi' => 'Pendaftaran untuk sertifikasi Batch 1 tahun ini telah dibuka. Silakan daftar melalui portal.',
                    'jenis' => 'info'
                ]
            );
        }

        // 5. Rekening
        Rekening::firstOrCreate(
            ['no_rekening' => '1234567890'],
            [
                'bank' => 'Bank Mandiri',
                'nama_pemilik' => 'FIKOM UMI Makassar',
                'is_active' => true
            ]
        );
        Rekening::firstOrCreate(
            ['no_rekening' => '0987654321'],
            [
                'bank' => 'Bank BNI',
                'nama_pemilik' => 'FIKOM Certification Center',
                'is_active' => false
            ]
        );
    }
}
