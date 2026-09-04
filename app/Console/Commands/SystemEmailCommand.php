<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Pendaftaran, Pembayaran, PesanMasuk, Peserta};
use App\Mail\{
    OtpMail,
    PendaftaranDiterima,
    PembayaranDikonfirmasi,
    PembayaranDitolak,
    PerpanjanganDisetujui,
    PerpanjanganDitolak,
    ResetPassword
};
use Illuminate\Support\Facades\{Mail, Log};

class SystemEmailCommand extends Command
{
    /**
     * Signature CLI command
     *
     * @var string
     */
    protected $signature = 'email:send {type} {id} {extra?}';

    /**
     * Deskripsi command
     *
     * @var string
     */
    protected $description = 'Kirim email sistem secara asynchronous di background process';

    /**
     * Eksekusi command
     */
    public function handle()
    {
        $type  = $this->argument('type');
        $id    = $this->argument('id');
        $extra = $this->argument('extra');

        try {
            switch ($type) {
                case 'pendaftaran':
                    $pendaftaran = Pendaftaran::with(['peserta', 'kegiatan', 'biaya', 'pembayaran'])->find($id);
                    if ($pendaftaran && $pendaftaran->peserta) {
                        Mail::to($pendaftaran->peserta->email)->send(new PendaftaranDiterima($pendaftaran));
                    }
                    break;

                case 'otp':
                    $parts = explode('|', $extra ?? '');
                    $otp   = $parts[0] ?? '';
                    $tType = $parts[1] ?? 'register';
                    if ($id && $otp) {
                        Mail::to($id)->send(new OtpMail($otp, $tType));
                    }
                    break;

                case 'kontak':
                    $pesan = PesanMasuk::find($id);
                    if ($pesan) {
                        $tujuanEmail = env('MAIL_USERNAME') ?: (env('MAIL_FROM_ADDRESS') ?: 'fikom.iclabs@umi.ac.id');
                        if ($tujuanEmail) {
                            Mail::raw(
                                "PESAN MASUK BARU DARI HUBUNGI KAMI\n" .
                                "==================================\n\n" .
                                "Nama Pengirim : {$pesan->nama}\n" .
                                "Email Pengirim: {$pesan->email}\n" .
                                "Waktu Pengiriman: " . $pesan->created_at->format('d M Y, H:i') . " WITA\n\n" .
                                "ISIAN PESAN / PERTANYAAN:\n" .
                                "--------------------------\n" .
                                "{$pesan->pesan}\n\n" .
                                "==================================\n" .
                                "Pesan ini juga telah otomatis tersimpan di Panel Admin (Menu: KONTEN -> Pesan Masuk).",
                                function ($message) use ($tujuanEmail, $pesan) {
                                    $message->to($tujuanEmail)
                                            ->subject('📩 [FIKOM FCC] Pesan Baru dari: ' . $pesan->nama)
                                            ->replyTo($pesan->email, $pesan->nama);
                                }
                            );
                        }
                    }
                    break;

                case 'verifikasi_bayar':
                    $pembayaran = Pembayaran::with(['pendaftaran.peserta', 'pendaftaran.kegiatan'])->find($id);
                    if ($pembayaran && $pembayaran->pendaftaran?->peserta) {
                        Mail::to($pembayaran->pendaftaran->peserta->email)
                            ->send(new PembayaranDikonfirmasi($pembayaran));
                    }
                    break;

                case 'tolak_bayar':
                    $pembayaran = Pembayaran::with(['pendaftaran.peserta', 'pendaftaran.kegiatan'])->find($id);
                    if ($pembayaran && $pembayaran->pendaftaran?->peserta) {
                        Mail::to($pembayaran->pendaftaran->peserta->email)
                            ->send(new PembayaranDitolak($pembayaran, $extra));
                    }
                    break;

                case 'approve_perpanjangan':
                    $pembayaran = Pembayaran::with(['pendaftaran.peserta', 'pendaftaran.kegiatan'])->find($id);
                    if ($pembayaran && $pembayaran->pendaftaran?->peserta) {
                        Mail::to($pembayaran->pendaftaran->peserta->email)
                            ->send(new PerpanjanganDisetujui($pembayaran));
                    }
                    break;

                case 'tolak_perpanjangan':
                    $pembayaran = Pembayaran::with(['pendaftaran.peserta', 'pendaftaran.kegiatan'])->find($id);
                    if ($pembayaran && $pembayaran->pendaftaran?->peserta) {
                        Mail::to($pembayaran->pendaftaran->peserta->email)
                            ->send(new PerpanjanganDitolak($pembayaran, $extra));
                    }
                    break;

                case 'reset_pass':
                    $peserta = Peserta::find($id);
                    if ($peserta && $extra) {
                        Mail::to($peserta->email)->send(new ResetPassword($peserta->nama, $extra));
                    }
                    break;
            }
        } catch (\Throwable $e) {
            Log::warning("SystemEmailCommand error [{$type}]: " . $e->getMessage());
        }

        return 0;
    }
}
