<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Kontak extends Model {
    protected $table='kontak';
    protected $fillable=['nama','alamat','telepon','email','maps_embed'];
    public static function aktif(): ?self { return self::latest()->first(); }

    /**
     * Format nomor telepon dengan nama jika tersedia: "081234567890 (Admin FCC)"
     */
    public function getTeleponDenganNamaAttribute(): string
    {
        $telp = $this->telepon ?? '(0411) 455 855';
        if (!empty($this->nama)) {
            return $telp . ' (' . $this->nama . ')';
        }
        return $telp;
    }

    /**
     * URL WhatsApp otomatis dari nomor telepon/WA
     */
    public function getWaUrlAttribute(): string
    {
        $raw = $this->telepon ?? '6281234567890';
        if (preg_match('/(?:\+?62|0)8[0-9\s\-]{8,}/', $raw, $matches)) {
            $digits = preg_replace('/\D/', '', $matches[0]);
            if (str_starts_with($digits, '0')) {
                $digits = '62' . substr($digits, 1);
            }
            return 'https://wa.me/' . $digits;
        }
        $digits = preg_replace('/\D/', '', $raw);
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }
        return 'https://wa.me/' . ($digits ?: '6281234567890');
    }

    /**
     * URL mailto untuk email resmi
     */
    public function getMailtoUrlAttribute(): string
    {
        return 'mailto:' . trim($this->email ?? 'fcc@fikom.umi.ac.id');
    }
}
