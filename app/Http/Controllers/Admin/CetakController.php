<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Sertifikat, Pembayaran, Kegiatan, Pendaftaran};
use Illuminate\Http\Request;

class CetakController extends Controller
{
    /** Sertifikat PDF per peserta (Dicoding-style Static Storage Serving) */
    public function sertifikat(Sertifikat $sertifikat)
    {
        $safeNomor = str_replace(['/', '\\'], '-', $sertifikat->nomor_sertifikat);
        $kegiatan = $sertifikat->pendaftaran?->kegiatan;
        $kegiatanUpdated = $kegiatan ? $kegiatan->updated_at?->timestamp : 0;
        $forceFresh = request()->has('fresh') || request()->has('regenerate');

        // 1. Check if pre-rendered PDF already exists in static storage and is not stale
        if (!empty($sertifikat->file_sertifikat) && !$forceFresh) {
            $filePath = storage_path('app/public/' . $sertifikat->file_sertifikat);
            if (!file_exists($filePath)) {
                $filePath = public_path('storage/' . $sertifikat->file_sertifikat);
            }
            if (file_exists($filePath) && is_file($filePath)) {
                $fileMtime = filemtime($filePath);
                if ($kegiatanUpdated && $fileMtime < $kegiatanUpdated) {
                    @unlink($filePath);
                    $sertifikat->update(['file_sertifikat' => null]);
                } else {
                    return response()->file($filePath, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="sertifikat-' . $safeNomor . '.pdf"',
                        'Cache-Control' => 'no-cache, no-store, must-revalidate',
                        'Pragma' => 'no-cache',
                        'Expires' => '0',
                    ]);
                }
            }
        }

        // 2. If not pre-rendered yet, generate, save to static storage, and serve
        $service = app(\App\Services\Admin\SertifikatService::class);
        $service->regeneratePdf($sertifikat);

        $sertifikat->refresh();
        if (!empty($sertifikat->file_sertifikat)) {
            $filePath = storage_path('app/public/' . $sertifikat->file_sertifikat);
            if (file_exists($filePath) && is_file($filePath)) {
                return response()->file($filePath, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="sertifikat-' . $safeNomor . '.pdf"',
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0',
                ]);
            }
        }

        // Fallback: render view data
        $viewData = $service->buildPdfViewData($sertifikat);
        if (class_exists(\Barryvdh\DomPDF\PDF::class)) {
            $pdf = app('dompdf.wrapper')
                ->setPaper('a4', 'landscape')
                ->setOption('isRemoteEnabled', false)
                ->setOption('isHtml5ParserEnabled', true);

            $pdf->loadView('admin.cetak.sertifikat-pdf', $viewData);
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="sertifikat-' . $safeNomor . '.pdf"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        }
        return view('admin.cetak.sertifikat-pdf', $viewData);
    }
    /** Invoice PDF — tagihan sebelum bayar */
    public function invoice(Pembayaran $pembayaran)
    {
        $pembayaran->load(['pendaftaran.peserta','pendaftaran.kegiatan','pendaftaran.biaya']);
        $rekening = \App\Models\Rekening::where('is_active',true)->first();

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $safeKode = str_replace(['/', '\\'], '-', $pembayaran->kode_pembayaran);
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.invoice-pdf', compact('pembayaran','rekening'))
                ->setPaper('a4');
            return $pdf->stream("invoice-{$safeKode}.pdf");
        }
        return view('admin.cetak.invoice-pdf', compact('pembayaran','rekening'));
    }

    /** Bukti Pembayaran PDF — setelah terverifikasi */
    public function buktiPembayaran(Pembayaran $pembayaran)
    {
        if ($pembayaran->status_pembayaran !== 'terverifikasi') {
            return back()->with('error', 'Bukti hanya bisa dicetak setelah pembayaran terverifikasi.');
        }
        if (empty($pembayaran->no_kwitansi)) {
            $pembayaran->update(['no_kwitansi' => Pembayaran::generateNoKwitansi()]);
        }

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $safeKode = str_replace(['/', '\\'], '-', $pembayaran->kode_pembayaran);
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.bukti-pdf', compact('pembayaran'))
                ->setPaper('a5');
            return $pdf->stream("bukti-{$safeKode}.pdf");
        }
        return view('admin.cetak.bukti-pdf', compact('pembayaran'));
    }

    /** Daftar Presensi PDF / Print View */
    public function presensi(Kegiatan $kegiatan)
    {
        $kegiatan->load([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            'pendaftaran.peserta',
            'pendaftaran.pembayaran'
        ]);

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.presensi-pdf', compact('kegiatan'))
                ->setPaper('a4', 'landscape');
            return $pdf->stream("presensi-{$kegiatan->id}.pdf");
        }

        return view('admin.cetak.presensi-pdf', compact('kegiatan'));
    }
}







