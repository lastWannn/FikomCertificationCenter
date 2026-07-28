<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class Pelatihan extends Model {
    use HasHashid;
    protected $table='pelatihan';
    protected $fillable=['kode','judul','isi','gambar','link_materi','kategori_id', 'prasyarat_id'];
    public function kategori()     { return $this->belongsTo(Kategori::class,'kategori_id'); }
    public function materi()       { return $this->hasMany(MateriPelatihan::class)->orderBy('urutan'); }
    public function persyaratan()  { return $this->hasMany(PersyaratanPelatihan::class)->orderBy('urutan'); }
    public function prasyarat()    { return $this->belongsTo(Pelatihan::class, 'prasyarat_id'); }

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
