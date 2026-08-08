<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Arsip\{StoreArsipRequest, UpdateArsipRequest};
use App\Models\{ArsipKegiatan, Kegiatan};
use App\Services\Admin\ArsipService;

class ArsipController extends Controller
{
    public function __construct(private ArsipService $service) {}

    public function index()
    {
        $this->service->autoArchiveCompleted();

        return view('admin.lainnya.arsip', [
            'arsip' => ArsipKegiatan::with('kegiatan')->paginate(10)
        ]);
    }

    public function create()
    {
        return view('admin.lainnya.arsip-form', [
            'kegiatan' => Kegiatan::doesntHave('arsip')->get()
        ]);
    }

    public function store(StoreArsipRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('admin.arsip.index')
            ->with('success', 'Arsip dibuat.');
    }

    public function show(ArsipKegiatan $arsip)
    {
        return view('admin.lainnya.arsip-form', compact('arsip'));
    }

    public function edit(ArsipKegiatan $arsip)
    {
        return view('admin.lainnya.arsip-form', compact('arsip'), [
            'kegiatan' => Kegiatan::all()
        ]);
    }

    public function update(UpdateArsipRequest $request, ArsipKegiatan $arsip)
    {
        $this->service->update($arsip, $request->validated());
        return redirect()->route('admin.arsip.index')
            ->with('success', 'Arsip diperbarui.');
    }

    public function destroy(ArsipKegiatan $arsip)
    {
        $this->service->delete($arsip);
        return back()->with('success', 'Arsip dihapus.');
    }

    public function uploadFoto(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'foto' => 'required|file|mimes:jpeg,jpg,png,webp,heic,heif|max:40960',
        ]);

        $path = \App\Helpers\ImageHelper::compressToWebp($request->file('foto'), 'arsip-dokumentasi');
        if ($path) {
            return response()->json([
                'success' => true,
                'path'    => $path,
                'url'     => asset('storage/' . $path),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengompresi foto.'], 422);
    }
}