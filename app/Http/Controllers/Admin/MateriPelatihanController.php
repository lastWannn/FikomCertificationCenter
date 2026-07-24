<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Materi\{StoreMateriPelatihanRequest, UpdateMateriPelatihanRequest};
use App\Models\{MateriPelatihan, Pelatihan};
use App\Services\Admin\MateriPelatihanService;
use Illuminate\Http\Request;

class MateriPelatihanController extends Controller
{
    public function __construct(private MateriPelatihanService $service) {}

    public function index(Request $request)
    {
        $pelatihans = Pelatihan::orderBy('judul')->get();
        $selectedPelatihan = null;
        
        if ($request->has('pelatihan_id') && $request->pelatihan_id) {
            $selectedPelatihan = Pelatihan::with('materi')->find($request->pelatihan_id);
        }

        return view('admin.pelatihan.materi.index', compact('pelatihans', 'selectedPelatihan'));
    }

    public function create(Pelatihan $pelatihan)
    {
        return view('admin.materi.pelatihan-form', compact('pelatihan'));
    }

    public function store(StoreMateriPelatihanRequest $request, Pelatihan $pelatihan)
    {
        $this->service->create($pelatihan, $request->validated());
        return back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Pelatihan $pelatihan, MateriPelatihan $materi)
    {
        return view('admin.materi.pelatihan-form', compact('pelatihan', 'materi'));
    }

    public function update(UpdateMateriPelatihanRequest $request, Pelatihan $pelatihan, MateriPelatihan $materi)
    {
        $this->service->update($materi, $request->validated());
        return back()->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Pelatihan $pelatihan, MateriPelatihan $materi)
    {
        $this->service->delete($pelatihan, $materi);
        return back()->with('success', 'Materi dihapus.');
    }

    public function reorder(Request $request, Pelatihan $pelatihan)
    {
        $request->validate(['order' => 'required|array']);
        $this->service->reorder($request->order);
        return response()->json(['ok' => true]);
    }
}

