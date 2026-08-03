<?php
namespace App\Services\Peserta;

use App\Models\{Kegiatan, Pendaftaran, Pembayaran, Peserta};
use App\Mail\PendaftaranDiterima;
use Illuminate\Support\Facades\{Mail, Log};
use Illuminate\Support\Str;

class PendaftaranService
{
    public function daftar(int $pesertaId, Kegiatan $kegiatan, ?int $biayaKegiatanId = null): Pendaftaran
    {
        if (Pendaftaran::where(['peserta_id' => $pesertaId, 'kegiatan_id' => $kegiatan->id])->exists()) {
            throw new \RuntimeException('Anda sudah mendaftarkan diri ke kegiatan ini.');
        }
        if ($kegiatan->isFull()) {
            throw new \RuntimeException('Maaf, kuota kegiatan sudah penuh.');
        }

        // Penentuan biaya otomatis jika tidak dikirim dari form / jika kegiatan berbayar
        if ($kegiatan->isBerbayar() && !$biayaKegiatanId) {
            $peserta = Peserta::find($pesertaId);
            $biayaKegiatanId = $this->tentukanBiayaOtomatis($peserta, $kegiatan);
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
                'status_pembayaran'=> 'menunggu_pembayaran',
            ]);
        }

        $pendaftaran->load(['peserta', 'kegiatan', 'biaya', 'pembayaran']);
        $this->kirimEmailKonfirmasi($pendaftaran);
        return $pendaftaran;
    }

    /**
     * Tentukan Biaya secara otomatis berdasarkan profil peserta
     */
    public function tentukanBiayaOtomatis(?Peserta $peserta, Kegiatan $kegiatan): ?int
    {
        $daftarBiaya = $kegiatan->biaya;
        if ($daftarBiaya->isEmpty()) {
            return null;
        }

        // 1. Cek apakah Mahasiswa UMI (email berakhiran @umi.ac.id atau instansi mengandung UMI)
        $isUmi = false;
        if ($peserta) {
            $email = strtolower($peserta->email ?? '');
            $instansi = strtolower($peserta->instansi ?? '');
            if (str_ends_with($email, '@umi.ac.id') || str_contains($instansi, 'umi') || str_contains($instansi, 'muslim indonesia')) {
                $isUmi = true;
            }
        }

        if ($isUmi) {
            // Cari opsi biaya Mahasiswa UMI / Internal
            $biayaUmi = $daftarBiaya->first(function ($b) {
                $nama = strtolower($b->nama_jenis ?? '');
                return str_contains($nama, 'mahasiswa') || str_contains($nama, 'umi') || str_contains($nama, 'internal');
            });
            if ($biayaUmi) {
                return $biayaUmi->id;
            }
        }

        // 2. Jika bukan UMI atau opsi UMI tidak ada, cari opsi biaya Umum / Eksternal
        $biayaUmum = $daftarBiaya->first(function ($b) {
            $nama = strtolower($b->nama_jenis ?? '');
            return str_contains($nama, 'umum') || str_contains($nama, 'eksternal') || str_contains($nama, 'reguler');
        });

        if ($biayaUmum) {
            return $biayaUmum->id;
        }

        // 3. Fallback: Ambil biaya opsi pertama yang tersedia
        return $daftarBiaya->first()?->id;
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
