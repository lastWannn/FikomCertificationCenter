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
        // Auto archive completed activities
        app(\App\Services\Admin\ArsipService::class)->autoArchiveCompleted();

        $kegiatanTerbaru = Kegiatan::upcoming()
            ->with(['kegiatanPelatihan.jadwalPelatihan.pelatihan',
                    'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
                    'biaya'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $stats = [
            'pelatihan'   => \App\Models\Pelatihan::count(),
            'sertifikasi' => \App\Models\Sertifikasi::count(),
            'peserta'     => \App\Models\Peserta::count(),
            'mitra'       => Mitra::count(),
        ];

        $mitras    = Mitra::orderBy('urutan', 'asc')->get();
        $arsips    = ArsipKegiatan::with('kegiatan')->orderBy('created_at','desc')->limit(5)->get();
        $konten    = KontenHalaman::all()->keyBy('jenis');
        $faqs      = Informasi::faq()->latest()->get();
        $infos     = Informasi::info()->aktif()->latest()->limit(3)->get();
        $testimonis = \App\Models\Testimoni::latest()->get();

        return view('landing.index', compact(
            'kegiatanTerbaru', 'stats', 'mitras', 'arsips', 'konten', 'faqs', 'infos', 'testimonis'
        ));
    }

    public function profil()
    {
        $konten = KontenHalaman::all()->keyBy('jenis');
        $mitras = Mitra::orderBy('urutan', 'asc')->get();
        return view('landing.profil', compact('konten','mitras'));
    }

    public function kegiatan(Request $request)
    {
        app(\App\Services\Admin\ArsipService::class)->autoArchiveCompleted();

        $query  = Kegiatan::upcoming()
            ->with(['kegiatanPelatihan.jadwalPelatihan.pelatihan',
                    'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
                    'biaya', 'pendaftaran']);
        if ($request->jenis && in_array($request->jenis, ['pelatihan','sertifikasi'])) {
            $query->where('jenis_kegiatan', $request->jenis);
        }
        if ($request->kategori) {
            $query->where(function($q) use ($request) {
                $q->whereHas('kegiatanPelatihan.jadwalPelatihan.pelatihan', function($q) use ($request) {
                    $q->where('kategori_id', $request->kategori);
                })->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi.sertifikasi', function($q) use ($request) {
                    $q->where('kategori_id', $request->kategori);
                });
            });
        }
        
        $kegiatan = $query->paginate(9);
        $kategoris = \App\Models\Kategori::all();
        
        return view('landing.kegiatan', compact('kegiatan', 'kategoris'));
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
                   ->orWhereHas('kategori', fn($k) => $k->where('nama_kategori','LIKE',"%{$q}%"));
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
