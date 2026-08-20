<?php
namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Testimoni;
use Illuminate\Support\Facades\Auth;

class SertifikatController extends Controller
{
    public function index()
    {
        $peserta = Auth::guard('peserta')->user();
        $sertifikat = Sertifikat::whereHas(
            'pendaftaran',
            fn($q) => $q->where('peserta_id', $peserta->id)
        )
        ->with('pendaftaran.kegiatan')
        ->get();

        $hasTestimoni = Testimoni::where('peserta_id', $peserta->id)->exists();

        return view('peserta.sertifikat', compact('sertifikat', 'hasTestimoni'));
    }

    public function download(Sertifikat $sertifikat)
    {
        $pesertaId = Auth::guard('peserta')->id();

        // Pastikan sertifikat milik peserta yang sedang login
        if ($sertifikat->pendaftaran->peserta_id !== $pesertaId) {
            abort(403, 'Akses ditolak.');
        }

        // Syarat Wajib Testimoni untuk Download Sertifikat
        $hasTestimoni = Testimoni::where('peserta_id', $pesertaId)->exists();
        if (!$hasTestimoni) {
            return redirect()->route('peserta.testimoni')
                ->with('warning', 'Silakan tulis testimoni pengalaman Anda terlebih dahulu untuk membuka akses pengunduhan sertifikat kompetensi.');
        }

        if (!$sertifikat->file_sertifikat) {
            return back()->with('error', 'File sertifikat belum tersedia. Hubungi Admin FCC.');
        }

        $filePath = storage_path('app/public/' . $sertifikat->file_sertifikat);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File sertifikat tidak ditemukan di server.');
        }

        return response()->download($filePath);
    }

    public function preview(Sertifikat $sertifikat)
    {
        $pesertaId = Auth::guard('peserta')->id();

        // Pastikan sertifikat milik peserta yang sedang login
        if ($sertifikat->pendaftaran->peserta_id !== $pesertaId) {
            abort(403, 'Akses ditolak.');
        }

        // Syarat Wajib Testimoni untuk Preview Sertifikat
        $hasTestimoni = Testimoni::where('peserta_id', $pesertaId)->exists();
        if (!$hasTestimoni) {
            return redirect()->route('peserta.testimoni')
                ->with('warning', 'Silakan tulis testimoni pengalaman Anda terlebih dahulu untuk melihat pratinjau sertifikat kompetensi.');
        }

        $sertifikat->load('pendaftaran.kegiatan', 'pendaftaran.peserta');
        return view('peserta.sertifikat-preview', compact('sertifikat'));
    }
}
