<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesanMasuk;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index(Request $request)
    {
        $query = PesanMasuk::latest();

        if ($request->has('status') && in_array($request->status, ['belum_dibaca', 'dibaca', 'dibalas'])) {
            $query->where('status', $request->status);
        }

        if ($request->has('q') && !empty($request->q)) {
            $q = trim($request->q);
            $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('pesan', 'like', "%{$q}%");
            });
        }

        $pesanList = $query->paginate(15)->withQueryString();
        $unreadCount = PesanMasuk::where('status', 'belum_dibaca')->count();

        return view('admin.lainnya.pesan-index', compact('pesanList', 'unreadCount'));
    }

    public function show(PesanMasuk $pesan)
    {
        if ($pesan->status === 'belum_dibaca') {
            $pesan->update(['status' => 'dibaca']);
        }
        return view('admin.lainnya.pesan-show', compact('pesan'));
    }

    public function markAsRead(PesanMasuk $pesan)
    {
        if ($pesan->status === 'belum_dibaca') {
            $pesan->update(['status' => 'dibaca']);
        }
        return response()->json([
            'success' => true,
            'unread_count' => PesanMasuk::where('status', 'belum_dibaca')->count()
        ]);
    }

    public function destroy(PesanMasuk $pesan)
    {
        $pesan->delete();
        return redirect()->route('admin.pesan.index')->with('success', 'Pesan masuk berhasil dihapus.');
    }
}
