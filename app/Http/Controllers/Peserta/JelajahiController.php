<?php
namespace App\Http\Controllers\Peserta;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class JelajahiController extends Controller {
    public function index(Request $r) {
        $peserta = Auth::guard('peserta')->user();
        $sudahDaftar = $peserta->pendaftaran()->pluck('kegiatan_id')->toArray();
        $q = Kegiatan::with(['kegiatanPelatihan.jadwalPelatihan.pelatihan','kegiatanSertifikasi.jadwalSertifikasi.sertifikasi','biaya','pendaftaran']);
        if ($r->jenis && in_array($r->jenis,['pelatihan','sertifikasi'])) $q->where('jenis_kegiatan',$r->jenis);
        if ($r->q) $q->where(function($sub) use ($r) { $sub->whereHas('kegiatanPelatihan.jadwalPelatihan.pelatihan',fn($p)=>$p->where('judul','like','%'.$r->q.'%'))->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',fn($s)=>$s->where('judul','like','%'.$r->q.'%')); });
        $kegiatan = $q->paginate(9);
        return view('peserta.jelajahi',compact('kegiatan','sudahDaftar'));
    }
}