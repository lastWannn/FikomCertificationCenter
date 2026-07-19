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
        $this->command->info('Seeder OK! Admin: admin@fcc.ac.id / password');
    }
}