<?php
namespace App\Mail;

use App\Models\Pendaftaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Content, Envelope};
use Illuminate\Queue\SerializesModels;

class PendaftaranDiterima extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pendaftaran $pendaftaran) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Pendaftaran — ' . $this->pendaftaran->kegiatan->judul
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.pendaftaran-diterima');
    }
}
