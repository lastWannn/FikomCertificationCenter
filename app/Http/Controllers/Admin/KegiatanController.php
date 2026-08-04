<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Kegiatan\ToggleBiayaRequest;
use App\Models\Kegiatan;
use App\Services\Admin\KegiatanService;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function __construct(private KegiatanService $service) {}

    public function index(Request $r)
    {
        $query = Kegiatan::doesntHave('arsip')->with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            'biaya',
            'pendaftaran',
        ])->orderBy('created_at','desc');

        if ($r->jenis && in_array($r->jenis,['pelatihan','sertifikasi'])) {
            $query->where('jenis_kegiatan', $r->jenis);
        }

        $kegiatan = $query->paginate(12);
        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            'biaya',
            'pendaftaran.peserta',
            'pendaftaran.pembayaran',
        ]);
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function destroy(Kegiatan $kegiatan)
    {
        try {
            $this->service->delete($kegiatan);
            return redirect()->route('admin.kegiatan.index')
                ->with('success', 'Kegiatan berhasil dihapus.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function toggleBiaya(ToggleBiayaRequest $request, Kegiatan $kegiatan)
    {
        $this->service->toggleBiaya($kegiatan);
        return back()->with('success', 'Semua biaya dihapus. Kegiatan sekarang gratis.');
    }

    public function edit(Kegiatan $kegiatan)
    {
        $kegiatan->load([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            'biaya',
        ]);
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'nama_kegiatan'    => 'required|string|max:255',
            'tgl_pelaksanaan'  => 'nullable|date',
            'jam_mulai'        => 'nullable',
            'jam_selesai'      => 'nullable',
            'tgl_batas_daftar' => 'nullable|date',
            'kuota_peserta'    => 'required|integer|min:1',
            'nama_jenis_biaya' => 'nullable|array',
            'nominal_biaya'    => 'nullable|array',
        ]);

        $jadwal = $kegiatan->jadwal;
        if ($jadwal) {
            $jadwal->update([
                'nama_kegiatan'    => $request->nama_kegiatan,
                'tgl_pelaksanaan'  => $request->tgl_pelaksanaan,
                'jam_mulai'        => $request->jam_mulai,
                'jam_selesai'      => $request->jam_selesai,
                'tgl_batas_daftar' => $request->tgl_batas_daftar,
                'kuota_peserta'    => $request->kuota_peserta,
            ]);
        }

        // Sync Biaya
        $kegiatan->biaya()->delete();
        if ($request->filled('nama_jenis_biaya')) {
            foreach ($request->nama_jenis_biaya as $index => $nama) {
                if (!empty($nama) && isset($request->nominal_biaya[$index])) {
                    $kegiatan->biaya()->create([
                        'nama_jenis' => $nama,
                        'nominal'    => (float) $request->nominal_biaya[$index],
                    ]);
                }
            }
        }

        return redirect()->route('admin.kegiatan.show', $kegiatan)
            ->with('success', 'Data kegiatan berhasil diperbarui.');
    }

    public function arsipkan(Kegiatan $kegiatan)
    {
        if (!$kegiatan->arsip) {
            \App\Models\ArsipKegiatan::create([
                'kegiatan_id' => $kegiatan->id,
                'judul'       => $kegiatan->judul,
                'ringkasan'   => 'Kegiatan ' . $kegiatan->judul . ' telah selesai dilaksanakan.',
            ]);
        }
        return back()->with('success', 'Kegiatan berhasil ditandai selesai dan dipindahkan ke Arsip Kegiatan.');
    }
}

