<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{KategoriPelatihan, KategoriSertifikasi};
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('admin.kategori.index', [
            'pelatihan'   => KategoriPelatihan::withCount('pelatihan')->orderBy('nama_kategori')->get(),
            'sertifikasi' => KategoriSertifikasi::withCount('sertifikasi')->orderBy('nama_kategori')->get(),
        ]);
    }

    public function store(Request $r)
    {
        $r->validate([
            'nama_kategori' => 'required|string|max:150',
            'jenis'         => 'required|in:pelatihan,sertifikasi',
        ]);
        if ($r->jenis === 'pelatihan') {
            KategoriPelatihan::create(['nama_kategori' => $r->nama_kategori]);
        } else {
            KategoriSertifikasi::create(['nama_kategori' => $r->nama_kategori]);
        }
        return back()->with('success', 'Kategori '.ucfirst($r->jenis).' berhasil ditambahkan.');
    }

    /**
     * Update — $id sekarang adalah hashid, decode dulu.
     */
    public function update(Request $r, string $hashid)
    {
        $r->validate([
            'nama_kategori' => 'required|string|max:150',
            'jenis'         => 'required|in:pelatihan,sertifikasi',
        ]);

        if ($r->jenis === 'pelatihan') {
            $kat = KategoriPelatihan::findByHashidOrFail($hashid);
            $kat->update(['nama_kategori' => $r->nama_kategori]);
        } else {
            $kat = KategoriSertifikasi::findByHashidOrFail($hashid);
            $kat->update(['nama_kategori' => $r->nama_kategori]);
        }
        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Destroy — $id sekarang adalah hashid, decode dulu.
     */
    public function destroy(string $hashid, Request $r)
    {
        $r->validate(['jenis' => 'required|in:pelatihan,sertifikasi']);

        if ($r->jenis === 'pelatihan') {
            $kat = KategoriPelatihan::findByHashidOrFail($hashid);
            if ($kat->pelatihan()->count()) {
                return back()->with('error', 'Kategori masih digunakan oleh program pelatihan.');
            }
            $kat->delete();
        } else {
            $kat = KategoriSertifikasi::findByHashidOrFail($hashid);
            if ($kat->sertifikasi()->count()) {
                return back()->with('error', 'Kategori masih digunakan oleh program sertifikasi.');
            }
            $kat->delete();
        }
        return back()->with('success', 'Kategori dihapus.');
    }

    public function create() { return redirect()->route('admin.kategori.index'); }
    public function edit(string $hashid) { return redirect()->route('admin.kategori.index'); }
    public function show(string $hashid) { return redirect()->route('admin.kategori.index'); }
}
