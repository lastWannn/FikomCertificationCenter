<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Sertifikasi\{StoreSertifikasiRequest, UpdateSertifikasiRequest};
use App\Models\{Sertifikasi, Kategori};
use App\Services\Admin\SertifikasiService;

class SertifikasiController extends Controller
{
    public function __construct(private SertifikasiService $service) {}

    public function index()
    {
        return view('admin.sertifikasi.index', [
            'sertifikasi' => Sertifikasi::with('kategori')->paginate(10),
            'kategori'    => Kategori::all(),
        ]);
    }

    public function create()
    {
        return view('admin.sertifikasi.create', [
            'kategori' => Kategori::all()
        ]);
    }

    public function store(StoreSertifikasiRequest $request)
    {
        $sertifikasi = $this->service->create($request->validated());

        // Find if there is an active kegiatan associated with this sertifikasi's schedules
        $kegiatan = \App\Models\Kegiatan::whereHas('kegiatanSertifikasi.jadwalSertifikasi', function($q) use ($sertifikasi) {
            $q->where('sertifikasi_id', $sertifikasi->id);
        })->latest()->first();

        if ($kegiatan && $request->boolean('langsung_aktifkan')) {
            $initialJadwal = $sertifikasi->jadwal()->latest()->first();
            if ($initialJadwal && !empty($initialJadwal->biaya_setup)) {
                return redirect()->route('admin.kegiatan.show', $kegiatan->hashid)
                    ->with('success', 'Sertifikasi berhasil ditambahkan, langsung aktif, dan biaya diatur.');
            }
            return redirect()->route('admin.biaya.create', ['kegiatan_id' => $kegiatan->hashid])
                ->with('success', 'Sertifikasi berhasil ditambahkan dan langsung aktif. Silakan tentukan biaya pendaftarannya agar tidak terpublikasi sebagai kegiatan gratis.');
        }

        return redirect()->route('admin.sertifikasi.index')
            ->with('success', 'Sertifikasi berhasil ditambahkan.');
    }

    public function show(Sertifikasi $sertifikasi)
    {
        $sertifikasi->load(['materi', 'jadwal.kegiatanSertifikasi.kegiatan']);
        return view('admin.sertifikasi.show', [
            'sertifikasi' => $sertifikasi
        ]);
    }

    public function edit(Sertifikasi $sertifikasi)
    {
        return view('admin.sertifikasi.edit', compact('sertifikasi'), [
            'kategori' => Kategori::all()
        ]);
    }

    public function update(UpdateSertifikasiRequest $request, Sertifikasi $sertifikasi)
    {
        $this->service->update($sertifikasi, $request->validated());
        return redirect()->route('admin.sertifikasi.index')
            ->with('success', 'Sertifikasi diperbarui.');
    }

    public function destroy(Sertifikasi $sertifikasi)
    {
        $this->service->delete($sertifikasi);
        return redirect()->route('admin.sertifikasi.index')
            ->with('success', 'Sertifikasi dihapus.');
    }
}