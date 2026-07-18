<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Kegiatan\ToggleBiayaRequest;
use App\Models\Kegiatan;
use App\Services\Admin\KegiatanService;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function __construct(private KegiatanService $service) {}

    public function index(Request $r)
    {
        $query = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan.instruktur',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            'biaya',
            'pendaftaran',
        ])->orderBy('created_at','desc');

        if ($r->jenis && in_array($r->jenis,['pelatihan','sertifikasi'])) {
            $query->where('jenis_kegiatan', $r->jenis);
        }

        $kegiatan = $query->paginate(12);
        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan.instruktur',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            'biaya',
            'pendaftaran.peserta',
            'pendaftaran.pembayaran',
        ]);
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function destroy(Kegiatan $kegiatan)
    {
        try {
            $this->service->delete($kegiatan);
            return redirect()->route('admin.kegiatan.index')
                ->with('success', 'Kegiatan berhasil dihapus.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function toggleBiaya(ToggleBiayaRequest $request, Kegiatan $kegiatan)
    {
        $this->service->toggleBiaya($kegiatan);
        return back()->with('success', 'Semua biaya dihapus. Kegiatan sekarang gratis.');
    }
}

