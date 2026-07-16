<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class MateriSertifikasi extends Model {
    use HasHashid;
    protected $table='materi_sertifikasi';
    protected $fillable=['sertifikasi_id','judul_materi','isi','file_materi','urutan'];
    protected $casts=['urutan'=>'integer'];
    public function sertifikasi() { return $this->belongsTo(Sertifikasi::class); }
    public function nilai()       { return $this->hasMany(Nilai::class); }
}
