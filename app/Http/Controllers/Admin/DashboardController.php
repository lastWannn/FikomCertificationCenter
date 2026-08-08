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

        $pelatihanDates = \App\Models\JadwalPelatihan::whereBetween('tgl_pelaksanaan', [$startOfMonth, $endOfMonth])
            ->get(['nama_kegiatan', 'tgl_pelaksanaan']);

        $sertifikasiDates = \App\Models\JadwalSertifikasi::whereBetween('tgl_pelaksanaan', [$startOfMonth, $endOfMonth])
            ->get(['nama_kegiatan', 'tgl_pelaksanaan']);

        $tanggalKegiatanMap = [];
        foreach ($pelatihanDates as $jp) {
            if ($jp->tgl_pelaksanaan) {
                $dayNum = (int) $jp->tgl_pelaksanaan->format('j');
                $tanggalKegiatanMap[$dayNum][] = $jp->nama_kegiatan ?: 'Pelatihan';
            }
        }
        foreach ($sertifikasiDates as $js) {
            if ($js->tgl_pelaksanaan) {
                $dayNum = (int) $js->tgl_pelaksanaan->format('j');
                $tanggalKegiatanMap[$dayNum][] = $js->nama_kegiatan ?: 'Sertifikasi';
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
