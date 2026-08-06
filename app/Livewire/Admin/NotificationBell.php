<?php

namespace App\Livewire\Admin;

use App\Models\Pembayaran;
use Livewire\Component;

class NotificationBell extends Component
{
    public bool $isOpen = false;

    public function toggleDropdown(): void
    {
        $this->isOpen = !$this->isOpen;
    }

    public function closeDropdown(): void
    {
        $this->isOpen = false;
    }

    public function render()
    {
        $notifPembayaran = Pembayaran::where('status_pembayaran', 'menunggu_verifikasi')
            ->with(['pendaftaran.peserta', 'pendaftaran.kegiatan'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        $notifPerpanjangan = Pembayaran::where('status_perpanjangan', 'menunggu')
            ->with(['pendaftaran.peserta', 'pendaftaran.kegiatan'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        $countPembayaran = Pembayaran::where('status_pembayaran', 'menunggu_verifikasi')->count();
        $countPerpanjangan = Pembayaran::where('status_perpanjangan', 'menunggu')->count();
        $totalNotifCount = $countPembayaran + $countPerpanjangan;

        return view('livewire.admin.notification-bell', [
            'notifPembayaran'   => $notifPembayaran,
            'notifPerpanjangan' => $notifPerpanjangan,
            'totalNotifCount'   => $totalNotifCount,
        ]);
    }
}
