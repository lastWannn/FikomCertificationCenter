<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Rekening\{StoreRekeningRequest, UpdateRekeningRequest};
use App\Models\Rekening;
use App\Services\Admin\RekeningService;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public function __construct(private RekeningService $service) {}

    private function checkSuperAdmin(): void
    {
        if (!auth('admin')->user()?->isSuperAdmin()) {
            abort(403, 'Akses Ditolak. Hanya Super Admin yang berhak mengelola atau mengubah nomor rekening pembayaran.');
        }
    }

    public function index(Request $request)
    {
        $query = Rekening::query();

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function($q) use ($search) {
                $q->where('bank', 'like', "%{$search}%")
                  ->orWhere('no_rekening', 'like', "%{$search}%")
                  ->orWhere('nama_pemilik', 'like', "%{$search}%");
            });
        }

        return view('admin.lainnya.rekening', [
            'rekening' => $query->orderBy('is_active', 'desc')->latest()->paginate(9)->withQueryString()
        ]);
    }

    public function create()
    {
        $this->checkSuperAdmin();
        return view('admin.lainnya.rekening-form');
    }

    public function store(StoreRekeningRequest $request)
    {
        $this->checkSuperAdmin();
        $this->service->create($request->validated());
        return redirect()->route('admin.rekening.index')
            ->with('success', 'Rekening ditambahkan.');
    }

    public function show(Rekening $rekening)
    {
        return redirect()->route('admin.rekening.index');
    }

    public function edit(Rekening $rekening)
    {
        $this->checkSuperAdmin();
        return view('admin.lainnya.rekening-form', compact('rekening'));
    }

    public function update(UpdateRekeningRequest $request, Rekening $rekening)
    {
        $this->checkSuperAdmin();
        $this->service->update($rekening, $request->validated());
        return redirect()->route('admin.rekening.index')
            ->with('success', 'Rekening diperbarui.');
    }

    public function destroy(Rekening $rekening)
    {
        $this->checkSuperAdmin();
        $this->service->delete($rekening);
        return back()->with('success', 'Rekening dihapus.');
    }

    public function aktifkan(Rekening $rekening)
    {
        $this->checkSuperAdmin();
        $this->service->aktifkan($rekening);
        return back()->with('success', 'Rekening ' . $rekening->bank . ' diaktifkan.');
    }
}