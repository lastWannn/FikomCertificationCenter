<?php
namespace App\Http\Controllers\Peserta;
use App\Http\Controllers\Controller;
use App\Models\{Kegiatan,Pendaftaran,Pembayaran,Sertifikat};
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller {
    public function index() {
        Pembayaran::updateExpiredPayments();
        $peserta = Auth::guard('peserta')->user();
        $stats = [
            'terdaftar'  => Pendaftaran::where('peserta_id',$peserta->id)->where('status_pendaftaran','terdaftar')->count(),
            'menunggu'   => Pendaftaran::where('peserta_id',$peserta->id)->where('status_pendaftaran','menunggu_verifikasi')->count(),
            'sertifikat' => Sertifikat::whereHas('pendaftaran',fn($q)=>$q->where('peserta_id',$peserta->id))->count(),
        ];
        $pendaftaranTerbaru = Pendaftaran::where('peserta_id',$peserta->id)->with(['kegiatan','biaya','pembayaran'])->orderBy('created_at','desc')->limit(5)->get();
        $sudahDaftar = Pendaftaran::where('peserta_id',$peserta->id)->pluck('kegiatan_id')->toArray();
        $kegiatan = Kegiatan::visibleToPublic()
            ->upcoming()
            ->with(['kegiatanPelatihan.jadwalPelatihan.pelatihan','kegiatanSertifikasi.jadwalSertifikasi.sertifikasi','biaya','pendaftaran'])
            ->orderBy('created_at','desc')
            ->get()
            ->filter(fn($k) => $k->isRegisterable())
            ->take(3);
        return view('peserta.dashboard',compact('peserta','stats','pendaftaranTerbaru','sudahDaftar','kegiatan'));
    }
}