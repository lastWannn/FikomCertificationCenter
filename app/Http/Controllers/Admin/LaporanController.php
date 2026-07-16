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
        $tahun  = $r->tahun ?? date('Y');
        $bulan  = $r->bulan;

        // Pendapatan per bulan
        $pendapatan = Pembayaran::selectRaw('MONTH(created_at) as bulan, SUM(jumlah_bayar) as total')
            ->where('status_pembayaran','terverifikasi')
            ->whereYear('created_at', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Pendaftaran per kegiatan
        $perKegiatan = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
        ])->withCount('pendaftaran')->orderByDesc('pendaftaran_count')->limit(10)->get();

        // Summary
        $summary = [
            'total_peserta'    => Peserta::count(),
            'total_pendaftaran'=> Pendaftaran::count(),
            'total_terverifikasi'=> Pembayaran::where('status_pembayaran','terverifikasi')->count(),
            'total_pendapatan' => Pembayaran::where('status_pembayaran','terverifikasi')->sum('jumlah_bayar'),
        ];

        $availableYears = range(date('Y'), date('Y')-3);

        return view('admin.laporan.index', compact('pendapatan','perKegiatan','summary','tahun','bulan','availableYears'));
    }

    public function exportCsv(Request $r)
    {
        $pendaftaran = Pendaftaran::with(['peserta','kegiatan','pembayaran','biaya'])
            ->when($r->kegiatan_id, fn($q) => $q->where('kegiatan_id', $r->kegiatan_id))
            ->get();

        $csv = "Nama,Email,No HP,Instansi,Kegiatan,Jenis Biaya,Nominal,Status Pendaftaran,Status Pembayaran,Tanggal Daftar
";
        foreach ($pendaftaran as $pd) {
            $csv .= implode(',', [
                '"'.($pd->peserta->nama??'').'"',
                '"'.($pd->peserta->email??'').'"',
                '"'.($pd->peserta->no_hp??'').'"',
                '"'.($pd->peserta->instansi??'').'"',
                '"'.addslashes($pd->kegiatan->judul??'').'"',
                '"'.($pd->biaya->nama_jenis??'Gratis').'"',
                '"'.($pd->biaya->nominal??0).'"',
                '"'.($pd->status_pendaftaran??'').'"',
                '"'.($pd->pembayaran->status_pembayaran??'-').'"',
                '"'.($pd->tgl_daftar?->format('d/m/Y H:i')??'').'"',
            ])."
";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan-pendaftaran-'.date('Y-m-d').'.csv"',
        ]);
    }
}
