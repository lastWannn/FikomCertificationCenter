<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelatihan;
use App\Models\Pendaftaran;
use App\Models\Nilai;
use Illuminate\Http\Request;

class PointPesertaController extends Controller
{
    public function index()
    {
        $jadwal = JadwalPelatihan::with(['pelatihan', 'kegiatan.pendaftaran'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pelatihan.point.index', compact('jadwal'));
    }

    public function show($jadwal_id)
    {
        $jadwal = JadwalPelatihan::with(['pelatihan.materi'])->findOrFail($jadwal_id);
        
        $pendaftaran = Pendaftaran::with(['peserta', 'nilai'])
            ->whereHas('kegiatan.kegiatanPelatihan', function($q) use ($jadwal) {
                $q->where('jadwal_pelatihan_id', $jadwal->id);
            })
            ->whereIn('status_pendaftaran', ['terdaftar', 'lulus', 'tidak_lulus'])
            ->get();

        return view('admin.pelatihan.point.show', compact('jadwal', 'pendaftaran'));
    }

    public function update(Request $request, $jadwal_id, $pendaftaran_id)
    {
        $jadwal = JadwalPelatihan::findOrFail($jadwal_id);

        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->nilai as $materi_id => $score) {
            if ($score !== null) {
                Nilai::updateOrCreate(
                    [
                        'pendaftaran_id' => $pendaftaran_id,
                        'materi_pelatihan_id' => $materi_id,
                    ],
                    [
                        'nilai' => $score
                    ]
                );
            }
        }

        return redirect()->route('admin.pelatihan.point.show', $jadwal_id)
            ->with('success', 'Nilai berhasil disimpan.');
    }
}
