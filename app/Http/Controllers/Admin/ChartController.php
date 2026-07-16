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
}
