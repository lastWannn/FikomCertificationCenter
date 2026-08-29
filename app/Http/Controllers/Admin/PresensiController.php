<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Kegiatan, Pendaftaran};
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    /**
     * Tampilkan daftar kegiatan untuk presensi fisik (cetak kertas per kegiatan).
     */
    public function index(Request $request)
    {
        $query = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi'
        ])
        ->withCount(['pendaftaran as total_peserta' => function ($q) {
            $q->where('status_pendaftaran', 'terdaftar');
        }]);

        if ($request->jenis) {
            $query->where('jenis_kegiatan', $request->jenis);
        }

        if ($request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->whereHas('kegiatanPelatihan.jadwalPelatihan', fn($j) => $j->where('nama_kegiatan', 'like', "%{$search}%"))
                  ->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi', fn($j) => $j->where('nama_kegiatan', 'like', "%{$search}%"));
            });
        }

        $kegiatanList = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.lainnya.presensi', compact('kegiatanList'));
    }

    /**
     * Tampilkan daftar peserta per kegiatan tertentu.
     */
    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi'
        ]);

        $pendaftaran = Pendaftaran::where('kegiatan_id', $kegiatan->id)
            ->where('status_pendaftaran', 'terdaftar')
            ->with('peserta')
            ->paginate(20);

        return view('admin.lainnya.presensi-detail', compact('kegiatan', 'pendaftaran'));
    }

    public function markHadir(Pendaftaran $pendaftaran, Request $r)
    {
        $jadwal = $pendaftaran->kegiatan?->jadwal;
        if ($jadwal && $jadwal->tgl_pelaksanaan && \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->gt(now()->startOfDay())) {
            return back()->with('error', 'Presensi gagal: Pelaksanaan kegiatan belum dimulai (Tanggal Pelaksanaan: ' . \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->format('d M Y') . ').');
        }

        $r->validate(['status_kehadiran' => 'required|in:hadir,tidak_hadir,belum']);
        $pendaftaran->update(['status_kehadiran' => $r->status_kehadiran]);
        return back()->with('success', 'Presensi peserta berhasil diperbarui.');
    }

    public function export(Kegiatan $kegiatan)
    {
        $pendaftaran = Pendaftaran::where('kegiatan_id', $kegiatan->id)
            ->with('peserta')
            ->where('status_pendaftaran', 'terdaftar')
            ->get();

        $csv  = "No,Nama,Email,No HP,Instansi,Kelamin,Status Kehadiran\n";
        foreach ($pendaftaran as $i => $pd) {
            $csv .= ($i + 1) . ',' .
                '"' . ($pd->peserta->nama ?? '') . '",' .
                '"' . ($pd->peserta->email ?? '') . '",' .
                '"' . ($pd->peserta->no_hp ?? '') . '",' .
                '"' . ($pd->peserta->instansi ?? '') . '",' .
                '"' . ($pd->peserta->kelamin ?? '') . '",' .
                '"' . ($pd->status_kehadiran ?? 'belum') . '"' .
                "\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="presensi-' . $kegiatan->id . '-' . date('Y-m-d') . '.csv"',
        ]);
    }
}
