<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KegiatanSertifikasi extends Model {
    protected $table='kegiatan_sertifikasi';
    protected $primaryKey='kegiatan_id';
    public $incrementing=false; public $timestamps=false;
    protected $fillable=['kegiatan_id','jadwal_sertifikasi_id'];
    public function kegiatan()         { return $this->belongsTo(Kegiatan::class); }
    public function jadwalSertifikasi(){ return $this->belongsTo(JadwalSertifikasi::class); }
}
