<?php
namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QrController extends Controller
{
    public function show(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->peserta_id !== Auth::guard('peserta')->id()) {
            abort(403);
        }
        if (!$pendaftaran->qr_token) {
            $pendaftaran->update(['qr_token' => Str::random(32)]);
        }
        $pendaftaran->load('kegiatan');
        return view('peserta.qr', compact('pendaftaran'));
    }

    public function cetak(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->peserta_id !== Auth::guard('peserta')->id()) {
            abort(403);
        }
        if (!$pendaftaran->qr_token) {
            $pendaftaran->update(['qr_token' => Str::random(32)]);
        }
        $pendaftaran->load(['kegiatan','peserta']);
        return view('peserta.qr-cetak', compact('pendaftaran'));
    }
}
