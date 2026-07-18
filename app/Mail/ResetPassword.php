<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Content, Envelope};
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nama,
        public string $passwordBaru
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: '[FCC] Reset Password Akun Anda');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.reset-password');
    }
}
