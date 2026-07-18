<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KegiatanPelatihan extends Model {
    protected $table='kegiatan_pelatihan';
    protected $primaryKey='kegiatan_id';
    public $incrementing=false; public $timestamps=false;
    protected $fillable=['kegiatan_id','jadwal_pelatihan_id'];
    public function kegiatan()       { return $this->belongsTo(Kegiatan::class); }
    public function jadwalPelatihan(){ return $this->belongsTo(JadwalPelatihan::class); }
}
