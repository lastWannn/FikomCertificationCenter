<?php

namespace App\Livewire\Admin;

use App\Models\Kegiatan;
use Livewire\Component;
use Livewire\WithPagination;

class PresensiKegiatanList extends Component
{
    use WithPagination;

    public string $q = '';
    public string $jenis = '';

    protected $queryString = [
        'q'     => ['except' => ''],
        'jenis' => ['except' => ''],
    ];

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function updatingJenis(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['q', 'jenis']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Kegiatan::with([
            'kegiatanPelatihan.jadwalPelatihan.pelatihan',
            'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi'
        ])
        ->withCount(['pendaftaran as total_peserta' => function ($q) {
            $q->where('status_pendaftaran', 'terdaftar');
        }]);

        if (!empty($this->jenis) && in_array($this->jenis, ['pelatihan', 'sertifikasi'])) {
            $query->where('jenis_kegiatan', $this->jenis);
        }

        if (!empty(trim($this->q))) {
            $search = trim($this->q);
            $query->where(function ($sub) use ($search) {
                $sub->whereHas('kegiatanPelatihan.jadwalPelatihan', fn($j) => $j->where('nama_kegiatan', 'like', "%{$search}%"))
                    ->orWhereHas('kegiatanSertifikasi.jadwalSertifikasi', fn($j) => $j->where('nama_kegiatan', 'like', "%{$search}%"));
            });
        }

        $kegiatanList = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.presensi-kegiatan-list', [
            'kegiatanList' => $kegiatanList,
        ]);
    }
}
