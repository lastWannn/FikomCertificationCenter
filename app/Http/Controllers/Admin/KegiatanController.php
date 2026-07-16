<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Kegiatan, BiayaKegiatan};
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
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
        if ($kegiatan->pendaftaran()->whereIn('status_pendaftaran',['terdaftar','menunggu_verifikasi'])->count() > 0) {
            return back()->with('error', 'Kegiatan tidak bisa dihapus. Masih ada peserta aktif.');
        }
        $kegiatan->delete();
        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function toggleBiaya(Request $r, Kegiatan $kegiatan)
    {
        // Toggle gratis/berbayar: hapus semua biaya → jadi gratis
        $r->validate(['aksi' => 'required|in:hapus_semua']);
        $kegiatan->biaya()->delete();
        return back()->with('success', 'Semua biaya dihapus. Kegiatan sekarang gratis.');
    }
}
