<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Jadwal\{StoreJadwalPelatihanRequest, UpdateJadwalRequest};
use App\Models\{JadwalPelatihan, Pelatihan};
use App\Services\Admin\JadwalPelatihanService;

class JadwalPelatihanController extends Controller
{
    public function __construct(private JadwalPelatihanService $service) {}

    public function index(\Illuminate\Http\Request $r) {
        return view('admin.jadwal.pelatihan', [
            'pelatihan' => Pelatihan::with(['instruktur','kategori'])->get(),
            'jadwal'    => JadwalPelatihan::with(['pelatihan.instruktur','kegiatanPelatihan.kegiatan'])
                ->when($r->pelatihan_id, fn($q) => $q->where('pelatihan_id',$r->pelatihan_id))
                ->orderBy('tgl_pelaksanaan','desc')->paginate(15),
        ]);
    }
    public function create(Pelatihan $pelatihan) {
        return view('admin.jadwal.pelatihan-form', compact('pelatihan'));
    }
    public function store(StoreJadwalPelatihanRequest $request, Pelatihan $pelatihan) {
        $jadwal = $this->service->store($pelatihan->id, $request->validated());
        if ($request->boolean('langsung_aktifkan')) {
            $kegiatan = $this->service->aktifkan($jadwal);
            if ($jadwal->nominal_biaya !== null) {
                return redirect()->route('admin.kegiatan.show', $kegiatan->hashid)->with('success', 'Jadwal ditambahkan, langsung aktif, dan biaya diatur.');
            }
            return redirect()->route('admin.biaya.create', ['kegiatan_id' => $kegiatan->hashid])
                ->with('success', 'Jadwal ditambahkan dan langsung aktif. Silakan tentukan biaya pendaftarannya agar tidak terpublikasi sebagai kegiatan gratis.');
        }
        return redirect()->route('admin.pelatihan.show', $pelatihan->id)
            ->with('success','Jadwal pelatihan berhasil ditambahkan.');
    }
    public function edit(JadwalPelatihan $jadwal) {
        return view('admin.jadwal.pelatihan-form', ['jadwal'=>$jadwal,'pelatihan'=>$jadwal->pelatihan]);
    }
    public function update(UpdateJadwalRequest $request, JadwalPelatihan $jadwal) {
        $this->service->update($jadwal, $request->validated());
        return redirect()->route('admin.pelatihan.show', $jadwal->pelatihan_id)->with('success','Jadwal berhasil diperbarui.');
    }
    public function destroy(JadwalPelatihan $jadwal) {
        try {
            $this->service->delete($jadwal);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success','Jadwal dihapus.');
    }
    public function aktifkan(JadwalPelatihan $jadwal) {
        try {
            $kegiatan = $this->service->aktifkan($jadwal);
            if ($jadwal->nominal_biaya !== null) {
                return redirect()->route('admin.kegiatan.show', $kegiatan->hashid)->with('success', 'Kegiatan berhasil diaktifkan.');
            }
            return redirect()->route('admin.biaya.create', ['kegiatan_id' => $kegiatan->hashid])
                ->with('success', 'Kegiatan berhasil diaktifkan. Silakan tentukan biaya pendaftarannya agar tidak terpublikasi sebagai kegiatan gratis.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function nonaktifkan(JadwalPelatihan $jadwal) {
        try {
            $this->service->nonaktifkan($jadwal);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success','Kegiatan berhasil dinonaktifkan.');
    }
}
