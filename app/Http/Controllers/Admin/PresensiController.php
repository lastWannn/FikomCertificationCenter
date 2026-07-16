<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Pendaftaran,Kegiatan};
use Illuminate\Http\Request;
class PresensiController extends Controller {
    public function index(Request $r) {
        $kegiatan = Kegiatan::with(['kegiatanPelatihan.jadwalPelatihan.pelatihan','kegiatanSertifikasi.jadwalSertifikasi.sertifikasi'])->get();
        $q = Pendaftaran::with(['peserta','kegiatan'])->where('status_pendaftaran','terdaftar');
        if ($r->kegiatan_id) $q->where('kegiatan_id',$r->kegiatan_id);
        return view('admin.lainnya.presensi',['kegiatan'=>$kegiatan,'pendaftaran'=>$q->paginate(20)]);
    }
    public function show(Kegiatan $kegiatan) { return view('admin.lainnya.presensi',['kegiatan'=>[$kegiatan],'pendaftaran'=>$kegiatan->pendaftaran()->with('peserta')->paginate(20)]); }
    public function markHadir(Pendaftaran $pendaftaran, Request $r) {
        $r->validate(['status_kehadiran'=>'required|in:hadir,tidak_hadir,belum']);
        $pendaftaran->update(['status_kehadiran'=>$r->status_kehadiran]);
        return back()->with('success','Presensi diperbarui.');
    }

    public function export(\App\Models\Kegiatan $kegiatan)
    {
        $pendaftaran = \App\Models\Pendaftaran::where('kegiatan_id', $kegiatan->id)
            ->with('peserta')
            ->where('status_pendaftaran','terdaftar')
            ->get();

        $csv  = "No,Nama,Email,No HP,Instansi,Kelamin,Status Kehadiran\n";
        foreach ($pendaftaran as $i => $pd) {
            $csv .= ($i+1).','.
                '"'.($pd->peserta->nama??'').'",'  .
                '"'.($pd->peserta->email??'').'",' .
                '"'.($pd->peserta->no_hp??'').'",' .
                '"'.($pd->peserta->instansi??'').'",' .
                '"'.($pd->peserta->kelamin??'').'",' .
                '"'.($pd->status_kehadiran??'belum').'"' .
                "\n";
        }
        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="presensi-'.date('Y-m-d').'.csv"',
        ]);
    }
}
