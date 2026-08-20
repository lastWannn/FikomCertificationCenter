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
        $bgSrc = null;
        if (!empty($sertifikat->gambar_latar)) {
            $realPath = public_path('storage/' . $sertifikat->gambar_latar);
            if (!file_exists($realPath)) {
                $realPath = storage_path('app/public/' . $sertifikat->gambar_latar);
            }
            if (file_exists($realPath) && is_file($realPath)) {
                $type = pathinfo($realPath, PATHINFO_EXTENSION);
                $data = file_get_contents($realPath);
                $bgSrc = 'data:image/' . ($type === 'svg' ? 'svg+xml' : $type) . ';base64,' . base64_encode($data);
            }
        }

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $safeNomor = str_replace(['/', '\\'], '-', $sertifikat->nomor_sertifikat);
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak.sertifikat-pdf', compact('sertifikat', 'bgSrc'))
                ->setPaper('a4','landscape');

            return $pdf->stream("sertifikat-{$safeNomor}.pdf");
        }
        // Fallback: tampilkan sebagai HTML untuk di-print
        return view('admin.cetak.sertifikat-pdf', compact('sertifikat', 'bgSrc'));
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
        $pembayaran->load(['pendaftaran.peserta','pendaftaran.kegiatan','pendaftaran.biaya']);

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

        return view('admin.cetak.presensi-pdf', compact('kegiatan'));
    }

    /** Cetak Lembar Penilaian */
    public function lembarPenilaian(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['peserta', 'kegiatan.kegiatanPelatihan.jadwalPelatihan.pelatihan.materi', 'nilai']);
        
        return view('admin.cetak.penilaian-pdf', compact('pendaftaran'));
    }
}
