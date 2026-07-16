<?php
namespace App\Mail;

use App\Models\Pembayaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Content, Envelope};
use Illuminate\Queue\SerializesModels;

class PembayaranDikonfirmasi extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pembayaran $pembayaran) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembayaran Terverifikasi — ' . $this->pembayaran->pendaftaran->kegiatan->judul
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.pembayaran-dikonfirmasi');
    }
}
