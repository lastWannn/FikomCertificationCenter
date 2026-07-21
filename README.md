# FIKOM Certification Center (FCC) UMI

![FCC Cover](public/storage/mitra/default-cover.png) *(Ilustrasi)*

Aplikasi portal sertifikasi resmi untuk Fakultas Ilmu Komputer (FIKOM) Universitas Muslim Indonesia (UMI). Aplikasi ini dibangun untuk memfasilitasi mahasiswa dan masyarakat umum dalam mengikuti berbagai pelatihan dan sertifikasi kompetensi IT secara profesional.

## ✨ Fitur Utama

- **Autentikasi Modern:** Login, pendaftaran, dan lupa password menggunakan verifikasi OTP via Email (tanpa perpindahan halaman/menggunakan modal popup yang *seamless*).
- **Manajemen Pelatihan:** Sistem pengelolaan jadwal pelatihan, materi, dan persyaratan sertifikasi.
- **Integrasi Pembayaran:** Terintegrasi dengan **Midtrans** (Simulator/Production) untuk pembayaran biaya sertifikasi yang otomatis terverifikasi.
- **Sistem Kehadiran:** Absensi instan menggunakan teknologi pemindaian QR Code (Scanner terintegrasi).
- **Sertifikat Digital:** Cetak sertifikat otomatis kelulusan peserta.
- **Dashboard Admin:** Statistik komprehensif, manajemen mitra, pengguna, instruktur, laporan, dan pengaturan website.
- **Desain UI/UX Premium:** Menggunakan tema gelap (*dark theme*) dengan aksen emas yang elegan, responsif, dan kaya akan animasi mikro (dibangun dengan Tailwind CSS murni).

---

## 🛠️ Persyaratan Sistem (Requirements)

Sebelum menjalankan aplikasi ini, pastikan sistem Anda memiliki:
- **PHP** >= 8.2
- **Composer** (untuk dependensi PHP)
- **Node.js & npm** (untuk kompilasi aset Frontend Vite)
- **MySQL / MariaDB** (sebagai database)

---

## 🚀 Panduan Instalasi (Installation Guide)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

1. **Clone Repository**
   ```bash
   git clone https://github.com/lastWannn/FikomCertificationCenter.git
   cd FikomCertificationCenter
   ```

2. **Install Dependensi PHP & Node.js**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file konfigurasi *environment* dan sesuaikan dengan pengaturan *database* Anda.
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` menggunakan *text editor* dan atur konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Seeding (Data Dummy)**
   Jalankan migrasi untuk membuat struktur tabel dan mengisi data awal (Admin, Pelatihan, Mitra, dll).
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Tautkan Folder Storage**
   Agar gambar (foto profil, logo mitra) dapat diakses publik, buat *symlink* ke folder storage:
   ```bash
   php artisan storage:link
   ```

7. **Build Aset Frontend (Vite)**
   Aplikasi ini menggunakan Vite. Wajib melakukan *build* atau jalankan *dev server*.
   ```bash
   # Untuk produksi/hasil akhir
   npm run build
   
   # ATAU untuk development (hot-reload)
   npm run dev
   ```

8. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Buka browser dan akses: `http://localhost:8000`

---

## 🔐 Akun Default (Testing)

Setelah Anda menjalankan `php artisan migrate:fresh --seed`, Anda dapat masuk menggunakan akun berikut:

**Administrator:**
- Email: `admin@fcc.umi.ac.id`
- Password: `password`

**Peserta (Mahasiswa UMI):**
- Email: `mahasiswa@umi.ac.id`
- Password: `password`

**Peserta (Umum):**
- Email: `umum@example.com`
- Password: `password`

---

## 📧 Konfigurasi Email (OTP)

Secara bawaan (*default*), pengiriman email diatur menggunakan mode `log` untuk mempermudah tahap pengembangan. Jika Anda menggunakan `MAIL_MAILER=log`, kode OTP tidak dikirim ke internet, melainkan **dicetak di dalam file `storage/logs/laravel.log`**.

Jika Anda ingin mencoba pengiriman email secara nyata menggunakan **Gmail SMTP**, ubah file `.env` Anda menjadi:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email_anda@gmail.com
MAIL_PASSWORD=app_password_anda_16_karakter
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email_anda@gmail.com
MAIL_FROM_NAME="FIKOM Certification Center"
```
Setelah mengubah `.env`, pastikan membersihkan cache konfigurasi:
```bash
php artisan config:clear
```

---

## 💡 Tambahan: Cara Menambah Mitra & Logo

### Tambah Mitra via Admin Panel
Akses: `/admin/informasi` → Kelola Mitra

### Upload Logo Mitra (Manual)
**Direktori logo:** `storage/app/public/mitra/`
**URL publik:** `public/storage/mitra/`

**Format yang disarankan:**
- Format: PNG atau SVG (transparan)
- Ukuran: 200×200 px atau 300×300 px
- Latar: transparan atau putih
- Maksimal: 500 KB

---

*Dikembangkan untuk Fakultas Ilmu Komputer - Universitas Muslim Indonesia.*
