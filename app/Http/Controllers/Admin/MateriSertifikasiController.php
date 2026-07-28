<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Materi\{StoreMateriSertifikasiRequest, UpdateMateriSertifikasiRequest};
use App\Models\{MateriSertifikasi, Sertifikasi};
use App\Services\Admin\MateriSertifikasiService;
use Illuminate\Http\Request;

class MateriSertifikasiController extends Controller
{
    public function __construct(private MateriSertifikasiService $service) {}

    public function index(Request $request)
    {
        $sertifikasis = Sertifikasi::orderBy('judul')->get();
        $selectedSertifikasi = null;
        
        if ($request->has('sertifikasi_id') && $request->sertifikasi_id) {
            $selectedSertifikasi = Sertifikasi::with('materi')->find($request->sertifikasi_id);
        }

        return view('admin.sertifikasi.materi.index', compact('sertifikasis', 'selectedSertifikasi'));
    }

    public function create(Sertifikasi $sertifikasi)
    {
        return view('admin.materi.sertifikasi-form', compact('sertifikasi'));
    }

    public function store(StoreMateriSertifikasiRequest $request, Sertifikasi $sertifikasi)
    {
        $this->service->create($sertifikasi, $request->validated());
        return back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Sertifikasi $sertifikasi, MateriSertifikasi $materi)
    {
        return view('admin.materi.sertifikasi-form', compact('sertifikasi', 'materi'));
    }

    public function update(UpdateMateriSertifikasiRequest $request, Sertifikasi $sertifikasi, MateriSertifikasi $materi)
    {
        $this->service->update($materi, $request->validated());
        return back()->with('success', 'Materi diperbarui.');
    }

    public function destroy(Sertifikasi $sertifikasi, MateriSertifikasi $materi)
    {
        $this->service->delete($materi);
        return back()->with('success', 'Materi dihapus.');
    }
}

