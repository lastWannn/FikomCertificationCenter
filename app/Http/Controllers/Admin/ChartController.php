<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Pembayaran, Pendaftaran, Kegiatan, Peserta};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    /** Pendapatan per bulan — 12 bulan terakhir */
    public function pendapatan(Request $r)
    {
        $tahun = $r->tahun ?? date('Y');
        $data  = [];
        $labels= [];

        for ($m = 1; $m <= 12; $m++) {
            $labels[] = date('M', mktime(0,0,0,$m,1));
            $data[]   = (float) Pembayaran::where('status_pembayaran','terverifikasi')
                ->whereYear('created_at',  $tahun)
                ->whereMonth('created_at', $m)
                ->sum('jumlah_bayar');
        }

        return response()->json([
            'labels'   => $labels,
            'datasets' => [[
                'label'           => 'Pendapatan (Rp)',
                'data'            => $data,
                'backgroundColor' => 'rgba(255,200,26,0.15)',
                'borderColor'     => '#FFC81A',
                'borderWidth'     => 2.5,
                'fill'            => true,
                'tension'         => 0.4,
                'pointBackgroundColor' => '#131218',
                'pointBorderColor'     => '#FFC81A',
                'pointRadius'          => 5,
            ]],
        ]);
    }

    /** Pendaftaran per bulan */
    public function pendaftaran(Request $r)
    {
        $tahun = $r->tahun ?? date('Y');
        $data  = [];
        $labels= [];

        for ($m = 1; $m <= 12; $m++) {
            $labels[] = date('M', mktime(0,0,0,$m,1));
            $data[]   = Pendaftaran::whereYear('created_at',$tahun)
                ->whereMonth('created_at',$m)
                ->count();
        }

        return response()->json([
            'labels'   => $labels,
            'datasets' => [[
                'label'           => 'Pendaftaran',
                'data'            => $data,
                'backgroundColor' => '#131218',
                'borderRadius'    => 6,
            ]],
        ]);
    }

    /** Distribusi kegiatan pelatihan vs sertifikasi */
    public function kegiatan()
    {
        $pel  = Kegiatan::where('jenis_kegiatan','pelatihan')->count();
        $sert = Kegiatan::where('jenis_kegiatan','sertifikasi')->count();

        return response()->json([
            'labels'   => ['Pelatihan','Sertifikasi'],
            'datasets' => [[
                'data'            => [$pel, $sert],
                'backgroundColor' => ['#FFC81A','#131218'],
                'borderWidth'     => 0,
                'hoverOffset'     => 8,
            ]],
        ]);
    }

    /** Stats summary untuk dashboard cards */
    public function stats()
    {
        return response()->json([
            'peserta_baru_bulan_ini'   => Peserta::whereMonth('created_at', date('m'))->count(),
            'pendaftaran_minggu_ini'   => Pendaftaran::whereBetween('created_at',[now()->startOfWeek(),now()->endOfWeek()])->count(),
            'pendapatan_bulan_ini'     => Pembayaran::where('status_pembayaran','terverifikasi')->whereMonth('created_at',date('m'))->sum('jumlah_bayar'),
            'menunggu_verifikasi'      => Pembayaran::where('status_pembayaran','menunggu_verifikasi')->count(),
        ]);
    }

    /** Status Pendaftar & Transaksi */
    public function statusPendaftar()
    {
        $terverifikasi = Pembayaran::where('status_pembayaran', 'terverifikasi')->count();
        $menunggu     = Pembayaran::whereIn('status_pembayaran', ['menunggu_verifikasi', 'menunggu_pembayaran'])->count();
        $ditolak      = Pembayaran::where('status_pembayaran', 'ditolak')->count();
        $kadaluarsa   = Pembayaran::where('status_pembayaran', 'kadaluarsa')->count();

        return response()->json([
            'labels'   => ['Terverifikasi', 'Menunggu', 'Ditolak', 'Kadaluarsa'],
            'datasets' => [[
                'data'            => [$terverifikasi, $menunggu, $ditolak, $kadaluarsa],
                'backgroundColor' => ['#10B981', '#F59E0B', '#EF4444', '#94A3B8'],
                'borderWidth'     => 0,
                'hoverOffset'     => 6,
            ]],
        ]);
    }

    /** AJAX Calendar Data for dynamic month switching */
    public function calendarData(Request $r)
    {
        try {
            $calendarDate = $r->month ? \Carbon\Carbon::parse($r->month . '-01') : now();
        } catch (\Exception $e) {
            $calendarDate = now();
        }

        $today = now();
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

        return response()->json([
            'month_label'           => $calendarDate->translatedFormat('F Y'),
            'month_key'             => $calendarDate->format('Y-m'),
            'prev_month'            => $prevMonth,
            'next_month'            => $nextMonth,
            'days_in_month'         => $calendarDate->daysInMonth,
            'start_day_of_week'     => $startOfMonth->dayOfWeek,
            'is_current_real_month' => $calendarDate->format('Y-m') === $today->format('Y-m'),
            'today_day'             => $today->day,
            'kegiatan_map'          => $tanggalKegiatanMap,
        ]);
    }
}
