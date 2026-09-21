<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Sertifikat, Pendaftaran, Kegiatan};
use App\Services\Admin\SertifikatService;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    public function __construct(private SertifikatService $service) {}

    public function index(Request $r) {
        $allKegiatan = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            'pendaftaran.sertifikat',
            'pendaftaran.peserta',
        ])->latest()->get();

        $groupedByTitle = $allKegiatan->groupBy(fn($k) => trim($k->judul));

        $masterGroups = $groupedByTitle->map(function ($items, $judul) {
            $utama = $items->first(fn($k) => $k->has_latar) ?? $items->first();
            $jadwalItems = $items->map(function ($k) {
                $totalPeserta = $k->pendaftaran->where('status_pendaftaran', 'terdaftar')->count();
                $totalTerbit = $k->pendaftaran->filter(fn($p) => $p->sertifikat !== null)->count();
                return [
                    'kegiatan'               => $k,
                    'jadwal_nama'            => $k->jadwal?->nama_kegiatan ?: ('Jadwal ' . ($k->jadwal?->tgl_pelaksanaan?->translatedFormat('d M Y') ?? 'Reguler')),
                    'tgl_pelaksanaan_format' => $k->jadwal?->tgl_pelaksanaan?->translatedFormat('d F Y') ?? '-',
                    'total_peserta'          => $totalPeserta,
                    'total_terbit'           => $totalTerbit,
                ];
            });

            return [
                'judul'           => $judul,
                'utama'           => $utama,
                'has_latar'       => $utama->has_latar,
                'latar_url'       => $utama->latar_url,
                'layout_settings' => $utama->layout_settings,
                'jadwal_list'     => $jadwalItems,
                'sample_sertifikat' => Sertifikat::whereHas('pendaftaran', fn($q) => $q->whereIn('kegiatan_id', $items->pluck('id')))->first(),
            ];
        })->values();

        $kegiatanUnique = $allKegiatan->unique(fn($k) => trim($k->judul))->values();

        $query = Sertifikat::with(['pendaftaran.peserta','pendaftaran.kegiatan'])->latest();

        if ($r->filled('q')) {
            $qStr = '%' . trim($r->q) . '%';
            $query->where(function($sub) use ($qStr) {
                $sub->where('nomor_sertifikat', 'like', $qStr)
                    ->orWhereHas('pendaftaran.peserta', fn($p) => $p->where('nama', 'like', $qStr)->orWhere('email', 'like', $qStr));
            });
        }

        if ($r->filled('filter_kegiatan')) {
            $selectedKegiatan = Kegiatan::find($r->filter_kegiatan);
            if ($selectedKegiatan) {
                $targetJudul = trim($selectedKegiatan->judul);
                $matchingIds = Kegiatan::all()
                    ->filter(fn($k) => trim($k->judul) === $targetJudul)
                    ->pluck('id');
                $query->whereHas('pendaftaran', fn($p) => $p->whereIn('kegiatan_id', $matchingIds));
            }
        }

        $sertifikat = $query->paginate(10)->withQueryString();

        return view('admin.sertifikat.index', [
            'sertifikat'   => $sertifikat,
            'kegiatan'     => $kegiatanUnique,
            'masterGroups' => $masterGroups,
        ]);
    }

    public function previewSamplePdf(Kegiatan $kegiatan) {
        $targetJudul = trim($kegiatan->judul);
        $matchingIds = Kegiatan::all()->filter(fn($k) => trim($k->judul) === $targetJudul)->pluck('id');
        $sample = Sertifikat::whereHas('pendaftaran', fn($q) => $q->whereIn('kegiatan_id', $matchingIds))->first();

        if (!$sample) {
            $sample = Sertifikat::first();
        }

        if (!$sample) {
            return back()->with('error', 'Belum ada data sertifikat/peserta untuk melakukan preview layout PDF.');
        }

        return (new CetakController())->sertifikat($sample);
    }
    public function peserta(Kegiatan $kegiatan) {
        $kegiatan->load(['kegiatanPelatihan.jadwalPelatihan.pelatihan','kegiatanSertifikasi.jadwalSertifikasi.sertifikasi']);

        $pendaftaran = Pendaftaran::where('kegiatan_id', $kegiatan->id)
            ->with(['peserta', 'sertifikat', 'kegiatan.kegiatanPelatihan.jadwalPelatihan', 'kegiatan.kegiatanSertifikasi.jadwalSertifikasi'])
            ->orderBy('status_pendaftaran')
            ->get();

        return view('admin.sertifikat.peserta', compact('kegiatan','pendaftaran'));
    }
    public function uploadLatar(Request $r) {
        $r->validate(['kegiatan_id'=>'required','latar'=>'required|image|max:5120']);
        $this->service->uploadLatar($r->kegiatan_id, $r->file('latar'));
        return back()->with('success','Template latar berhasil diunggah.')->with('uploaded_kegiatan_id', (int)$r->kegiatan_id);
    }
    public function terbitkan(Request $r, Pendaftaran $pendaftaran) {
        $r->validate(['tgl_terbit'=>'required|date']);
        $this->service->terbitkan($pendaftaran, $r->tgl_terbit);
        return back()->with('success','Sertifikat berhasil diterbitkan.');
    }
    public function terbitkanSemua(Request $r, Kegiatan $kegiatan) {
        $r->validate(['tgl_terbit'=>'required|date']);
        $count = $this->service->terbitkanSemua($kegiatan, $r->tgl_terbit);
        return back()->with('success', "{$count} sertifikat berhasil diterbitkan.");
    }

    public function layoutEditor(Kegiatan $kegiatan) {
        $kegiatan->load(['kegiatanPelatihan.jadwalPelatihan.pelatihan', 'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi']);
        $layout = $kegiatan->layout_settings;
        $name = $layout['name'] ?? [];
        $name['font_family'] = $name['font_family'] ?? 'Allura';
        $layout['name'] = $name;

        $desc = $layout['desc'] ?? [];
        $desc['font_family'] = $desc['font_family'] ?? 'Poppins';
        $layout['desc'] = $desc;

        $bgSrc = null;
        $gambarLatarPath = $kegiatan->nama_latar;
        if (empty($gambarLatarPath) || !file_exists(public_path('storage/' . $gambarLatarPath))) {
            if (file_exists(storage_path('app/public/latar-sertifikat/LfPQPcpLb5uKPx2YELbIUgQuIhxbnViaBBACTWv5.webp'))) {
                $gambarLatarPath = 'latar-sertifikat/LfPQPcpLb5uKPx2YELbIUgQuIhxbnViaBBACTWv5.webp';
            }
        }

        if (!empty($gambarLatarPath)) {
            $realPath = public_path('storage/' . $gambarLatarPath);
            if (!file_exists($realPath)) {
                $realPath = storage_path('app/public/' . $gambarLatarPath);
            }
            if (file_exists($realPath) && is_file($realPath)) {
                $type = pathinfo($realPath, PATHINFO_EXTENSION);
                $data = file_get_contents($realPath);
                $bgSrc = 'data:image/' . ($type === 'svg' ? 'svg+xml' : ($type === 'webp' ? 'webp' : $type)) . ';base64,' . base64_encode($data);
            }
        }

        $dummySertifikat = Sertifikat::whereHas('pendaftaran', fn($q) => $q->where('kegiatan_id', $kegiatan->id))->with('pendaftaran.peserta')->first();

        $otherKegiatans = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
        ])
        ->get()
        ->filter(fn($k) => trim($k->judul) !== trim($kegiatan->judul))
        ->unique(fn($k) => trim($k->judul))
        ->values()
        ->map(function($k) {
            return [
                'id'        => $k->id,
                'judul'     => $k->judul,
                'has_latar' => $k->has_latar,
                'latar_url' => $k->latar_url,
                'layout'    => $k->layout_settings,
            ];
        });

        return view('admin.sertifikat.layout-editor', compact('kegiatan', 'layout', 'bgSrc', 'dummySertifikat', 'otherKegiatans'));
    }

    public function saveLayout(Request $r, Kegiatan $kegiatan) {
        $r->validate([
            'layout' => 'required|array',
        ]);

        $targetJudul = trim($kegiatan->judul);
        $matching = Kegiatan::all()->filter(fn($k) => trim($k->judul) === $targetJudul);
        foreach ($matching as $k) {
            $k->update(['sertifikat_layout' => $r->layout]);

            Sertifikat::whereHas('pendaftaran', fn($q) => $q->where('kegiatan_id', $k->id))
                ->update(['file_sertifikat' => null]);
        }

        if ($r->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Koordinat tata letak & font sertifikat berhasil disimpan.']);
        }

        return back()->with('success', 'Koordinat tata letak & font sertifikat berhasil disimpan.');
    }
}





