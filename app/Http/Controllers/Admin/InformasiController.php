<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Informasi\{StoreInformasiRequest, UpdateInformasiRequest};
use App\Models\Informasi;
use App\Services\Admin\InformasiService;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function __construct(private InformasiService $service) {}

    public function index(Request $request)
    {
        $q = Informasi::with('admin')->orderBy('created_at', 'desc');
        if ($request->jenis) {
            $q->where('jenis', $request->jenis);
        }
        return view('admin.lainnya.informasi', [
            'informasi' => $q->paginate(15)
        ]);
    }

    public function create()
    {
        return redirect()->route('admin.informasi.index');
    }

    public function store(StoreInformasiRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi ditambahkan.');
    }

    public function show(Informasi $informasi)
    {
        return redirect()->route('admin.informasi.index');
    }

    public function edit(Informasi $informasi)
    {
        return redirect()->route('admin.informasi.index');
    }

    public function update(UpdateInformasiRequest $request, Informasi $informasi)
    {
        $this->service->update($informasi, $request->validated());
        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi diperbarui.');
    }

    public function destroy(Informasi $informasi)
    {
        $this->service->delete($informasi);
        return back()->with('success', 'Informasi dihapus.');
    }
}