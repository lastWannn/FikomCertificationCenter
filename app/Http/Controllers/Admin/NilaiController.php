<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Nilai\StoreNilaiRequest;
use App\Models\{Nilai, Pendaftaran, Kegiatan};
use App\Services\Admin\NilaiService;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function __construct(private NilaiService $service) {}

    public function index(Request $r) {
        $kegiatan    = Kegiatan::all();
        $pendaftaran = collect();
        if ($r->kegiatan_id) {
            $pendaftaran = Pendaftaran::with(['peserta','nilai','kegiatan'])
                ->where('kegiatan_id',$r->kegiatan_id)->where('status_pendaftaran','terdaftar')->paginate(20);
        }
        return view('admin.nilai.index', compact('kegiatan','pendaftaran'));
    }
    public function show(Pendaftaran $pendaftaran) {
        $pendaftaran->load(['peserta','kegiatan','nilai.materiPelatihan','nilai.materiSertifikasi']);
        return view('admin.nilai.show', compact('pendaftaran'));
    }
    /** FIX: Menggunakan NilaiService yang sudah memperbaiki bug kolom materi_pel_id */
    public function store(StoreNilaiRequest $request, Pendaftaran $pendaftaran) {
        $jadwal = $pendaftaran->kegiatan?->jadwal;
        if ($jadwal && $jadwal->tgl_pelaksanaan && $jadwal->tgl_pelaksanaan->gt(now()->startOfDay())) {
            return back()->with('error', 'Penilaian tidak dapat dilakukan karena kegiatan belum dimulai (Tanggal Pelaksanaan: ' . $jadwal->tgl_pelaksanaan->format('d M Y') . ').');
        }

        $count = $this->service->simpan($pendaftaran, $request->validated()['nilai']);
        return back()->with('success', "{$count} nilai berhasil disimpan.");
    }
    public function update(Request $r, Nilai $nilai) {
        $r->validate(['nilai'=>'required|numeric|min:0|max:100']);
        $this->service->update($nilai, $r->nilai, $r->keterangan);
        return back()->with('success','Nilai diperbarui.');
    }
}
