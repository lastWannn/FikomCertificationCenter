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
        $sertifikat->load([
            'pendaftaran.peserta',
            'pendaftaran.kegiatan.kegiatanPelatihan.jadwalPelatihan',
            'pendaftaran.kegiatan.kegiatanSertifikasi.jadwalSertifikasi'
        ]);
        $bgSrc = null;
        $gambarLatarPath = $sertifikat->gambar_latar ?? $sertifikat->pendaftaran->kegiatan?->nama_latar;
        if (empty($gambarLatarPath) || !file_exists(public_path('storage/' . $gambarLatarPath))) {
            // Check default uploaded background template
            if (file_exists(storage_path('app/public/latar-sertifikat/LfPQPcpLb5uKPx2YELbIUgQuIhxbnViaBBACTWv5.webp'))) {
                $gambarLatarPath = 'latar-sertifikat/LfPQPcpLb5uKPx2YELbIUgQuIhxbnViaBBACTWv5.webp';
            }
        }

        if (!empty($gambarLatarPath)) {
            $realPath = public_path('storage/' . $gambarLatarPath);
            if (!file_exists($realPath)) {
                $realPath = storage_path('app/public/' . $gambarLatarPath);
            }
            if (file_exists($realPath) && is_file($realPath)) {
                $type = pathinfo($realPath, PATHINFO_EXTENSION);
                $data = file_get_contents($realPath);
                $bgSrc = 'data:image/' . ($type === 'svg' ? 'svg+xml' : ($type === 'webp' ? 'webp' : $type)) . ';base64,' . base64_encode($data);
            }
        }

        $tglPelaksanaanFormat = $sertifikat->pendaftaran->kegiatan?->jadwal?->tgl_pelaksanaan 
            ? $sertifikat->pendaftaran->kegiatan->jadwal->tgl_pelaksanaan->translatedFormat('d F Y') 
            : 'September 12th, 2021';

        $tglTerbitFormat = $sertifikat->tgl_terbit 
            ? $sertifikat->tgl_terbit->translatedFormat('d F Y') 
            : 'September 12th, 2021';

        $layout = $sertifikat->pendaftaran->kegiatan?->layout_settings ?? [];
        $name = $layout['name'] ?? [];
        $name['font_family'] = $name['font_family'] ?? 'Allura';
        $layout['name'] = $name;

        $desc = $layout['desc'] ?? [];
        $desc['font_family'] = $desc['font_family'] ?? 'Poppins';
        $layout['desc'] = $desc;

        if (!file_exists(storage_path('fonts'))) {
            @mkdir(storage_path('fonts'), 0777, true);
        }

        if (class_exists(\Barryvdh\DomPDF\PDF::class)) {
            $safeNomor = str_replace(['/', '\\'], '-', $sertifikat->nomor_sertifikat);
            $pdf = app('dompdf.wrapper')
                ->setPaper('a4', 'landscape')
                ->setOption('isRemoteEnabled', true)
                ->setOption('isHtml5ParserEnabled', true);

            $pdf->loadView('admin.cetak.sertifikat-pdf', compact('sertifikat', 'bgSrc', 'tglPelaksanaanFormat', 'tglTerbitFormat', 'layout'));

            return $pdf->stream("sertifikat-{$safeNomor}.pdf");
        }
        // Fallback: tampilkan sebagai HTML untuk di-print
        return view('admin.cetak.sertifikat-pdf', compact('sertifikat', 'bgSrc', 'tglPelaksanaanFormat', 'tglTerbitFormat', 'layout'));
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
                ->setPaper('a4', 'portrait');
            return $pdf->stream("presensi-{$kegiatan->id}.pdf");
        }

        return view('admin.cetak.presensi-pdf', compact('kegiatan'));
    }

    /** Cetak Lembar Penilaian */
    public function lembarPenilaian(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['peserta', 'kegiatan.kegiatanPelatihan.jadwalPelatihan.pelatihan.materi', 'nilai']);
        
        return view('admin.cetak.penilaian-pdf', compact('pendaftaran'));
    }
}







