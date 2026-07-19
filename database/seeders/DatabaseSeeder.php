<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; use App\Models\Kontak;
use App\Models\KontenHalaman; use App\Models\Mitra;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call(KategoriSeeder::class);
        Admin::firstOrCreate(['email'=>'admin@fcc.ac.id'],['nama'=>'Admin FCC','password'=>Hash::make('password')]);
        Kontak::firstOrCreate(['email'=>'fcc@fikom.umi.ac.id'],['alamat'=>'Jl. Urip Sumoharjo No.225, Makassar 90232','telepon'=>'(0411) 455 855','email'=>'fcc@fikom.umi.ac.id','maps_embed'=>'']);
        foreach ([['beranda','Selamat Datang di FCC','Platform sertifikasi dan pelatihan profesional FIKOM UMI.'],
                  ['tentang_kami','Tentang Kami','FIKOM Certification Center adalah unit pelaksana Fakultas Ilmu Komputer UMI.'],
                  ['visi_misi_tujuan','Visi Misi & Tujuan','Visi: Menjadi pusat sertifikasi TI terkemuka di Indonesia Timur.'],
                  ['tata_cara_pendaftaran','Tata Cara Pendaftaran','Ikuti 4 langkah mudah untuk mendaftarkan diri ke kegiatan FCC.']] as [$j,$t,$i])
            KontenHalaman::firstOrCreate(['jenis'=>$j],['judul'=>$t,'isi'=>$i]);
        $mitras = [
            ['nama_mitra'=>'Microsoft Indonesia','inisial'=>'MS','warna'=>'#059669','urutan'=>2,'logo'=>'mitra/microsoft.png'],
            ['nama_mitra'=>'Cisco Systems','inisial'=>'CSC','warna'=>'#0284C7','urutan'=>1,'logo'=>'mitra/cisco.png'],
            ['nama_mitra'=>'MikroTik','inisial'=>'MIK','warna'=>'#4B5563','urutan'=>3,'logo'=>'mitra/mikrotik.png'],
        ];

        foreach ($mitras as $m) {
            Mitra::updateOrCreate(['nama_mitra' => $m['nama_mitra']], $m);
        }
        // Tambahan data dummy untuk Pelatihan dan Sertifikasi
        $kategori = \App\Models\Kategori::first();

        // 1. Instruktur
        $instruktur = \App\Models\Instruktur::firstOrCreate(
            ['email' => 'instruktur@fcc.ac.id'],
            [
                'no_identitas' => '1234567890',
                'nama' => 'Budi Santoso, M.Kom',
                'alamat' => 'Jl. Pendidikan No. 1',
                'kelamin' => 'L',
                'no_hp' => '081234567890',
                'keahlian' => 'Web Development',
                'password' => Hash::make('password')
            ]
        );

        // 2. Pelatihan
        $pelatihan = \App\Models\Pelatihan::firstOrCreate(
            ['kode' => 'PL-001'],
            [
                'judul' => 'Pelatihan Web Development Dasar',
                'isi' => 'Pelatihan intensif untuk belajar pengembangan web dari nol menggunakan HTML, CSS, dan PHP.',
                'kategori_id' => $kategori->id,
                'instruktur_id' => $instruktur->id,
                'gambar' => null,
            ]
        );

        // 3. Jadwal Pelatihan
        $jadwalPelatihan = \App\Models\JadwalPelatihan::firstOrCreate(
            ['nama_kegiatan' => 'Batch 1 - Web Dev Dasar'],
            [
                'pelatihan_id' => $pelatihan->id,
                'kuota_peserta' => 30,
                'untuk_peserta' => 'mahasiswa,umum',
                'tgl_batas_daftar' => now()->addDays(7)->format('Y-m-d'),
                'tgl_pelaksanaan' => now()->addDays(14)->format('Y-m-d'),
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '15:00:00',
            ]
        );

        // 4. Kegiatan (Pelatihan)
        $kegiatanPelatihan = \App\Models\Kegiatan::firstOrCreate(
            ['jenis_kegiatan' => 'pelatihan', 'nama_latar' => 'Batch 1 - Web Dev Dasar']
        );
        \App\Models\KegiatanPelatihan::firstOrCreate([
            'kegiatan_id' => $kegiatanPelatihan->id,
            'jadwal_pelatihan_id' => $jadwalPelatihan->id
        ]);
        \App\Models\BiayaKegiatan::firstOrCreate([
            'kegiatan_id' => $kegiatanPelatihan->id,
            'nama_jenis' => 'Mahasiswa UMI',
            'nominal' => 150000
        ]);

        // 5. Sertifikasi
        $sertifikasi = \App\Models\Sertifikasi::firstOrCreate(
            ['kode' => 'SR-001'],
            [
                'judul' => 'Sertifikasi Jaringan Dasar (MTCNA)',
                'isi' => 'Sertifikasi resmi Mikrotik untuk kompetensi jaringan dasar.',
                'kategori_id' => $kategori->id,
                'gambar' => null,
            ]
        );

        // 6. Jadwal Sertifikasi
        $jadwalSertifikasi = \App\Models\JadwalSertifikasi::firstOrCreate(
            ['nama_kegiatan' => 'Sertifikasi MTCNA 2026'],
            [
                'sertifikasi_id' => $sertifikasi->id,
                'kuota_peserta' => 20,
                'untuk_peserta' => 'mahasiswa,umum',
                'tgl_batas_daftar' => now()->addDays(10)->format('Y-m-d'),
                'tgl_pelaksanaan' => now()->addDays(20)->format('Y-m-d'),
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '17:00:00',
            ]
        );

        // 7. Kegiatan (Sertifikasi)
        $kegiatanSertifikasi = \App\Models\Kegiatan::firstOrCreate(
            ['jenis_kegiatan' => 'sertifikasi', 'nama_latar' => 'Sertifikasi MTCNA 2024']
        );
        \App\Models\KegiatanSertifikasi::firstOrCreate([
            'kegiatan_id' => $kegiatanSertifikasi->id,
            'jadwal_sertifikasi_id' => $jadwalSertifikasi->id
        ]);
        \App\Models\BiayaKegiatan::firstOrCreate([
            'kegiatan_id' => $kegiatanSertifikasi->id,
            'nama_jenis' => 'Umum',
            'nominal' => 500000
        ]);

        $this->command->info('Seeder OK! Admin: admin@fcc.ac.id / password');
    }
}