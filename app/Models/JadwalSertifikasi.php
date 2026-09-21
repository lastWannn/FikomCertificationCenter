<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class JadwalSertifikasi extends Model {
    use HasHashid;
    protected $table='jadwal_sertifikasi';
    protected $fillable=['sertifikasi_id','nama_kegiatan','biaya_setup','kuota_peserta','untuk_peserta','tgl_batas_daftar','tgl_pelaksanaan','jam_mulai','jam_selesai'];
    protected $casts=['tgl_batas_daftar'=>'date','tgl_pelaksanaan'=>'date','kuota_peserta'=>'integer','biaya_setup'=>'array'];
    public function sertifikasi()       { return $this->belongsTo(Sertifikasi::class); }
    public function kegiatanSertifikasi(){ return $this->hasOne(KegiatanSertifikasi::class); }
    public function kegiatan()          { return $this->hasOneThrough(Kegiatan::class,KegiatanSertifikasi::class,'jadwal_sertifikasi_id','id','id','kegiatan_id'); }
    public function getMasihDapatDidaftarAttribute(): bool { return now()->lte($this->tgl_batas_daftar); }
}
