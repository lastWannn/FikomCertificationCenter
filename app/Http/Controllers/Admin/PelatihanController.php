<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pelatihan\{StorePelatihanRequest, UpdatePelatihanRequest};
use App\Models\{Pelatihan, Kategori, Instruktur};
use App\Services\Admin\PelatihanService;

class PelatihanController extends Controller
{
    public function __construct(private PelatihanService $service) {}

    public function index() {
        return view('admin.pelatihan.index', [
            'pelatihan'  => Pelatihan::with(['kategori','instruktur'])->paginate(10),
            'kategori'   => Kategori::all(),
            'instruktur' => Instruktur::all(),
        ]);
    }
    public function create() {
        return view('admin.pelatihan.create', [
            'kategori'   => Kategori::all(),
            'instruktur' => Instruktur::all(),
        ]);
    }
    public function store(StorePelatihanRequest $request) {
        $data = $request->validated();
        if ($request->hasFile('gambar')) $data['gambar'] = $request->file('gambar');
        $pelatihan = $this->service->create($data);
        
        // Find if there is an active kegiatan associated with this pelatihan's schedules
        $kegiatan = \App\Models\Kegiatan::whereHas('kegiatanPelatihan.jadwalPelatihan', function($q) use ($pelatihan) {
            $q->where('pelatihan_id', $pelatihan->id);
        })->latest()->first();

        if ($kegiatan && $request->boolean('langsung_aktifkan')) {
            $initialJadwal = $pelatihan->jadwal()->latest()->first();
            if ($initialJadwal && !empty($initialJadwal->biaya_setup)) {
                return redirect()->route('admin.kegiatan.show', $kegiatan->hashid)
                    ->with('success', 'Pelatihan berhasil ditambahkan, langsung aktif, dan biaya diatur.');
            }
            return redirect()->route('admin.biaya.create', ['kegiatan_id' => $kegiatan->hashid])
                ->with('success', 'Pelatihan berhasil ditambahkan dan langsung aktif. Silakan tentukan biaya pendaftarannya agar tidak terpublikasi sebagai kegiatan gratis.');
        }

        return redirect()->route('admin.pelatihan.index')
            ->with('success', 'Pelatihan berhasil ditambahkan.');
    }
    public function show(Pelatihan $pelatihan) {
        $pelatihan->load(['materi', 'jadwal.kegiatanPelatihan.kegiatan']);
        return view('admin.pelatihan.show', compact('pelatihan'));
    }
    public function edit(Pelatihan $pelatihan) {
        return view('admin.pelatihan.edit', array_merge(compact('pelatihan'), [
            'kategori'   => Kategori::all(),
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
