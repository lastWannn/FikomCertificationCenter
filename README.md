
## Cara Menambah Mitra & Logo

### Tambah Mitra via Admin Panel
Akses: `/admin/informasi` → Kelola Mitra

### Upload Logo Mitra
**Direktori logo:** `storage/app/public/mitra/`
**URL publik:** `public/storage/mitra/`

**Format yang disarankan:**
- Format: PNG atau SVG (transparan lebih bagus)
- Ukuran: 200×200 px atau 300×300 px
- Latar: transparan atau putih
- Maksimal: 500 KB

**Cara upload via shell:**
```bash
# Copy logo ke direktori storage
cp logo_telkom.png storage/app/public/mitra/

# Update field 'logo' di tabel mitra
php artisan tinker
>>> App\Models\Mitra::where('nama_mitra','PT. Telkom Indonesia')->update(['logo'=>'mitra/logo_telkom.png'])
```

**Cara upload via Seeder (untuk development):**
```php
// database/seeders/DatabaseSeeder.php
Mitra::create([
    'nama_mitra' => 'PT. Telkom Indonesia',
    'inisial'    => 'TLK',
    'logo'       => 'mitra/telkom.png',  // letakkan file di storage/app/public/mitra/
]);
```

**Tampilan:**
- **Ada logo:** Gambar logo muncul dalam kotak 64×64 px (hitam)
- **Tanpa logo:** Inisial kuning tampil sebagai fallback otomatis
