<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class Nilai extends Model {
    use HasHashid;
    protected $table='nilai';
    protected $fillable=['pendaftaran_id','materi_pelatihan_id','materi_sertifikasi_id','nilai','keterangan'];
    protected $casts=['nilai'=>'decimal:2'];
    public function pendaftaran()       { return $this->belongsTo(Pendaftaran::class); }
    public function materiPelatihan()   { return $this->belongsTo(MateriPelatihan::class); }
    public function materiSertifikasi() { return $this->belongsTo(MateriSertifikasi::class); }
    public function getMateriAttribute() { return $this->materiPelatihan ?? $this->materiSertifikasi; }
}
