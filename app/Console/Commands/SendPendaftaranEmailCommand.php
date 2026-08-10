<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pendaftaran;
use App\Mail\PendaftaranDiterima;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendPendaftaranEmailCommand extends Command
{
    /**
     * Nama dan signature command CLI
     *
     * @var string
     */
    protected $signature = 'email:pendaftaran {id}';

    /**
     * Deskripsi command
     *
     * @var string
     */
    protected $description = 'Kirim email konfirmasi pendaftaran & PDF invoice secara asynchronous di background';

    /**
     * Eksekusi command
     */
    public function handle()
    {
        $id = $this->argument('id');
        $pendaftaran = Pendaftaran::with(['peserta', 'kegiatan', 'biaya', 'pembayaran'])->find($id);

        if (!$pendaftaran || !$pendaftaran->peserta) {
            $this->error("Pendaftaran #{$id} tidak ditemukan.");
            return 1;
        }

        try {
            Mail::to($pendaftaran->peserta->email)->send(new PendaftaranDiterima($pendaftaran));
            $this->info("Email pendaftaran #{$id} berhasil dikirim ke {$pendaftaran->peserta->email}");
        } catch (\Throwable $e) {
            Log::warning("Gagal mengirim email pendaftaran #{$id}: " . $e->getMessage());
            $this->error("Error sending email: " . $e->getMessage());
        }

        return 0;
    }
}
