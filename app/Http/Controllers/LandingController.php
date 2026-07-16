<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Informasi;
use App\Models\Mitra;
use App\Models\ArsipKegiatan;
use App\Models\KontenHalaman;
use App\Models\Kontak;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $kegiatanTerbaru = Kegiatan::with(['kegiatanPelatihan.jadwalPelatihan.pelatihan',
                                           'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
                                           'biaya'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $stats = [
            'pelatihan'   => \App\Models\Pelatihan::count(),
            'sertifikasi' => \App\Models\Sertifikasi::count(),
            'peserta'     => \App\Models\Peserta::count(),
            'mitra'       => Mitra::count(),
        ];

        $mitras    = Mitra::all();
        $arsips    = ArsipKegiatan::with('kegiatan')->orderBy('created_at','desc')->limit(5)->get();
        $konten    = KontenHalaman::all()->keyBy('jenis');

        return view('landing.index', compact(
            'kegiatanTerbaru', 'stats', 'mitras', 'arsips', 'konten'
        ));
    }

    public function profil()
    {
        $konten = KontenHalaman::all()->keyBy('jenis');
        $mitras = Mitra::all();
        return view('landing.profil', compact('konten','mitras'));
    }

    public function kegiatan(Request $request)
    {
        $query  = Kegiatan::with(['kegiatanPelatihan.jadwalPelatihan.pelatihan',
                                   'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
                                   'biaya', 'pendaftaran']);
        if ($request->jenis && in_array($request->jenis, ['pelatihan','sertifikasi'])) {
            $query->where('jenis_kegiatan', $request->jenis);
        }
        $kegiatan = $query->paginate(9);
        return view('landing.kegiatan', compact('kegiatan'));
    }

    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan.materi',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi.materi',
            'biaya',
        ]);
        return view('landing.show', compact('kegiatan'));
    }

    public function pendaftaran()
    {
        return view('landing.pendaftaran');
    }

    public function arsip(Request $request)
    {
        $arsips = ArsipKegiatan::with('kegiatan')->orderBy('created_at','desc')->paginate(6);
        return view('landing.arsip', compact('arsips'));
    }

    public function kontak()
    {
        $kontak = Kontak::latest()->first();
        return view('landing.kontak', compact('kontak'));
    }

    public function kontakPost(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:150',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);
        // Simpan atau kirim email — implementasi sesuai kebutuhan
        return back()->with('success','Pesan berhasil dikirim! Kami akan segera menghubungi Anda.');
    }

    public function arsipShow(ArsipKegiatan $arsip)
    {
        $arsip->load('kegiatan');
        return view('landing.arsip-show', compact('arsip'));
    }

    public function sendReset(\Illuminate\Http\Request $r) 
    { 
        return back()->with('status', 'Fitur reset password akan segera tersedia.');
    }

    /** Full-text search API untuk autocomplete + halaman hasil */
    public function search(\Illuminate\Http\Request $r)
    {
        $q = trim($r->q ?? '');
        if (strlen($q) < 2) {
            return request()->wantsJson()
                ? response()->json(['results'=>[]])
                : redirect()->route('landing.kegiatan');
        }

        $kegiatan = \App\Models\Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan.kategori',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi.kategori',
            'biaya',
        ])->where(function($query) use ($q) {
            // Cari di relasi pelatihan
            $query->whereHas('kegiatanPelatihan.jadwalPelatihan.pelatihan', function($qp) use ($q) {
                $qp->where('judul','LIKE',"%{$q}%")
                   ->orWhere('isi','LIKE',"%{$q}%")
                   ->orWhereHas('kategori', fn($k) => $k->where('nama_kategori','LIKE',"%{$q}%"))
                   ->orWhereHas('instruktur', fn($i) => $i->where('nama','LIKE',"%{$q}%"));
            })
            // Cari di relasi sertifikasi
            ->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi.sertifikasi', function($qs) use ($q) {
                $qs->where('judul','LIKE',"%{$q}%")
                   ->orWhere('isi','LIKE',"%{$q}%")
                   ->orWhereHas('kategori', fn($k) => $k->where('nama_kategori','LIKE',"%{$q}%"));
            });
        })->limit(20)->get();

        if (request()->wantsJson() || $r->ajax) {
            return response()->json([
                'results' => $kegiatan->map(fn($k) => [
                    'id'     => $k->id,
                    'judul'  => $k->judul,
                    'jenis'  => $k->jenis_kegiatan,
                    'tanggal'=> $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA',
                    'url'    => route('landing.show', $k->id),
                    'biaya'  => $k->biaya->isEmpty() ? 'Gratis' : 'Rp '.number_format($k->biaya->min('nominal'),0,',','.'),
                ])->values(),
                'total' => $kegiatan->count(),
                'query' => $q,
            ]);
        }

        return view('landing.search', compact('kegiatan','q'));
    }
}
