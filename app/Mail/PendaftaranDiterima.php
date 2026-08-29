<?php
namespace App\Mail;

use App\Models\{Pendaftaran, Rekening};
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Content, Envelope, Attachment};
use Illuminate\Queue\SerializesModels;

class PendaftaranDiterima extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pendaftaran $pendaftaran) {}

    public function envelope(): Envelope
    {
        $subjectPrefix = $this->pendaftaran->pembayaran ? 'Tagihan & Invoice Pendaftaran — ' : 'Konfirmasi Pendaftaran — ';
        return new Envelope(
            subject: $subjectPrefix . $this->pendaftaran->kegiatan->judul
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.pendaftaran-diterima');
    }

    public function attachments(): array
    {
        $attachments = [];

        if ($this->pendaftaran->pembayaran && class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pembayaran = $this->pendaftaran->pembayaran;
            $pembayaran->loadMissing(['pendaftaran.peserta', 'pendaftaran.kegiatan', 'pendaftaran.biaya']);
            $rekening = Rekening::where('is_active', true)->first();

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.invoice-pdf', compact('pembayaran', 'rekening'))
                ->setPaper('a4');

            $attachments[] = Attachment::fromData(
                fn () => $pdf->output(),
                "Invoice-{$pembayaran->kode_pembayaran}.pdf"
            )->withMime('application/pdf');
        }

        return $attachments;
    }
}
