<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonis = Testimoni::orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.testimoni.index', compact('testimonis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'keterangan' => 'required|string|max:255',
            'kata' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'status' => 'nullable|in:dipublikasikan,pending,ditolak',
        ]);

        $data = $request->except('foto');
        $data['status'] = $request->input('status', 'dipublikasikan');

        if ($request->hasFile('foto')) {
            $data['foto'] = \App\Helpers\ImageHelper::compressToWebp($request->file('foto'), 'testimoni');
        }

        Testimoni::create($data);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil ditambahkan');
    }

    public function update(Request $request, Testimoni $testimoni)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'keterangan' => 'required|string|max:255',
            'kata' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'status' => 'nullable|in:dipublikasikan,pending,ditolak',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($testimoni->foto) {
                Storage::disk('public')->delete($testimoni->foto);
            }
            $data['foto'] = \App\Helpers\ImageHelper::compressToWebp($request->file('foto'), 'testimoni');
        }

        $testimoni->update($data);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil diperbarui');
    }

    public function toggleStatus(Testimoni $testimoni)
    {
        $newStatus = $testimoni->status === 'dipublikasikan' ? 'pending' : 'dipublikasikan';
        $testimoni->update(['status' => $newStatus]);

        $msg = $newStatus === 'dipublikasikan' 
            ? 'Testimoni telah dipublikasikan ke Landing Page.' 
            : 'Testimoni telah disembunyikan (Pending).';

        return redirect()->route('admin.testimoni.index')->with('success', $msg);
    }

    public function destroy(Testimoni $testimoni)
    {
        if ($testimoni->foto) {
            Storage::disk('public')->delete($testimoni->foto);
        }
        $testimoni->delete();

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil dihapus');
    }
}
