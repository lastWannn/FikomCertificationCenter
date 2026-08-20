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
        // 1. Admin (Super Admin)
        Admin::updateOrCreate(
            ['email' => 'admin@fcc.com'],
            [
                'nama'     => 'Super Admin FCC',
                'role'     => 'super_admin',
                'password' => Hash::make('password')
            ]
        );



        // 3. Peserta Dummy (Mahasiswa UMI)
        Peserta::firstOrCreate(
            ['email' => 'mahasiswa@umi.ac.id'],
            [
                'nama' => 'mahasiswa',
                'alamat' => 'Perintis Kemerdekaan, Makassar',
                'kelamin' => 'L',
                'instansi' => 'Fakultas Ilmu Komputer UMI',
                'no_hp' => '085244556677',
                'password' => Hash::make('password'),
                'status_akun' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        // 4. Peserta Dummy (Umum)
        Peserta::firstOrCreate(
            ['email' => 'umum@example.com'],
            [
                'nama' => 'umum',
                'alamat' => 'Jl. AP Pettarani, Makassar',
                'kelamin' => 'P',
                'instansi' => 'Freelance',
                'no_hp' => '082155667788',
                'password' => Hash::make('password'),
                'status_akun' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        // 5. Peserta Dummy (Peserta FCC)
        Peserta::firstOrCreate(
            ['email' => 'peserta@fcc.com'],
            [
                'nama' => 'Peserta FCC',
                'alamat' => 'Jl. UMI Makassar',
                'kelamin' => 'L',
                'instansi' => 'Universitas Muslim Indonesia',
                'no_hp' => '081234567890',
                'password' => Hash::make('password'),
                'status_akun' => 'aktif',
                'email_verified_at' => now(),
            ]
        );
    }
}
