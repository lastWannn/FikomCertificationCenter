<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Nilai\StoreNilaiRequest;
use App\Models\{Nilai, Pendaftaran, Kegiatan};
use App\Services\Admin\NilaiService;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function __construct(private NilaiService $service) {}

    public function index(Request $r) {
        $kegiatan    = Kegiatan::all();
        $pendaftaran = collect();
        if ($r->kegiatan_id) {
            $pendaftaran = Pendaftaran::with(['peserta','nilai','kegiatan'])
                ->where('kegiatan_id',$r->kegiatan_id)->where('status_pendaftaran','terdaftar')->paginate(20);
        }
        return view('admin.nilai.index', compact('kegiatan','pendaftaran'));
    }
    public function show(Pendaftaran $pendaftaran) {
        $pendaftaran->load(['peserta','kegiatan','nilai.materiPelatihan','nilai.materiSertifikasi']);
        return view('admin.nilai.show', compact('pendaftaran'));
    }
    /** FIX: Menggunakan NilaiService yang sudah memperbaiki bug kolom materi_pel_id */
    public function store(StoreNilaiRequest $request, Pendaftaran $pendaftaran) {
        $jadwal = $pendaftaran->kegiatan?->jadwal;
        if ($jadwal && $jadwal->tgl_pelaksanaan && $jadwal->tgl_pelaksanaan->gt(now()->startOfDay())) {
            return back()->with('error', 'Penilaian tidak dapat dilakukan karena kegiatan belum dimulai (Tanggal Pelaksanaan: ' . $jadwal->tgl_pelaksanaan->format('d M Y') . ').');
        }

        $count = $this->service->simpan($pendaftaran, $request->validated()['nilai']);
        return back()->with('success', "{$count} nilai berhasil disimpan.");
    }
    public function update(Request $r, Nilai $nilai) {
        $r->validate(['nilai'=>'required|numeric|min:0|max:100']);
        $this->service->update($nilai, $r->nilai, $r->keterangan);
        return back()->with('success','Nilai diperbarui.');
    }

    /**
     * Memindai ulang transkrip nilai PDF secara on-demand via AJAX request
     */
    public function rescanTranskrip(Pendaftaran $pendaftaran)
    {
        if (empty($pendaftaran->transkrip_nilai)) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta belum mengunggah dokumen transkrip nilai.',
            ], 400);
        }

        $filePath = null;
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($pendaftaran->transkrip_nilai)) {
            $filePath = \Illuminate\Support\Facades\Storage::disk('public')->path($pendaftaran->transkrip_nilai);
        } elseif (file_exists(storage_path('app/public/' . $pendaftaran->transkrip_nilai))) {
            $filePath = storage_path('app/public/' . $pendaftaran->transkrip_nilai);
        } elseif (file_exists(public_path('storage/' . $pendaftaran->transkrip_nilai))) {
            $filePath = public_path('storage/' . $pendaftaran->transkrip_nilai);
        }

        if (!$filePath || !file_exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'Berkas transkrip nilai tidak ditemukan pada server penyimpanan.',
            ], 404);
        }

        $result = app(\App\Services\Peserta\TranskripParserService::class)->parseAndPopulateNilai(
            $pendaftaran,
            $filePath
        );

        $pendaftaran->load('nilai');

        return response()->json([
            'success'       => $result['success'] ?? false,
            'message'       => $result['message'] ?? 'Pemindaian selesai.',
            'matched_count' => $result['matched_count'] ?? 0,
            'matched'       => $result['matched'] ?? [],
            'nilai'         => $pendaftaran->nilai,
        ]);
    }
}
