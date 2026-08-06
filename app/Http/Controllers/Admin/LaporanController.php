<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Pendaftaran, Pembayaran, Kegiatan, Peserta};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $r)
    {
        $tahun         = $r->tahun ?? date('Y');
        $bulan         = $r->bulan;
        $jenisKegiatan = $r->jenis_kegiatan;

        // Query Dasar Pembayaran Terverifikasi per Tahun & Filter
        $queryPembayaran = Pembayaran::with(['pendaftaran.kegiatan'])
            ->where('status_pembayaran', 'terverifikasi')
            ->whereYear('created_at', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->when($jenisKegiatan, function($q) use ($jenisKegiatan) {
                $q->whereHas('pendaftaran.kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan));
            });

        // Summary Data
        $totalPeserta      = Peserta::count();
        $totalPendaftaran  = Pendaftaran::whereYear('created_at', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->when($jenisKegiatan, fn($q) => $q->whereHas('kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan)))
            ->count();
            
        $totalTerverifikasi= (clone $queryPembayaran)->count();
        $totalPendapatan   = (clone $queryPembayaran)->sum('jumlah_bayar');
        $rateVerifikasi    = $totalPendaftaran > 0 ? round(($totalTerverifikasi / $totalPendaftaran) * 100, 1) : 0;
        $avgTransaksi      = $totalTerverifikasi > 0 ? round($totalPendapatan / $totalTerverifikasi) : 0;

        $summary = [
            'total_peserta'       => $totalPeserta,
            'total_pendaftaran'   => $totalPendaftaran,
            'total_terverifikasi' => $totalTerverifikasi,
            'total_pendapatan'    => $totalPendapatan,
            'rate_verifikasi'     => $rateVerifikasi,
            'avg_transaksi'       => $avgTransaksi,
        ];

        // 1. Data Grafik Monthly Pendapatan & Pendaftaran (12 Bulan)
        $pendapatanBulanan = array_fill(1, 12, 0);
        $pendaftaranBulanan = array_fill(1, 12, 0);

        $rawPendapatan = Pembayaran::selectRaw('MONTH(created_at) as bulan, SUM(jumlah_bayar) as total')
            ->where('status_pembayaran', 'terverifikasi')
            ->whereYear('created_at', $tahun)
            ->when($jenisKegiatan, function($q) use ($jenisKegiatan) {
                $q->whereHas('pendaftaran.kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan));
            })
            ->groupBy('bulan')
            ->get();

        foreach ($rawPendapatan as $item) {
            $pendapatanBulanan[$item->bulan] = (int) $item->total;
        }

        $rawPendaftaran = Pendaftaran::selectRaw('MONTH(created_at) as bulan, COUNT(id) as total')
            ->whereYear('created_at', $tahun)
            ->when($jenisKegiatan, fn($q) => $q->whereHas('kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan)))
            ->groupBy('bulan')
            ->get();

        foreach ($rawPendaftaran as $item) {
            $pendaftaranBulanan[$item->bulan] = (int) $item->total;
        }

        // 2. Data Grafik Distribution Status Pembayaran
        $statusPembayaranCounts = Pembayaran::selectRaw('status_pembayaran, COUNT(id) as total')
            ->whereYear('created_at', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->groupBy('status_pembayaran')
            ->pluck('total', 'status_pembayaran')
            ->toArray();

        // 3. Data Perbandingan Pelatihan vs Sertifikasi
        $jenisCounts = Kegiatan::join('pendaftaran', 'kegiatan.id', '=', 'pendaftaran.kegiatan_id')
            ->whereYear('pendaftaran.created_at', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('pendaftaran.created_at', $bulan))
            ->selectRaw('kegiatan.jenis_kegiatan, COUNT(pendaftaran.id) as total')
            ->groupBy('kegiatan.jenis_kegiatan')
            ->pluck('total', 'jenis_kegiatan')
            ->toArray();

        // 4. Top Kegiatan Terfavorit (10 Kegiatan)
        $perKegiatan = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
        ])
        ->withCount(['pendaftaran' => function($q) use ($tahun, $bulan) {
            $q->whereYear('created_at', $tahun)
              ->when($bulan, fn($b) => $b->whereMonth('created_at', $bulan));
        }])
        ->when($jenisKegiatan, fn($q) => $q->where('jenis_kegiatan', $jenisKegiatan))
        ->orderByDesc('pendaftaran_count')
        ->limit(10)
        ->get();

        // 5. Transaksi Terbaru / List Ringkasan Laporan Pendaftaran
        $transaksiTerbaru = Pendaftaran::with(['peserta', 'kegiatan', 'biaya', 'pembayaran'])
            ->whereYear('created_at', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->when($jenisKegiatan, fn($q) => $q->whereHas('kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan)))
            ->latest()
            ->limit(15)
            ->get();

        $availableYears = range(date('Y'), date('Y')-3);

        return view('admin.laporan.index', compact(
            'summary',
            'tahun',
            'bulan',
            'jenisKegiatan',
            'availableYears',
            'pendapatanBulanan',
            'pendaftaranBulanan',
            'statusPembayaranCounts',
            'jenisCounts',
            'perKegiatan',
            'transaksiTerbaru'
        ));
    }

    public function exportCsv(Request $r)
    {
        $tahun         = $r->tahun ?? date('Y');
        $bulan         = $r->bulan;
        $jenisKegiatan = $r->jenis_kegiatan;

        $pendaftaran = Pendaftaran::with(['peserta','kegiatan','pembayaran','biaya'])
            ->whereYear('created_at', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->when($jenisKegiatan, fn($q) => $q->whereHas('kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan)))
            ->latest()
            ->get();

        $csv = "No,Kode Transaksi,Nama Peserta,Email,No HP,Instansi,Judul Kegiatan,Jenis Kegiatan,Skema/Tipe Biaya,Nominal (Rp),Status Pendaftaran,Status Pembayaran,Tanggal Daftar\n";
        
        foreach ($pendaftaran as $idx => $pd) {
            $csv .= implode(',', [
                $idx + 1,
                '"'.($pd->pembayaran->kode_pembayaran ?? '-').'"',
                '"'.addslashes($pd->peserta->nama ?? '').'"',
                '"'.($pd->peserta->email ?? '').'"',
                '"'.($pd->peserta->no_hp ?? '').'"',
                '"'.addslashes($pd->peserta->instansi ?? '-').'"',
                '"'.addslashes($pd->kegiatan->judul ?? '').'"',
                '"'.ucfirst($pd->kegiatan->jenis_kegiatan ?? '-').'"',
                '"'.addslashes($pd->biaya->nama_jenis ?? 'Gratis').'"',
                '"'.($pd->pembayaran->jumlah_bayar ?? $pd->biaya->nominal ?? 0).'"',
                '"'.ucfirst(str_replace('_', ' ', $pd->status_pendaftaran ?? '')).'"',
                '"'.ucfirst(str_replace('_', ' ', $pd->pembayaran->status_pembayaran ?? 'Belum Bayar')).'"',
                '"'.($pd->tgl_daftar?->format('d/m/Y H:i') ?? '').'"',
            ])."\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan-fikom-'.$tahun.($bulan ? '-'.$bulan : '').'.csv"',
        ]);
    }
}

