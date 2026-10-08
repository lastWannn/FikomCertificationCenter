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

        // 4. Top Kegiatan Terfavorit (Dikelompokkan Berdasarkan Nama Kegiatan Induk, Akumulasi Pendaftar)
        $allKegiatan = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
        ])
        ->withCount(['pendaftaran' => function($q) use ($tahun, $bulan) {
            $q->whereYear('created_at', $tahun)
              ->when($bulan, fn($b) => $b->whereMonth('created_at', $bulan));
        }])
        ->when($jenisKegiatan, fn($q) => $q->where('jenis_kegiatan', $jenisKegiatan))
        ->get();

        $groupedKegiatan = [];
        foreach ($allKegiatan as $k) {
            // Ambil murni nama kegiatan/program induk (abaikan nama jadwal kegiatan)
            $namaProgram = $k->detail?->judul ?: $k->judul;
            $jenis       = $k->jenis_kegiatan;
            $key         = $jenis . '_' . $namaProgram;

            if (!isset($groupedKegiatan[$key])) {
                $groupedKegiatan[$key] = (object) [
                    'judul'             => $namaProgram,
                    'jenis_kegiatan'    => $jenis,
                    'pendaftaran_count' => 0,
                ];
            }

            $groupedKegiatan[$key]->pendaftaran_count += (int) $k->pendaftaran_count;
        }

        $perKegiatan = collect($groupedKegiatan)
            ->filter(fn($item) => $item->pendaftaran_count > 0)
            ->sortByDesc('pendaftaran_count')
            ->values()
            ->take(10);

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

        // 7. Demografi Peserta Berdasarkan Inputan Instansi Terbanyak (Dinamis)
        $pesertaQuery = Peserta::whereHas('pendaftaran', function($q) use ($tahun, $bulan, $jenisKegiatan) {
            $q->whereYear('created_at', $tahun)
              ->when($bulan, fn($b) => $b->whereMonth('created_at', $bulan))
              ->when($jenisKegiatan, fn($j) => $j->whereHas('kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan)));
        });

        $rawInstansi = (clone $pesertaQuery)
            ->selectRaw('TRIM(COALESCE(NULLIF(instansi, ""), "Masyarakat Umum")) as nama_instansi, COUNT(id) as total')
            ->groupBy('nama_instansi')
            ->orderByDesc('total')
            ->get();

        $topInstansi = $rawInstansi->take(5);
        $sisaCount   = $rawInstansi->skip(5)->sum('total');

        $demografiInstansi = [];
        foreach ($topInstansi as $item) {
            $demografiInstansi[] = [
                'label' => $item->nama_instansi,
                'total' => (int) $item->total,
            ];
        }
        if ($sisaCount > 0) {
            $demografiInstansi[] = [
                'label' => 'Instansi Lainnya',
                'total' => (int) $sisaCount,
            ];
        }

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
        $tipeLaporan   = $r->tipe_laporan ?? 'per_kegiatan';

        $namaBulan = $bulan ? (['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'][$bulan] ?? $bulan) : null;
        $periodeText = ($namaBulan ? $namaBulan . ' ' : '') . 'Tahun ' . $tahun;

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setShowGridLines(true);

        // Styling Palette
        $headerBgColor = 'FF1E293B'; // Slate 800
        $headerTextColor = 'FFFFFFFF'; // White
        $zebraColor = 'FFF8FAFC'; // Slate 50
        $borderColor = 'FFE2E8F0'; // Slate 200
        $summaryBgColor = 'FFFEF3C7'; // Amber 100
        $summaryTextColor = 'FF0F172A'; // Slate 900

        // ════════════════════════════════════════════════════════════════════
        // 4. TIPE: RINCIAN PEMBAYARAN PER PROGRAM / KEGIATAN (MULTI-SHEET)
        // ════════════════════════════════════════════════════════════════════
        if ($tipeLaporan === 'per_kegiatan') {
            return $this->exportKegiatanExcel($r);
        }

        // ════════════════════════════════════════════════════════════════════
        // 1. TIPE: BUKU KAS / LOG MUTASI TRANSAKSI GLOBAL
        // ════════════════════════════════════════════════════════════════════
        if ($tipeLaporan === 'keuangan') {
            $statusBayar = $r->status_pembayaran ?? 'terverifikasi';

            $query = Pembayaran::with([
                'pendaftaran.peserta',
                'pendaftaran.biaya',
                'pendaftaran.kegiatan.kegiatanPelatihan.jadwalPelatihan.pelatihan',
                'pendaftaran.kegiatan.kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            ])
                ->whereYear('created_at', $tahun)
                ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
                ->when($jenisKegiatan, function($q) use ($jenisKegiatan) {
                    $q->whereHas('pendaftaran.kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan));
                });

            if ($statusBayar && $statusBayar !== 'semua') {
                $query->where('status_pembayaran', $statusBayar);
            }

            $transaksi = $query->orderBy('created_at', 'desc')->get();

            $sheet->setTitle('Buku Kas Mutasi Global');

            // Header Judul Dokumen
            $sheet->mergeCells('A1:N1');
            $sheet->setCellValue('A1', 'FIKOM CERTIFICATION CENTER (FCC)');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF131218'));

            $sheet->mergeCells('A2:N2');
            $sheet->setCellValue('A2', 'BUKU KAS & LOG MUTASI TRANSAKSI KEUANGAN GLOBAL');
            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(11.5)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF334155'));

            $sheet->mergeCells('A3:N3');
            $sheet->setCellValue('A3', 'Periode: ' . $periodeText . '  |  Status: ' . ucfirst(str_replace('_', ' ', $statusBayar)) . '  |  Filter Jenis: ' . ($jenisKegiatan ? ucfirst($jenisKegiatan) : 'Semua Program') . '  |  Digenerate: ' . now()->translatedFormat('d F Y H:i') . ' WITA');
            $sheet->getStyle('A3')->getFont()->setSize(9.5)->setItalic(true)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF64748B'));

            // Header Tabel (Baris 5)
            $headers = ['No', 'Kode Pembayaran', 'Waktu Transaksi', 'Nama Peserta', 'Email Peserta', 'No. HP', 'Instansi', 'Program Kegiatan', 'Jenis', 'Skema Biaya', 'Metode / Layanan Bank', 'Nama Pengirim', 'Nominal (Rp)', 'Status Pembayaran'];
            $colLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'];
            $colWidths  = [6,   22,   18,  26,  26,  16,  26,  32,  14,  18,  22,  22,  18,  18];

            foreach ($headers as $i => $h) {
                $col = $colLetters[$i];
                $cell = $col . '5';
                $sheet->setCellValue($cell, $h);
                $sheet->getColumnDimension($col)->setWidth($colWidths[$i]);
                $sheet->getStyle($cell)->getFont()->setBold(true)->setSize(10)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($headerTextColor));
                $sheet->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle($cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($headerBgColor);
                $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB('FF0F172A');
            }
            $sheet->getRowDimension(5)->setRowHeight(26);

            $row = 6;
            $totalNominal = 0;
            foreach ($transaksi as $idx => $t) {
                $nominal = (int) ($t->jumlah_bayar ?? 0);
                $totalNominal += $nominal;

                $metodeBank = trim(($t->metode_pembayaran ? ucfirst(str_replace('_', ' ', $t->metode_pembayaran)) : '') . ($t->nama_layanan_bank ? ' (' . $t->nama_layanan_bank . ')' : '')) ?: '-';
                $namaPengirim = $t->nama_pengirim ?: '-';
                $statusFormatted = ucfirst(str_replace('_', ' ', $t->status_pembayaran ?? '-'));

                $sheet->setCellValue('A' . $row, $idx + 1);
                $sheet->setCellValue('B' . $row, $t->kode_pembayaran ?? '-');
                $sheet->setCellValue('C' . $row, $t->created_at ? $t->created_at->format('d/m/Y H:i') : '-');
                $sheet->setCellValue('D' . $row, $t->pendaftaran?->peserta?->nama ?? '-');
                $sheet->setCellValue('E' . $row, $t->pendaftaran?->peserta?->email ?? '-');
                $sheet->setCellValue('F' . $row, $t->pendaftaran?->peserta?->no_hp ?? '-');
                $sheet->setCellValue('G' . $row, $t->pendaftaran?->peserta?->instansi ?? '-');
                $sheet->setCellValue('H' . $row, $t->pendaftaran?->kegiatan?->judul ?? '-');
                $sheet->setCellValue('I' . $row, ucfirst($t->pendaftaran?->kegiatan?->jenis_kegiatan ?? '-'));
                $sheet->setCellValue('J' . $row, $t->pendaftaran?->biaya?->nama_jenis ?? 'Gratis');
                $sheet->setCellValue('K' . $row, $metodeBank);
                $sheet->setCellValue('L' . $row, $namaPengirim);
                $sheet->setCellValue('M' . $row, $nominal);
                $sheet->setCellValue('N' . $row, $statusFormatted);

                // Alignments
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('N' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Nominal Format
                $sheet->getStyle('M' . $row)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('M' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('M' . $row)->getFont()->setBold(true);

                // Row Heights & Styling
                $sheet->getRowDimension($row)->setRowHeight(21);
                $sheet->getStyle('A' . $row . ':N' . $row)->getFont()->setSize(9.5)->setName('Segoe UI');
                $sheet->getStyle('A' . $row . ':N' . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // Zebra striping
                if ($row % 2 === 1) {
                    $sheet->getStyle('A' . $row . ':N' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($zebraColor);
                }

                foreach ($colLetters as $cl) {
                    $sheet->getStyle($cl . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB($borderColor);
                }

                $row++;
            }

            if ($transaksi->isEmpty()) {
                $sheet->mergeCells('A6:N6');
                $sheet->setCellValue('A6', 'Tidak ditemukan data transaksi pembayaran pada periode ini.');
                $sheet->getStyle('A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getRowDimension(6)->setRowHeight(24);
                $row = 7;
            }

            // Summary Row
            $sheet->mergeCells('A' . $row . ':L' . $row);
            $sheet->setCellValue('A' . $row, 'TOTAL TRANSAKSI TERDATA (' . count($transaksi) . ' Transaksi)');
            $sheet->setCellValue('M' . $row, $totalNominal);
            $sheet->setCellValue('N' . $row, '');

            $sheet->getStyle('A' . $row . ':N' . $row)->getFont()->setBold(true)->setSize(10)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($summaryTextColor));
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('M' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('M' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('A' . $row . ':N' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($summaryBgColor);

            foreach ($colLetters as $cl) {
                $sheet->getStyle($cl . $row)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB('FF94A3B8');
                $sheet->getStyle($cl . $row)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE)->getColor()->setARGB('FF0F172A');
                $sheet->getStyle($cl . $row)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB($borderColor);
                $sheet->getStyle($cl . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB($borderColor);
            }
            $sheet->getRowDimension($row)->setRowHeight(24);

            $filename = 'buku-kas-transaksi-global-fcc-' . $tahun . ($bulan ? '-' . $bulan : '') . '-' . now()->format('YmdHis') . '.xlsx';

        // ════════════════════════════════════════════════════════════════════
        // 2. TIPE: REKAPITULASI KINERJA PER PROGRAM KEGIATAN
        // ════════════════════════════════════════════════════════════════════
        } elseif ($tipeLaporan === 'rekap_program') {
            $allKegiatan = Kegiatan::with([
                'kegiatanPelatihan.jadwalPelatihan.pelatihan',
                'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            ])
            ->withCount([
                'pendaftaran as total_pendaftar' => function($q) use ($tahun, $bulan) {
                    $q->whereYear('created_at', $tahun)
                      ->when($bulan, fn($b) => $b->whereMonth('created_at', $bulan));
                },
                'pendaftaran as total_lunas' => function($q) use ($tahun, $bulan) {
                    $q->whereYear('created_at', $tahun)
                      ->when($bulan, fn($b) => $b->whereMonth('created_at', $bulan))
                      ->whereHas('pembayaran', fn($p) => $p->where('status_pembayaran', 'terverifikasi'));
                }
            ])
            ->when($jenisKegiatan, fn($q) => $q->where('jenis_kegiatan', $jenisKegiatan))
            ->get();

            $grouped = [];
            foreach ($allKegiatan as $k) {
                $namaProgram = $k->detail?->judul ?: $k->judul;
                $jenis       = ucfirst($k->jenis_kegiatan);
                $key         = $k->jenis_kegiatan . '_' . $namaProgram;

                if (!isset($grouped[$key])) {
                    $grouped[$key] = [
                        'nama_program'     => $namaProgram,
                        'jenis'            => $jenis,
                        'total_batch'      => 0,
                        'total_pendaftar'  => 0,
                        'total_lunas'      => 0,
                        'kegiatan_ids'     => [],
                    ];
                }

                $grouped[$key]['total_batch']     += 1;
                $grouped[$key]['total_pendaftar'] += (int) $k->total_pendaftar;
                $grouped[$key]['total_lunas']     += (int) $k->total_lunas;
                $grouped[$key]['kegiatan_ids'][]   = $k->id;
            }

            $sheet->setTitle('Rekapitulasi Kinerja Program');

            // Header Dokumen
            $sheet->mergeCells('A1:I1');
            $sheet->setCellValue('A1', 'FIKOM CERTIFICATION CENTER (FCC)');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF131218'));

            $sheet->mergeCells('A2:I2');
            $sheet->setCellValue('A2', 'REKAPITULASI KINERJA & PARTISIPASI PROGRAM KEGIATAN');
            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(11.5)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF334155'));

            $sheet->mergeCells('A3:I3');
            $sheet->setCellValue('A3', 'Periode: ' . $periodeText . '  |  Filter: ' . ($jenisKegiatan ? ucfirst($jenisKegiatan) : 'Semua Program') . '  |  Digenerate: ' . now()->translatedFormat('d F Y H:i') . ' WITA');
            $sheet->getStyle('A3')->getFont()->setSize(9.5)->setItalic(true)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF64748B'));

            // Header Tabel (Baris 5)
            $headers = ['No', 'Nama Program Kegiatan', 'Jenis Program', 'Jumlah Batch / Jadwal', 'Total Pendaftar', 'Peserta Lunas', 'Sertifikat Diterbitkan', 'Tingkat Kelulusan', 'Total Pendapatan (Rp)'];
            $colLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
            $colWidths  = [6,   38,  16,  20,  16,  18,  20,  18,  22];

            foreach ($headers as $i => $h) {
                $col = $colLetters[$i];
                $cell = $col . '5';
                $sheet->setCellValue($cell, $h);
                $sheet->getColumnDimension($col)->setWidth($colWidths[$i]);
                $sheet->getStyle($cell)->getFont()->setBold(true)->setSize(10)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($headerTextColor));
                $sheet->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle($cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($headerBgColor);
                $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB('FF0F172A');
            }
            $sheet->getRowDimension(5)->setRowHeight(26);

            $row = 6;
            $sumBatch = 0; $sumPendaftar = 0; $sumLunas = 0; $sumSertifikat = 0; $sumPendapatan = 0;
            $idx = 1;

            foreach ($grouped as $g) {
                $kegiatanIds = $g['kegiatan_ids'];

                $totalSertifikat = \App\Models\Sertifikat::whereYear('created_at', $tahun)
                    ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
                    ->whereHas('pendaftaran', fn($p) => $p->whereIn('kegiatan_id', $kegiatanIds))
                    ->count();

                $totalPendapatan = (int) Pembayaran::where('status_pembayaran', 'terverifikasi')
                    ->whereYear('created_at', $tahun)
                    ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
                    ->whereHas('pendaftaran', fn($p) => $p->whereIn('kegiatan_id', $kegiatanIds))
                    ->sum('jumlah_bayar');

                $rateLulus = $g['total_lunas'] > 0 ? round(($totalSertifikat / $g['total_lunas']) * 100, 1) : 0;

                $sumBatch       += $g['total_batch'];
                $sumPendaftar   += $g['total_pendaftar'];
                $sumLunas       += $g['total_lunas'];
                $sumSertifikat  += $totalSertifikat;
                $sumPendapatan  += $totalPendapatan;

                $sheet->setCellValue('A' . $row, $idx++);
                $sheet->setCellValue('B' . $row, $g['nama_program']);
                $sheet->setCellValue('C' . $row, $g['jenis']);
                $sheet->setCellValue('D' . $row, $g['total_batch']);
                $sheet->setCellValue('E' . $row, $g['total_pendaftar']);
                $sheet->setCellValue('F' . $row, $g['total_lunas']);
                $sheet->setCellValue('G' . $row, $totalSertifikat);
                $sheet->setCellValue('H' . $row, $rateLulus . '%');
                $sheet->setCellValue('I' . $row, $totalPendapatan);

                // Alignments
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('B' . $row)->getFont()->setBold(true);
                $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('H' . $row)->getFont()->setBold(true);

                $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('I' . $row)->getFont()->setBold(true);

                $sheet->getRowDimension($row)->setRowHeight(21);
                $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->setSize(9.5)->setName('Segoe UI');
                $sheet->getStyle('A' . $row . ':I' . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                if ($row % 2 === 1) {
                    $sheet->getStyle('A' . $row . ':I' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($zebraColor);
                }

                foreach ($colLetters as $cl) {
                    $sheet->getStyle($cl . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB($borderColor);
                }

                $row++;
            }

            if (empty($grouped)) {
                $sheet->mergeCells('A6:I6');
                $sheet->setCellValue('A6', 'Tidak ditemukan data program kegiatan pada periode ini.');
                $sheet->getStyle('A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getRowDimension(6)->setRowHeight(24);
                $row = 7;
            }

            $avgRate = $sumLunas > 0 ? round(($sumSertifikat / $sumLunas) * 100, 1) : 0;

            // Summary Row
            $sheet->mergeCells('A' . $row . ':C' . $row);
            $sheet->setCellValue('A' . $row, 'TOTAL KESELURUHAN');
            $sheet->setCellValue('D' . $row, $sumBatch);
            $sheet->setCellValue('E' . $row, $sumPendaftar);
            $sheet->setCellValue('F' . $row, $sumLunas);
            $sheet->setCellValue('G' . $row, $sumSertifikat);
            $sheet->setCellValue('H' . $row, $avgRate . '%');
            $sheet->setCellValue('I' . $row, $sumPendapatan);

            $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->setBold(true)->setSize(10)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($summaryTextColor));
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('D' . $row . ':H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('A' . $row . ':I' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($summaryBgColor);

            foreach ($colLetters as $cl) {
                $sheet->getStyle($cl . $row)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB('FF94A3B8');
                $sheet->getStyle($cl . $row)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE)->getColor()->setARGB('FF0F172A');
                $sheet->getStyle($cl . $row)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB($borderColor);
                $sheet->getStyle($cl . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB($borderColor);
            }
            $sheet->getRowDimension($row)->setRowHeight(24);

            $filename = 'rekapitulasi-kinerja-program-fcc-' . $tahun . ($bulan ? '-' . $bulan : '') . '-' . now()->format('YmdHis') . '.xlsx';

        // ════════════════════════════════════════════════════════════════════
        // 3. TIPE: DAFTAR PESERTA & KELULUSAN SERTIFIKAT
        // ════════════════════════════════════════════════════════════════════
        } else {
            $statusSertifikat = $r->status_sertifikat ?? 'semua';
            $statusBayar      = $r->status_pembayaran ?? 'terverifikasi';

            $query = Pendaftaran::with([
                'peserta',
                'kegiatan.kegiatanPelatihan.jadwalPelatihan.pelatihan',
                'kegiatan.kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
                'pembayaran',
                'biaya',
                'sertifikat'
            ])
                ->whereYear('created_at', $tahun)
                ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
                ->when($jenisKegiatan, fn($q) => $q->whereHas('kegiatan', fn($k) => $k->where('jenis_kegiatan', $jenisKegiatan)));

            if ($statusBayar && $statusBayar !== 'semua') {
                $query->whereHas('pembayaran', fn($p) => $p->where('status_pembayaran', $statusBayar));
            }

            if ($statusSertifikat === 'terbit') {
                $query->whereHas('sertifikat');
            } elseif ($statusSertifikat === 'belum') {
                $query->whereDoesntHave('sertifikat');
            }

            $pendaftarList = $query->latest()->get();

            $sheet->setTitle('Peserta & Kelulusan');

            // Header Dokumen
            $sheet->mergeCells('A1:L1');
            $sheet->setCellValue('A1', 'FIKOM CERTIFICATION CENTER (FCC)');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF131218'));

            $sheet->mergeCells('A2:L2');
            $sheet->setCellValue('A2', 'DATA OPERASIONAL PESERTA & KELULUSAN SERTIFIKAT');
            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(11.5)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF334155'));

            $sheet->mergeCells('A3:L3');
            $sheet->setCellValue('A3', 'Periode: ' . $periodeText . '  |  Status Sertifikat: ' . ucfirst($statusSertifikat) . '  |  Status Bayar: ' . ucfirst(str_replace('_', ' ', $statusBayar)) . '  |  Digenerate: ' . now()->translatedFormat('d F Y H:i') . ' WITA');
            $sheet->getStyle('A3')->getFont()->setSize(9.5)->setItalic(true)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF64748B'));

            // Header Tabel (Baris 5)
            $headers = ['No', 'Nomor Sertifikat', 'Nama Lengkap Peserta', 'Email Peserta', 'No. HP / WhatsApp', 'Instansi', 'Program Kegiatan', 'Jenis', 'Waktu Pelaksanaan', 'Status Pembayaran', 'Tanggal Terbit', 'URL Verifikasi Keabsahan'];
            $colLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
            $colWidths  = [6,   26,  26,  26,  16,  26,  32,  14,  18,  18,  18,  26];

            foreach ($headers as $i => $h) {
                $col = $colLetters[$i];
                $cell = $col . '5';
                $sheet->setCellValue($cell, $h);
                $sheet->getColumnDimension($col)->setWidth($colWidths[$i]);
                $sheet->getStyle($cell)->getFont()->setBold(true)->setSize(10)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($headerTextColor));
                $sheet->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle($cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($headerBgColor);
                $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB('FF0F172A');
            }
            $sheet->getRowDimension(5)->setRowHeight(26);

            $row = 6;
            $terbitCount = 0;
            foreach ($pendaftarList as $idx => $pd) {
                $hasCert = (bool) $pd->sertifikat;
                if ($hasCert) $terbitCount++;

                $noSertifikat = $pd->sertifikat?->nomor_sertifikat ?? 'Belum Terbit';
                $tglTerbit    = $pd->sertifikat?->tgl_terbit ? $pd->sertifikat->tgl_terbit->format('d/m/Y') : '-';
                $verifyUrl    = $pd->sertifikat ? route('sertifikat.verifikasi', $pd->sertifikat->nomor_sertifikat) : null;

                $tglPel = $pd->kegiatan?->jadwal?->tgl_pelaksanaan 
                    ? $pd->kegiatan->jadwal->tgl_pelaksanaan->format('d/m/Y') 
                    : '-';

                $sheet->setCellValue('A' . $row, $idx + 1);
                $sheet->setCellValue('B' . $row, $noSertifikat);
                $sheet->setCellValue('C' . $row, $pd->peserta?->nama ?? '-');
                $sheet->setCellValue('D' . $row, $pd->peserta?->email ?? '-');
                $sheet->setCellValue('E' . $row, $pd->peserta?->no_hp ?? '-');
                $sheet->setCellValue('F' . $row, $pd->peserta?->instansi ?? '-');
                $sheet->setCellValue('G' . $row, $pd->kegiatan?->judul ?? '-');
                $sheet->setCellValue('H' . $row, ucfirst($pd->kegiatan?->jenis_kegiatan ?? '-'));
                $sheet->setCellValue('I' . $row, $tglPel);
                $sheet->setCellValue('J' . $row, ucfirst(str_replace('_', ' ', $pd->pembayaran?->status_pembayaran ?? 'Belum Bayar')));
                $sheet->setCellValue('K' . $row, $tglTerbit);

                if ($verifyUrl) {
                    $sheet->setCellValue('L' . $row, 'Verifikasi Sertifikat ↗');
                    $sheet->getCell('L' . $row)->getHyperlink()->setUrl($verifyUrl);
                    $sheet->getStyle('L' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF0284C7'))->setUnderline(true);
                } else {
                    $sheet->setCellValue('L' . $row, '-');
                    $sheet->getStyle('L' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF94A3B8'));
                }

                // Alignments
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $row)->getFont()->setBold($hasCert);
                $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->getRowDimension($row)->setRowHeight(21);
                $sheet->getStyle('A' . $row . ':L' . $row)->getFont()->setSize(9.5)->setName('Segoe UI');
                $sheet->getStyle('A' . $row . ':L' . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                if ($row % 2 === 1) {
                    $sheet->getStyle('A' . $row . ':L' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($zebraColor);
                }

                foreach ($colLetters as $cl) {
                    $sheet->getStyle($cl . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB($borderColor);
                }

                $row++;
            }

            if ($pendaftarList->isEmpty()) {
                $sheet->mergeCells('A6:L6');
                $sheet->setCellValue('A6', 'Tidak ditemukan data peserta pada periode ini.');
                $sheet->getStyle('A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getRowDimension(6)->setRowHeight(24);
                $row = 7;
            }

            // Summary Row
            $sheet->mergeCells('A' . $row . ':I' . $row);
            $sheet->setCellValue('A' . $row, 'TOTAL PESERTA TERDATA: ' . count($pendaftarList) . ' Peserta');
            $sheet->mergeCells('J' . $row . ':L' . $row);
            $sheet->setCellValue('J' . $row, 'SERTIFIKAT TERBIT: ' . $terbitCount . ' Berkas');

            $sheet->getStyle('A' . $row . ':L' . $row)->getFont()->setBold(true)->setSize(10)->setName('Segoe UI')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($summaryTextColor));
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $row . ':L' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($summaryBgColor);

            foreach ($colLetters as $cl) {
                $sheet->getStyle($cl . $row)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB('FF94A3B8');
                $sheet->getStyle($cl . $row)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE)->getColor()->setARGB('FF0F172A');
                $sheet->getStyle($cl . $row)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB($borderColor);
                $sheet->getStyle($cl . $row)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB($borderColor);
            }
            $sheet->getRowDimension($row)->setRowHeight(24);

            $filename = 'data-peserta-kelulusan-fcc-' . $tahun . ($bulan ? '-' . $bulan : '') . '-' . now()->format('YmdHis') . '.xlsx';
        }

        return response()->streamDownload(function() use ($spreadsheet) {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }

        public function exportKegiatanExcel(Request $r)
        {
            $programKey = $r->program_key;
            $kegiatanId = $r->kegiatan_id;

            $kegiatanQuery = Kegiatan::with([
                'kegiatanPelatihan.jadwalPelatihan.pelatihan',
                'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
                'pendaftaran.peserta',
                'pendaftaran.pembayaran',
                'pendaftaran.biaya'
            ]);

            if ($kegiatanId && $kegiatanId !== 'all') {
                $kegiatanList = $kegiatanQuery->where('id', $kegiatanId)->get();
            } elseif ($programKey) {
                $parts = explode('_', $programKey, 2);
                $jenis = $parts[0] ?? null;
                $detailId = (int) ($parts[1] ?? 0);

                if ($jenis === 'pelatihan') {
                    $kegiatanQuery->whereHas('kegiatanPelatihan.jadwalPelatihan', function($q) use ($detailId) {
                        $q->where('pelatihan_id', $detailId);
                    });
                } elseif ($jenis === 'sertifikasi') {
                    $kegiatanQuery->whereHas('kegiatanSertifikasi.jadwalSertifikasi', function($q) use ($detailId) {
                        $q->where('sertifikasi_id', $detailId);
                    });
                }
                $kegiatanList = $kegiatanQuery->get();
            } else {
                return back()->with('error', 'Silakan pilih program kegiatan terlebih dahulu.');
            }

            if ($kegiatanList->isEmpty()) {
                return back()->with('error', 'Tidak ditemukan data kegiatan untuk diexport.');
            }

            // Urutkan kegiatan dari tanggal pelaksanaan terbaru ke terlama
            $kegiatanList = $kegiatanList->sortByDesc(function($k) {
                return $k->jadwal?->tgl_pelaksanaan ? $k->jadwal->tgl_pelaksanaan->timestamp : ($k->created_at?->timestamp ?? 0);
            })->values();

            $firstKegiatan = $kegiatanList->first();
            $judulProgram = $firstKegiatan->detail?->judul ?? $firstKegiatan->judul;

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            // Hapus sheet default awal
            $spreadsheet->removeSheetByIndex(0);

            $usedSheetNames = [];

            foreach ($kegiatanList as $sheetIndex => $kegiatan) {
                $judulKegiatan  = $kegiatan->judul;
                $tglPelaksanaan = $kegiatan->jadwal?->tgl_pelaksanaan 
                    ? $kegiatan->jadwal->tgl_pelaksanaan->translatedFormat('d-M-Y') 
                    : 'Belum Set';

                $tglShort = $kegiatan->jadwal?->tgl_pelaksanaan 
                    ? $kegiatan->jadwal->tgl_pelaksanaan->translatedFormat('d-M-Y') 
                    : ('Batch-' . ($sheetIndex + 1));

                // Bersihkan & format nama sheet Excel (Maks 28 Karakter unik, tanpa karakter terlarang)
                $sheetNameRaw = preg_replace('/[\:\/\\\?\*\[\]]/', '', $tglShort);
                $sheetName = \Illuminate\Support\Str::limit($sheetNameRaw, 28, '');
                if (in_array($sheetName, $usedSheetNames)) {
                    $sheetName .= '-' . ($sheetIndex + 1);
                }
                $usedSheetNames[] = $sheetName;

                $sheet = $spreadsheet->createSheet();
                $sheet->setTitle($sheetName);

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

                $pendaftaranList = $kegiatan->pendaftaran()
                    ->with(['peserta', 'pembayaran', 'biaya'])
                    ->latest()
                    ->get();

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

                    // 5. Status Pembayaran (Lunas, Menunggu Verifikasi, Ditolak, Belum Lunas)
                    if ($statusPay === 'terverifikasi') {
                        $statusText  = 'Lunas';
                        $statusColor = 'FF059669'; // Hijau
                    } elseif ($statusPay === 'menunggu_verifikasi') {
                        $statusText  = 'Menunggu Verifikasi';
                        $statusColor = 'FF0284C7'; // Biru
                    } elseif ($statusPay === 'ditolak') {
                        $statusText  = 'Ditolak';
                        $statusColor = 'FFDC2626'; // Merah
                    } else {
                        $statusText  = 'Belum Lunas';
                        $statusColor = 'FFD97706'; // Amber / Oranye
                    }

                    $sheet->setCellValue('E' . $row, $statusText);
                    $statusStyle = $sheet->getStyle('E' . $row);
                    $statusStyle->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($statusColor));
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

                if ($pendaftaranList->isEmpty()) {
                    $sheet->mergeCells('A6:F6');
                    $sheet->setCellValue('A6', 'Belum ada data pendaftaran / pembayaran untuk kegiatan ini.');
                    $sheet->getStyle('A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }
            }

            $filename = 'laporan-pembayaran-' . \Illuminate\Support\Str::slug($judulProgram) . '-' . now()->format('YmdHis') . '.xlsx';

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
