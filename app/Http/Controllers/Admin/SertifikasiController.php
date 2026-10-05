<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Sertifikasi\{StoreSertifikasiRequest, UpdateSertifikasiRequest};
use App\Models\{Sertifikasi, Kategori};
use App\Services\Admin\SertifikasiService;

class SertifikasiController extends Controller
{
    public function __construct(private SertifikasiService $service) {}

    public function index(\Illuminate\Http\Request $r)
    {
        $perPage = in_array((int)$r->get('per_page'), [10, 15, 25, 50, 100]) ? (int)$r->get('per_page') : 10;
        return view('admin.sertifikasi.index', [
            'sertifikasi' => Sertifikasi::with('kategori')->withCount(['jadwal', 'materi'])->latest()->paginate($perPage),
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

    public function show(Sertifikasi $sertifikasi, \Illuminate\Http\Request $r)
    {
        $sertifikasi->load(['materi']);
        $perPage = in_array((int)$r->get('per_page'), [10, 15, 25, 50, 100]) ? (int)$r->get('per_page') : 10;
        $jadwal = $sertifikasi->jadwal()
            ->with(['kegiatanSertifikasi.kegiatan.biaya'])
            ->orderBy('tgl_pelaksanaan', 'desc')
            ->paginate($perPage);
        return view('admin.sertifikasi.show', compact('sertifikasi', 'jadwal'));
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
        try {
            $this->service->delete($sertifikasi);
            return redirect()->route('admin.sertifikasi.index')
                ->with('success', 'Sertifikasi ' . $sertifikasi->judul . ' berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}