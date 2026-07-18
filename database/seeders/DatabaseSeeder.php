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
        foreach ([['Universitas Muslim Indonesia','UMI','#1E40AF',1],['PT. Telkom Indonesia','TLK','#DC2626',2],
                  ['BNSP Indonesia','BNSP','#7C3AED',3],['Microsoft Indonesia','MS','#059669',4],
                  ['Cisco Systems','CSC','#0284C7',5],['Dinas Kominfo Makassar','KOM','#065F46',6]] as [$n,$i,$c,$u])
            Mitra::firstOrCreate(['nama_mitra'=>$n],['inisial'=>$i,'warna'=>$c,'urutan'=>$u]);
        $this->command->info('Seeder OK! Admin: admin@fcc.ac.id / password');
    }
}