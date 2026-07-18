<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Pelatihan, Sertifikasi, Peserta, Kegiatan, Pembayaran};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pelatihan'   => Pelatihan::count(),
            'sertifikasi' => Sertifikasi::count(),
            'peserta'     => Peserta::count(),
            'pendapatan'  => Pembayaran::where('status_pembayaran','terverifikasi')->sum('jumlah_bayar'),
        ];

        $kegiatanTerbaru = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            'pendaftaran',
        ])->orderBy('created_at','desc')->limit(5)->get();

        $pembayaranMenunggu = Pembayaran::with(['pendaftaran.peserta','pendaftaran.kegiatan'])
            ->where('status_pembayaran','menunggu_verifikasi')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats','kegiatanTerbaru','pembayaranMenunggu'));
    }
}
