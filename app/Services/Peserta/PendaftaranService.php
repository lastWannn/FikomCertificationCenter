<?php
namespace App\Services\Peserta;

use App\Models\{Kegiatan, Pendaftaran, Pembayaran};
use App\Mail\PendaftaranDiterima;
use Illuminate\Support\Facades\{Mail, Log};
use Illuminate\Support\Str;

class PendaftaranService
{
    public function daftar(int $pesertaId, Kegiatan $kegiatan, ?int $biayaKegiatanId): Pendaftaran
    {
        if (Pendaftaran::where(['peserta_id' => $pesertaId, 'kegiatan_id' => $kegiatan->id])->exists()) {
            throw new \RuntimeException('Anda sudah mendaftarkan diri ke kegiatan ini.');
        }
        if ($kegiatan->isFull()) {
            throw new \RuntimeException('Maaf, kuota kegiatan sudah penuh.');
        }

        $pendaftaran = Pendaftaran::create([
            'peserta_id'         => $pesertaId,
            'kegiatan_id'        => $kegiatan->id,
            'biaya_kegiatan_id'  => $biayaKegiatanId,
            'tgl_daftar'         => now(),
            'status_pendaftaran' => $biayaKegiatanId ? 'menunggu_pembayaran' : 'terdaftar',
            'qr_token'           => Str::random(32),
        ]);

        if ($biayaKegiatanId) {
            $biaya     = $kegiatan->biaya->find($biayaKegiatanId);
            // Generate kode unik 3 digit berdasarkan jenis kegiatan
            $kodeUnik  = Pembayaran::generateKodeUnik($kegiatan->jenis_kegiatan);

            Pembayaran::create([
                'pendaftaran_id'   => $pendaftaran->id,
                'kode_pembayaran'  => Pembayaran::generateKode(),
                'kode_unik'        => $kodeUnik,   // ← kode 3 digit
                'tgl_kadaluarsa'   => now()->addHours(2),
                'jumlah_bayar'     => $biaya->nominal,
                // nominal_transfer = jumlah_bayar + kode_unik (accessor di model)
                'status_pembayaran'=> 'menunggu_pembayaran',
            ]);
        }

        $this->kirimEmailKonfirmasi($pendaftaran);
        return $pendaftaran;
    }

    private function kirimEmailKonfirmasi(Pendaftaran $pendaftaran): void
    {
        try {
            Mail::to($pendaftaran->peserta->email)->send(new PendaftaranDiterima($pendaftaran));
        } catch (\Exception $e) {
            Log::warning('Email pendaftaran gagal: ' . $e->getMessage());
        }
    }
}
