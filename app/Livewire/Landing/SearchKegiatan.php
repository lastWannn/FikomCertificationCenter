<?php

namespace App\Livewire\Landing;

use App\Models\Kegiatan;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;

class SearchKegiatan extends Component
{
    use WithPagination;

    public string $search = '';
    public string $jenis = '';
    public string $kategoriId = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'jenis' => ['except' => ''],
        'kategoriId' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingJenis(): void
    {
        $this->resetPage();
    }

    public function updatingKategoriId(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'jenis', 'kategoriId']);
        $this->resetPage();
    }

    public function render()
    {
        // Auto archive completed activities
        app(\App\Services\Admin\ArsipService::class)->autoArchiveCompleted();

        $query = Kegiatan::upcoming()
            ->with([
                'kegiatanPelatihan.jadwalPelatihan.pelatihan.kategori',
                'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi.kategori',
                'biaya',
                'pendaftaran'
            ]);

        if (!empty($this->jenis) && in_array($this->jenis, ['pelatihan', 'sertifikasi'])) {
            $query->where('jenis_kegiatan', $this->jenis);
        }

        if (!empty($this->kategoriId)) {
            $query->where(function ($q) {
                $q->whereHas('kegiatanPelatihan.jadwalPelatihan.pelatihan', function ($qp) {
                    $qp->where('kategori_id', $this->kategoriId);
                })->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi.sertifikasi', function ($qs) {
                    $qs->where('kategori_id', $this->kategoriId);
                });
            });
        }

        if (!empty(trim($this->search))) {
            $s = trim($this->search);
            $query->where(function ($q) use ($s) {
                $q->whereHas('kegiatanPelatihan.jadwalPelatihan.pelatihan', function ($qp) use ($s) {
                    $qp->where('judul', 'LIKE', "%{$s}%")->orWhere('isi', 'LIKE', "%{$s}%");
                })->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi.sertifikasi', function ($qs) use ($s) {
                    $qs->where('judul', 'LIKE', "%{$s}%")->orWhere('isi', 'LIKE', "%{$s}%");
                });
            });
        }

        $kegiatan = $query
            ->leftJoin('kegiatan_pelatihan as kp', 'kegiatan.id', '=', 'kp.kegiatan_id')
            ->leftJoin('jadwal_pelatihan as jp', 'kp.jadwal_pelatihan_id', '=', 'jp.id')
            ->leftJoin('kegiatan_sertifikasi as ks', 'kegiatan.id', '=', 'ks.kegiatan_id')
            ->leftJoin('jadwal_sertifikasi as js', 'ks.jadwal_sertifikasi_id', '=', 'js.id')
            ->select('kegiatan.*')
            ->orderByRaw("CASE WHEN status = 'comingsoon' THEN 1 ELSE 0 END ASC")
            ->orderByRaw("COALESCE(jp.tgl_pelaksanaan, js.tgl_pelaksanaan) ASC")
            ->orderBy('kegiatan.id', 'asc')
            ->paginate(9);
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('livewire.landing.search-kegiatan', [
            'kegiatan' => $kegiatan,
            'kategoris' => $kategoris
        ]);
    }
}
