<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;

class Kegiatan extends Model {
    use HasHashid;
    protected $table    = 'kegiatan';
    protected $fillable = ['jenis_kegiatan','nama_latar','qr_token'];  // FIX: tambah qr_token

    public function kegiatanPelatihan()   { return $this->hasOne(KegiatanPelatihan::class); }
    public function kegiatanSertifikasi() { return $this->hasOne(KegiatanSertifikasi::class); }
    public function biaya()               { return $this->hasMany(BiayaKegiatan::class); }
    public function pendaftaran()         { return $this->hasMany(Pendaftaran::class); }
    public function arsip()               { return $this->hasOne(ArsipKegiatan::class); }

    public function getDetailAttribute() {
        if ($this->jenis_kegiatan === 'pelatihan')
            return $this->kegiatanPelatihan?->jadwalPelatihan?->pelatihan;
        return $this->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi;
    }
    public function getJadwalAttribute() {
        if ($this->jenis_kegiatan === 'pelatihan')
            return $this->kegiatanPelatihan?->jadwalPelatihan;
        return $this->kegiatanSertifikasi?->jadwalSertifikasi;
    }
    public function getJudulAttribute(): string { return $this->detail?->judul ?? '-'; }
    public function getTerisiAttribute(): int {
        return $this->pendaftaran()
            ->whereIn('status_pendaftaran',['menunggu_pembayaran','menunggu_verifikasi','terdaftar'])
            ->count();
    }
    public function getKuotaAttribute(): int   { return $this->jadwal?->kuota_peserta ?? 0; }
    public function isBerbayar(): bool         { return $this->biaya()->exists(); }
    public function isFull(): bool             { return $this->kuota > 0 && $this->terisi >= $this->kuota; }
    public function scopePelatihan($q)         { return $q->where('jenis_kegiatan','pelatihan'); }
    public function scopeSertifikasi($q)       { return $q->where('jenis_kegiatan','sertifikasi'); }
}
