<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserManagement\ToggleStatusRequest;
use App\Models\Peserta;
use App\Services\Admin\UserManagementService;

class UserManagementController extends Controller
{
    public function __construct(private UserManagementService $service) {}

    public function index()  { return redirect()->route('admin.pengguna.peserta'); }

    public function peserta(\Illuminate\Http\Request $r) {
        $query = Peserta::withCount('pendaftaran')
            ->when($r->search, fn($q) => $q->where('nama','LIKE',"%{$r->search}%")->orWhere('email','LIKE',"%{$r->search}%"))
            ->when($r->status, fn($q) => $q->where('status_akun',$r->status))->latest();
        return view('admin.pengguna.peserta', [
            'peserta' => $query->paginate(20)->withQueryString(),
            'stats'   => [
                'total'       => Peserta::count(),
                'aktif'       => Peserta::where('status_akun','aktif')->count(),
                'nonaktif'    => Peserta::where('status_akun','nonaktif')->count(),
                'ditangguhkan'=> Peserta::where('status_akun','ditangguhkan')->count(),
            ],
        ]);
    }
    public function detailPeserta(\Illuminate\Http\Request $request, Peserta $peserta) {
        $peserta->load(['pendaftaran.kegiatan','pendaftaran.pembayaran','pendaftaran.sertifikat']);
        if ($request->ajax()) {
            return view('admin.pengguna._detail-modal', compact('peserta'));
        }
        return view('admin.pengguna.detail-peserta', compact('peserta'));
    }
    public function toggleStatusPeserta(ToggleStatusRequest $request, Peserta $peserta) {
        $this->service->toggleStatus($peserta, $request->status);
        $label = match($request->status) {'aktif'=>'diaktifkan','nonaktif'=>'dinonaktifkan',default=>'ditangguhkan'};
        return back()->with('success', "Akun {$peserta->nama} berhasil {$label}.");
    }
    public function hapusPeserta(Peserta $peserta) {
        try {
            $this->service->hapus($peserta);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('admin.pengguna.peserta')->with('success','Akun peserta berhasil dihapus.');
    }
    public function resetPassword(Peserta $peserta) {
        $newPass = $this->service->resetPassword($peserta);
        return back()->with('success', "Password direset. Email dikirim ke {$peserta->email}.");
    }
}
