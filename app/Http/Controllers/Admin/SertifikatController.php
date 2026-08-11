<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Sertifikat, Pendaftaran, Kegiatan};
use App\Services\Admin\SertifikatService;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    public function __construct(private SertifikatService $service) {}

    public function index(Request $r) {
        $kegiatanList = Kegiatan::latest()->get();
        if ($kegiatanList->isEmpty()) {
            $kegiatanList = Kegiatan::whereHas('pendaftaran', fn($q) => $q->where('status_pendaftaran', 'terdaftar'))->get();
        }
        $kegiatanUnique = $kegiatanList->unique(fn($k) => trim($k->judul))->values();

        $query = Sertifikat::with(['pendaftaran.peserta','pendaftaran.kegiatan'])->latest();

        if ($r->filled('q')) {
            $qStr = '%' . trim($r->q) . '%';
            $query->where(function($sub) use ($qStr) {
                $sub->where('nomor_sertifikat', 'like', $qStr)
                    ->orWhereHas('pendaftaran.peserta', fn($p) => $p->where('nama', 'like', $qStr)->orWhere('email', 'like', $qStr));
            });
        }

        if ($r->filled('filter_kegiatan')) {
            $query->whereHas('pendaftaran', fn($p) => $p->where('kegiatan_id', $r->filter_kegiatan));
        }

        $sertifikat = $query->paginate(10)->withQueryString();

        return view('admin.sertifikat.index', [
            'sertifikat' => $sertifikat,
            'kegiatan'   => $kegiatanUnique,
        ]);
    }
    public function peserta(Kegiatan $kegiatan) {
        $kegiatan->load(['kegiatanPelatihan.jadwalPelatihan.pelatihan','kegiatanSertifikasi.jadwalSertifikasi.sertifikasi']);
        $pendaftaran = Pendaftaran::where('kegiatan_id',$kegiatan->id)->with(['peserta','sertifikat'])->orderBy('status_pendaftaran')->get();
        return view('admin.sertifikat.peserta', compact('kegiatan','pendaftaran'));
    }
    public function uploadLatar(Request $r) {
        $r->validate(['kegiatan_id'=>'required','latar'=>'required|image|max:5120']);
        $this->service->uploadLatar($r->kegiatan_id, $r->file('latar'));
        return back()->with('success','Template latar berhasil diunggah.')->with('uploaded_kegiatan_id', (int)$r->kegiatan_id);
    }
    public function terbitkan(Request $r, Pendaftaran $pendaftaran) {
        $r->validate(['tgl_terbit'=>'required|date']);
        $this->service->terbitkan($pendaftaran, $r->tgl_terbit);
        return back()->with('success','Sertifikat berhasil diterbitkan.');
    }
    public function terbitkanSemua(Request $r, Kegiatan $kegiatan) {
        $r->validate(['tgl_terbit'=>'required|date']);
        $count = $this->service->terbitkanSemua($kegiatan, $r->tgl_terbit);
        return back()->with('success', "{$count} sertifikat berhasil diterbitkan.");
    }
}
