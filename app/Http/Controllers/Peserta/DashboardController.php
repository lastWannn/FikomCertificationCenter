<?php
namespace App\Http\Controllers\Peserta;
use App\Http\Controllers\Controller;
use App\Models\{Kegiatan,Pendaftaran,Pembayaran,Sertifikat};
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller {
    public function index() {
        $peserta = Auth::guard('peserta')->user();
        $stats = [
            'terdaftar'  => Pendaftaran::where('peserta_id',$peserta->id)->where('status_pendaftaran','terdaftar')->count(),
            'menunggu'   => Pendaftaran::where('peserta_id',$peserta->id)->where('status_pendaftaran','menunggu_verifikasi')->count(),
            'sertifikat' => Sertifikat::whereHas('pendaftaran',fn($q)=>$q->where('peserta_id',$peserta->id))->count(),
        ];
        $pendaftaranTerbaru = Pendaftaran::where('peserta_id',$peserta->id)->with(['kegiatan','biaya','pembayaran'])->orderBy('created_at','desc')->limit(5)->get();
        $kegiatan = Kegiatan::with(['kegiatanPelatihan.jadwalPelatihan.pelatihan','kegiatanSertifikasi.jadwalSertifikasi.sertifikasi','biaya'])->orderBy('created_at','desc')->limit(3)->get();
        return view('peserta.dashboard',compact('peserta','stats','pendaftaranTerbaru','kegiatan'));
    }
}