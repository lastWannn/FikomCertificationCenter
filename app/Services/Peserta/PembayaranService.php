<?php
namespace App\Services\Peserta;

use App\Models\Pembayaran;
use Illuminate\Http\UploadedFile;

class PembayaranService
{
    public function aktifkan(Pembayaran $pembayaran): void
    {
        // Reset status perpanjangan saat diaktifkan manual (kode baru)
        $pembayaran->update([
            'tgl_kadaluarsa'      => now()->addHours(2),
            'status_pembayaran'   => 'menunggu_pembayaran',
            'status_perpanjangan' => null,
        ]);
    }

    public function requestPerpanjangan(Pembayaran $pembayaran, ?string $alasan = null): void
    {
        if (!$pembayaran->bisaRequestPerpanjangan()) {
            throw new \RuntimeException('Permintaan perpanjangan tidak dapat diajukan saat ini.');
        }
        $pembayaran->requestPerpanjangan($alasan);
    }

    /**
     * Upload bukti pembayaran — hanya gambar yang diterima.
     * Peserta hanya bisa upload saat timer masih aktif.
     */
    public function konfirmasi(Pembayaran $pembayaran, array $data, UploadedFile $file): void
    {
        if (!$pembayaran->bisaUploadBukti()) {
            throw new \RuntimeException('Upload tidak bisa dilakukan. Pastikan waktu pembayaran masih aktif dan tidak sedang menunggu persetujuan perpanjangan.');
        }

        $path = $file->store('bukti-bayar', 'public');

        $pembayaran->update([
            'metode_pembayaran' => $data['metode_pembayaran'],
            'nama_pengirim'     => $data['nama_pengirim'],
            'tgl_transfer'      => $data['tgl_transfer'],
            'jam_transfer'      => $data['jam_transfer'],
            'bukti_bayar'       => $path,
            'status_pembayaran' => 'menunggu_verifikasi',
        ]);
        $pembayaran->pendaftaran->update(['status_pendaftaran' => 'menunggu_verifikasi']);
    }
}
