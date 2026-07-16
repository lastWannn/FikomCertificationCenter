<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class Pelatihan extends Model {
    use HasHashid;
    protected $table='pelatihan';
    protected $fillable=['kode','judul','isi','gambar','link_materi','kategori_pelatihan_id','instruktur_id'];
    public function kategori()     { return $this->belongsTo(KategoriPelatihan::class,'kategori_pelatihan_id'); }
    public function instruktur()   { return $this->belongsTo(Instruktur::class); }
    public function materi()       { return $this->hasMany(MateriPelatihan::class)->orderBy('urutan'); }
    public function persyaratan()  { return $this->hasMany(PersyaratanPelatihan::class)->orderBy('urutan'); }
    public function jadwal()       { return $this->hasMany(JadwalPelatihan::class); }
}
