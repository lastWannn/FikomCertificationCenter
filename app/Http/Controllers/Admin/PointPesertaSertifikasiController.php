<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSertifikasi;
use App\Models\Pendaftaran;
use App\Models\Nilai;
use Illuminate\Http\Request;

class PointPesertaSertifikasiController extends Controller
{
    public function index()
    {
        $jadwal = JadwalSertifikasi::with(['sertifikasi', 'kegiatan.pendaftaran'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.sertifikasi.point.index', compact('jadwal'));
    }

    public function show($jadwal_id)
    {
        $jadwal = JadwalSertifikasi::with(['sertifikasi.materi'])->findOrFail($jadwal_id);
        
        $pendaftaran = Pendaftaran::with(['peserta', 'nilai'])
            ->whereHas('kegiatan.kegiatanSertifikasi', function($q) use ($jadwal) {
                $q->where('jadwal_sertifikasi_id', $jadwal->id);
            })
            ->whereIn('status_pendaftaran', ['terdaftar', 'lulus', 'tidak_lulus'])
            ->get();

        return view('admin.sertifikasi.point.show', compact('jadwal', 'pendaftaran'));
    }

    public function update(Request $request, $jadwal_id, $pendaftaran_id)
    {
        $jadwal = JadwalSertifikasi::findOrFail($jadwal_id);
        if ($jadwal->tgl_pelaksanaan && $jadwal->tgl_pelaksanaan->gt(now()->startOfDay())) {
            return back()->with('error', 'Penilaian tidak dapat dilakukan karena sertifikasi belum dimulai (Tanggal Pelaksanaan: ' . $jadwal->tgl_pelaksanaan->format('d M Y') . ').');
        }

        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->nilai as $materi_id => $score) {
            if ($score !== null) {
                Nilai::updateOrCreate(
                    [
                        'pendaftaran_id' => $pendaftaran_id,
                        'materi_sertifikasi_id' => $materi_id,
                    ],
                    [
                        'nilai' => $score
                    ]
                );
            }
        }

        return redirect()->route('admin.sertifikasi.point.show', $jadwal_id)
            ->with('success', 'Nilai peserta sertifikasi berhasil disimpan.');
    }
}
