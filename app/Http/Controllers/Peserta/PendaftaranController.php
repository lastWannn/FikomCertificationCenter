<?php
namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Http\Requests\Peserta\StorePendaftaranRequest;
use App\Models\{Kegiatan, Pendaftaran};
use App\Services\Peserta\PendaftaranService;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function __construct(private PendaftaranService $service) {}

    public function index()
    {
        $pesertaId   = Auth::guard('peserta')->id();
        $pendaftaran = Pendaftaran::where('peserta_id', $pesertaId)
            ->with(['kegiatan', 'biaya', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('peserta.pendaftaran', compact('pendaftaran'));
    }

    public function store(StorePendaftaranRequest $request, Kegiatan $kegiatan)
    {
        try {
            $pendaftaran = $this->service->daftar(
                Auth::guard('peserta')->id(),
                $kegiatan,
                $request->biaya_kegiatan_id
            );
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        if ($pendaftaran->biaya_kegiatan_id) {
            return redirect()->route('peserta.pembayaran')
                ->with('success', 'Pendaftaran berhasil! Segera lakukan pembayaran dalam 2 jam.');
        }
        return redirect()->route('peserta.pendaftaran')
            ->with('success', 'Pendaftaran berhasil! Kegiatan gratis, Anda langsung terdaftar.');
    }

    /**
     * FIX KRITIS: Sebelumnya pakai `int $id` + query manual.
     * Route `{pendaftaran}` menggunakan HasHashid model binding —
     * parameter harus diketik `Pendaftaran $pendaftaran` agar
     * Laravel memanggil resolveRouteBinding() untuk decode hashid.
     * Cek kepemilikan dilakukan manual setelah model di-resolve.
     */
    public function show(Pendaftaran $pendaftaran)
    {
        // Pastikan pendaftaran milik peserta yang sedang login
        if ($pendaftaran->peserta_id !== Auth::guard('peserta')->id()) {
            abort(403, 'Akses ditolak.');
        }

        $pendaftaran->load(['kegiatan', 'biaya', 'pembayaran']);
        return view('peserta.pendaftaran-detail', compact('pendaftaran'));
    }
}
