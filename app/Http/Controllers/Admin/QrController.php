<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Kegiatan, Pendaftaran};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class QrController extends Controller
{
    public function index(Kegiatan $kegiatan)
    {
        $kegiatan->load(['pendaftaran.peserta','pendaftaran.pembayaran']);
        return view('admin.kegiatan.qr', compact('kegiatan'));
    }

    public function cetakSheet(Kegiatan $kegiatan)
    {
        // Pastikan semua pendaftaran punya QR token
        $pendaftaran = Pendaftaran::where('kegiatan_id', $kegiatan->id)
            ->where('status_pendaftaran','terdaftar')
            ->with('peserta')
            ->get();

        foreach ($pendaftaran as $pd) {
            if (!$pd->qr_token) {
                $pd->update(['qr_token' => Str::random(32)]);
            }
        }

        return view('admin.cetak.qr-sheet', compact('kegiatan','pendaftaran'));
    }

    public function showQr(Pendaftaran $pendaftaran)
    {
        if (!$pendaftaran->qr_token) {
            $pendaftaran->update(['qr_token' => Str::random(32)]);
        }
        return view('admin.kegiatan.qr-detail', compact('pendaftaran'));
    }

    public function regenerate(Request $r, Kegiatan $kegiatan)
    {
        Pendaftaran::where('kegiatan_id', $kegiatan->id)
            ->each(fn($pd) => $pd->update(['qr_token' => Str::random(32)]));
        return back()->with('success', 'Semua QR Code berhasil di-generate ulang.');
    }

    public function scan(string $token)
    {
        $pendaftaran = Pendaftaran::where('qr_token', $token)
            ->with(['peserta','kegiatan'])
            ->first();

        if (!$pendaftaran) {
            return view('admin.cetak.qr-scan-result', ['status'=>'invalid']);
        }

        if ($pendaftaran->status_kehadiran === 'hadir') {
            return view('admin.cetak.qr-scan-result', [
                'status'       => 'already',
                'pendaftaran'  => $pendaftaran,
            ]);
        }

        if ($pendaftaran->status_pendaftaran !== 'terdaftar') {
            return view('admin.cetak.qr-scan-result', [
                'status'       => 'belum_bayar',
                'pendaftaran'  => $pendaftaran,
            ]);
        }

        $pendaftaran->update(['status_kehadiran' => 'hadir']);

        return view('admin.cetak.qr-scan-result', [
            'status'       => 'success',
            'pendaftaran'  => $pendaftaran,
        ]);
    }
}
