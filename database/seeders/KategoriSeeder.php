<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Jaringan Komputer dan Virtualisasi Server',
            'Keamanan Jaringan dan Digital Forensik',
            'Pemrograman Desktop',
            'Pemrograman Web',
            'Pemrograman Mobile',
            'IoT, Robotika dan Mikrokontroler',
            'Machine Learning',
            'Desain Grafis dan Multimedia',
            'Microsoft Office',
            'Open Journal System (OJS)',
            'Database',
            'Pemrograman',
            'Sistem Operasi'
        ];

        foreach ($categories as $category) {
            Kategori::firstOrCreate(['nama_kategori' => $category]);
        }
    }
}
