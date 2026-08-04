<?php
namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Http\Requests\Peserta\{KonfirmasiPembayaranRequest, RequestPerpanjanganRequest};
use App\Models\{Pembayaran, Rekening};
use App\Services\Peserta\PembayaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * FIX KRITIS: Seluruh variabel PHP sebelumnya ditulis \\$ (double-backslash)
 * sehingga PHP menganggapnya sebagai literal string backslash + nama var,
 * bukan variabel PHP — menyebabkan ParseError di seluruh file.
 * Diperbaiki: \\$x → $x, \\\\RuntimeException → \RuntimeException
 */
class PembayaranController extends Controller
{
    public function __construct(private PembayaranService $service) {}

    /** Pastikan pembayaran milik peserta yang sedang login */
    private function authorizeOwnership(Pembayaran $pembayaran): void
    {
        if ($pembayaran->pendaftaran->peserta_id !== Auth::guard('peserta')->id()) {
            abort(403, 'Akses ditolak.');
        }
    }

    public function index()
    {
        Pembayaran::updateExpiredPayments();

        $pembayaran = Pembayaran::whereHas(
            'pendaftaran',
            fn($q) => $q->where('peserta_id', Auth::guard('peserta')->id())
        )
        ->with('pendaftaran.kegiatan')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('peserta.pembayaran', compact('pembayaran'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $this->authorizeOwnership($pembayaran);
        $pembayaran->load('pendaftaran.kegiatan', 'pendaftaran.biaya');
        $pembayaran->checkAndUpdateExpiry();
        $rekening = Rekening::aktif();
        return view('peserta.pembayaran-detail', compact('pembayaran', 'rekening'));
    }

    public function aktifkan(Request $r, Pembayaran $pembayaran)
    {
        $this->authorizeOwnership($pembayaran);
        $this->service->aktifkan($pembayaran);
        return redirect()->route('peserta.pembayaran.show', $pembayaran)
            ->with('success', 'Kode pembayaran berhasil diaktifkan! Segera transfer dalam 2 jam.');
    }

    public function requestPerpanjangan(RequestPerpanjanganRequest $request, Pembayaran $pembayaran)
    {
        $this->authorizeOwnership($pembayaran);
        try {
            $this->service->requestPerpanjangan($pembayaran, $request->alasan);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', 'Permintaan perpanjangan terkirim. Tunggu persetujuan Admin.');
    }

    public function konfirmasi(KonfirmasiPembayaranRequest $request, Pembayaran $pembayaran)
    {
        $this->authorizeOwnership($pembayaran);
        try {
            $this->service->konfirmasi($pembayaran, $request->validated(), $request->file('bukti_bayar'));
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('peserta.pembayaran')
            ->with('success', 'Foto bukti transfer terkirim. Menunggu verifikasi Admin.');
    }

    public function invoice(Pembayaran $pembayaran)
    {
        $this->authorizeOwnership($pembayaran);
        $pembayaran->load(['pendaftaran.peserta', 'pendaftaran.kegiatan', 'pendaftaran.biaya']);
        $rekening = Rekening::aktif();

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.invoice-pdf', compact('pembayaran', 'rekening'))
                ->setPaper('a5');
            return $pdf->download("invoice-{$pembayaran->kode_pembayaran}.pdf");
        }
        return view('admin.cetak.invoice-pdf', compact('pembayaran', 'rekening'));
    }
}
