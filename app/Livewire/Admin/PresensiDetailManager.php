<?php

namespace App\Livewire\Admin;

use App\Models\Kegiatan;
use App\Models\Pendaftaran;
use Livewire\Component;
use Livewire\WithPagination;

class PresensiDetailManager extends Component
{
    use WithPagination;

    public Kegiatan $kegiatan;
    public string $search = '';
    public string $statusFilter = '';
    public ?string $toastMessage = null;

    protected $queryString = [
        'search'       => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function mount(Kegiatan $kegiatan): void
    {
        $this->kegiatan = $kegiatan;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function markAttendance(int $pendaftaranId, string $status): void
    {
        $jadwal = $this->kegiatan->jadwal;
        if ($jadwal && $jadwal->tgl_pelaksanaan && \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->gt(now()->startOfDay())) {
            $this->toastMessage = "Presensi tidak dapat diubah karena kegiatan belum dimulai (Tanggal Pelaksanaan: " . \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->format('d M Y') . ").";
            return;
        }

        if (!in_array($status, ['hadir', 'tidak_hadir', 'belum'])) return;

        $pendaftaran = Pendaftaran::where('id', $pendaftaranId)
            ->where('kegiatan_id', $this->kegiatan->id)
            ->first();

        if ($pendaftaran) {
            $pendaftaran->update(['status_kehadiran' => $status]);
            
            $nama = $pendaftaran->peserta->nama ?? 'Peserta';
            $label = match($status) {
                'hadir' => 'HADIR',
                'tidak_hadir' => 'TIDAK HADIR',
                default => 'BELUM HADIR'
            };

            $this->toastMessage = "Presensi {$nama} diperbarui menjadi {$label}.";
        }
    }

    public function render()
    {
        $query = Pendaftaran::where('kegiatan_id', $this->kegiatan->id)
            ->where('status_pendaftaran', 'terdaftar')
            ->with('peserta');

        if (!empty(trim($this->search))) {
            $s = trim($this->search);
            $query->whereHas('peserta', function ($p) use ($s) {
                $p->where('nama', 'LIKE', "%{$s}%")
                  ->orWhere('email', 'LIKE', "%{$s}%")
                  ->orWhere('instansi', 'LIKE', "%{$s}%")
                  ->orWhere('no_hp', 'LIKE', "%{$s}%");
            });
        }

        if (!empty($this->statusFilter)) {
            $query->where('status_kehadiran', $this->statusFilter);
        }

        $pendaftaranList = $query->paginate(20);

        $counts = [
            'total'       => Pendaftaran::where('kegiatan_id', $this->kegiatan->id)->where('status_pendaftaran', 'terdaftar')->count(),
            'hadir'       => Pendaftaran::where('kegiatan_id', $this->kegiatan->id)->where('status_pendaftaran', 'terdaftar')->where('status_kehadiran', 'hadir')->count(),
            'tidak_hadir' => Pendaftaran::where('kegiatan_id', $this->kegiatan->id)->where('status_pendaftaran', 'terdaftar')->where('status_kehadiran', 'tidak_hadir')->count(),
            'belum'       => Pendaftaran::where('kegiatan_id', $this->kegiatan->id)->where('status_pendaftaran', 'terdaftar')->where(function($q) { $q->whereNull('status_kehadiran')->orWhere('status_kehadiran', 'belum'); })->count(),
        ];

        return view('livewire.admin.presensi-detail-manager', [
            'pendaftaran' => $pendaftaranList,
            'counts'      => $counts,
        ]);
    }
}
