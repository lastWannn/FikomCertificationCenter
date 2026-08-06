<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{
    public function index()
    {
        $mitras = Mitra::orderBy('urutan', 'asc')->paginate(12)->withQueryString();
        return view('admin.mitra.index', compact('mitras'));
    }

    public function create()
    {
        return view('admin.mitra.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'inisial' => 'required|string|max:10',
            'warna' => 'nullable|string|max:20',
            'urutan' => 'nullable|integer|unique:mitra,urutan',
            'deskripsi' => 'nullable|string',
            'link_website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048'
        ], [
            'urutan.unique' => 'Nomor urutan ini sudah dipakai oleh mitra lain. Silakan pilih urutan lain.'
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = \App\Helpers\ImageHelper::compressToWebp($request->file('logo'), 'mitra');
        }

        Mitra::create($data);

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra berhasil ditambahkan');
    }

    public function edit(Mitra $mitra)
    {
        return view('admin.mitra.edit', compact('mitra'));
    }

    public function update(Request $request, Mitra $mitra)
    {
        $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'inisial' => 'required|string|max:10',
            'warna' => 'nullable|string|max:20',
            'urutan' => 'nullable|integer|unique:mitra,urutan,' . $mitra->id,
            'deskripsi' => 'nullable|string',
            'link_website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048'
        ], [
            'urutan.unique' => 'Nomor urutan ini sudah dipakai oleh mitra lain. Silakan pilih urutan lain.'
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            if ($mitra->logo) {
                Storage::disk('public')->delete($mitra->logo);
            }
            $data['logo'] = \App\Helpers\ImageHelper::compressToWebp($request->file('logo'), 'mitra');
        }

        $mitra->update($data);

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra berhasil diubah');
    }

    public function destroy(Mitra $mitra)
    {
        if ($mitra->logo) {
            Storage::disk('public')->delete($mitra->logo);
        }
        $mitra->delete();

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra berhasil dihapus');
    }
}
