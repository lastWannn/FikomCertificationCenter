<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Materi\{StoreMateriSertifikasiRequest, UpdateMateriSertifikasiRequest};
use App\Models\{MateriSertifikasi, Sertifikasi};
use App\Services\Admin\MateriSertifikasiService;

class MateriSertifikasiController extends Controller
{
    public function __construct(private MateriSertifikasiService $service) {}

    public function create(Sertifikasi $sertifikasi)
    {
        return view('admin.materi.sertifikasi-form', compact('sertifikasi'));
    }

    public function store(StoreMateriSertifikasiRequest $request, Sertifikasi $sertifikasi)
    {
        $this->service->create($sertifikasi, $request->validated());
        return redirect()->route('admin.sertifikasi.show', $sertifikasi->id)
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Sertifikasi $sertifikasi, MateriSertifikasi $materi)
    {
        return view('admin.materi.sertifikasi-form', compact('sertifikasi', 'materi'));
    }

    public function update(UpdateMateriSertifikasiRequest $request, Sertifikasi $sertifikasi, MateriSertifikasi $materi)
    {
        $this->service->update($materi, $request->validated());
        return redirect()->route('admin.sertifikasi.show', $sertifikasi->id)
            ->with('success', 'Materi diperbarui.');
    }

    public function destroy(Sertifikasi $sertifikasi, MateriSertifikasi $materi)
    {
        $this->service->delete($materi);
        return back()->with('success', 'Materi dihapus.');
    }
}

