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
        $pelatihans = \App\Models\Pelatihan::all();
        $sertifikasis = \App\Models\Sertifikasi::all();

        $allKegiatan = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            'pendaftaran.sertifikat',
            'pendaftaran.peserta',
        ])->latest()->get();

        $masterGroups = collect();

        // 1. Process Pelatihan Master
        foreach ($pelatihans as $pel) {
            $kegiatans = $allKegiatan->filter(fn($k) => $k->kegiatanPelatihan?->jadwalPelatihan?->pelatihan_id == $pel->id);
            $utama = $kegiatans->first(fn($k) => $k->has_latar) ?? $kegiatans->first();

            $hasLatar = $pel->has_latar || ($utama?->has_latar ?? false);
            $latarUrl = $pel->latar_url ?? $utama?->latar_url;
            $layoutSettings = $pel->sertifikat_layout ?? ($utama?->layout_settings ?? (new Kegiatan())->layout_settings);

            $jadwalItems = $kegiatans->map(function ($k) {
                $totalPeserta = $k->pendaftaran->where('status_pendaftaran', 'terdaftar')->count();
                $totalTerbit = $k->pendaftaran->filter(fn($p) => $p->sertifikat !== null)->count();
                return [
                    'kegiatan'               => $k,
                    'jadwal_nama'            => $k->jadwal?->nama_kegiatan ?: ('Jadwal ' . ($k->jadwal?->tgl_pelaksanaan?->translatedFormat('d M Y') ?? 'Reguler')),
                    'tgl_pelaksanaan_format' => $k->jadwal?->tgl_pelaksanaan?->translatedFormat('d F Y') ?? '-',
                    'total_peserta'          => $totalPeserta,
                    'total_terbit'           => $totalTerbit,
                ];
            })->values();

            $selectId = $utama ? (string)$utama->id : 'pelatihan_' . $pel->id;

            $masterGroups->push([
                'id'              => $selectId,
                'jenis'           => 'pelatihan',
                'master_id'       => $pel->id,
                'judul'           => $pel->judul,
                'utama'           => $utama,
                'has_latar'       => $hasLatar,
                'latar_url'       => $latarUrl,
                'layout_settings' => $layoutSettings,
                'jadwal_list'     => $jadwalItems,
                'sample_sertifikat' => $kegiatans->isNotEmpty() ? Sertifikat::whereHas('pendaftaran', fn($q) => $q->whereIn('kegiatan_id', $kegiatans->pluck('id')))->first() : null,
            ]);
        }

        // 2. Process Sertifikasi Master
        foreach ($sertifikasis as $ser) {
            $kegiatans = $allKegiatan->filter(fn($k) => $k->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi_id == $ser->id);
            $utama = $kegiatans->first(fn($k) => $k->has_latar) ?? $kegiatans->first();

            $hasLatar = $ser->has_latar || ($utama?->has_latar ?? false);
            $latarUrl = $ser->latar_url ?? $utama?->latar_url;
            $layoutSettings = $ser->sertifikat_layout ?? ($utama?->layout_settings ?? (new Kegiatan())->layout_settings);

            $jadwalItems = $kegiatans->map(function ($k) {
                $totalPeserta = $k->pendaftaran->where('status_pendaftaran', 'terdaftar')->count();
                $totalTerbit = $k->pendaftaran->filter(fn($p) => $p->sertifikat !== null)->count();
                return [
                    'kegiatan'               => $k,
                    'jadwal_nama'            => $k->jadwal?->nama_kegiatan ?: ('Jadwal ' . ($k->jadwal?->tgl_pelaksanaan?->translatedFormat('d M Y') ?? 'Reguler')),
                    'tgl_pelaksanaan_format' => $k->jadwal?->tgl_pelaksanaan?->translatedFormat('d F Y') ?? '-',
                    'total_peserta'          => $totalPeserta,
                    'total_terbit'           => $totalTerbit,
                ];
            })->values();

            $selectId = $utama ? (string)$utama->id : 'sertifikasi_' . $ser->id;

            $masterGroups->push([
                'id'              => $selectId,
                'jenis'           => 'sertifikasi',
                'master_id'       => $ser->id,
                'judul'           => $ser->judul,
                'utama'           => $utama,
                'has_latar'       => $hasLatar,
                'latar_url'       => $latarUrl,
                'layout_settings' => $layoutSettings,
                'jadwal_list'     => $jadwalItems,
                'sample_sertifikat' => $kegiatans->isNotEmpty() ? Sertifikat::whereHas('pendaftaran', fn($q) => $q->whereIn('kegiatan_id', $kegiatans->pluck('id')))->first() : null,
            ]);
        }

        $query = Sertifikat::with(['pendaftaran.peserta','pendaftaran.kegiatan'])->latest();

        if ($r->filled('q')) {
            $qStr = '%' . trim($r->q) . '%';
            $query->where(function($sub) use ($qStr) {
                $sub->where('nomor_sertifikat', 'like', $qStr)
                    ->orWhereHas('pendaftaran.peserta', fn($p) => $p->where('nama', 'like', $qStr)->orWhere('email', 'like', $qStr));
            });
        }

        if ($r->filled('filter_kegiatan')) {
            $val = $r->filter_kegiatan;
            if (is_numeric($val)) {
                $selectedKegiatan = Kegiatan::find($val);
                if ($selectedKegiatan) {
                    $targetJudul = trim($selectedKegiatan->detail?->judul ?? $selectedKegiatan->judul);
                    $matchingIds = Kegiatan::all()
                        ->filter(fn($k) => trim($k->detail?->judul ?? $k->judul) === $targetJudul)
                        ->pluck('id');
                    $query->whereHas('pendaftaran', fn($p) => $p->whereIn('kegiatan_id', $matchingIds));
                }
            }
        }

        $sertifikat = $query->paginate(10)->withQueryString();

        return view('admin.sertifikat.index', [
            'sertifikat'   => $sertifikat,
            'masterGroups' => $masterGroups,
        ]);
    }

    private function resolveKegiatanOrDummy(string|int $kegiatanId): Kegiatan
    {
        if ($kegiatanId instanceof Kegiatan) {
            return $kegiatanId;
        }

        if (is_string($kegiatanId) && str_starts_with($kegiatanId, 'pelatihan_')) {
            $pelId = (int) str_replace('pelatihan_', '', $kegiatanId);
            $pel = \App\Models\Pelatihan::findOrFail($pelId);
            $existing = Kegiatan::all()->first(fn($k) => $k->kegiatanPelatihan?->jadwalPelatihan?->pelatihan_id == $pelId);
            if ($existing) return $existing;

            $dummy = new Kegiatan([
                'jenis_kegiatan'    => 'pelatihan',
                'nama_latar'        => $pel->nama_latar,
                'sertifikat_layout' => $pel->sertifikat_layout,
            ]);
            $dummy->id = 'pelatihan_' . $pel->id;
            $kp = new \App\Models\KegiatanPelatihan();
            $jp = new \App\Models\JadwalPelatihan(['nama_kegiatan' => null]);
            $jp->setRelation('pelatihan', $pel);
            $kp->setRelation('jadwalPelatihan', $jp);
            $dummy->setRelation('kegiatanPelatihan', $kp);
            return $dummy;
        }

        if (is_string($kegiatanId) && str_starts_with($kegiatanId, 'sertifikasi_')) {
            $serId = (int) str_replace('sertifikasi_', '', $kegiatanId);
            $ser = \App\Models\Sertifikasi::findOrFail($serId);
            $existing = Kegiatan::all()->first(fn($k) => $k->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi_id == $serId);
            if ($existing) return $existing;

            $dummy = new Kegiatan([
                'jenis_kegiatan'    => 'sertifikasi',
                'nama_latar'        => $ser->nama_latar,
                'sertifikat_layout' => $ser->sertifikat_layout,
            ]);
            $dummy->id = 'sertifikasi_' . $ser->id;
            $ks = new \App\Models\KegiatanSertifikasi();
            $js = new \App\Models\JadwalSertifikasi(['nama_kegiatan' => null]);
            $js->setRelation('sertifikasi', $ser);
            $ks->setRelation('jadwalSertifikasi', $js);
            $dummy->setRelation('kegiatanSertifikasi', $ks);
            return $dummy;
        }

        return Kegiatan::findOrFail($kegiatanId);
    }

    public function previewSamplePdf(string|int $kegiatanId) {
        $kegiatan = $this->resolveKegiatanOrDummy($kegiatanId);
        $targetJudul = trim($kegiatan->detail?->judul ?? $kegiatan->judul);
        $matchingIds = Kegiatan::all()->filter(fn($k) => trim($k->detail?->judul ?? $k->judul) === $targetJudul)->pluck('id');
        $sample = Sertifikat::whereHas('pendaftaran', fn($q) => $q->whereIn('kegiatan_id', $matchingIds))->first();

        if (!$sample) {
            $sample = Sertifikat::first();
        }

        if (!$sample) {
            $dummyPeserta = new \App\Models\Peserta([
                'nama'  => 'M. Rizwan.',
                'email' => 'peserta.sampel@fikom.umi.ac.id',
            ]);
            $dummyPendaftaran = new Pendaftaran([
                'kegiatan_id' => is_numeric($kegiatan->id) ? $kegiatan->id : null,
            ]);
            $dummyPendaftaran->setRelation('peserta', $dummyPeserta);
            $dummyPendaftaran->setRelation('kegiatan', $kegiatan);

            $sample = new Sertifikat([
                'nomor_sertifikat' => '0001/CERT/FCC/' . date('Ym'),
                'tgl_terbit'       => now(),
            ]);
            $sample->setRelation('pendaftaran', $dummyPendaftaran);
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

    public function layoutEditor(string|int $kegiatanId) {
        $kegiatan = $this->resolveKegiatanOrDummy($kegiatanId);
        $kegiatan->loadMissing(['kegiatanPelatihan.jadwalPelatihan.pelatihan', 'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi']);
        $layout = $kegiatan->layout_settings;
        $name = $layout['name'] ?? [];
        $name['font_family'] = $name['font_family'] ?? 'Allura';
        $layout['name'] = $name;

        $desc = $layout['desc'] ?? [];
        $desc['font_family'] = $desc['font_family'] ?? 'Poppins';
        $layout['desc'] = $desc;

        $bgSrc = null;
        $gambarLatarPath = $kegiatan->nama_latar;
        $realPath = null;

        if (!empty($gambarLatarPath)) {
            $realPath = public_path('storage/' . $gambarLatarPath);
            if (!file_exists($realPath)) {
                $realPath = storage_path('app/public/' . $gambarLatarPath);
            }
            if (!file_exists($realPath)) {
                $realPath = public_path($gambarLatarPath);
            }
        }

        if (empty($realPath) || !file_exists($realPath)) {
            $realPath = public_path('images/latarsertifikat_default.webp');
        }

        if (file_exists($realPath) && is_file($realPath)) {
            $type = pathinfo($realPath, PATHINFO_EXTENSION);
            $data = file_get_contents($realPath);
            $bgSrc = 'data:image/' . ($type === 'svg' ? 'svg+xml' : ($type === 'webp' ? 'webp' : $type)) . ';base64,' . base64_encode($data);
        }

        $dummySertifikat = is_numeric($kegiatan->id)
            ? Sertifikat::whereHas('pendaftaran', fn($q) => $q->where('kegiatan_id', $kegiatan->id))->with('pendaftaran.peserta')->first()
            : null;

        $otherKegiatans = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
        ])
        ->get()
        ->filter(fn($k) => trim($k->detail?->judul ?? $k->judul) !== trim($kegiatan->detail?->judul ?? $kegiatan->judul))
        ->unique(fn($k) => trim($k->detail?->judul ?? $k->judul))
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

    public function saveLayout(Request $r, string|int $kegiatanId) {
        $r->validate([
            'layout' => 'required|array',
        ]);

        if (is_string($kegiatanId) && str_starts_with($kegiatanId, 'pelatihan_')) {
            $pelId = (int) str_replace('pelatihan_', '', $kegiatanId);
            $pel = \App\Models\Pelatihan::find($pelId);
            if ($pel) {
                $pel->update(['sertifikat_layout' => $r->layout]);
                $matching = Kegiatan::all()->filter(fn($k) => $k->kegiatanPelatihan?->jadwalPelatihan?->pelatihan_id == $pelId);
                foreach ($matching as $k) {
                    $k->update(['sertifikat_layout' => $r->layout]);
                    Sertifikat::whereHas('pendaftaran', fn($q) => $q->where('kegiatan_id', $k->id))->update(['file_sertifikat' => null]);
                }
            }
        } elseif (is_string($kegiatanId) && str_starts_with($kegiatanId, 'sertifikasi_')) {
            $serId = (int) str_replace('sertifikasi_', '', $kegiatanId);
            $ser = \App\Models\Sertifikasi::find($serId);
            if ($ser) {
                $ser->update(['sertifikat_layout' => $r->layout]);
                $matching = Kegiatan::all()->filter(fn($k) => $k->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi_id == $serId);
                foreach ($matching as $k) {
                    $k->update(['sertifikat_layout' => $r->layout]);
                    Sertifikat::whereHas('pendaftaran', fn($q) => $q->where('kegiatan_id', $k->id))->update(['file_sertifikat' => null]);
                }
            }
        } else {
            $target = Kegiatan::find($kegiatanId);
            if ($target) {
                $targetJudul = trim($target->detail?->judul ?? $target->judul);
                if ($target->jenis_kegiatan === 'pelatihan' && $target->kegiatanPelatihan?->jadwalPelatihan?->pelatihan) {
                    $target->kegiatanPelatihan->jadwalPelatihan->pelatihan->update(['sertifikat_layout' => $r->layout]);
                } elseif ($target->jenis_kegiatan === 'sertifikasi' && $target->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi) {
                    $target->kegiatanSertifikasi->jadwalSertifikasi->sertifikasi->update(['sertifikat_layout' => $r->layout]);
                }

                $matching = Kegiatan::all()->filter(fn($k) => trim($k->detail?->judul ?? $k->judul) === $targetJudul);
                foreach ($matching as $k) {
                    $k->update(['sertifikat_layout' => $r->layout]);
                    Sertifikat::whereHas('pendaftaran', fn($q) => $q->where('kegiatan_id', $k->id))->update(['file_sertifikat' => null]);
                }
            }
        }

        if ($r->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Koordinat tata letak & font sertifikat berhasil disimpan.']);
        }

        return back()->with('success', 'Koordinat tata letak & font sertifikat berhasil disimpan.');
    }
}





