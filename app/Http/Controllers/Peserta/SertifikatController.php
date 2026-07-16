<?php
namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
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

        return view('peserta.sertifikat', compact('sertifikat'));
    }

    /**
     * FIX FUNGSIONAL: Method download() sebelumnya:
     *   1. Parameter `Sertifikat $sertifikat` diinjeksi via model binding
     *   2. Lalu langsung di-overwrite dengan query yang pakai `$id` — variabel tidak terdefinisi
     * Diperbaiki: gunakan model yang sudah diinjeksi, tambah cek kepemilikan.
     */
    public function download(Sertifikat $sertifikat)
    {
        // Pastikan sertifikat milik peserta yang sedang login
        if ($sertifikat->pendaftaran->peserta_id !== Auth::guard('peserta')->id()) {
            abort(403, 'Akses ditolak.');
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

    /**
     * FIX FUNGSIONAL: Route preview/{sertifikat} sudah ada tapi method belum ada.
     * Tanpa method ini, akses URL tersebut menyebabkan BadMethodCallException.
     */
    public function preview(Sertifikat $sertifikat)
    {
        // Pastikan sertifikat milik peserta yang sedang login
        if ($sertifikat->pendaftaran->peserta_id !== Auth::guard('peserta')->id()) {
            abort(403, 'Akses ditolak.');
        }

        $sertifikat->load('pendaftaran.kegiatan', 'pendaftaran.peserta');
        return view('peserta.sertifikat-preview', compact('sertifikat'));
    }
}
