<?php
namespace App\Services\Admin;

use App\Models\Pembayaran;
use App\Mail\{PembayaranDikonfirmasi, PembayaranDitolak, PerpanjanganDisetujui, PerpanjanganDitolak};
use Illuminate\Support\Facades\{Mail, Log};

class PembayaranService
{
    /* ── Verifikasi & Tolak ────────────────────────────────── */
    public function verifikasi(Pembayaran $pembayaran, ?string $noKwitansi = null): void
    {
        $pembayaran->verifikasi($noKwitansi);
        dispatch(function () use ($pembayaran) {
            try {
                Mail::to($pembayaran->pendaftaran->peserta->email)
                    ->send(new PembayaranDikonfirmasi($pembayaran));
            } catch (\Exception $e) {
                Log::warning('Email verifikasi gagal: ' . $e->getMessage());
            }
        })->afterResponse();
    }

    public function tolak(Pembayaran $pembayaran, ?string $alasan = null): void
    {
        $pembayaran->tolak();
        dispatch(function () use ($pembayaran, $alasan) {
            try {
                Mail::to($pembayaran->pendaftaran->peserta->email)
                    ->send(new PembayaranDitolak($pembayaran, $alasan));
            } catch (\Exception $e) {
                Log::warning('Email tolak gagal: ' . $e->getMessage());
            }
        })->afterResponse();
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

        try {
            Mail::to($pembayaran->pendaftaran->peserta->email)
                ->send(new PerpanjanganDisetujui($pembayaran));
        } catch (\Exception $e) {
            Log::warning('Email perpanjangan disetujui gagal: ' . $e->getMessage());
        }
    }

    public function tolakPerpanjangan(Pembayaran $pembayaran, ?string $catatan = null): void
    {
        $pembayaran->tolakPerpanjangan($catatan);

        try {
            Mail::to($pembayaran->pendaftaran->peserta->email)
                ->send(new PerpanjanganDitolak($pembayaran, $catatan));
        } catch (\Exception $e) {
            Log::warning('Email perpanjangan ditolak gagal: ' . $e->getMessage());
        }
    }
}
