<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index()
    {
        $peserta = auth('peserta')->user();
        $testimoni = Testimoni::where('peserta_id', $peserta->id)->first();

        // Get completed activities for auto-suggesting keterangan
        $kegiatanTerdaftar = $peserta->pendaftaranAktif()
            ->with('kegiatan')
            ->latest()
            ->get();

        return view('peserta.testimoni', compact('peserta', 'testimoni', 'kegiatanTerdaftar'));
    }

    public function store(Request $request)
    {
        $peserta = auth('peserta')->user();

        // Check if participant already has a testimoni
        $existing = Testimoni::where('peserta_id', $peserta->id)->first();
        if ($existing) {
            return $this->update($request, $existing);
        }

        $request->validate([
            'rating'     => 'required|integer|min:1|max:5',
            'keterangan' => 'required|string|max:255',
            'kata'       => 'required|string|max:1000',
        ]);

        $data = [
            'peserta_id' => $peserta->id,
            'nama'       => $peserta->nama,
            'rating'     => $request->rating,
            'keterangan' => $request->keterangan,
            'kata'       => $request->kata,
            'status'     => 'dipublikasikan',
        ];

        Testimoni::create($data);

        return redirect()->route('peserta.sertifikat')->with('success', 'Terima kasih! Testimoni Anda telah tersimpan. Anda sekarang dapat mengunduh sertifikat kompetensi Anda.');
    }

    public function update(Request $request, Testimoni $testimoni)
    {
        $peserta = auth('peserta')->user();

        if ($testimoni->peserta_id != $peserta->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'rating'     => 'required|integer|min:1|max:5',
            'keterangan' => 'required|string|max:255',
            'kata'       => 'required|string|max:1000',
        ]);

        $data = [
            'nama'       => $peserta->nama,
            'rating'     => $request->rating,
            'keterangan' => $request->keterangan,
            'kata'       => $request->kata,
        ];

        $testimoni->update($data);

        return redirect()->route('peserta.testimoni')->with('success', 'Testimoni Anda berhasil diperbarui!');
    }

    public function destroy(Testimoni $testimoni)
    {
        $peserta = auth('peserta')->user();

        if ($testimoni->peserta_id != $peserta->id) {
            abort(403, 'Akses ditolak.');
        }

        if ($testimoni->foto) {
            Storage::disk('public')->delete($testimoni->foto);
        }

        $testimoni->delete();

        return redirect()->route('peserta.testimoni')->with('success', 'Testimoni Anda telah dihapus.');
    }
}
