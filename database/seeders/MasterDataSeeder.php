<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Instruktur;
use App\Models\Pelatihan;
use App\Models\Sertifikasi;
use App\Models\MateriPelatihan;
use App\Models\MateriSertifikasi;
use App\Models\PersyaratanPelatihan;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = Kategori::first();
        $instrukturWeb = Instruktur::where('keahlian', 'Web Development')->first();
        $instrukturNet = Instruktur::where('keahlian', 'Networking')->first();

        // 1. Pelatihan Web Dev (Berbayar)
        if ($instrukturWeb && $kategori) {
            $pelatihan1 = Pelatihan::firstOrCreate(
                ['kode' => 'PL-001'],
                [
                    'judul' => 'Pelatihan Web Development Dasar',
                    'isi' => 'Pelatihan intensif untuk belajar pengembangan web dari nol menggunakan HTML, CSS, dan PHP.',
                    'kategori_id' => $kategori->id,
                    'instruktur_id' => $instrukturWeb->id,
                    'gambar' => null,
                ]
            );

            // Materi
            MateriPelatihan::firstOrCreate(['pelatihan_id' => $pelatihan1->id, 'judul_materi' => 'Pengenalan HTML & CSS']);
            MateriPelatihan::firstOrCreate(['pelatihan_id' => $pelatihan1->id, 'judul_materi' => 'Dasar-dasar PHP']);
            MateriPelatihan::firstOrCreate(['pelatihan_id' => $pelatihan1->id, 'judul_materi' => 'Koneksi Database MySQL']);
            
            // Persyaratan
            PersyaratanPelatihan::firstOrCreate(['pelatihan_id' => $pelatihan1->id, 'deskripsi_syarat' => 'Membawa laptop sendiri']);
            PersyaratanPelatihan::firstOrCreate(['pelatihan_id' => $pelatihan1->id, 'deskripsi_syarat' => 'Mengerti dasar penggunaan komputer']);
        }

        // 2. Pelatihan Git (Gratis)
        if ($instrukturWeb && $kategori) {
            $pelatihan2 = Pelatihan::firstOrCreate(
                ['kode' => 'PL-002'],
                [
                    'judul' => 'Workshop Git & GitHub untuk Pemula',
                    'isi' => 'Workshop praktis untuk memahami penggunaan Git & GitHub dalam tim developer.',
                    'kategori_id' => $kategori->id,
                    'instruktur_id' => $instrukturWeb->id,
                    'gambar' => null,
                ]
            );
            
            MateriPelatihan::firstOrCreate(['pelatihan_id' => $pelatihan2->id, 'judul_materi' => 'Pengenalan Version Control System']);
            MateriPelatihan::firstOrCreate(['pelatihan_id' => $pelatihan2->id, 'judul_materi' => 'Basic Git Commands']);
            PersyaratanPelatihan::firstOrCreate(['pelatihan_id' => $pelatihan2->id, 'deskripsi_syarat' => 'Memiliki akun GitHub']);
        }

        // 3. Sertifikasi Networking (MTCNA)
        if ($kategori) {
            $sertifikasi1 = Sertifikasi::firstOrCreate(
                ['kode' => 'SR-001'],
                [
                    'judul' => 'Sertifikasi Jaringan Dasar (MTCNA)',
                    'isi' => 'Sertifikasi resmi Mikrotik untuk kompetensi jaringan dasar. Mempersiapkan Anda menjadi network engineer handal.',
                    'kategori_id' => $kategori->id,
                    'gambar' => null,
                ]
            );
            
            MateriSertifikasi::firstOrCreate(['sertifikasi_id' => $sertifikasi1->id, 'judul_materi' => 'MikroTik RouterOS Introduction']);
            MateriSertifikasi::firstOrCreate(['sertifikasi_id' => $sertifikasi1->id, 'judul_materi' => 'Firewall, QoS, and Routing basics']);
        }
    }
}
