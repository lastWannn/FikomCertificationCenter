<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function edit()
    {
        $kontak = Kontak::aktif() ?? new Kontak();
        return view('admin.pengaturan.kontak', compact('kontak'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'nullable|string|max:150',
            'alamat' => 'nullable|string',
            'telepon' => ['nullable', 'string', 'max:50', 'regex:/^[0-9\+\-\(\)\/\s]+$/'],
            'email' => 'nullable|email|max:150',
            'maps_embed' => 'nullable|string',
        ], [
            'telepon.regex' => 'Nomor telepon hanya boleh berisi angka dan simbol (+, -, (), /, spasi).',
        ]);

        $kontak = Kontak::aktif();
        if ($kontak) {
            $kontak->update($request->all());
        } else {
            Kontak::create($request->all());
        }

        return redirect()->route('admin.kontak.edit')->with('success', 'Pengaturan Kontak berhasil diperbarui');
    }
}
