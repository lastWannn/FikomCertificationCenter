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
        return new Envelope(
            subject: '[FCC] Pembayaran Ditolak — Perlu Tindak Lanjut'
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.pembayaran-ditolak');
    }
}
