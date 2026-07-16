# FCC Laravel - Panduan Setup

## Requirements
- PHP 8.3+
- Composer
- Node.js 20+
- MySQL 8.0+

## Langkah Instalasi

### 1. Copy file ke project Laravel
Copy semua file dari folder ini ke root project Laravel kamu.

**PERHATIAN**: Hapus file migrasi default users bawaan Laravel:
```
database/migrations/0001_01_01_000000_create_users_table.php
```
File ini HARUS dihapus karena sudah digantikan oleh tabel `admins`, `instruktur`, dan `peserta`.

### 2. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_URL=http://localhost:8000
DB_DATABASE=fcc_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Install dependencies
```bash
composer install
npm install
```

### 4. Jalankan migrasi & seeder
```bash
php artisan migrate --seed
php artisan storage:link
```

### 5. Build assets
```bash
npm run dev        # untuk development
# atau
npm run build      # untuk production
```

### 6. Jalankan server
```bash
php artisan serve
```

---

## Akun Default
| Role  | Email               | Password |
|-------|---------------------|----------|
| Admin | admin@fcc.ac.id     | password |

---

## Struktur Halaman

### Public (Landing Page)
| Route            | URL                  |
|------------------|----------------------|
| Beranda          | /                    |
| Profil           | /profil              |
| Kegiatan         | /kegiatan            |
| Detail Kegiatan  | /kegiatan/{id}       |
| Pendaftaran      | /pendaftaran         |
| Arsip            | /arsip               |
| Hubungi Kami     | /hubungi-kami        |

### Auth
| Route    | URL      |
|----------|----------|
| Login    | /masuk   |
| Register | /daftar  |
| Logout   | POST /keluar |

### Admin Panel
| Route          | URL               |
|----------------|-------------------|
| Dashboard      | /admin/           |
| Pelatihan      | /admin/pelatihan  |
| Sertifikasi    | /admin/sertifikasi|
| Biaya          | /admin/biaya      |
| Pembayaran     | /admin/pembayaran |
| Presensi       | /admin/presensi   |
| Arsip          | /admin/arsip      |
| Informasi/FAQ  | /admin/informasi  |
| Rekening       | /admin/rekening   |
| Sertifikat     | /admin/sertifikat |
| Profil         | /admin/profil     |

### Peserta Portal
| Route           | URL               |
|-----------------|-------------------|
| Dashboard       | /peserta/         |
| Jelajahi        | /peserta/jelajahi |
| Pendaftaran     | /peserta/pendaftaran |
| Pembayaran      | /peserta/pembayaran  |
| Sertifikat      | /peserta/sertifikat  |
| Profil          | /peserta/profil      |

---

## Database - 26 Tabel

```
admins                  — Akun admin penyelenggara
instruktur              — Akun instruktur pelatihan
peserta                 — Akun peserta (dapat login + mendaftar kegiatan)
kategori_pelatihan      — Kategori program pelatihan
kategori_sertifikasi    — Kategori program sertifikasi
pelatihan               — Program pelatihan (judul, instruktur, materi)
sertifikasi             — Program sertifikasi (judul, kategori, materi)
materi_pelatihan        — Materi/modul tiap pelatihan
persyaratan_pelatihan   — Persyaratan peserta tiap pelatihan
jadwal_pelatihan        — Jadwal pelaksanaan pelatihan
materi_sertifikasi      — Materi/modul tiap sertifikasi
jadwal_sertifikasi      — Jadwal pelaksanaan sertifikasi
kegiatan                — Supertype: penghubung jadwal → kegiatan aktif
kegiatan_pelatihan      — Relasi kegiatan → jadwal pelatihan (CTI)
kegiatan_sertifikasi    — Relasi kegiatan → jadwal sertifikasi (CTI)
biaya_kegiatan          — Jenis & nominal biaya per kegiatan
pendaftaran             — Pendaftaran peserta ke kegiatan (anti-duplikasi)
pembayaran              — Data pembayaran + kode unik + countdown
nilai                   — Nilai/penilaian peserta per materi
sertifikat              — Sertifikat digital yang diterbitkan
informasi               — Informasi & FAQ publik
rekening                — Rekening tujuan pembayaran (satu aktif)
arsip_kegiatan          — Arsip dokumentasi kegiatan selesai
konten_halaman          — Konten CMS halaman publik (beranda, profil, dll.)
mitra                   — Data mitra institusi (logo, inisial, warna)
kontak                  — Informasi kontak & Google Maps embed
```

---

## Palet Warna (Tailwind CSS v4)

| Variable          | Hex       | Penggunaan            |
|-------------------|-----------|-----------------------|
| --color-fcc-yellow| #FFC81A   | CTA button, accent    |
| --color-fcc-black | #131218   | Background utama      |
| --color-fcc-dark  | #1A1920   | Background section    |
| Putih             | #FFFFFF   | Card, form background |

---

## Catatan Penting
- Authentication multi-guard: Admin, Peserta (login di halaman yang sama, backend menentukan role)
- GuestFcc middleware mencegah pengguna yang sudah login mengakses halaman /masuk & /daftar
- Pembayaran menggunakan kode unik dengan countdown 2 jam otomatis
- Constraints CHECK pada tabel `nilai` untuk memastikan XOR: materi_pelatihan_id OR materi_sertifikasi_id
