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
    public function getJudulAttribute(): string { return $this->jadwal?->nama_kegiatan ?? $this->detail?->judul ?? '-'; }
    public function getTerisiAttribute(): int {
        return $this->pendaftaran()
            ->whereIn('status_pendaftaran',['menunggu_pembayaran','menunggu_verifikasi','terdaftar'])
            ->count();
    }
    public function getKuotaAttribute(): int   { return $this->jadwal?->kuota_peserta ?? 0; }
    public function isBerbayar(): bool         { return $this->biaya()->exists(); }
    public function isFull(): bool             { return $this->kuota > 0 && $this->terisi >= $this->kuota; }
    public function isPassed(): bool
    {
        $jadwal = $this->jadwal;
        if (!$jadwal || !$jadwal->tgl_pelaksanaan) return false;
        return $jadwal->tgl_pelaksanaan->lte(now()->startOfDay());
    }
    public function scopePelatihan($q)         { return $q->where('jenis_kegiatan','pelatihan'); }
    public function scopeSertifikasi($q)       { return $q->where('jenis_kegiatan','sertifikasi'); }

    public function scopeUpcoming($q)
    {
        $today = now()->toDateString();
        return $q->where(function($query) use ($today) {
            $query->whereHas('kegiatanPelatihan.jadwalPelatihan', function($j) use ($today) {
                $j->where('tgl_pelaksanaan', '>', $today)
                  ->orWhereNull('tgl_pelaksanaan');
            })->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi', function($j) use ($today) {
                $j->where('tgl_pelaksanaan', '>', $today)
                  ->orWhereNull('tgl_pelaksanaan');
            });
        });
    }

    public function scopePassed($q)
    {
        $today = now()->toDateString();
        return $q->where(function($query) use ($today) {
            $query->whereHas('kegiatanPelatihan.jadwalPelatihan', function($j) use ($today) {
                $j->whereNotNull('tgl_pelaksanaan')->where('tgl_pelaksanaan', '<=', $today);
            })->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi', function($j) use ($today) {
                $j->whereNotNull('tgl_pelaksanaan')->where('tgl_pelaksanaan', '<=', $today);
            });
        });
    }
}
