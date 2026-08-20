<?php

namespace Database\Seeders;

use App\Models\Testimoni;
use Illuminate\Database\Seeder;

class TestimoniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonis = [
            [
                'nama'       => 'Ahmad Raziq, S.Kom.',
                'rating'     => 5,
                'keterangan' => 'Alumni Sertifikasi Network Engineer (BNSP)',
                'kata'       => 'Pelatihan dan sertifikasi di FIKOM Certification Center sangat terstruktur. Instrukturnya profesional dan materi yang diajarkan sangat relevan dengan kebutuhan dunia kerja saat ini.',
                'status'     => 'dipublikasikan',
            ],
            [
                'nama'       => 'Nurfadhilah, S.Kom.',
                'rating'     => 5,
                'keterangan' => 'Peserta Pelatihan Web Development Batch 2',
                'kata'       => 'Materi pelatihan praktikal sekali dan fasilitator sangat membantu hingga paham. Sertifikat resmi dari FIKOM UMI menjadi nilai tambah besar saat melamar kerja.',
                'status'     => 'dipublikasikan',
            ],
            [
                'nama'       => 'Muhammad Fikri',
                'rating'     => 5,
                'keterangan' => 'Mahasiswa FIKOM UMI · Sertifikasi Cyber Security',
                'kata'       => 'Fasilitas lab komputer yang memadai dan bimbingan simulasi ujian yang intensif membuat saya lulus ujian sertifikasi BNSP dalam sekali percobaan.',
                'status'     => 'dipublikasikan',
            ],
            [
                'nama'       => 'Siti Nurhaliza, S.T.',
                'rating'     => 5,
                'keterangan' => 'Peserta Sertifikasi Data Analyst',
                'kata'       => 'Sangat merekomendasikan FCC UMI bagi siapa saja yang ingin meningkatkan kompetensi digital. Proses pendaftaran mudah dan pelayanan timnya sangat ramah.',
                'status'     => 'dipublikasikan',
            ],
            [
                'nama'       => 'Andi Muhammad Ikhsan',
                'rating'     => 5,
                'keterangan' => 'Alumni Pelatihan Mobile App Development',
                'kata'       => 'Banyak ilmu praktis yang tidak didapatkan di bangku kuliah biasa. Sangat bersyukur bisa ikut pelatihan di FCC UMI, portofolio proyek akhir saya langsung dilirik perusahaan.',
                'status'     => 'dipublikasikan',
            ],
        ];

        foreach ($testimonis as $t) {
            Testimoni::firstOrCreate(
                ['nama' => $t['nama']],
                $t
            );
        }
    }
}
