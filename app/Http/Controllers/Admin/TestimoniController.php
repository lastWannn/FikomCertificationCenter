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
        $testimonis = Testimoni::orderBy('created_at', 'desc')->get();
        return view('admin.testimoni.index', compact('testimonis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'keterangan' => 'required|string|max:255',
            'kata' => 'required|string',
            'foto' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('testimoni', 'public');
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
            'foto' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($testimoni->foto) {
                Storage::disk('public')->delete($testimoni->foto);
            }
            $data['foto'] = $request->file('foto')->store('testimoni', 'public');
        }

        $testimoni->update($data);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil diperbarui');
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
