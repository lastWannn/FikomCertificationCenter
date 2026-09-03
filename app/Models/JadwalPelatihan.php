<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
class JadwalPelatihan extends Model {
    use HasHashid;
    protected $table='jadwal_pelatihan';
    protected $fillable=['pelatihan_id','nama_kegiatan','biaya_setup','kuota_peserta','untuk_peserta','tgl_batas_daftar','tgl_pelaksanaan','jam_mulai','jam_selesai'];
    protected $casts=['tgl_batas_daftar'=>'date','tgl_pelaksanaan'=>'date','kuota_peserta'=>'integer','biaya_setup'=>'array'];
    public function pelatihan()       { return $this->belongsTo(Pelatihan::class); }
    public function kegiatanPelatihan(){ return $this->hasOne(KegiatanPelatihan::class); }
    public function kegiatan()        { return $this->hasOneThrough(Kegiatan::class,KegiatanPelatihan::class,'jadwal_pelatihan_id','id','id','kegiatan_id'); }
    public function getMasihDapatDidaftarAttribute(): bool { return now()->lte($this->tgl_batas_daftar); }
    
    public function getNamaDisplayAttribute(): string 
    {
        $nama = trim($this->nama_kegiatan ?? '');
        return !empty($nama) ? $nama : ($this->pelatihan?->judul ?? '-');
    }
}
