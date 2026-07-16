<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PersyaratanPelatihan extends Model {
    protected $table='persyaratan_pelatihan';
    protected $fillable=['pelatihan_id','deskripsi_syarat','urutan'];
    public function pelatihan() { return $this->belongsTo(Pelatihan::class); }
}
