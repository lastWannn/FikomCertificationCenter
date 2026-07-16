<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Jadwal\{StoreJadwalPelatihanRequest as StoreJadwalSertifikasiRequest, UpdateJadwalRequest};
use App\Models\{JadwalSertifikasi, Sertifikasi};
use App\Services\Admin\JadwalSertifikasiService;

class JadwalSertifikasiController extends Controller
{
    public function __construct(private JadwalSertifikasiService $service) {}

    public function index(\Illuminate\Http\Request $r) {
        return view('admin.jadwal.sertifikasi', [
            'sertifikasi' => Sertifikasi::with('kategori')->get(),
            'jadwal'      => JadwalSertifikasi::with(['sertifikasi.kategori','kegiatanSertifikasi.kegiatan'])
                ->when($r->sertifikasi_id, fn($q) => $q->where('sertifikasi_id',$r->sertifikasi_id))
                ->orderBy('tgl_pelaksanaan','desc')->paginate(15),
        ]);
    }
    public function create(Sertifikasi $sertifikasi) {
        return view('admin.jadwal.sertifikasi-form', compact('sertifikasi'));
    }
    public function store(StoreJadwalSertifikasiRequest $request, Sertifikasi $sertifikasi) {
        $jadwal = $this->service->store($sertifikasi->id, $request->validated());
        if ($request->boolean('langsung_aktifkan')) {
            $this->service->aktifkan($jadwal);
            return redirect()->route('admin.kegiatan.index')->with('success','Kegiatan langsung diaktifkan.');
        }
        return redirect()->route('admin.jadwal-sertifikasi.index')->with('success','Jadwal berhasil ditambahkan.');
    }
    public function edit(JadwalSertifikasi $jadwal) {
        return view('admin.jadwal.sertifikasi-form', ['jadwal'=>$jadwal,'sertifikasi'=>$jadwal->sertifikasi]);
    }
    public function update(UpdateJadwalRequest $request, JadwalSertifikasi $jadwal) {
        $this->service->update($jadwal, $request->validated());
        return redirect()->route('admin.jadwal-sertifikasi.index')->with('success','Jadwal berhasil diperbarui.');
    }
    public function destroy(JadwalSertifikasi $jadwal) {
        try { $this->service->delete($jadwal); }
        catch (\RuntimeException $e) { return back()->with('error',$e->getMessage()); }
        return back()->with('success','Jadwal dihapus.');
    }
    public function aktifkan(JadwalSertifikasi $jadwal) {
        try { $this->service->aktifkan($jadwal); }
        catch (\RuntimeException $e) { return back()->with('error',$e->getMessage()); }
        return redirect()->route('admin.kegiatan.index')->with('success','Kegiatan berhasil diaktifkan.');
    }
    public function nonaktifkan(JadwalSertifikasi $jadwal) {
        try { $this->service->nonaktifkan($jadwal); }
        catch (\RuntimeException $e) { return back()->with('error',$e->getMessage()); }
        return back()->with('success','Kegiatan berhasil dinonaktifkan.');
    }
}
