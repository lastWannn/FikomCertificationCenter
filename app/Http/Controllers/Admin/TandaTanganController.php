<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TandaTangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TandaTanganController extends Controller
{
    /**
     * Halaman Pengaturan Tanda Tangan Digital
     */
    public function index()
    {
        $ttd = TandaTangan::getAktif();
        return view('admin.tanda-tangan.index', compact('ttd'));
    }

    /**
     * Simpan / Update Pengaturan Tanda Tangan & File TTD
     */
    public function update(Request $request)
    {
        $request->validate([
            'dekan_nama'        => 'required|string|max:150',
            'dekan_jabatan'     => 'required|string|max:100',
            'dekan_nip'         => 'nullable|string|max:50',
            'dekan_ttd'         => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',

            'ketua_nama'        => 'required|string|max:150',
            'ketua_jabatan'     => 'required|string|max:100',
            'ketua_nip'         => 'nullable|string|max:50',
            'ketua_ttd'         => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',

            'bendahara_nama'    => 'required|string|max:150',
            'bendahara_jabatan' => 'required|string|max:100',
            'bendahara_nip'     => 'nullable|string|max:50',
            'bendahara_ttd'     => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ], [
            'dekan_nama.required'     => 'Nama Dekan wajib diisi.',
            'dekan_jabatan.required'  => 'Jabatan Dekan wajib diisi.',
            'dekan_ttd.image'         => 'File TTD Dekan harus berupa gambar (PNG/JPG/WebP/SVG).',
            'dekan_ttd.max'           => 'Ukuran file TTD Dekan maksimal 2MB.',

            'ketua_nama.required'     => 'Nama Ketua Unit wajib diisi.',
            'ketua_jabatan.required'  => 'Jabatan Ketua Unit wajib diisi.',
            'ketua_ttd.image'         => 'File TTD Ketua Unit harus berupa gambar (PNG/JPG/WebP/SVG).',
            'ketua_ttd.max'           => 'Ukuran file TTD Ketua Unit maksimal 2MB.',

            'bendahara_nama.required' => 'Nama Bendahara/Keuangan wajib diisi.',
            'bendahara_jabatan.required' => 'Jabatan Bendahara/Keuangan wajib diisi.',
            'bendahara_ttd.image'     => 'File TTD/Stempel Invoice harus berupa gambar (PNG/JPG/WebP/SVG).',
            'bendahara_ttd.max'       => 'Ukuran file TTD/Stempel Invoice maksimal 2MB.',
        ]);

        $ttd = TandaTangan::getAktif();

        $ttd->dekan_nama        = $request->dekan_nama;
        $ttd->dekan_jabatan     = $request->dekan_jabatan;
        $ttd->dekan_nip         = $request->dekan_nip;

        $ttd->ketua_nama        = $request->ketua_nama;
        $ttd->ketua_jabatan     = $request->ketua_jabatan;
        $ttd->ketua_nip         = $request->ketua_nip;

        $ttd->bendahara_nama    = $request->bendahara_nama;
        $ttd->bendahara_jabatan = $request->bendahara_jabatan;
        $ttd->bendahara_nip     = $request->bendahara_nip;

        // Handle upload file TTD Dekan (Otomatis hapus background putih & simpan file baru tanpa merusak arsip lama)
        if ($request->hasFile('dekan_ttd')) {
            $ttd->dekan_ttd = \App\Helpers\SignatureHelper::processTransparent($request->file('dekan_ttd'), 'tanda-tangan');
        }

        // Handle upload file TTD Ketua Unit (Otomatis hapus background putih & simpan file baru tanpa merusak arsip lama)
        if ($request->hasFile('ketua_ttd')) {
            $ttd->ketua_ttd = \App\Helpers\SignatureHelper::processTransparent($request->file('ketua_ttd'), 'tanda-tangan');
        }

        // Handle upload file TTD/Stempel Bendahara (Otomatis hapus background putih & simpan file baru tanpa merusak arsip lama)
        if ($request->hasFile('bendahara_ttd')) {
            $ttd->bendahara_ttd = \App\Helpers\SignatureHelper::processTransparent($request->file('bendahara_ttd'), 'tanda-tangan');
        }

        $ttd->save();

        return redirect()->route('admin.tanda-tangan.index')->with('success', 'Pengaturan Tanda Tangan & Penandatangan Dokumen berhasil diperbarui!');
    }

    /**
     * Hapus gambar TTD aktif (dekan / ketua / bendahara) dari pengaturan aktif
     */
    public function destroy($type)
    {
        $ttd = TandaTangan::getAktif();

        if ($type === 'dekan' && $ttd->dekan_ttd) {
            $ttd->dekan_ttd = null;
            $ttd->save();
            return redirect()->back()->with('success', 'File Tanda Tangan Dekan berhasil dikosongkan dari pengaturan aktif.');
        }

        if ($type === 'ketua' && $ttd->ketua_ttd) {
            $ttd->ketua_ttd = null;
            $ttd->save();
            return redirect()->back()->with('success', 'File Tanda Tangan Ketua Unit berhasil dikosongkan dari pengaturan aktif.');
        }

        if ($type === 'bendahara' && $ttd->bendahara_ttd) {
            $ttd->bendahara_ttd = null;
            $ttd->save();
            return redirect()->back()->with('success', 'File Tanda Tangan / Stempel Bendahara Invoice berhasil dikosongkan dari pengaturan aktif.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus file tanda tangan.');
    }
}
