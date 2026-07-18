<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class MateriPelatihan extends Model {
    use HasHashid;
    protected $table='materi_pelatihan';
    protected $fillable=['pelatihan_id','judul_materi','file_materi','jam_pelajaran','urutan'];
    protected $casts=['jam_pelajaran'=>'integer','urutan'=>'integer'];
    public function pelatihan() { return $this->belongsTo(Pelatihan::class); }
    public function nilai()     { return $this->hasMany(Nilai::class); }
}
