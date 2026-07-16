<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Sertifikat, Pembayaran, Kegiatan, Pendaftaran};
use Illuminate\Http\Request;

class CetakController extends Controller
{
    /** Sertifikat PDF per peserta */
    public function sertifikat(Sertifikat $sertifikat)
    {
        $sertifikat->load(['pendaftaran.peserta','pendaftaran.kegiatan']);

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.sertifikat-pdf', compact('sertifikat'))
                ->setPaper('a4','landscape');
            return $pdf->download("sertifikat-{$sertifikat->nomor_sertifikat}.pdf");
        }
        // Fallback: tampilkan sebagai HTML untuk di-print
        return view('admin.cetak.sertifikat-pdf', compact('sertifikat'));
    }

    /** Invoice PDF — tagihan sebelum bayar */
    public function invoice(Pembayaran $pembayaran)
    {
        $pembayaran->load(['pendaftaran.peserta','pendaftaran.kegiatan','pendaftaran.biaya']);
        $rekening = \App\Models\Rekening::where('is_active',true)->first();

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.invoice-pdf', compact('pembayaran','rekening'))
                ->setPaper('a5');
            return $pdf->download("invoice-{$pembayaran->kode_pembayaran}.pdf");
        }
        return view('admin.cetak.invoice-pdf', compact('pembayaran','rekening'));
    }

    /** Bukti Pembayaran PDF — setelah terverifikasi */
    public function buktiPembayaran(Pembayaran $pembayaran)
    {
        if ($pembayaran->status_pembayaran !== 'terverifikasi') {
            return back()->with('error', 'Bukti hanya bisa dicetak setelah pembayaran terverifikasi.');
        }
        $pembayaran->load(['pendaftaran.peserta','pendaftaran.kegiatan','pendaftaran.biaya']);

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.bukti-pdf', compact('pembayaran'))
                ->setPaper('a5');
            return $pdf->download("bukti-{$pembayaran->kode_pembayaran}.pdf");
        }
        return view('admin.cetak.bukti-pdf', compact('pembayaran'));
    }

    /** Daftar Presensi PDF */
    public function presensi(Kegiatan $kegiatan)
    {
        $kegiatan->load(['pendaftaran.peserta','pendaftaran.pembayaran']);

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.presensi-pdf', compact('kegiatan'))
                ->setPaper('a4');
            return $pdf->download("presensi-{$kegiatan->id}.pdf");
        }
        return view('admin.cetak.presensi-pdf', compact('kegiatan'));
    }
}
