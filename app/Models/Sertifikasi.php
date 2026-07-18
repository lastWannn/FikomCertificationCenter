<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class Sertifikasi extends Model {
    use HasHashid;
    protected $table='sertifikasi';
    protected $fillable=['kode','judul','isi','gambar','link_materi','kategori_id'];
    public function kategori()  { return $this->belongsTo(Kategori::class,'kategori_id'); }
    public function materi()    { return $this->hasMany(MateriSertifikasi::class)->orderBy('urutan'); }
    public function jadwal()    { return $this->hasMany(JadwalSertifikasi::class); }
}
