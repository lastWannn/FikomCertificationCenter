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

        // Hanya kegiatan aktif (public & comingsoon), draf tidak pernah tampil di kegiatan aktif
        $query->visibleToPublic();

        if ($r->jenis && in_array($r->jenis,['pelatihan','sertifikasi'])) {
            $query->where('jenis_kegiatan', $r->jenis);
        }

        $totalAktif = Kegiatan::visibleToPublic()->doesntHave('arsip')->count();
        $totalPelatihan = Kegiatan::visibleToPublic()->doesntHave('arsip')->where('jenis_kegiatan', 'pelatihan')->count();
        $totalSertifikasi = Kegiatan::visibleToPublic()->doesntHave('arsip')->where('jenis_kegiatan', 'sertifikasi')->count();
        $totalPendaftar = \App\Models\Pendaftaran::whereHas('kegiatan', function($q) {
            $q->visibleToPublic()->doesntHave('arsip');
        })->count();

        $kegiatan = $query->paginate(12);
        return view('admin.kegiatan.index', compact(
            'kegiatan',
            'totalAktif',
            'totalPelatihan',
            'totalSertifikasi',
            'totalPendaftar'
        ));
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
            $isArchived = $kegiatan->arsip()->exists();
            $isPassed   = $kegiatan->isPassed();
            
            $this->service->delete($kegiatan);

            if ($isArchived) {
                $message = 'Kegiatan yang diarsip berhasil dihapus secara permanen.';
            } elseif ($isPassed) {
                $message = 'Kegiatan yang telah selesai berhasil dipindahkan ke Arsip Kegiatan.';
            } else {
                $message = 'Kegiatan berhasil dihapus.';
            }

            return redirect()->route('admin.kegiatan.index')
                ->with('success', $message);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function toggleBiaya(ToggleBiayaRequest $request, Kegiatan $kegiatan)
    {
        $this->service->toggleBiaya($kegiatan);
        $this->syncJadwalBiayaSetup($kegiatan);
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
            'nama_kegiatan'      => 'required|string|max:255',
            'tgl_pelaksanaan'    => 'nullable|date',
            'jam_mulai'          => 'nullable',
            'jam_selesai'        => 'nullable',
            'tgl_batas_daftar'   => 'nullable|date',
            'kuota_peserta'      => 'required|integer|min:1|max:500',
            'status'             => 'nullable|in:draf,comingsoon,public',
            'nama_jenis_biaya'   => 'nullable|array',
            'nama_jenis_biaya.*' => 'nullable|string|max:100',
            'nominal_biaya'      => 'nullable|array',
            'nominal_biaya.*'    => 'nullable|numeric|min:0|max:999999999',
        ], [
            'nama_kegiatan.required'  => 'Nama kegiatan wajib diisi.',
            'kuota_peserta.required'  => 'Kuota peserta wajib diisi.',
            'kuota_peserta.min'       => 'Kuota peserta minimal 1 orang.',
            'kuota_peserta.max'       => 'Kuota peserta maksimal 500 orang.',
            'nominal_biaya.*.numeric' => 'Nominal biaya harus berupa angka.',
            'nominal_biaya.*.min'     => 'Nominal biaya tidak boleh minus.',
            'nominal_biaya.*.max'     => 'Nominal biaya tidak boleh melebihi Rp 999.999.999.',
        ]);

        if ($request->filled('status')) {
            $kegiatan->update(['status' => $request->status]);
        }

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

        // Sync back to Jadwal master (biaya_setup)
        $this->syncJadwalBiayaSetup($kegiatan);

        return redirect()->back()
            ->with('success', 'Data kegiatan berhasil diperbarui.');
    }


    private function syncJadwalBiayaSetup(Kegiatan $kegiatan): void
    {
        $jadwal = $kegiatan->jadwal;
        if ($jadwal) {
            $biayaSetup = $kegiatan->biaya()->get()->map(function ($b) {
                return ['nama' => $b->nama_jenis, 'nominal' => (float) $b->nominal];
            })->values()->toArray();
            $jadwal->update(['biaya_setup' => empty($biayaSetup) ? null : $biayaSetup]);
        }
    }

    public function arsipkan(Kegiatan $kegiatan)
    {
        if (!$kegiatan->isPassed()) {
            return back()->with('error', 'Kegiatan belum selesai dilaksanakan dan tidak dapat dipindahkan ke Arsip Kegiatan.');
        }

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

