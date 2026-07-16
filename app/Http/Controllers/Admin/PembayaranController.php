<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pembayaran\{
    VerifikasiPembayaranRequest, TolakPembayaranRequest,
    ApprovePerpanjanganRequest, TolakPerpanjanganRequest,
};
use App\Models\Pembayaran;
use App\Services\Admin\PembayaranService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function __construct(private PembayaranService $service) {}

    public function index(Request $r)
    {
        $q = Pembayaran::with(['pendaftaran.peserta', 'pendaftaran.kegiatan'])
            ->orderBy('created_at', 'desc');

        if ($r->status) $q->where('status_pembayaran', $r->status);

        // Filter: tampilkan request perpanjangan pending
        if ($r->perpanjangan === 'menunggu') {
            $q->where('status_perpanjangan', 'menunggu');
        }

        $pembayaran           = $q->paginate(15);
        $countPerpanjanganPending = Pembayaran::where('status_perpanjangan', 'menunggu')->count();

        return view('admin.lainnya.pembayaran', compact('pembayaran', 'countPerpanjanganPending'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->checkAndUpdateExpiry();
        return view('admin.lainnya.pembayaran-detail', compact('pembayaran'));
    }

    /* ── Verifikasi & Tolak Pembayaran ────────────────────── */
    public function verifikasi(VerifikasiPembayaranRequest $request, Pembayaran $pembayaran)
    {
        $this->service->verifikasi($pembayaran, $request->no_kwitansi);
        return back()->with('success', 'Pembayaran terverifikasi. Email konfirmasi terkirim ke peserta.');
    }

    public function tolak(TolakPembayaranRequest $request, Pembayaran $pembayaran)
    {
        $this->service->tolak($pembayaran, $request->alasan);
        return back()->with('success', 'Pembayaran ditolak. Peserta telah diberitahu via email.');
    }

    public function perpanjang(Request $r, Pembayaran $pembayaran)
    {
        $this->service->perpanjang($pembayaran);
        return back()->with('success', 'Kode diperpanjang +2 jam.');
    }

    /* ── Approve & Tolak Perpanjangan ─────────────────────── */
    public function approvePerpanjangan(ApprovePerpanjanganRequest $request, Pembayaran $pembayaran)
    {
        if ($pembayaran->status_perpanjangan !== 'menunggu') {
            return back()->with('error', 'Tidak ada permintaan perpanjangan aktif.');
        }
        $this->service->approvePerpanjangan(
            $pembayaran,
            (int) $request->jam_tambah,
            $request->catatan
        );
        return back()->with('success', "Perpanjangan +{$request->jam_tambah} jam disetujui. Email terkirim ke peserta.");
    }

    public function tolakPerpanjangan(TolakPerpanjanganRequest $request, Pembayaran $pembayaran)
    {
        if ($pembayaran->status_perpanjangan !== 'menunggu') {
            return back()->with('error', 'Tidak ada permintaan perpanjangan aktif.');
        }
        $this->service->tolakPerpanjangan($pembayaran, $request->catatan);
        return back()->with('success', 'Permintaan perpanjangan ditolak. Peserta telah diberitahu.');
    }
}
