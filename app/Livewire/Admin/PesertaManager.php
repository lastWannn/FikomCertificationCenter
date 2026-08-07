<?php

namespace App\Livewire\Admin;

use App\Models\Peserta;
use App\Services\Admin\UserManagementService;
use Livewire\Component;
use Livewire\WithPagination;

class PesertaManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public ?string $message = null;
    public ?string $messageType = 'success';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function toggleStatus(int $pesertaId, string $newStatus): void
    {
        $peserta = Peserta::find($pesertaId);
        if (!$peserta) return;

        app(UserManagementService::class)->toggleStatus($peserta, $newStatus);

        $label = match($newStatus) {
            'aktif' => 'diaktifkan',
            default => 'dinonaktifkan',
        };

        $this->message = "Status akun {$peserta->nama} berhasil {$label}.";
        $this->messageType = 'success';
    }

    public function deletePeserta(int $pesertaId): void
    {
        $peserta = Peserta::find($pesertaId);
        if (!$peserta) return;

        try {
            app(UserManagementService::class)->hapus($peserta);
            $this->message = "Akun peserta {$peserta->nama} berhasil dihapus.";
            $this->messageType = 'success';
        } catch (\Exception $e) {
            $this->message = $e->getMessage();
            $this->messageType = 'error';
        }
    }

    public function resetPassword(int $pesertaId): void
    {
        $peserta = Peserta::find($pesertaId);
        if (!$peserta) return;

        app(UserManagementService::class)->resetPassword($peserta);

        $this->message = "Password untuk {$peserta->nama} berhasil direset dan dikirim ke {$peserta->email}.";
        $this->messageType = 'success';
    }

    public function render()
    {
        $query = Peserta::withCount('pendaftaran')
            ->when($this->search, function ($q) {
                $s = trim($this->search);
                $q->where(function ($sub) use ($s) {
                    $sub->where('nama', 'LIKE', "%{$s}%")
                        ->orWhere('email', 'LIKE', "%{$s}%")
                        ->orWhere('no_hp', 'LIKE', "%{$s}%")
                        ->orWhere('instansi', 'LIKE', "%{$s}%");
                });
            })
            ->when($this->status, function ($q) {
                $q->where('status_akun', $this->status);
            })
            ->latest();

        $pesertaList = $query->paginate(15);

        $stats = [
            'total'    => Peserta::count(),
            'aktif'    => Peserta::where('status_akun', 'aktif')->count(),
            'nonaktif' => Peserta::where('status_akun', 'nonaktif')->count(),
        ];

        return view('livewire.admin.peserta-manager', [
            'peserta' => $pesertaList,
            'stats'   => $stats,
        ]);
    }
}
