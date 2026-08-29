<?php
namespace App\Mail;

use App\Models\Pembayaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Content, Envelope};
use Illuminate\Queue\SerializesModels;

class PembayaranDitolak extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pembayaran $pembayaran, public ?string $alasan = null) {}

    public function envelope(): Envelope
    {
        $judul = $this->pembayaran->pendaftaran?->kegiatan?->judul ?? 'Kegiatan';
        return new Envelope(
            subject: '[FIKOM FCC] Pembayaran Ditolak — ' . $judul
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.pembayaran-ditolak');
    }
}
