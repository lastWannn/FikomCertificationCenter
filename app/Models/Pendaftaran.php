<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
use Illuminate\Database\Eloquent\Builder;

class Pendaftaran extends Model {
    use HasHashid;
    protected $table    = 'pendaftaran';
    protected $fillable = [
        'peserta_id','kegiatan_id','biaya_kegiatan_id',
        'tgl_daftar','status_pendaftaran','status_kehadiran',
        'qr_token',
        'transkrip_nilai',
    ];
    protected $casts = ['tgl_daftar' => 'datetime'];

    public function peserta()    { return $this->belongsTo(Peserta::class); }
    public function kegiatan()   { return $this->belongsTo(Kegiatan::class); }
    public function biaya()      { return $this->belongsTo(BiayaKegiatan::class,'biaya_kegiatan_id'); }
    public function pembayaran() { return $this->hasOne(Pembayaran::class); }
    public function nilai()      { return $this->hasMany(Nilai::class); }
    public function sertifikat() { return $this->hasOne(Sertifikat::class); }

    public function scopeTerdaftar(Builder $q)          { return $q->where('status_pendaftaran','terdaftar'); }
    public function scopeMenungguVerifikasi(Builder $q) { return $q->where('status_pendaftaran','menunggu_verifikasi'); }
    public function getIsTerdaftarAttribute(): bool     { return $this->status_pendaftaran === 'terdaftar'; }
    public function getIsGratisAttribute(): bool        { return is_null($this->biaya_kegiatan_id); }

    public function getTranskripUrlAttribute(): ?string
    {
        if (!$this->transkrip_nilai) return null;
        if (str_starts_with($this->transkrip_nilai, 'http://') || str_starts_with($this->transkrip_nilai, 'https://')) {
            return $this->transkrip_nilai;
        }
        return asset('storage/' . $this->transkrip_nilai);
    }
}
