<?php
namespace App\Services\Admin;

use App\Models\Pembayaran;
use App\Helpers\AsyncMail;

class PembayaranService
{
    /* ── Verifikasi & Tolak ────────────────────────────────── */
    public function verifikasi(Pembayaran $pembayaran, ?string $noKwitansi = null): void
    {
        $pembayaran->verifikasi($noKwitansi);
        AsyncMail::dispatch('verifikasi_bayar', $pembayaran->id);
    }

    public function tolak(Pembayaran $pembayaran, ?string $alasan = null): void
    {
        $pembayaran->tolak();
        AsyncMail::dispatch('tolak_bayar', $pembayaran->id, $alasan);
    }

    public function perpanjang(Pembayaran $pembayaran): void
    {
        $pembayaran->perpanjang();
    }

    /* ── Perpanjangan waktu ────────────────────────────────── */
    public function approvePerpanjangan(Pembayaran $pembayaran, int $jamTambah, ?string $catatan = null): void
    {
        $pembayaran->update([
            'tgl_kadaluarsa'      => now()->addHours($jamTambah),
            'status_pembayaran'   => 'menunggu_pembayaran',
            'status_perpanjangan' => 'disetujui',
            'catatan_perpanjangan'=> $catatan,
        ]);

        AsyncMail::dispatch('approve_perpanjangan', $pembayaran->id);
    }

    public function tolakPerpanjangan(Pembayaran $pembayaran, ?string $catatan = null): void
    {
        $pembayaran->tolakPerpanjangan($catatan);
        AsyncMail::dispatch('tolak_perpanjangan', $pembayaran->id, $catatan);
    }
}
