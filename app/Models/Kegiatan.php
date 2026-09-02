<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;

class Kegiatan extends Model {
    use HasHashid;
    protected $table    = 'kegiatan';
    protected $fillable = ['jenis_kegiatan','nama_latar','sertifikat_layout','qr_token','status'];
    protected $casts    = ['sertifikat_layout' => 'array'];

    public function kegiatanPelatihan()   { return $this->hasOne(KegiatanPelatihan::class); }
    public function kegiatanSertifikasi() { return $this->hasOne(KegiatanSertifikasi::class); }
    public function biaya()               { return $this->hasMany(BiayaKegiatan::class); }
    public function pendaftaran()         { return $this->hasMany(Pendaftaran::class); }
    public function arsip()               { return $this->hasOne(ArsipKegiatan::class); }

    public function getLayoutSettingsAttribute(): array
    {
        $default = [
            'title'    => ['top' => 36, 'left' => 0, 'font_size' => 32, 'font_family' => 'Times New Roman'],
            'subtitle' => ['top' => 48, 'left' => 0, 'font_size' => 11, 'font_family' => 'Montserrat'],
            'label' => ['top' => 63, 'left' => 0, 'font_size' => 8.5, 'font_family' => 'Arial'],
            'name'  => ['top' => 71, 'left' => 0, 'font_size' => 36, 'font_family' => 'Great Vibes'],
            'desc'  => ['top' => 109, 'left' => 0, 'font_size' => 10, 'title_font_size' => 14, 'line_height' => 0.9, 'line_gap' => 0, 'font_family' => 'Poppins'],
            'date'  => ['top' => 146, 'right' => 46, 'font_size' => 9.5, 'font_family' => 'Arial'],
            'sig1'  => ['top' => 167.5, 'left' => 60, 'font_size' => 10, 'font_family' => 'Arial'],
            'sig2'  => ['top' => 167.5, 'right' => 46, 'font_size' => 10, 'font_family' => 'Arial'],
        ];

        if (empty($this->sertifikat_layout)) {
            return $default;
        }

        $merged = array_replace_recursive($default, $this->sertifikat_layout);
        if (isset($merged['desc']['line_gap']) && (float)$merged['desc']['line_gap'] < 0) {
            $merged['desc']['line_gap'] = 0;
        }
        return $merged;
    }

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
    public function getJudulAttribute(): string { return $this->detail?->judul ?? $this->jadwal?->nama_kegiatan ?? '-'; }
    public function getLatarUrlAttribute(): ?string {
        if (empty($this->nama_latar)) return null;
        if (str_starts_with($this->nama_latar, 'http://') || str_starts_with($this->nama_latar, 'https://')) {
            return $this->nama_latar;
        }
        return asset('storage/' . $this->nama_latar);
    }
    public function getHasLatarAttribute(): bool {
        if (empty($this->nama_latar)) return false;
        return file_exists(public_path('storage/' . $this->nama_latar))
            || file_exists(storage_path('app/public/' . $this->nama_latar));
    }
    public function getTerisiAttribute(): int {
        return $this->pendaftaran()
            ->whereIn('status_pendaftaran',['menunggu_pembayaran','menunggu_verifikasi','terdaftar'])
            ->count();
    }
    public function getKuotaAttribute(): int   { return $this->jadwal?->kuota_peserta ?? 0; }
    public function isBerbayar(): bool         { return $this->biaya()->exists(); }
    public function isFull(): bool             { return $this->kuota > 0 && $this->terisi >= $this->kuota; }
    
    public function isDraf(): bool             { return $this->status === 'draf'; }
    public function isComingSoon(): bool       { return $this->status === 'comingsoon'; }
    public function isPublic(): bool           { return $this->status === 'public' || empty($this->status); }
    
    public function isRegistrationClosed(): bool
    {
        $jadwal = $this->jadwal;
        if (!$jadwal) return false;

        if ($jadwal->tgl_batas_daftar && $jadwal->tgl_batas_daftar->lt(now()->startOfDay())) {
            return true;
        }

        if ($jadwal->tgl_pelaksanaan && $jadwal->tgl_pelaksanaan->lt(now()->startOfDay())) {
            return true;
        }

        return false;
    }

    public function isRegisterable(): bool     { return $this->isPublic() && !$this->isFull() && !$this->isRegistrationClosed(); }

    public function isPassed(): bool
    {
        $jadwal = $this->jadwal;
        if (!$jadwal || !$jadwal->tgl_pelaksanaan) return false;
        return $jadwal->tgl_pelaksanaan->lt(now()->startOfDay());
    }
    public function scopePelatihan($q)         { return $q->where('jenis_kegiatan','pelatihan'); }
    public function scopeSertifikasi($q)       { return $q->where('jenis_kegiatan','sertifikasi'); }
    public function scopeVisibleToPublic($q)   { return $q->where(fn($sub) => $sub->whereIn('status', ['public', 'comingsoon'])->orWhereNull('status')); }

    public function scopeUpcoming($q)
    {
        $today = now()->toDateString();
        return $q->where(function($sub) {
            $sub->whereIn('status', ['public', 'comingsoon'])->orWhereNull('status');
        })->where(function($query) use ($today) {
            $query->whereHas('kegiatanPelatihan.jadwalPelatihan', function($j) use ($today) {
                $j->where('tgl_pelaksanaan', '>=', $today)
                  ->orWhereNull('tgl_pelaksanaan');
            })->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi', function($j) use ($today) {
                $j->where('tgl_pelaksanaan', '>=', $today)
                  ->orWhereNull('tgl_pelaksanaan');
            });
        });
    }

    public function scopePassed($q)
    {
        $today = now()->toDateString();
        return $q->where(function($query) use ($today) {
            $query->whereHas('kegiatanPelatihan.jadwalPelatihan', function($j) use ($today) {
                $j->whereNotNull('tgl_pelaksanaan')->where('tgl_pelaksanaan', '<', $today);
            })->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi', function($j) use ($today) {
                $j->whereNotNull('tgl_pelaksanaan')->where('tgl_pelaksanaan', '<', $today);
            });
        });
    }
}
