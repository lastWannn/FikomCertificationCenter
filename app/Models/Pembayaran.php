<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid;
use Illuminate\Support\Str;

class Pembayaran extends Model
{
    use HasHashid;
    protected $table = 'pembayaran';

    protected $fillable = [
        'pendaftaran_id', 'kode_pembayaran', 'kode_unik', 'tgl_kadaluarsa', 'jumlah_bayar',
        'status_pembayaran',
        'metode_pembayaran', 'nama_layanan_bank', 'nama_pengirim',
        'no_referensi', 'berita_transaksi',
        'tgl_transfer', 'jam_transfer', 'bukti_bayar',
        'no_kwitansi', 'tgl_kwitansi',
        // Perpanjangan
        'request_perpanjangan_at', 'alasan_perpanjangan',
        'status_perpanjangan', 'catatan_perpanjangan',
    ];

    protected $casts = [
        'tgl_kadaluarsa'           => 'datetime',
        'tgl_transfer'             => 'date',
        'tgl_kwitansi'             => 'date',
        'tgl_verifikasi'           => 'datetime',
        'jumlah_bayar'             => 'decimal:0',
        'request_perpanjangan_at'  => 'datetime',
    ];

    /* ── RELATIONS ────────────────────────────────────────────── */
    public function pendaftaran() { return $this->belongsTo(Pendaftaran::class); }

    /* ── KODE UNIK ─────────────────────────────────────────────
     *
     * Logika kode unik 3 digit pada nominal pembayaran:
     *   Digit ke-1 : jenis kegiatan → 1 = pelatihan, 2 = sertifikasi
     *   Digit ke-2,3 : angka acak 10–99 (unik per transaksi)
     *
     * Contoh (pelatihan, nominal 500.000):
     *   kode_unik       = "147"     (1 = pelatihan, 47 = acak)
     *   nominal_transfer = 500.147  (peserta transfer TEPAT jumlah ini)
     *
     * Manfaat:
     *   - Admin bisa langsung identifikasi jenis & transaksi dari nominal
     *   - Tidak ada dua transaksi dengan nominal identik dalam satu hari
     * ───────────────────────────────────────────────────────── */
    public static function generateKodeUnik(string $jenisKegiatan): string
    {
        // Digit pertama: 1 = pelatihan, 2 = sertifikasi
        $prefix = $jenisKegiatan === 'pelatihan' ? 1 : 2;

        // 2 digit acak 10–99 agar total selalu 3 digit
        $acak = rand(10, 99);

        return (string) ($prefix * 100 + $acak);  // "147", "263", dll.
    }

    /**
     * Nominal yang HARUS ditransfer oleh peserta.
     * = jumlah_bayar + kode_unik
     * Contoh: 500000 + 147 = 500147
     */
    public function getNominalTransferAttribute(): int
    {
        return (int) $this->jumlah_bayar + (int) ($this->kode_unik ?? 0);
    }

    public function getNominalTransferFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->nominal_transfer, 0, ',', '.');
    }

    /* ── KODE PEMBAYARAN ────────────────────────────────────── */
    public static function generateKode(): string
    {
        do {
            $kode = 'FCC-' . now()->format('Ym') . '-' . strtoupper(Str::random(6));
        } while (self::where('kode_pembayaran', $kode)->exists());

        return $kode;
    }

    /* ── STATUS & EXPIRY ────────────────────────────────────── */
    public function isKadaluarsa(): bool
    {
        return $this->status_pembayaran === 'menunggu_pembayaran'
            && now()->gt($this->tgl_kadaluarsa);
    }

    public function isAktif(): bool
    {
        return $this->status_pembayaran === 'menunggu_pembayaran'
            && now()->lt($this->tgl_kadaluarsa);
    }

    /**
     * Cek expiry & update status saat view dibuka.
     * Tidak mengubah status jika sedang menunggu perpanjangan.
     */
    public function checkAndUpdateExpiry(): void
    {
        if ($this->isKadaluarsa()
            && $this->status_perpanjangan !== 'menunggu') {
            $this->update(['status_pembayaran' => 'kadaluarsa']);
            $this->pendaftaran->update(['status_pendaftaran' => 'menunggu_pembayaran']);
        }
    }

    /** Admin memperpanjang batas waktu +2 jam */
    public function perpanjang(?int $jamTambah = 2): void
    {
        $this->update([
            'tgl_kadaluarsa'          => now()->addHours($jamTambah),
            'status_pembayaran'       => 'menunggu_pembayaran',
            'status_perpanjangan'     => 'disetujui',
        ]);
    }

    /** Peserta meminta perpanjangan */
    public function requestPerpanjangan(?string $alasan = null): void
    {
        $this->update([
            'request_perpanjangan_at' => now(),
            'alasan_perpanjangan'     => $alasan,
            'status_perpanjangan'     => 'menunggu',
        ]);
    }

    /** Admin menolak permintaan perpanjangan */
    public function tolakPerpanjangan(?string $catatan = null): void
    {
        $this->update([
            'status_perpanjangan'   => 'ditolak',
            'catatan_perpanjangan'  => $catatan,
        ]);
    }

    public function verifikasi(?string $noKwitansi = null): void
    {
        $this->update([
            'status_pembayaran' => 'terverifikasi',
            'no_kwitansi'       => $noKwitansi,
            'tgl_kwitansi'      => now()->toDateString(),
        ]);
        $this->pendaftaran->update(['status_pendaftaran' => 'terdaftar']);
    }

    public function tolak(): void
    {
        $this->update(['status_pembayaran' => 'ditolak']);
        $this->pendaftaran->update(['status_pendaftaran' => 'ditolak']);
    }

    /* ── ACCESSORS ──────────────────────────────────────────── */
    public function getMinutesLeftAttribute(): int
    {
        if ($this->status_pembayaran !== 'menunggu_pembayaran') return 0;
        return max(0, (int) now()->diffInMinutes($this->tgl_kadaluarsa, false));
    }

    public function getJumlahBayarFormatAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->jumlah_bayar, 0, ',', '.');
    }

    /** Apakah peserta boleh request perpanjangan? */
    public function bisaRequestPerpanjangan(): bool
    {
        return in_array($this->status_pembayaran, ['menunggu_pembayaran', 'kadaluarsa'])
            && !in_array($this->status_perpanjangan, ['menunggu', 'disetujui'])
            && $this->status_pembayaran !== 'terverifikasi';
    }

    /** Apakah peserta boleh upload bukti? */
    public function bisaUploadBukti(): bool
    {
        return $this->isAktif()
            && $this->status_perpanjangan !== 'menunggu';
    }
}
