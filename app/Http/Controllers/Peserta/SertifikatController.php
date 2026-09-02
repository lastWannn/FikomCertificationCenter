<?php
namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Services\Admin\SertifikatService;
use App\Models\Testimoni;
use Illuminate\Support\Facades\Auth;

class SertifikatController extends Controller
{
    public function __construct(private SertifikatService $sertifikatService) {}

    public function index()
    {
        $peserta = Auth::guard('peserta')->user();
        $pendaftaranList = \App\Models\Pendaftaran::where('peserta_id', $peserta->id)
            ->where('status_pendaftaran', 'terdaftar')
            ->with(['kegiatan.kegiatanPelatihan.jadwalPelatihan', 'kegiatan.kegiatanSertifikasi.jadwalSertifikasi', 'sertifikat'])
            ->latest()
            ->get();

        $hasTestimoni = Testimoni::where('peserta_id', $peserta->id)->exists();

        return view('peserta.sertifikat', compact('peserta', 'pendaftaranList', 'hasTestimoni'));
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

        $filePath = $sertifikat->file_sertifikat
            ? storage_path('app/public/' . $sertifikat->file_sertifikat)
            : null;

        if (!$filePath || !file_exists($filePath)) {
            $this->sertifikatService->regeneratePdf($sertifikat);
            $sertifikat->refresh();
        }

        $filePath = storage_path('app/public/' . $sertifikat->file_sertifikat);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File sertifikat tidak ditemukan di server.');
        }

        return response()->download($filePath);
    }

    public function preview(Sertifikat $sertifikat)
    {
        return redirect()->route('peserta.sertifikat');
    }
}
