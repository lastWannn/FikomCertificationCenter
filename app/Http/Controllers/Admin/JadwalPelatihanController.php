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
            $this->service->aktifkan($jadwal);
            return redirect()->route('admin.kegiatan.index')
                ->with('success','Jadwal dibuat dan langsung diaktifkan sebagai Kegiatan.');
        }
        return redirect()->route('admin.jadwal-pelatihan.index')
            ->with('success','Jadwal pelatihan berhasil ditambahkan.');
    }
    public function edit(JadwalPelatihan $jadwal) {
        return view('admin.jadwal.pelatihan-form', ['jadwal'=>$jadwal,'pelatihan'=>$jadwal->pelatihan]);
    }
    public function update(UpdateJadwalRequest $request, JadwalPelatihan $jadwal) {
        $this->service->update($jadwal, $request->validated());
        return redirect()->route('admin.jadwal-pelatihan.index')->with('success','Jadwal berhasil diperbarui.');
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
            $this->service->aktifkan($jadwal);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('admin.kegiatan.index')->with('success','Jadwal berhasil diaktifkan sebagai Kegiatan.');
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
