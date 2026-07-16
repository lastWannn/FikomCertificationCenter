<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class KategoriPelatihan extends Model {
    use HasHashid;
    protected $table='kategori_pelatihan';
    protected $fillable=['nama_kategori'];
    public function pelatihan() { return $this->hasMany(Pelatihan::class); }
}
