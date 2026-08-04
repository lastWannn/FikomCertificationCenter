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
        Pembayaran::updateExpiredPayments();

        $q = Pembayaran::with([
            'pendaftaran.peserta',
            'pendaftaran.kegiatan.kegiatanPelatihan.jadwalPelatihan',
            'pendaftaran.kegiatan.kegiatanSertifikasi.jadwalSertifikasi',
        ])->orderBy('created_at', 'desc');

        // Search: Nama, Email, Kode Pembayaran, Kode Unik
        if ($r->filled('q')) {
            $keyword = trim($r->q);
            $q->where(function($query) use ($keyword) {
                $query->where('kode_pembayaran', 'like', "%{$keyword}%")
                      ->orWhere('kode_unik', 'like', "%{$keyword}%")
                      ->orWhereHas('pendaftaran.peserta', function($p) use ($keyword) {
                          $p->where('nama', 'like', "%{$keyword}%")
                            ->orWhere('email', 'like', "%{$keyword}%");
                      });
            });
        }

        // Filter: Status Pembayaran
        if ($r->filled('status')) {
            if ($r->status === 'req_perpanjangan') {
                $q->where('status_perpanjangan', 'menunggu');
            } else {
                $q->where('status_pembayaran', $r->status);
            }
        }

        // Filter: Jenis Kegiatan
        if ($r->filled('jenis')) {
            $q->whereHas('pendaftaran.kegiatan', function($k) use ($r) {
                $k->where('jenis_kegiatan', $r->jenis);
            });
        }

        // Filter: Tampilkan request perpanjangan pending
        if ($r->perpanjangan === 'menunggu') {
            $q->where('status_perpanjangan', 'menunggu');
        }

        $pembayaran               = $q->paginate(15)->withQueryString();
        $countPerpanjanganPending = Pembayaran::where('status_perpanjangan', 'menunggu')->count();
        $countMenungguVerifikasi  = Pembayaran::where('status_pembayaran', 'menunggu_verifikasi')->count();

        return view('admin.lainnya.pembayaran', compact('pembayaran', 'countPerpanjanganPending', 'countMenungguVerifikasi'));
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
