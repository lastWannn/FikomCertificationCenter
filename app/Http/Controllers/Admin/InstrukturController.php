<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Instruktur\{StoreInstrukturRequest, UpdateInstrukturRequest};
use App\Models\Instruktur;
use App\Services\Admin\InstrukturService;

class InstrukturController extends Controller
{
    public function __construct(private InstrukturService $service) {}

    /** Halaman utama instruktur — menggunakan Livewire component */
    public function liveIndex()
    {
        return view('admin.instruktur.livewire-index');
    }

    public function index() {
        return view('admin.instruktur.index', [
            'instruktur' => Instruktur::withCount('pelatihan')->orderBy('nama')->paginate(15)
        ]);
    }
    public function create() { return view('admin.instruktur.form'); }

    public function store(StoreInstrukturRequest $request) {
        $this->service->create($request->validated());
        return redirect()->route('admin.instruktur.index')
            ->with('success', 'Instruktur berhasil ditambahkan.');
    }
    public function show(Instruktur $instruktur) { return view('admin.instruktur.form', compact('instruktur')); }
    public function edit(Instruktur $instruktur)  { return view('admin.instruktur.form', compact('instruktur')); }

    public function update(UpdateInstrukturRequest $request, Instruktur $instruktur) {
        $this->service->update($instruktur, $request->validated());
        return redirect()->route('admin.instruktur.index')
            ->with('success', 'Data instruktur berhasil diperbarui.');
    }
    public function destroy(Instruktur $instruktur) {
        try {
            $this->service->delete($instruktur);
            return back()->with('success', 'Instruktur dihapus.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
