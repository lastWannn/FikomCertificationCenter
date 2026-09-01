<?php
namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class JelajahiController extends Controller {
    public function index(Request $r) {
        $peserta = Auth::guard('peserta')->user();
        $sudahDaftar = $peserta->pendaftaran()
            ->whereNotIn('status_pendaftaran', ['ditolak', 'dibatalkan'])
            ->whereDoesntHave('pembayaran', function ($p) {
                $p->whereIn('status_pembayaran', ['ditolak', 'kadaluarsa']);
            })
            ->pluck('kegiatan_id')
            ->toArray();

        $q = Kegiatan::visibleToPublic()->with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi',
            'biaya',
            'pendaftaran'
        ]);

        if ($r->jenis && in_array($r->jenis, ['pelatihan', 'sertifikasi'])) {
            $q->where('jenis_kegiatan', $r->jenis);
        }

        if ($r->q) {
            $q->where(function($sub) use ($r) {
                $sub->whereHas('kegiatanPelatihan.jadwalPelatihan.pelatihan', fn($p) => $p->where('judul', 'like', '%'.$r->q.'%'))
                    ->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi.sertifikasi', fn($s) => $s->where('judul', 'like', '%'.$r->q.'%'));
            });
        }

        $allKegiatan = $q->get();

        // Custom sorting:
        // 1. Kegiatan TERBUKA di paling atas.
        // 2. Kegiatan terbuka diurutkan berdasarkan deadline pendaftaran terdekat (ASCENDING).
        // 3. Kegiatan TUTUP di paling bawah.
        // 4. Kegiatan tutup diurutkan berdasarkan tanggal pelaksanaan (DESCENDING).
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

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 9;
        $currentItems = $sorted->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $kegiatan = new LengthAwarePaginator(
            $currentItems,
            $sorted->count(),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $r->query(),
            ]
        );

        return view('peserta.jelajahi', compact('kegiatan', 'sudahDaftar'));
    }
}