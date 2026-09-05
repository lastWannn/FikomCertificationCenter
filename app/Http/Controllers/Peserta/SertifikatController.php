<?php
namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\Pendaftaran;
use App\Services\Admin\SertifikatService;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function uploadTranskrip(Request $request, Pendaftaran $pendaftaran)
    {
        $pesertaId = Auth::guard('peserta')->id();

        // Pastikan pendaftaran milik peserta yang sedang login
        if ($pendaftaran->peserta_id !== $pesertaId) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'transkrip_nilai' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'transkrip_nilai.required' => 'Silakan pilih berkas transkrip nilai Anda.',
            'transkrip_nilai.file'     => 'Berkas harus berupa file yang valid.',
            'transkrip_nilai.mimes'    => 'Format berkas harus berupa PDF, JPG, JPEG, atau PNG.',
            'transkrip_nilai.max'      => 'Ukuran berkas transkrip nilai maksimal 5MB.',
        ]);

        // Hapus berkas lama jika ada
        if ($pendaftaran->transkrip_nilai && Storage::disk('public')->exists($pendaftaran->transkrip_nilai)) {
            Storage::disk('public')->delete($pendaftaran->transkrip_nilai);
        }

        $file = $request->file('transkrip_nilai');
        $ext = $file->getClientOriginalExtension();
        $filename = 'transkrip_' . $pendaftaran->id . '_' . time() . '.' . $ext;
        $path = $file->storeAs('transkrip-nilai', $filename, 'public');

        $pendaftaran->update([
            'transkrip_nilai' => $path,
        ]);

        // Otomatisasi pembacaan transkrip (PDF / gambar) & auto-populate nilai ke database
        $parseResult = app(\App\Services\Peserta\TranskripParserService::class)->parseAndPopulateNilai(
            $pendaftaran,
            storage_path('app/public/' . $path)
        );

        $msg = 'Transkrip nilai berhasil diunggah!';
        if (!empty($parseResult['success']) && ($parseResult['matched_count'] ?? 0) > 0) {
            $msg .= ' ' . $parseResult['matched_count'] . ' nilai materi berhasil terdeteksi dan diisi otomatis ke sistem.';
        } else {
            $msg .= ' Panitia/Admin akan memverifikasi dan menerbitkan sertifikat Anda.';
        }

        return back()->with('success', $msg);
    }
}
