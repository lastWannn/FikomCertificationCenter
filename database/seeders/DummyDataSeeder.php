<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\Kategori;
use App\Models\Instruktur;
use App\Models\Pelatihan;
use App\Models\Sertifikasi;
use App\Models\MateriPelatihan;
use App\Models\MateriSertifikasi;
use App\Models\PersyaratanPelatihan;
use App\Models\JadwalPelatihan;
use App\Models\JadwalSertifikasi;
use App\Models\Kegiatan;
use App\Models\KegiatanPelatihan;
use App\Models\KegiatanSertifikasi;
use App\Models\BiayaKegiatan;
use App\Models\Mitra;
use App\Models\Testimoni;
use App\Models\Informasi;
use App\Models\Peserta;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai Seeding 10 Data Dummy per Entitas...');

        // 1. Kategori (10+ Data)
        $kategoriList = [
            'Pemrograman Web',
            'Pemrograman Mobile',
            'Jaringan Komputer dan Virtualisasi Server',
            'Keamanan Jaringan dan Digital Forensik',
            'Data Science & Artificial Intelligence',
            'Cloud Computing & DevOps',
            'Database & Big Data',
            'Desain Grafis & UI/UX',
            'Internet of Things (IoT) & Robotika',
            'Manajemen Proyek IT & Scrum',
            'Microsoft Office & Produktivitas',
            'Sistem Operasi & Linux System',
        ];
        $kategoris = [];
        foreach ($kategoriList as $kName) {
            $kategoris[$kName] = Kategori::firstOrCreate(['nama_kategori' => $kName]);
        }
        $this->command->info('✓ 10+ Kategori siap.');

        // 2. Master Pelatihan (10 Data)
        $pelatihansData = [
            [
                'kode' => 'PL-001',
                'judul' => 'Fullstack Modern Web Development dengan Laravel & Vue',
                'isi' => 'Pelatihan intensif pengembangan aplikasi web skala enterprise menggunakan arsitektur modern Laravel 11, Inertia.js, dan Tailwind CSS.',
                'kategori' => 'Pemrograman Web',
                'materi' => ['Arsitektur MVC & Routing Laravel', 'Database Migration, Eloquent ORM & Relasi', 'Autentikasi & Authorization API', 'State Management Vue & UI Responsive', 'Deployment Production ke VPS'],
                'syarat' => ['Membawa laptop minimal RAM 8GB', 'Memahami dasar HTML, CSS, dan PHP'],
            ],
            [
                'kode' => 'PL-002',
                'judul' => 'Mobile App Development Flutter Multi-Platform',
                'isi' => 'Pelatihan pembuatan aplikasi mobile untuk Android dan iOS dengan satu basis kode Flutter & Dart, integrasi REST API, dan local storage.',
                'kategori' => 'Pemrograman Mobile',
                'materi' => ['Dart Programming Fundamentals', 'Flutter Widget Lifecycle & Layouting', 'State Management (Bloc & Provider)', 'Integrasi RESTful API & HTTP Client', 'Build APK & Publikasi Play Store'],
                'syarat' => ['Laptop support Android Studio / VS Code', 'Koneksi internet stabil saat workshop'],
            ],
            [
                'kode' => 'PL-003',
                'judul' => 'Data Science & Machine Learning Fundamentals dengan Python',
                'isi' => 'Pelatihan komprehensif analisis data, visualisasi interaktif, dan pemodelan prediktif machine learning menggunakan Pandas, NumPy, dan Scikit-Learn.',
                'kategori' => 'Data Science & Artificial Intelligence',
                'materi' => ['Python for Data Science Overview', 'Data Wrangling & Cleaning dengan Pandas', 'Exploratory Data Analysis (Seaborn & Matplotlib)', 'Supervised & Unsupervised Learning', 'Model Evaluation & Deployment Streamlit'],
                'syarat' => ['Dasar matematika & logika pemrograman', 'Laptop dengan Python 3.10+ terpasang'],
            ],
            [
                'kode' => 'PL-004',
                'judul' => 'UI/UX Design Masterclass: From Wireframe to High-Fidelity',
                'isi' => 'Belajar riset pengguna, information architecture, wireframing, design system, dan prototipe interaktif menggunakan Figma untuk aplikasi web & mobile.',
                'kategori' => 'Desain Grafis & UI/UX',
                'materi' => ['Design Thinking & User Research Method', 'User Journey Mapping & Information Architecture', 'Design System, Component & Auto-Layout Figma', 'Interactive Prototyping & Micro-interactions', 'Usability Testing & Hand-off ke Developer'],
                'syarat' => ['Memiliki akun Figma', 'Membawa mouse untuk kenyamanan mendesain'],
            ],
            [
                'kode' => 'PL-005',
                'judul' => 'DevOps Engineering & Containerization with Docker & Kubernetes',
                'isi' => 'Pelatihan otomatisasi pipeline CI/CD, deployment containerized microservices menggunakan Docker dan orkestrasi klaster Kubernetes.',
                'kategori' => 'Cloud Computing & DevOps',
                'materi' => ['Konsep DevOps & CI/CD Pipeline', 'Docker Container, Image & Docker Compose', 'Kubernetes Cluster Architecture & Pods', 'GitHub Actions Automated Testing & Deployment', 'Monitoring & Logging dengan Prometheus'],
                'syarat' => ['Dasar sistem operasi Linux', 'Laptop dengan RAM minimal 8GB'],
            ],
            [
                'kode' => 'PL-006',
                'judul' => 'Cyber Security Fundamentals & Ethical Hacking',
                'isi' => 'Pelatihan keamanan siber dasar, teknik vulnerability assessment, network penetration testing, dan pertahanan terhadap ancaman digital modern.',
                'kategori' => 'Keamanan Jaringan dan Digital Forensik',
                'materi' => ['Cyber Security Landscape & Attack Vectors', 'Network Reconnaissance & Port Scanning Nmap', 'Web Application Vulnerability (OWASP Top 10)', 'Metasploit Framework & Privilege Escalation', 'Security Hardening & Incident Response'],
                'syarat' => ['Memahami dasar jaringan TCP/IP', 'Menggunakan OS Linux Kali / VM'],
            ],
            [
                'kode' => 'PL-007',
                'judul' => 'Database Administration & Query Optimization PostgreSQL',
                'isi' => 'Manajemen database relasional tingkat lanjut, indexing, query optimization, replikasi data, backup recovery, dan keamanan database.',
                'kategori' => 'Database & Big Data',
                'materi' => ['Relational Database Architecture', 'Advanced SQL Queries, Window Functions & CTE', 'Indexing Strategies & EXPLAIN ANALYZE', 'Backup, Restore & High Availability Replication', 'Database Security & Role-Based Access'],
                'syarat' => ['Memahami query dasar SQL'],
            ],
            [
                'kode' => 'PL-008',
                'judul' => 'Internet of Things (IoT) Smart Automation dengan ESP32 & MQTT',
                'isi' => 'Pengembangan perangkat pintar IoT berbasis ESP32, integrasi sensor & aktuator, protokol komunikasi MQTT, dan dashboard monitoring real-time.',
                'kategori' => 'Internet of Things (IoT) & Robotika',
                'materi' => ['Arsitektur IoT & Pengenalan ESP32', 'Sensor Interfacing (Suhu, Kelembaban, Gerak)', 'Protokol MQTT & Cloud Broker Integration', 'Dashboard Monitoring IoT berbasis Web', 'Smart Home Automation Case Study'],
                'syarat' => ['Dasar pemrograman C/C++', 'Kit sensor akan disediakan oleh lab'],
            ],
            [
                'kode' => 'PL-009',
                'judul' => 'Linux System Administration & Server Hardening',
                'isi' => 'Manajemen server Linux Ubuntu/Debian, konfigurasi web server Nginx/Apache, manajemen user & permission, serta firewall security.',
                'kategori' => 'Sistem Operasi & Linux System',
                'materi' => ['Linux Command Line Essentials & Bash Scripting', 'User Management, Permissions & SSH Keys', 'Web Server Configuration (Nginx & PHP-FPM)', 'UFW Firewall & Fail2ban Security Hardening', 'System Monitoring & Automated Backup'],
                'syarat' => ['Dasar penggunaan terminal / command line'],
            ],
            [
                'kode' => 'PL-010',
                'judul' => 'Agile & Scrum Project Management for Tech Teams',
                'isi' => 'Metodologi manajemen proyek perangkat lunak modern dengan Scrum framework, sprint planning, backlog refinement, dan tools Jira.',
                'kategori' => 'Manajemen Proyek IT & Scrum',
                'materi' => ['Agile Manifesto & Core Scrum Principles', 'Scrum Roles: PO, Scrum Master & Dev Team', 'Sprint Ceremonies & Backlog Management', 'Story Points Estimation & Burndown Charts', 'Simulasi Proyek Real Menggunakan Jira'],
                'syarat' => ['Terbuka untuk mahasiswa dan profesional IT'],
            ],
        ];

        $pelatihans = [];
        foreach ($pelatihansData as $pData) {
            $kat = $kategoris[$pData['kategori']] ?? Kategori::first();
            $pel = Pelatihan::updateOrCreate(
                ['kode' => $pData['kode']],
                [
                    'judul' => $pData['judul'],
                    'isi' => $pData['isi'],
                    'kategori_id' => $kat->id,
                    'gambar' => null,
                ]
            );

            // Seed Materi
            foreach ($pData['materi'] as $mat) {
                MateriPelatihan::firstOrCreate([
                    'pelatihan_id' => $pel->id,
                    'judul_materi' => $mat,
                ]);
            }

            // Seed Syarat
            foreach ($pData['syarat'] as $sya) {
                PersyaratanPelatihan::firstOrCreate([
                    'pelatihan_id' => $pel->id,
                    'deskripsi_syarat' => $sya,
                ]);
            }

            $pelatihans[] = $pel;
        }
        $this->command->info('✓ 10 Master Pelatihan + Materi & Syarat siap.');

        // 4. Master Sertifikasi (10 Data)
        $sertifikasisData = [
            [
                'kode' => 'SR-001',
                'judul' => 'Sertifikasi MikroTik Certified Network Associate (MTCNA)',
                'isi' => 'Sertifikasi kompetensi jaringan resmi MikroTik internasional untuk konfigurasi RouterOS, routing, firewall, QoS, wireless, dan tunnel.',
                'kategori' => 'Jaringan Komputer dan Virtualisasi Server',
                'materi' => ['MikroTik RouterOS Architecture & Winbox', 'Static Routing & Default Gateway', 'Firewall Filter & NAT Configuration', 'Bandwidth Management & Queue Simple/Tree', 'Hotspot & Wireless Network Setup'],
            ],
            [
                'kode' => 'SR-002',
                'judul' => 'Sertifikasi BNSP Junior Web Developer',
                'isi' => 'Uji kompetensi profesi standar SKKNI untuk pengembang web junior yang mencakup perancangan arsitektur web, implementasi database, dan keamanan kode.',
                'kategori' => 'Pemrograman Web',
                'materi' => ['Menerapkan Pemrograman Berorientasi Objek (OOP)', 'Menggunakan Struktur Data & Algoritma', 'Membuat Kode Program Web Berbasis Framework', 'Mengimplementasikan Query Relational Database', 'Menulis Dokumentasi Perangkat Lunak'],
            ],
            [
                'kode' => 'SR-003',
                'judul' => 'Sertifikasi Cisco Certified Network Associate (CCNA 200-301)',
                'isi' => 'Standar sertifikasi global Cisco untuk pengelolaan jaringan IP enterprise, switching VLAN, routing OSPF, keamanan perangkat, dan otomasi jaringan.',
                'kategori' => 'Jaringan Komputer dan Virtualisasi Server',
                'materi' => ['Network Fundamentals & IP Addressing IPv4/IPv6', 'Network Access: VLANs, Trunking & EtherChannel', 'IP Connectivity: OSPFv2 Routing', 'IP Services: DHCP, DNS, NAT & SNMP', 'Security Fundamentals & Network Automation'],
            ],
            [
                'kode' => 'SR-004',
                'judul' => 'Sertifikasi BNSP Network Administrator Madya',
                'isi' => 'Sertifikasi profesi nasional BNSP bidang administrasi jaringan komputer, manajemen bandwidth, keamanan server, dan troubleshooting jaringan.',
                'kategori' => 'Jaringan Komputer dan Virtualisasi Server',
                'materi' => ['Merancang Topologi Jaringan Komputer', 'Mengkonfigurasi Switch & Router Jaringan', 'Memasang Jaringan Nirkabel (Wireless LAN)', 'Mengkonfigurasi Server Layanan Jaringan', 'Memelihara Keamanan Jaringan Komputer'],
            ],
            [
                'kode' => 'SR-005',
                'judul' => 'Sertifikasi AWS Certified Cloud Practitioner (CLF-C02)',
                'isi' => 'Validasi pemahaman fundamental infrastruktur cloud Amazon Web Services (AWS), keamanan cloud, arsitektur dasar, dan pricing model.',
                'kategori' => 'Cloud Computing & DevOps',
                'materi' => ['Cloud Concepts & Global AWS Infrastructure', 'AWS Core Services (EC2, S3, RDS, Lambda)', 'Security & Compliance in AWS Cloud', 'Cloud Economics & Billing Models', 'Cloud Migration & Disaster Recovery'],
            ],
            [
                'kode' => 'SR-006',
                'judul' => 'Sertifikasi BNSP Associate Data Scientist',
                'isi' => 'Uji kompetensi nasional untuk profesi Data Scientist yang memvalidasi kemampuan data cleansing, statistical modeling, dan machine learning implementation.',
                'kategori' => 'Data Science & Artificial Intelligence',
                'materi' => ['Menelaah & Membersihkan Data Mentah', 'Melakukan Eksplorasi Data (EDA)', 'Membangun Model Machine Learning Klasifikasi & Regresi', 'Mengevaluasi Kinerja Model Prediktif', 'Menyajikan Laporan Visualisasi Data Bisnis'],
            ],
            [
                'kode' => 'SR-007',
                'judul' => 'Sertifikasi Certified Ethical Hacker (CEH v12 Preparation)',
                'isi' => 'Sertifikasi standar keamanan siber internasional untuk pemindaian kerentanan, eksploitasi sistem legal, dan pengamanan aset digital perusahaan.',
                'kategori' => 'Keamanan Jaringan dan Digital Forensik',
                'materi' => ['Ethical Hacking Methodologies & Laws', 'Footprinting & Network Scanning Techniques', 'System Hacking & Malware Threats', 'Web Server & SQL Injection Exploits', 'Cloud & IoT Security Analysis'],
            ],
            [
                'kode' => 'SR-008',
                'judul' => 'Sertifikasi BNSP Cyber Security Analyst',
                'isi' => 'Sertifikasi kompetensi profesi untuk analis keamanan siber, pemantauan log SOC, deteksi ancaman malware, dan mitigasi insiden keamanan.',
                'kategori' => 'Keamanan Jaringan dan Digital Forensik',
                'materi' => ['Memantau Log Lalu Lintas Keamanan Jaringan', 'Mengidentifikasi Kerentanan Sistem (Vulnerability)', 'Menangani Insiden Keamanan Informasi', 'Menerapkan Enkripsi & Kontrol Akses', 'Menyusun Laporan Audit Keamanan Sistem'],
            ],
            [
                'kode' => 'SR-009',
                'judul' => 'Sertifikasi Oracle Certified Associate: Java SE Programmer',
                'isi' => 'Uji kompetensi resmi Oracle untuk kemampuan pemrograman berorientasi objek tingkat lanjut, exception handling, collections, dan Java API.',
                'kategori' => 'Pemrograman Web',
                'materi' => ['Java Data Types, Operators & Decision Constructs', 'Creating & Using Arrays & Collections', 'Working with Methods & Encapsulation', 'Inheritance, Polymorphism & Abstract Classes', 'Handling Exceptions & Java API Core'],
            ],
            [
                'kode' => 'SR-010',
                'judul' => 'Sertifikasi Professional Scrum Master (PSM I)',
                'isi' => 'Validasi pemahaman fundamental mengenai Scrum framework, fasilitasi tim developer, peningkatan produktivitas sprint, dan agile mindset.',
                'kategori' => 'Manajemen Proyek IT & Scrum',
                'materi' => ['Understanding & Applying the Scrum Framework', 'Developing People & High Performing Teams', 'Managing Products with Agility', 'Facilitating Effective Scrum Events', 'Removing Impediments & Servant Leadership'],
            ],
        ];

        $sertifikasis = [];
        foreach ($sertifikasisData as $sData) {
            $kat = $kategoris[$sData['kategori']] ?? Kategori::first();
            $ser = Sertifikasi::updateOrCreate(
                ['kode' => $sData['kode']],
                [
                    'judul' => $sData['judul'],
                    'isi' => $sData['isi'],
                    'kategori_id' => $kat->id,
                    'gambar' => null,
                ]
            );

            // Seed Materi
            foreach ($sData['materi'] as $mat) {
                MateriSertifikasi::firstOrCreate([
                    'sertifikasi_id' => $ser->id,
                    'judul_materi' => $mat,
                ]);
            }

            $sertifikasis[] = $ser;
        }
        $this->command->info('✓ 10 Master Sertifikasi + Materi siap.');

        // 4. Kegiatan & Jadwal (10 Kegiatan Aktif: 5 Pelatihan + 5 Sertifikasi)
        $latarFile = file_exists(storage_path('app/public/latar-sertifikat/temp_bg.jpg')) ? 'latar-sertifikat/temp_bg.jpg' : null;
        $allKegiatans = [];

        // 5 Pelatihan Aktif
        for ($i = 0; $i < 5; $i++) {
            $pel = $pelatihans[$i];
            $jadwal = JadwalPelatihan::updateOrCreate(
                ['nama_kegiatan' => 'Batch ' . ($i + 1) . ' - ' . Str::limit($pel->judul, 40)],
                [
                    'pelatihan_id' => $pel->id,
                    'kuota_peserta' => rand(25, 40),
                    'untuk_peserta' => 'LP',
                    'tgl_batas_daftar' => now()->addDays(5 + ($i * 3))->format('Y-m-d'),
                    'tgl_pelaksanaan' => now()->addDays(12 + ($i * 4))->format('Y-m-d'),
                    'jam_mulai' => '08:30:00',
                    'jam_selesai' => '16:00:00',
                ]
            );

            // Cek apakah sudah ada KegiatanPelatihan untuk jadwal ini
            $kegPel = KegiatanPelatihan::where('jadwal_pelatihan_id', $jadwal->id)->first();
            if ($kegPel && $kegPel->kegiatan) {
                $keg = $kegPel->kegiatan;
                $keg->update(['status' => 'public', 'nama_latar' => $latarFile]);
            } else {
                $keg = Kegiatan::create([
                    'jenis_kegiatan' => 'pelatihan',
                    'nama_latar' => $latarFile,
                    'status' => 'public',
                    'qr_token' => Str::random(32),
                ]);
                KegiatanPelatihan::create([
                    'kegiatan_id' => $keg->id,
                    'jadwal_pelatihan_id' => $jadwal->id,
                ]);
            }

            // Biaya tiered
            if ($i === 1) {
                // Kegiatan ke-2 dibuat gratis
                BiayaKegiatan::where('kegiatan_id', $keg->id)->delete();
            } else {
                BiayaKegiatan::updateOrCreate(
                    ['kegiatan_id' => $keg->id, 'nama_jenis' => 'Mahasiswa FIKOM UMI'],
                    ['nominal' => 150000 + ($i * 25000)]
                );
                BiayaKegiatan::updateOrCreate(
                    ['kegiatan_id' => $keg->id, 'nama_jenis' => 'Dosen / Alumni UMI'],
                    ['nominal' => 250000 + ($i * 25000)]
                );
                BiayaKegiatan::updateOrCreate(
                    ['kegiatan_id' => $keg->id, 'nama_jenis' => 'Umum / Instansi Luar'],
                    ['nominal' => 350000 + ($i * 25000)]
                );
            }

            $allKegiatans[] = $keg;
        }

        // 5 Sertifikasi Aktif
        for ($i = 0; $i < 5; $i++) {
            $ser = $sertifikasis[$i];
            $jadwal = JadwalSertifikasi::updateOrCreate(
                ['nama_kegiatan' => 'Uji Sertifikasi 2026 - ' . Str::limit($ser->judul, 40)],
                [
                    'sertifikasi_id' => $ser->id,
                    'kuota_peserta' => rand(20, 30),
                    'untuk_peserta' => 'LP',
                    'tgl_batas_daftar' => now()->addDays(8 + ($i * 3))->format('Y-m-d'),
                    'tgl_pelaksanaan' => now()->addDays(18 + ($i * 4))->format('Y-m-d'),
                    'jam_mulai' => '08:00:00',
                    'jam_selesai' => '17:00:00',
                ]
            );

            // Cek apakah sudah ada KegiatanSertifikasi untuk jadwal ini
            $kegSer = KegiatanSertifikasi::where('jadwal_sertifikasi_id', $jadwal->id)->first();
            if ($kegSer && $kegSer->kegiatan) {
                $keg = $kegSer->kegiatan;
                $keg->update(['status' => 'public', 'nama_latar' => $latarFile]);
            } else {
                $keg = Kegiatan::create([
                    'jenis_kegiatan' => 'sertifikasi',
                    'nama_latar' => $latarFile,
                    'status' => 'public',
                    'qr_token' => Str::random(32),
                ]);
                KegiatanSertifikasi::create([
                    'kegiatan_id' => $keg->id,
                    'jadwal_sertifikasi_id' => $jadwal->id,
                ]);
            }

            BiayaKegiatan::updateOrCreate(
                ['kegiatan_id' => $keg->id, 'nama_jenis' => 'Mahasiswa FIKOM UMI (Subsidi)'],
                ['nominal' => 350000 + ($i * 50000)]
            );
            BiayaKegiatan::updateOrCreate(
                ['kegiatan_id' => $keg->id, 'nama_jenis' => 'Dosen / Alumni / Mahasiswa Luar'],
                ['nominal' => 550000 + ($i * 50000)]
            );
            BiayaKegiatan::updateOrCreate(
                ['kegiatan_id' => $keg->id, 'nama_jenis' => 'Umum / Profesional'],
                ['nominal' => 750000 + ($i * 50000)]
            );

            $allKegiatans[] = $keg;
        }
        $this->command->info('✓ 10 Kegiatan Aktif (5 Pelatihan + 5 Sertifikasi) + Jadwal & Biaya siap.');

        // 6. Mitra Kolaborasi (10 Data)
        $mitrasData = [
            ['nama_mitra' => 'MikroTik Academy', 'inisial' => 'MTIK', 'link_website' => 'https://mikrotik.com/training/academy', 'urutan' => 1],
            ['nama_mitra' => 'Cisco Networking Academy', 'inisial' => 'CSCO', 'link_website' => 'https://www.netacad.com', 'urutan' => 2],
            ['nama_mitra' => 'Badan Nasional Sertifikasi Profesi (BNSP)', 'inisial' => 'BNSP', 'link_website' => 'https://bnsp.go.id', 'urutan' => 3],
            ['nama_mitra' => 'AWS Academy', 'inisial' => 'AWS', 'link_website' => 'https://aws.amazon.com/training/awsacademy/', 'urutan' => 4],
            ['nama_mitra' => 'Oracle Academy', 'inisial' => 'ORCL', 'link_website' => 'https://academy.oracle.com', 'urutan' => 5],
            ['nama_mitra' => 'Google Cloud for Education', 'inisial' => 'GCP', 'link_website' => 'https://cloud.google.com/edu', 'urutan' => 6],
            ['nama_mitra' => 'Microsoft Learn for Educators', 'inisial' => 'MSFT', 'link_website' => 'https://learn.microsoft.com', 'urutan' => 7],
            ['nama_mitra' => 'Red Hat Academy', 'inisial' => 'RHAT', 'link_website' => 'https://www.redhat.com/en/services/training/red-hat-academy', 'urutan' => 8],
            ['nama_mitra' => 'Lembaga Sertifikasi Profesi (LSP) Telematika', 'inisial' => 'LSPT', 'link_website' => 'https://lsp-telematika.or.id', 'urutan' => 9],
            ['nama_mitra' => 'Dicoding Indonesia', 'inisial' => 'DCDG', 'link_website' => 'https://www.dicoding.com', 'urutan' => 10],
        ];

        foreach ($mitrasData as $m) {
            Mitra::updateOrCreate(
                ['nama_mitra' => $m['nama_mitra']],
                [
                    'inisial' => $m['inisial'],
                    'link_website' => $m['link_website'],
                    'urutan' => $m['urutan'],
                    'warna' => '#FFC81A',
                    'deskripsi' => 'Mitra kolaborasi resmi FIKOM Certification Center Universitas Muslim Indonesia.',
                ]
            );
        }
        $this->command->info('✓ 10 Mitra Strategis siap.');

        // 7. Testimoni (10 Data)
        $testimonisData = [
            [
                'nama' => 'Ahmad Raziq, S.Kom.',
                'rating' => 5,
                'keterangan' => 'Alumni Sertifikasi MTCNA · Network Engineer di PT Telkom',
                'kata' => 'Pelatihan dan sertifikasi di FIKOM Certification Center sangat terstruktur. Instrukturnya profesional dan materi yang diajarkan sangat relevan dengan kebutuhan industri saat ini.',
                'status' => 'dipublikasikan',
            ],
            [
                'nama' => 'Nurfadhilah, S.Kom.',
                'rating' => 5,
                'keterangan' => 'Alumni Pelatihan Web Dev · Software Engineer di Startup Tech',
                'kata' => 'Materi pelatihannya praktikal sekali dan fasilitator membimbing hingga benar-benar paham. Sertifikat resmi FCC UMI menjadi nilai tambah saat proses rekrutmen kerja.',
                'status' => 'dipublikasikan',
            ],
            [
                'nama' => 'Muhammad Fikri Ramadhan',
                'rating' => 5,
                'keterangan' => 'Mahasiswa FIKOM UMI · Peserta Sertifikasi Cyber Security',
                'kata' => 'Fasilitas lab komputer yang memadai dan simulasi ujian yang intensif membuat saya lulus ujian sertifikasi BNSP dalam sekali percobaan.',
                'status' => 'dipublikasikan',
            ],
            [
                'nama' => 'Siti Nurhaliza, S.T.',
                'rating' => 5,
                'keterangan' => 'Peserta Sertifikasi Data Analyst · Data Associate',
                'kata' => 'Sangat merekomendasikan FCC UMI bagi siapa saja yang ingin meningkatkan kompetensi digital. Proses pendaftarannya cepat dan pelayanannya sangat ramah.',
                'status' => 'dipublikasikan',
            ],
            [
                'nama' => 'Andi Muhammad Ikhsan',
                'rating' => 5,
                'keterangan' => 'Alumni Mobile Dev · Flutter Developer Freelance',
                'kata' => 'Banyak ilmu praktis yang tidak didapatkan di perkuliahan biasa. Portofolio proyek akhir dari FCC langsung membantu saya memenangkan kontrak proyek luar negeri.',
                'status' => 'dipublikasikan',
            ],
            [
                'nama' => 'Putri Ayu Wandira, S.Kom.',
                'rating' => 5,
                'keterangan' => 'Peserta Sertifikasi UI/UX Design · Product Designer',
                'kata' => 'Mentor sangat berpengalaman di industri. Feedback desain yang diberikan detail dan membangun pola pikir problem-solving yang sangat aplikatif.',
                'status' => 'dipublikasikan',
            ],
            [
                'nama' => 'Reza Pratama Putra',
                'rating' => 5,
                'keterangan' => 'Peserta Pelatihan DevOps & Cloud AWS · Cloud Engineer',
                'kata' => 'Hands-on lab-nya sangat lengkap. Konsep CI/CD pipeline dan Docker langsung dipraktikkan di server sungguhan sehingga tidak sekadar teori belaka.',
                'status' => 'dipublikasikan',
            ],
            [
                'nama' => 'Nurul Hidayah, S.Si.',
                'rating' => 5,
                'keterangan' => 'Peserta Pelatihan Data Science · AI Research Assistant',
                'kata' => 'Penjelasan materi machine learning disampaikan secara runtut dan mudah dipahami bahkan untuk pemula. Fasilitas bimbingannya luar biasa!',
                'status' => 'dipublikasikan',
            ],
            [
                'nama' => 'Faisal Tanjung',
                'rating' => 5,
                'keterangan' => 'Peserta Sertifikasi CCNA · Infrastructure Specialist',
                'kata' => 'Simulasi packet tracer dan lab fisik Cisco sangat membantu memahami konsep routing & switching kompleks. Ujian sertifikasi jadi terasa jauh lebih mudah.',
                'status' => 'dipublikasikan',
            ],
            [
                'nama' => 'Dewi Anggraeni, S.Kom.',
                'rating' => 5,
                'keterangan' => 'Peserta Scrum Master Masterclass · Associate Project Manager',
                'kata' => 'Simulasi sprint planning dan studi kasus nyata sangat aplikatif untuk manajemen tim pengembang software di kantor saya saat ini.',
                'status' => 'dipublikasikan',
            ],
        ];

        foreach ($testimonisData as $t) {
            Testimoni::updateOrCreate(['nama' => $t['nama']], $t);
        }
        $this->command->info('✓ 10 Testimoni siap.');

        // 8. Informasi & Pengumuman (10 Data)
        $admin = Admin::first();
        $adminId = $admin ? $admin->id : 1;

        $informasisData = [
            ['judul' => 'Pembukaan Pendaftaran Sertifikasi Kompetensi Batch 1 2026', 'isi' => 'Pendaftaran program sertifikasi kompetensi BNSP dan vendor internasional resmi dibuka untuk seluruh mahasiswa UMI dan umum.', 'jenis' => 'info'],
            ['judul' => 'Jadwal Pelaksanaan Workshop Fullstack Web Development', 'isi' => 'Kegiatan workshop akan dilaksanakan secara offline di Lab Komputer FIKOM UMI Lantai 3 mulai pukul 08.30 WITA.', 'jenis' => 'info'],
            ['judul' => 'Panduan Verifikasi Pembayaran & Unggah Bukti Transfer', 'isi' => 'Pastikan nominal transfer sesuai dengan kode unik 3 digit agar sistem dapat memverifikasi pembayaran Anda secara otomatis.', 'jenis' => 'info'],
            ['judul' => 'Fasilitas Ujian Ulang (Remedial) Sertifikasi MTCNA', 'isi' => 'Peserta yang belum mencapai passing grade berhak mengikuti satu kali sesi remedial gratis sesuai jadwal yang ditetapkan asesor.', 'jenis' => 'info'],
            ['judul' => 'Subsidi Biaya Sertifikasi BNSP Khusus Mahasiswa Aktif FIKOM UMI', 'isi' => 'Fakultas menyediakan subsidi potongan biaya sertifikasi kompetensi hingga 50% bagi mahasiswa aktif semester 5 ke atas.', 'jenis' => 'info'],
            ['judul' => 'Bagaimana cara mendaftar kegiatan di FCC UMI?', 'isi' => 'Buat akun peserta di menu Daftar, lengkapi data diri, pilih program kegiatan yang diinginkan, lakukan pembayaran, dan unggah bukti transfer.', 'jenis' => 'faq'],
            ['judul' => 'Apakah sertifikat FCC diakui secara nasional & internasional?', 'isi' => 'Ya, sertifikat yang diterbitkan terafiliasi dengan BNSP (Badan Nasional Sertifikasi Profesi) serta vendor resmi seperti MikroTik, Cisco, dan AWS.', 'jenis' => 'faq'],
            ['judul' => 'Berapa lama proses verifikasi bukti transfer pembayaran?', 'isi' => 'Proses verifikasi oleh tim Admin FCC membutuhkan waktu maksimal 1x24 jam pada hari kerja.', 'jenis' => 'faq'],
            ['judul' => 'Apakah peserta umum di luar UMI boleh mendaftar?', 'isi' => 'Tentu saja, seluruh program pelatihan dan sertifikasi terbuka bagi masyarakat umum, profesional, maupun mahasiswa dari kampus lain.', 'jenis' => 'faq'],
            ['judul' => 'Bagaimana cara mengunduh sertifikat setelah lulus kegiatan?', 'isi' => 'Setelah dinilai lulus oleh instruktur/asesor, sertifikat digital ber-QR Code dapat diunduh langsung melalui dashboard akun peserta.', 'jenis' => 'faq'],
        ];

        foreach ($informasisData as $inf) {
            Informasi::updateOrCreate(
                ['judul' => $inf['judul']],
                [
                    'admin_id' => $adminId,
                    'isi' => $inf['isi'],
                    'jenis' => $inf['jenis'],
                    'tayang_mulai' => now()->subDays(2),
                    'tayang_selesai' => now()->addMonths(6),
                ]
            );
        }
        $this->command->info('✓ 10 Informasi & FAQ siap.');

        // 9. Peserta Dummy (10 Data)
        $pesertasData = [
            ['nama' => 'Muhammad Fauzan', 'email' => 'fauzan@student.umi.ac.id', 'no_hp' => '082199001101', 'instansi' => 'FIKOM UMI (Teknik Informatika)', 'kelamin' => 'L'],
            ['nama' => 'Siti Khadijah', 'email' => 'khadijah@student.umi.ac.id', 'no_hp' => '082199001102', 'instansi' => 'FIKOM UMI (Sistem Informasi)', 'kelamin' => 'P'],
            ['nama' => 'Andi Arya Putra', 'email' => 'arya.putra@student.unhas.ac.id', 'no_hp' => '082199001103', 'instansi' => 'Universitas Hasanuddin', 'kelamin' => 'L'],
            ['nama' => 'Nurul Ainun', 'email' => 'ainun@student.unm.ac.id', 'no_hp' => '082199001104', 'instansi' => 'Universitas Negeri Makassar', 'kelamin' => 'P'],
            ['nama' => 'Rizky Pratama', 'email' => 'rizky.pratama@techcompany.id', 'no_hp' => '082199001105', 'instansi' => 'PT Karya Digital Nusantara', 'kelamin' => 'L'],
            ['nama' => 'Fitriani Syam', 'email' => 'fitriani@student.umi.ac.id', 'no_hp' => '082199001106', 'instansi' => 'FIKOM UMI (Teknik Informatika)', 'kelamin' => 'P'],
            ['nama' => 'Bagus Setiawan', 'email' => 'bagus.setiawan@freelancer.com', 'no_hp' => '082199001107', 'instansi' => 'Freelance Web Developer', 'kelamin' => 'L'],
            ['nama' => 'Aulia Rahmah', 'email' => 'aulia.rahmah@student.uin-alauddin.ac.id', 'no_hp' => '082199001108', 'instansi' => 'UIN Alauddin Makassar', 'kelamin' => 'P'],
            ['nama' => 'Hendrik Kurniawan', 'email' => 'hendrik@bankmandiri.co.id', 'no_hp' => '082199001109', 'instansi' => 'Bank Mandiri IT Department', 'kelamin' => 'L'],
            ['nama' => 'Tari Safitri', 'email' => 'tari.safitri@student.umi.ac.id', 'no_hp' => '082199001110', 'instansi' => 'FIKOM UMI (Sistem Informasi)', 'kelamin' => 'P'],
        ];

        $pesertas = [];
        foreach ($pesertasData as $p) {
            $pesertas[] = Peserta::updateOrCreate(
                ['email' => $p['email']],
                [
                    'nama' => $p['nama'],
                    'no_hp' => $p['no_hp'],
                    'instansi' => $p['instansi'],
                    'kelamin' => $p['kelamin'],
                    'alamat' => 'Jl. Urip Sumoharjo, Makassar',
                    'password' => Hash::make('password'),
                    'status_akun' => 'aktif',
                    'email_verified_at' => now(),
                ]
            );
        }
        $this->command->info('✓ 10 Akun Peserta siap (Password default: password).');

        // 8. Pendaftaran & Pembayaran (10 Data)
        for ($i = 0; $i < 10; $i++) {
            $pes = $pesertas[$i];
            $keg = $allKegiatans[$i % count($allKegiatans)] ?? Kegiatan::first();
            if (!$keg) continue;

            $biaya = BiayaKegiatan::where('kegiatan_id', $keg->id)->first();
            $statusPend = ['terdaftar', 'menunggu_verifikasi', 'terdaftar', 'terdaftar', 'menunggu_verifikasi'][$i % 5];

            $pend = Pendaftaran::updateOrCreate(
                ['peserta_id' => $pes->id, 'kegiatan_id' => $keg->id],
                [
                    'biaya_kegiatan_id' => $biaya?->id,
                    'tgl_daftar' => now()->subDays(10 - $i),
                    'status_pendaftaran' => $statusPend,
                    'status_kehadiran' => $statusPend === 'terdaftar' ? 'hadir' : 'belum',
                    'qr_token' => Str::random(32),
                ]
            );

            if ($biaya) {
                $statusBayar = $statusPend === 'terdaftar' ? 'terverifikasi' : 'menunggu_verifikasi';
                Pembayaran::updateOrCreate(
                    ['pendaftaran_id' => $pend->id],
                    [
                        'kode_pembayaran' => 'INV-' . date('Ymd') . '-' . str_pad($pend->id, 4, '0', STR_PAD_LEFT),
                        'kode_unik' => Pembayaran::generateKodeUnik($keg->jenis_kegiatan),
                        'tgl_kadaluarsa' => now()->addDays(2),
                        'jumlah_bayar' => $biaya->nominal,
                        'status_pembayaran' => $statusBayar,
                        'metode_pembayaran' => 'transfer_bank',
                        'nama_layanan_bank' => 'Bank Syariah Indonesia (BSI)',
                        'nama_pengirim' => $pes->nama,
                        'no_referensi' => 'TRX-' . strtoupper(Str::random(8)),
                        'tgl_transfer' => now()->subDays(1),
                        'jam_transfer' => '10:30:00',
                        'no_kwitansi' => $statusBayar === 'terverifikasi' ? 'KW-' . date('Ymd') . '-' . $pend->id : null,
                        'tgl_kwitansi' => $statusBayar === 'terverifikasi' ? now() : null,
                    ]
                );
            }
        }
        $this->command->info('✓ 10 Pendaftaran & Pembayaran siap.');

        $this->command->info('🎉 Sukses! Seluruh 10 Data Dummy per Entitas berhasil dibuat.');
    }
}
