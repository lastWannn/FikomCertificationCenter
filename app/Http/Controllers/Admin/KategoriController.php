<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Kategori\{StoreKategoriRequest, UpdateKategoriRequest};
use App\Models\Kategori;
use App\Services\Admin\KategoriService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct(private KategoriService $service) {}

    public function index()
    {
        return view('admin.kategori.index', [
            'kategori' => Kategori::withCount(['pelatihan', 'sertifikasi'])->orderBy('nama_kategori')->get(),
        ]);
    }

    public function store(StoreKategoriRequest $request)
    {
        $this->service->create($request->validated());
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(UpdateKategoriRequest $request, string $hashid)
    {
        $this->service->update($hashid, $request->validated());
        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(string $hashid, Request $request)
    {
        try {
            $this->service->delete($hashid);
            return back()->with('success', 'Kategori dihapus.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create() { return redirect()->route('admin.kategori.index'); }
    public function edit(string $hashid) { return redirect()->route('admin.kategori.index'); }
    public function show(string $hashid) { return redirect()->route('admin.kategori.index'); }
}
