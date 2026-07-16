<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class KategoriSertifikasi extends Model {
    use HasHashid;
    protected $table='kategori_sertifikasi';
    protected $fillable=['nama_kategori'];
    public function sertifikasi() { return $this->hasMany(Sertifikasi::class); }
}
