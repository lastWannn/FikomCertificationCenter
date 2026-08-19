<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; use App\Models\Kontak;
use App\Models\KontenHalaman; use App\Models\Mitra;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            KategoriSeeder::class,
            UserSeeder::class,
            PengaturanSeeder::class,
            MasterDataSeeder::class,
            KegiatanSeeder::class,
            SiapTerbitSertifikatSeeder::class,
        ]);

        $this->command->info('Seeder Modular OK! Admin: admin@fcc.com / password');
    }
}
