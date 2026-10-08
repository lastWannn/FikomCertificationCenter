<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Kategori\{StoreKategoriRequest, UpdateKategoriRequest};
use App\Models\Kategori;
use App\Models\Pelatihan;
use App\Models\Sertifikasi;
use App\Services\Admin\KategoriService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct(private KategoriService $service) {}

    public function index(Request $request)
    {
        $query = Kategori::withCount(['pelatihan', 'sertifikasi']);

        if ($search = trim((string) $request->input('search'))) {
            $query->where('nama_kategori', 'like', "%{$search}%");
        }

        $kategori = $query->orderBy('nama_kategori')->paginate(10)->withQueryString();

        $totalKategori = Kategori::count();
        $totalPelatihan = Pelatihan::whereNotNull('kategori_id')->count();
        $totalSertifikasi = Sertifikasi::whereNotNull('kategori_id')->count();

        return view('admin.kategori.index', [
            'kategori' => $kategori,
            'totalKategori' => $totalKategori,
            'totalPelatihan' => $totalPelatihan,
            'totalSertifikasi' => $totalSertifikasi,
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
