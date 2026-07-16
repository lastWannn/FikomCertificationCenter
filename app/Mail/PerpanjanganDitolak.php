<?php
namespace App\Mail;

use App\Models\Pembayaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Content, Envelope};
use Illuminate\Queue\SerializesModels;

class PerpanjanganDitolak extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Pembayaran $pembayaran,
        public ?string $catatan = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: '[FCC] Perpanjangan Waktu Bayar Ditolak');
    }
    public function content(): Content
    {
        return new Content(view: 'emails.perpanjangan-ditolak');
    }
}
