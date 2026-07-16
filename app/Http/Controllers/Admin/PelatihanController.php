<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pelatihan\{StorePelatihanRequest, UpdatePelatihanRequest};
use App\Models\{Pelatihan, KategoriPelatihan, Instruktur};
use App\Services\Admin\PelatihanService;

class PelatihanController extends Controller
{
    public function __construct(private PelatihanService $service) {}

    public function index() {
        return view('admin.pelatihan.index', [
            'pelatihan' => Pelatihan::with(['kategori','instruktur'])->paginate(10)
        ]);
    }
    public function create() {
        return view('admin.pelatihan.create', [
            'kategori'   => KategoriPelatihan::all(),
            'instruktur' => Instruktur::all(),
        ]);
    }
    public function store(StorePelatihanRequest $request) {
        $data = $request->validated();
        if ($request->hasFile('gambar')) $data['gambar'] = $request->file('gambar');
        $this->service->create($data);
        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Pelatihan berhasil ditambahkan.');
    }
    public function show(Pelatihan $pelatihan) {
        return view('admin.pelatihan.show', compact('pelatihan'));
    }
    public function edit(Pelatihan $pelatihan) {
        return view('admin.pelatihan.edit', array_merge(compact('pelatihan'), [
            'kategori'   => KategoriPelatihan::all(),
            'instruktur' => Instruktur::all(),
        ]));
    }
    public function update(UpdatePelatihanRequest $request, Pelatihan $pelatihan) {
        $data = $request->validated();
        if ($request->hasFile('gambar')) $data['gambar'] = $request->file('gambar');
        $this->service->update($pelatihan, $data);
        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Pelatihan berhasil diperbarui.');
    }
    public function destroy(Pelatihan $pelatihan) {
        $this->service->delete($pelatihan);
        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Pelatihan berhasil dihapus.');
    }
}
