<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Sertifikat, Pendaftaran, Kegiatan};
use App\Services\Admin\SertifikatService;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    public function __construct(private SertifikatService $service) {}

    public function index() {
        return view('admin.sertifikat.index', [
            'sertifikat' => Sertifikat::with(['pendaftaran.peserta','pendaftaran.kegiatan'])->paginate(15),
            'kegiatan'   => Kegiatan::all(),
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
        return back()->with('success','Template latar berhasil diunggah.');
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
