<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Biaya\{StoreBiayaRequest, UpdateBiayaRequest};
use App\Models\{BiayaKegiatan, Kegiatan};
use App\Services\Admin\BiayaService;

class BiayaController extends Controller
{
    public function __construct(private BiayaService $service) {}

    public function index()
    {
        return view('admin.lainnya.biaya', [
            'biaya' => BiayaKegiatan::with('kegiatan')->paginate(15)
        ]);
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $selectedKegiatanId = $request->query('kegiatan_id');
        if ($selectedKegiatanId && !is_numeric($selectedKegiatanId)) {
            $selectedKegiatanId = Kegiatan::decodeHashid($selectedKegiatanId);
        }

        return view('admin.lainnya.biaya-form', [
            'kegiatan' => Kegiatan::all(),
            'selected_kegiatan_id' => $selectedKegiatanId
        ]);
    }

    public function store(StoreBiayaRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('admin.biaya.index')
            ->with('success', 'Biaya ditambahkan.');
    }

    public function show(BiayaKegiatan $biaya)
    {
        return redirect()->route('admin.biaya.index');
    }

    public function edit(BiayaKegiatan $biaya)
    {
        return view('admin.lainnya.biaya-form', [
            'biaya' => $biaya,
            'kegiatan' => Kegiatan::all()
        ]);
    }

    public function update(UpdateBiayaRequest $request, BiayaKegiatan $biaya)
    {
        $this->service->update($biaya, $request->validated());
        return redirect()->route('admin.biaya.index')
            ->with('success', 'Biaya diperbarui.');
    }

    public function destroy(BiayaKegiatan $biaya)
    {
        $this->service->delete($biaya);
        return back()->with('success', 'Biaya dihapus.');
    }
}