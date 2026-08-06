<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Rekening\{StoreRekeningRequest, UpdateRekeningRequest};
use App\Models\Rekening;
use App\Services\Admin\RekeningService;

class RekeningController extends Controller
{
    public function __construct(private RekeningService $service) {}

    private function checkSuperAdmin(): void
    {
        if (!auth('admin')->user()?->isSuperAdmin()) {
            abort(403, 'Akses Ditolak. Hanya Super Admin yang berhak mengelola atau mengubah nomor rekening pembayaran.');
        }
    }

    public function index()
    {
        return view('admin.lainnya.rekening', [
            'rekening' => Rekening::paginate(9)->withQueryString()
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