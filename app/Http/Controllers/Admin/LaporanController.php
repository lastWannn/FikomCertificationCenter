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

        // 1. Data Grafik (Bulanan jika Semua Bulan, Harian jika Bulan dipilih)
        if ($bulan) {
            $daysInMonth = \Carbon\Carbon::createFromDate($tahun, (int)$bulan, 1)->daysInMonth;
            $chartLabels = array_map(fn($d) => "Tgl $d", range(1, $daysInMonth));
            
            $pendapatanDataMap  = array_fill(1, $daysInMonth, 0);
            $pendaftaranDataMap = array_fill(1, $daysInMonth, 0);

            $rawPendapatan = Pembayaran::selectRaw('DAY(created_at) as tgl, SUM(jumlah_bayar) as total')
                ->where('status_pembayaran', 'terverifikasi')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->when($jenisKegiatan, function($q) use ($jenisKegiatan) {
                    $q->whereHas('pendaftaran.kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan));
                })
                ->groupBy('tgl')
                ->get();

            foreach ($rawPendapatan as $item) {
                $pendapatanDataMap[(int)$item->tgl] = (int) $item->total;
            }

            $rawPendaftaran = Pendaftaran::selectRaw('DAY(created_at) as tgl, COUNT(id) as total')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->when($jenisKegiatan, fn($q) => $q->whereHas('kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan)))
                ->groupBy('tgl')
                ->get();

            foreach ($rawPendaftaran as $item) {
                $pendaftaranDataMap[(int)$item->tgl] = (int) $item->total;
            }

            $pendapatanChartData  = array_values($pendapatanDataMap);
            $pendaftaranChartData = array_values($pendaftaranDataMap);
            $namaBulan            = \Carbon\Carbon::createFromDate($tahun, (int)$bulan, 1)->translatedFormat('F');
            $chartTitle           = "Grafik Tren Harian — Bulan $namaBulan $tahun";
        } else {
            $chartLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            $pendapatanDataMap  = array_fill(1, 12, 0);
            $pendaftaranDataMap = array_fill(1, 12, 0);

            $rawPendapatan = Pembayaran::selectRaw('MONTH(created_at) as bulan, SUM(jumlah_bayar) as total')
                ->where('status_pembayaran', 'terverifikasi')
                ->whereYear('created_at', $tahun)
                ->when($jenisKegiatan, function($q) use ($jenisKegiatan) {
                    $q->whereHas('pendaftaran.kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan));
                })
                ->groupBy('bulan')
                ->get();

            foreach ($rawPendapatan as $item) {
                $pendapatanDataMap[(int)$item->bulan] = (int) $item->total;
            }

            $rawPendaftaran = Pendaftaran::selectRaw('MONTH(created_at) as bulan, COUNT(id) as total')
                ->whereYear('created_at', $tahun)
                ->when($jenisKegiatan, fn($q) => $q->whereHas('kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan)))
                ->groupBy('bulan')
                ->get();

            foreach ($rawPendaftaran as $item) {
                $pendaftaranDataMap[(int)$item->bulan] = (int) $item->total;
            }

            $pendapatanChartData  = array_values($pendapatanDataMap);
            $pendaftaranChartData = array_values($pendaftaranDataMap);
            $chartTitle           = "Grafik Tren Bulanan — Tahun $tahun";
        }

        // 2. Data Grafik Distribution Status Pembayaran
        $statusPembayaranCounts = Pembayaran::selectRaw('status_pembayaran, COUNT(id) as total')
            ->whereYear('created_at', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->when($jenisKegiatan, function($q) use ($jenisKegiatan) {
                $q->whereHas('pendaftaran.kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan));
            })
            ->groupBy('status_pembayaran')
            ->pluck('total', 'status_pembayaran')
            ->toArray();

        // 3. Data Perbandingan Pelatihan vs Sertifikasi
        $jenisCounts = Kegiatan::join('pendaftaran', 'kegiatan.id', '=', 'pendaftaran.kegiatan_id')
            ->whereYear('pendaftaran.created_at', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('pendaftaran.created_at', $bulan))
            ->when($jenisKegiatan, fn($q) => $q->where('kegiatan.jenis_kegiatan', $jenisKegiatan))
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
            ->limit(10)
            ->get();

        // 6. Option 1: Sertifikat Diterbitkan & Rate
        $totalSertifikat = \App\Models\Sertifikat::whereYear('created_at', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->when($jenisKegiatan, function($q) use ($jenisKegiatan) {
                $q->whereHas('pendaftaran.kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan));
            })
            ->count();
        $rateSertifikat = $totalTerverifikasi > 0 ? round(($totalSertifikat / $totalTerverifikasi) * 100, 1) : 0;

        // 7. Option 2: Demografi Peserta (Asal Instansi)
        $pesertaQuery = Peserta::whereHas('pendaftaran', function($q) use ($tahun, $bulan, $jenisKegiatan) {
            $q->whereYear('created_at', $tahun)
              ->when($bulan, fn($b) => $b->whereMonth('created_at', $bulan))
              ->when($jenisKegiatan, fn($j) => $j->whereHas('kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan)));
        });

        $rawInstansi = (clone $pesertaQuery)
            ->selectRaw('COALESCE(NULLIF(instansi, ""), "Masyarakat Umum") as nama_instansi, COUNT(id) as total')
            ->groupBy('nama_instansi')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $demografiInstansi = [
            'fikom'      => (clone $pesertaQuery)->where(fn($q) => $q->where('instansi', 'LIKE', '%FIKOM%')->orWhere('instansi', 'LIKE', '%Ilmu Komputer%'))->count(),
            'umi'        => (clone $pesertaQuery)->where('instansi', 'LIKE', '%UMI%')->where('instansi', 'NOT LIKE', '%FIKOM%')->where('instansi', 'NOT LIKE', '%Ilmu Komputer%')->count(),
            'eksternal'  => (clone $pesertaQuery)->where(fn($q) => $q->whereNotNull('instansi')->where('instansi', '!=', ''))->where('instansi', 'NOT LIKE', '%UMI%')->count(),
            'umum'       => (clone $pesertaQuery)->where(fn($q) => $q->whereNull('instansi')->orWhere('instansi', ''))->count(),
        ];

        // 8. Option 4: Efisiensi Kuota & Keterisian Kelas
        $kegiatansForQuota = Kegiatan::with(['kegiatanPelatihan.jadwalPelatihan', 'kegiatanSertifikasi.jadwalSertifikasi'])
            ->when($jenisKegiatan, fn($q) => $q->where('jenis_kegiatan', $jenisKegiatan))
            ->get();

        $totalKuota  = $kegiatansForQuota->sum(fn($k) => $k->kuota);
        $totalTerisi = $kegiatansForQuota->sum(fn($k) => $k->terisi);
        $rateKuota   = $totalKuota > 0 ? round(($totalTerisi / $totalKuota) * 100, 1) : 0;

        $summary['total_sertifikat']  = $totalSertifikat;
        $summary['rate_sertifikat']   = $rateSertifikat;
        $summary['total_kuota']       = $totalKuota;
        $summary['total_terisi']      = $totalTerisi;
        $summary['rate_kuota']        = $rateKuota;
        $summary['demografi']         = $demografiInstansi;

        $availableYears  = range(date('Y'), date('Y')-3);
        $rawKegiatanList = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi'
        ])->latest()->get();

        $programGroupList = [];
        foreach ($rawKegiatanList as $k) {
            $programName = $k->detail?->judul ?? $k->judul;
            $jenis       = ucfirst($k->jenis_kegiatan);
            $key         = $k->jenis_kegiatan . '_' . ($k->detail?->id ?? $k->id);

            if (!isset($programGroupList[$key])) {
                $programGroupList[$key] = [
                    'key'          => $key,
                    'program_name' => $programName,
                    'jenis'        => $jenis,
                    'jadwal_list'  => [],
                ];
            }

            $tglRaw = $k->jadwal?->tgl_pelaksanaan;
            $tglPel = $tglRaw 
                ? $tglRaw->translatedFormat('d-M-Y') 
                : 'Tanggal Belum Set';

            $tglSort = $tglRaw ? $tglRaw->timestamp : ($k->created_at?->timestamp ?? 0);

            $namaJadwal = $k->jadwal?->nama_kegiatan;

            $programGroupList[$key]['jadwal_list'][] = [
                'id'              => $k->id,
                'nama_jadwal'     => $namaJadwal,
                'tgl_pelaksanaan' => $tglPel,
                'tgl_sort'        => $tglSort,
            ];
        }

        // Urutkan jadwal per program dari tanggal terbaru ke terlama
        foreach ($programGroupList as $key => &$group) {
            usort($group['jadwal_list'], fn($a, $b) => $b['tgl_sort'] <=> $a['tgl_sort']);
        }
        unset($group);

        return view('admin.laporan.index', compact(
            'summary',
            'tahun',
            'bulan',
            'jenisKegiatan',
            'availableYears',
            'programGroupList',
            'chartLabels',
            'pendapatanChartData',
            'pendaftaranChartData',
            'chartTitle',
            'statusPembayaranCounts',
            'jenisCounts',
            'perKegiatan',
            'transaksiTerbaru',
            'rawInstansi'
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

    public function exportKegiatanExcel(Request $r)
    {
        $kegiatanId = $r->kegiatan_id;
        $kegiatan = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            'pendaftaran.peserta',
            'pendaftaran.pembayaran',
            'pendaftaran.biaya'
        ])->find($kegiatanId);

        if (!$kegiatan) {
            return back()->with('error', 'Silakan pilih kegiatan terlebih dahulu.');
        }

        $judulKegiatan  = $kegiatan->judul;
        $tglPelaksanaan = $kegiatan->jadwal?->tgl_pelaksanaan 
            ? $kegiatan->jadwal->tgl_pelaksanaan->translatedFormat('d-M-Y') 
            : 'Belum Ditentukan';

        $pendaftaranList = $kegiatan->pendaftaran()
            ->with(['peserta', 'pembayaran', 'biaya'])
            ->latest()
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pembayaran');

        // Atur Lebar Kolom
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(38);
        $sheet->getColumnDimension('C')->setWidth(44);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(24);

        // Baris Header Judul
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'Data Pembayaran Peserta');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setName('Arial');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', $judulKegiatan);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14)->setName('Arial');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A3:F3');
        $sheet->setCellValue('A3', 'waktu pelaksanaan : ' . $tglPelaksanaan);
        $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(11)->setName('Arial')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('333333'));
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Header Tabel (Baris 5)
        $headers = ['No', 'Biodata Peserta', 'Data Pembayaran', 'Jumlah Bayar', 'Status Pembayaran', 'Bukti Bayar'];
        $cols = ['A', 'B', 'C', 'D', 'E', 'F'];
        foreach ($headers as $i => $h) {
            $col = $cols[$i];
            $cellRef = $col . '5';
            $sheet->setCellValue($cellRef, $h);
            $style = $sheet->getStyle($cellRef);
            $style->getFont()->setBold(true)->setSize(10)->setName('Arial')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('131218'));
            $style->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $style->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFC81A');
            $style->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB('FF000000');
        }
        $sheet->getRowDimension(5)->setRowHeight(26);

        $row = 6;
        foreach ($pendaftaranList as $idx => $pd) {
            $peserta = $pd->peserta;
            $pembayaran = $pd->pembayaran;
            $statusPay = $pembayaran?->status_pembayaran ?? 'belum_bayar';
            $isLunas = ($statusPay === 'terverifikasi');

            // 1. No
            $sheet->setCellValue('A' . $row, $idx + 1);
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

            // 2. Biodata Peserta
            $biodataText = "Nama : " . ($peserta->nama ?? '-') . "\n"
                         . "Email : " . ($peserta->email ?? '-') . "\n"
                         . "No : " . ($peserta->no_hp ?? '-') . "\n"
                         . "Pekerjaan : " . ($peserta->pekerjaan ?? '-') . "\n"
                         . "Instansi : " . ($peserta->instansi ?? '-');
            $sheet->setCellValue('B' . $row, $biodataText);
            $sheet->getStyle('B' . $row)->getAlignment()->setWrapText(true)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

            // 3. Data Pembayaran
            $tglPay = $pembayaran?->tgl_transfer ? $pembayaran->tgl_transfer->translatedFormat('d-M-Y') : ($pembayaran?->created_at ? $pembayaran->created_at->translatedFormat('d-M-Y') : '-');
            $jamPay = $pembayaran?->jam_transfer ?? ($pembayaran?->created_at ? $pembayaran->created_at->format('H:i') . ' WITA' : '-');
            $jenisPay = ucfirst($pembayaran->metode_pembayaran ?? $pd->biaya?->nama_jenis ?? 'Transfer Bank');
            $bankPay = $pembayaran->nama_layanan_bank ?? 'Bank Transfer';
            $pengirimPay = $pembayaran->nama_pengirim ?? '-';
            $refPay = $pembayaran->no_referensi ?? '-';

            $pembayaranText = "Kode Pembayaran : " . ($pembayaran->kode_pembayaran ?? '-') . "\n"
                            . "Tgl. Pembayaran : " . $tglPay . "\n"
                            . "Jam Pembayaran : " . $jamPay . "\n"
                            . "Jenis Pembayaran : " . $jenisPay . "\n"
                            . "Layanan/Bank : " . $bankPay . "\n"
                            . "Nama Pengirim : " . $pengirimPay;
            $sheet->setCellValue('C' . $row, $pembayaranText);
            $sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

            // 4. Jumlah Bayar
            $nominalText = $pembayaran ? $pembayaran->nominal_transfer_format : ('Rp ' . number_format($pd->biaya?->nominal ?? 0, 0, ',', '.'));
            $sheet->setCellValue('D' . $row, $nominalText);
            $sheet->getStyle('D' . $row)->getFont()->setBold(true);
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

            // 5. Status Pembayaran
            $statusText = $isLunas ? 'Lunas' : 'Tidak Lunas';
            $sheet->setCellValue('E' . $row, $statusText);
            $statusStyle = $sheet->getStyle('E' . $row);
            $statusStyle->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($isLunas ? 'FF059669' : 'FFDC2626'));
            $statusStyle->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

            // 6. Bukti Bayar
            if ($pembayaran && $pembayaran->bukti_bayar) {
                $buktiUrl = str_starts_with($pembayaran->bukti_bayar, 'http') ? $pembayaran->bukti_bayar : asset('storage/' . $pembayaran->bukti_bayar);
                $sheet->setCellValue('F' . $row, 'Lihat Bukti Bayar ↗');
                $sheet->getCell('F' . $row)->getHyperlink()->setUrl($buktiUrl);
                $sheet->getStyle('F' . $row)->getFont()->setBold(true)->setUnderline(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF0284C7'));
            } else {
                $sheet->setCellValue('F' . $row, '- Tidak Ada -');
                $sheet->getStyle('F' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF94A3B8'));
            }
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

            // Row Borders
            foreach ($cols as $col) {
                $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');
            }

            $row++;
        }

        $filename = 'laporan-pembayaran-' . \Illuminate\Support\Str::slug($judulKegiatan) . '-' . now()->format('YmdHis') . '.xlsx';

        return response()->streamDownload(function() use ($spreadsheet) {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}

