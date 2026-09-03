<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class Sertifikasi extends Model {
    use HasHashid;
    protected $table='sertifikasi';
    protected $fillable=['kode','judul','isi','gambar','link_materi','kategori_id', 'nama_latar', 'sertifikat_layout'];
    protected $casts=['sertifikat_layout' => 'array'];

    public function kategori()  { return $this->belongsTo(Kategori::class,'kategori_id'); }
    public function materi()    { return $this->hasMany(MateriSertifikasi::class)->orderBy('urutan'); }
    public function jadwal()    { return $this->hasMany(JadwalSertifikasi::class); }

    public function getLatarUrlAttribute(): ?string {
        if (empty($this->nama_latar)) {
            return asset('images/latarsertifikat_default.webp');
        }
        if (str_starts_with($this->nama_latar, 'http://') || str_starts_with($this->nama_latar, 'https://')) {
            return $this->nama_latar;
        }
        return asset('storage/' . $this->nama_latar);
    }

    public function getHasLatarAttribute(): bool {
        if (empty($this->nama_latar)) return true;
        return file_exists(public_path('storage/' . $this->nama_latar))
            || file_exists(storage_path('app/public/' . $this->nama_latar));
    }

    public function getLayoutSettingsAttribute(): array
    {
        $default = [
            'title'    => ['top' => 41,    'left' => 2,   'font_size' => 35,  'font_family' => 'Times New Roman'],
            'subtitle' => ['top' => 51,    'left' => 4,   'font_size' => 40,  'font_family' => 'Georgia'],
            'label'    => ['top' => 72,    'left' => 5,   'font_size' => 8.5, 'font_family' => 'Poppins'],
            'name'     => ['top' => 73.5,  'left' => 0,   'font_size' => 60,  'font_family' => 'Allura'],
            'desc'     => ['top' => 115.1, 'left' => 0,   'font_size' => 16,  'title_font_size' => 19, 'line_height' => 0.9, 'line_gap' => 0, 'font_family' => 'Poppins'],
            'date'     => ['top' => 146,   'right' => 59, 'font_size' => 9.5, 'font_family' => 'Arial'],
            'sig1'     => ['top' => 155,   'left' => 61.1,'font_size' => 10,  'font_family' => 'Arial'],
            'sig2'     => ['top' => 155.2, 'right' => 57.1,'font_size' => 10, 'font_family' => 'Arial'],
        ];

        if (empty($this->sertifikat_layout)) {
            return $default;
        }

        $merged = array_replace_recursive($default, $this->sertifikat_layout);
        if (isset($merged['desc']['line_gap']) && (float)$merged['desc']['line_gap'] < 0) {
            $merged['desc']['line_gap'] = 0;
        }
        return $merged;
    }

    public function getGambarUrlAttribute(): ?string
    {
        if (!$this->gambar) return null;
        if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
            return $this->gambar;
        }
        $path = preg_replace('/^storage\//', '', $this->gambar);
        return asset('storage/' . $path);
    }
}
