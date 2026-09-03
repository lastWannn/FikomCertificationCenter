<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Informasi;
use App\Models\Mitra;
use App\Models\ArsipKegiatan;
use App\Models\KontenHalaman;
use App\Models\Kontak;
use App\Models\PesanMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
            ->leftJoin('kegiatan_pelatihan as kp', 'kegiatan.id', '=', 'kp.kegiatan_id')
            ->leftJoin('jadwal_pelatihan as jp', 'kp.jadwal_pelatihan_id', '=', 'jp.id')
            ->leftJoin('kegiatan_sertifikasi as ks', 'kegiatan.id', '=', 'ks.kegiatan_id')
            ->leftJoin('jadwal_sertifikasi as js', 'ks.jadwal_sertifikasi_id', '=', 'js.id')
            ->select('kegiatan.*')
            ->orderByRaw("CASE WHEN status = 'comingsoon' THEN 1 ELSE 0 END ASC")
            ->orderByRaw("COALESCE(jp.tgl_pelaksanaan, js.tgl_pelaksanaan) ASC")
            ->orderBy('kegiatan.id', 'asc')
            ->limit(6)
            ->get();

        $stats = Cache::remember('landing_stats', 600, function() {
            return [
                'pelatihan'   => \App\Models\Pelatihan::count(),
                'sertifikasi' => \App\Models\Sertifikasi::count(),
                'peserta'     => \App\Models\Peserta::count(),
                'mitra'       => Mitra::count(),
            ];
        });

        $mitras     = Mitra::orderBy('urutan', 'asc')->get();
        $arsips     = ArsipKegiatan::with('kegiatan')->orderBy('created_at','desc')->limit(5)->get();
        $konten     = KontenHalaman::all()->keyBy('jenis');
        $faqs       = Informasi::faq()->latest()->get();
        $infos      = Informasi::info()->aktif()->latest()->limit(3)->get();
        $testimonis = \App\Models\Testimoni::dipublikasikan()->latest()->get();

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

        $query = Kegiatan::visibleToPublic()
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
        
        $allKegiatan = $query->get();

        $sorted = $allKegiatan->sort(function ($a, $b) {
            $aOpen = $a->isRegisterable();
            $bOpen = $b->isRegisterable();

            if ($aOpen !== $bOpen) {
                return $aOpen ? -1 : 1;
            }

            if ($aOpen) {
                $aDate = $a->jadwal?->tgl_batas_daftar ?? $a->jadwal?->tgl_pelaksanaan;
                $bDate = $b->jadwal?->tgl_batas_daftar ?? $b->jadwal?->tgl_pelaksanaan;

                $aTs = $aDate ? $aDate->timestamp : PHP_INT_MAX;
                $bTs = $bDate ? $bDate->timestamp : PHP_INT_MAX;

                return $aTs <=> $bTs;
            } else {
                $aDate = $a->jadwal?->tgl_pelaksanaan ?? $a->created_at;
                $bDate = $b->jadwal?->tgl_pelaksanaan ?? $b->created_at;

                $aTs = $aDate ? $aDate->timestamp : 0;
                $bTs = $bDate ? $bDate->timestamp : 0;

                return $bTs <=> $aTs;
            }
        });

        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $perPage = 9;
        $currentItems = $sorted->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $kegiatan = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $sorted->count(),
            $perPage,
            $currentPage,
            [
                'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        $kategoris = \App\Models\Kategori::all();
        
        return view('landing.kegiatan', compact('kegiatan', 'kategoris'));
    }

    public function show(Kegiatan $kegiatan)
    {
        if ($kegiatan->isDraf() && !auth()->guard('admin')->check()) {
            abort(404, 'Kegiatan belum dipublikasikan.');
        }

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
            'email' => ['required', 'string', 'max:150', new \App\Rules\ValidEmailAddress()],
            'pesan' => 'required|string',
        ]);

        $pesanMasuk = PesanMasuk::create([
            'nama'   => $request->nama,
            'email'  => $request->email,
            'pesan'  => $request->pesan,
            'status' => 'belum_dibaca',
        ]);

        // Kirim email notifikasi ke admin di background OS process (0 ms latency untuk pengunjung)
        \App\Helpers\AsyncMail::dispatch('kontak', $pesanMasuk->id);

        return back()->with('success', 'Pesan Anda telah berhasil dikirim! Tim kami akan segera menindaklanjuti.');
    }

    public function arsipShow(ArsipKegiatan $arsip)
    {
        $arsip->load('kegiatan');

        $beritaAcaraPath = preg_replace('/^storage\//', '', $arsip->berita_acara ?? '');
        $beritaAcaraFile = $beritaAcaraPath !== ''
            ? storage_path('app/public/' . $beritaAcaraPath)
            : null;
        $beritaAcaraUrl = ($beritaAcaraFile && file_exists($beritaAcaraFile))
            ? asset('storage/' . $beritaAcaraPath)
            : null;

        return view('landing.arsip-show', compact('arsip', 'beritaAcaraFile', 'beritaAcaraUrl'));
    }

    public function arsipPdf(ArsipKegiatan $arsip)
    {
        if (!empty($arsip->berita_acara)) {
            $cleanPath = preg_replace('/^storage\//', '', $arsip->berita_acara);
            $filePath  = storage_path('app/public/' . $cleanPath);

            if (file_exists($filePath)) {
                return response()->file($filePath, [
                    'Content-Type' => mime_content_type($filePath) ?: 'application/pdf',
                    'Content-Disposition' => 'inline; filename="Berita-Acara-' . \Illuminate\Support\Str::slug($arsip->judul ?: 'Kegiatan') . '.pdf"',
                ]);
            }
        }

        abort(404, 'File berita acara belum tersedia.');
    }

    public function downloadDomPdf(ArsipKegiatan $arsip, \App\Services\Admin\ArsipService $arsipService)
    {
        return $this->downloadBeritaAcara($arsip, $arsipService);
    }

    public function downloadBeritaAcara(ArsipKegiatan $arsip, \App\Services\Admin\ArsipService $arsipService)
    {
        session_write_close();

        $cleanPath = preg_replace('/^storage\//', '', $arsip->berita_acara ?? '');
        $filePath  = storage_path('app/public/' . $cleanPath);

        if (empty($cleanPath) || !file_exists($filePath)) {
            abort(404, 'File berita acara belum tersedia.');
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $filename = 'Berita-Acara-' . \Illuminate\Support\Str::slug($arsip->judul ?: 'Kegiatan') . '.' . $ext;

        return response()->download($filePath, $filename);
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

        $kegiatan = \App\Models\Kegiatan::visibleToPublic()->with([
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
