<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Instruktur;
use App\Models\Peserta;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin
        Admin::firstOrCreate(
            ['email' => 'admin@fcc.com'],
            [
                'nama' => 'Admin FCC',
                'password' => Hash::make('password')
            ]
        );

        // 2. Instruktur
        Instruktur::firstOrCreate(
            ['email' => 'instruktur@fcc.com'],
            [
                'no_identitas' => '1234567890',
                'nama' => 'Budi Santoso, M.Kom',
                'alamat' => 'Jl. Pendidikan No. 1, Makassar',
                'kelamin' => 'L',
                'no_hp' => '081234567890',
                'keahlian' => 'Web Development',
                'password' => Hash::make('password')
            ]
        );

        Instruktur::firstOrCreate(
            ['email' => 'ams@fcc.com'],
            [
                'no_identitas' => '0987654321',
                'nama' => 'Prof. Dr. Aan Maulana Sampe, S.Kom., M.Eng., Ph.D.',
                'alamat' => 'Jl. Kemerdekaan No. 45, Makassar',
                'kelamin' => 'P',
                'no_hp' => '081987654321',
                'keahlian' => 'Networking',
                'password' => Hash::make('password')
            ]
        );

        // 3. Peserta Dummy (Mahasiswa UMI)
        Peserta::firstOrCreate(
            ['email' => 'mahasiswa@umi.ac.id'],
            [
                'nama' => 'Andi Setiawan',
                'alamat' => 'Perintis Kemerdekaan, Makassar',
                'kelamin' => 'L',
                'instansi' => 'Fakultas Ilmu Komputer UMI',
                'no_hp' => '085244556677',
                'password' => Hash::make('password'),
                'status_akun' => 'aktif'
            ]
        );

        // 4. Peserta Dummy (Umum)
        Peserta::firstOrCreate(
            ['email' => 'umum@example.com'],
            [
                'nama' => 'Siti Aminah',
                'alamat' => 'Jl. AP Pettarani, Makassar',
                'kelamin' => 'P',
                'instansi' => 'Freelance',
                'no_hp' => '082155667788',
                'password' => Hash::make('password'),
                'status_akun' => 'aktif'
            ]
        );
    }
}
