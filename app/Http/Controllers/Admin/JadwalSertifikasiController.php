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
        $status = $request->input('status', 'public');
        if (in_array($status, ['public', 'comingsoon', 'draf'])) {
            $kegiatan = $this->service->aktifkan($jadwal);
            $kegiatan->update(['status' => $status]);
        }
        return redirect()->route('admin.sertifikasi.show', $sertifikasi)->with('success','Jadwal berhasil ditambahkan.');
    }
    public function edit(JadwalSertifikasi $jadwal) {
        return view('admin.jadwal.sertifikasi-form', ['jadwal'=>$jadwal,'sertifikasi'=>$jadwal->sertifikasi]);
    }
    public function update(UpdateJadwalRequest $request, JadwalSertifikasi $jadwal) {
        $this->service->update($jadwal, $request->validated());
        return redirect()->route('admin.sertifikasi.show', $jadwal->sertifikasi)->with('success','Jadwal berhasil diperbarui.');
    }
    public function destroy(JadwalSertifikasi $jadwal) {
        try { $this->service->delete($jadwal); }
        catch (\RuntimeException $e) { return back()->with('error',$e->getMessage()); }
        return back()->with('success','Jadwal dihapus.');
    }
    public function aktifkan(JadwalSertifikasi $jadwal) {
        try { 
            $this->service->aktifkan($jadwal); 
            return back()->with('success', 'Jadwal sertifikasi berhasil diaktifkan sebagai kegiatan publik.');
        } catch (\RuntimeException $e) { 
            return back()->with('error', $e->getMessage()); 
        }
    }
    public function updateStatus(\Illuminate\Http\Request $request, JadwalSertifikasi $jadwal) {
        $request->validate(['status' => 'required|in:draf,comingsoon,public']);
        $ks = $jadwal->kegiatanSertifikasi;
        if ($ks && $ks->kegiatan) {
            $ks->kegiatan->update(['status' => $request->status]);
        } else {
            if (in_array($request->status, ['comingsoon', 'public'])) {
                $kegiatan = $this->service->aktifkan($jadwal);
                $kegiatan->update(['status' => $request->status]);
            }
        }
        return back()->with('success', 'Status publikasi jadwal berhasil diperbarui.');
    }

    public function nonaktifkan(JadwalSertifikasi $jadwal) {
        try { $this->service->nonaktifkan($jadwal); }
        catch (\RuntimeException $e) { return back()->with('error',$e->getMessage()); }
        return back()->with('success','Kegiatan berhasil dinonaktifkan.');
    }
}
