<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Pelatihan, Sertifikasi, Peserta, Kegiatan, Pembayaran};
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $r)
    {
        $stats = [
            'pelatihan'   => Pelatihan::count(),
            'sertifikasi' => Sertifikasi::count(),
            'peserta'     => Peserta::count(),
            'pendapatan'  => Pembayaran::where('status_pembayaran','terverifikasi')->sum('jumlah_bayar'),
        ];

        $kegiatanTerbaru = Kegiatan::upcoming()
            ->with([
                'kegiatanPelatihan.jadwalPelatihan.pelatihan',
                'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
                'pendaftaran',
                'biaya'
            ])
            ->latest()
            ->limit(5)
            ->get();

        $pembayaranMenunggu = Pembayaran::with(['pendaftaran.peserta','pendaftaran.kegiatan'])
            ->where('status_pembayaran','menunggu_verifikasi')
            ->latest()
            ->limit(5)
            ->get();

        // Month Navigation Support
        try {
            $calendarDate = $r->month ? Carbon::parse($r->month . '-01') : now();
        } catch (\Exception $e) {
            $calendarDate = now();
        }

        $prevMonth = $calendarDate->copy()->subMonth()->format('Y-m');
        $nextMonth = $calendarDate->copy()->addMonth()->format('Y-m');

        $startOfMonth = $calendarDate->copy()->startOfMonth();
        $endOfMonth   = $calendarDate->copy()->endOfMonth();

        $pelatihanDates = \App\Models\JadwalPelatihan::with(['pelatihan', 'kegiatanPelatihan.kegiatan'])
            ->whereBetween('tgl_pelaksanaan', [$startOfMonth, $endOfMonth])
            ->get();

        $sertifikasiDates = \App\Models\JadwalSertifikasi::with(['sertifikasi', 'kegiatanSertifikasi.kegiatan'])
            ->whereBetween('tgl_pelaksanaan', [$startOfMonth, $endOfMonth])
            ->get();

        $tanggalKegiatanMap = [];
        foreach ($pelatihanDates as $jp) {
            if ($jp->tgl_pelaksanaan) {
                $dayNum = (int) $jp->tgl_pelaksanaan->format('j');
                $nama = $jp->kegiatanPelatihan?->kegiatan?->judul ?? ($jp->nama_kegiatan ?: ($jp->pelatihan?->nama_pelatihan ?: 'Pelatihan'));
                $tanggalKegiatanMap[$dayNum][] = $nama;
            }
        }
        foreach ($sertifikasiDates as $js) {
            if ($js->tgl_pelaksanaan) {
                $dayNum = (int) $js->tgl_pelaksanaan->format('j');
                $nama = $js->kegiatanSertifikasi?->kegiatan?->judul ?? ($js->nama_kegiatan ?: ($js->sertifikasi?->nama_sertifikasi ?: 'Sertifikasi'));
                $tanggalKegiatanMap[$dayNum][] = $nama;
            }
        }

        return view('admin.dashboard', compact(
            'stats',
            'kegiatanTerbaru',
            'pembayaranMenunggu',
            'tanggalKegiatanMap',
            'calendarDate',
            'prevMonth',
            'nextMonth'
        ));
    }
}
