<?php

namespace App\Livewire\Admin;

use App\Models\Pembayaran;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class PembayaranManager extends Component
{
    use WithPagination;

    public string $q = '';
    public string $status = '';
    public string $jenis = '';

    protected $queryString = [
        'q'      => ['except' => ''],
        'status' => ['except' => ''],
        'jenis'  => ['except' => ''],
    ];

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingJenis(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['q', 'status', 'jenis']);
        $this->resetPage();
    }

    public function render()
    {
        Pembayaran::updateExpiredPayments();

        $query = Pembayaran::with([
            'pendaftaran.peserta',
            'pendaftaran.kegiatan.kegiatanPelatihan.jadwalPelatihan',
            'pendaftaran.kegiatan.kegiatanSertifikasi.jadwalSertifikasi',
        ])->orderBy('created_at', 'desc');

        // Search: Nama, Email, Kode Pembayaran, Kode Unik
        if (!empty(trim($this->q))) {
            $keyword = trim($this->q);
            $query->where(function ($sub) use ($keyword) {
                $sub->where('kode_pembayaran', 'like', "%{$keyword}%")
                    ->orWhere('kode_unik', 'like', "%{$keyword}%")
                    ->orWhereHas('pendaftaran.peserta', function ($p) use ($keyword) {
                        $p->where('nama', 'like', "%{$keyword}%")
                          ->orWhere('email', 'like', "%{$keyword}%");
                    });
            });
        }

        // Filter: Status
        if (!empty($this->status)) {
            if ($this->status === 'req_perpanjangan') {
                $query->where('status_perpanjangan', 'menunggu');
            } else {
                $query->where('status_pembayaran', $this->status);
            }
        }

        // Filter: Jenis Kegiatan
        if (!empty($this->jenis) && in_array($this->jenis, ['pelatihan', 'sertifikasi'])) {
            $query->whereHas('pendaftaran.kegiatan', function ($k) {
                $k->where('jenis_kegiatan', $this->jenis);
            });
        }

        $pembayaranList = $query->paginate(15);

        $counts = [
            'total'               => Pembayaran::count(),
            'menunggu_verifikasi' => Pembayaran::where('status_pembayaran', 'menunggu_verifikasi')->count(),
            'req_perpanjangan'    => Pembayaran::where('status_perpanjangan', 'menunggu')->count(),
            'terverifikasi'       => Pembayaran::where('status_pembayaran', 'terverifikasi')->count(),
        ];

        return view('livewire.admin.pembayaran-manager', [
            'pembayaran' => $pembayaranList,
            'counts'     => $counts,
        ]);
    }
}
