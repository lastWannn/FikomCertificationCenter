<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{MateriSertifikasi, Sertifikasi};
use Illuminate\Http\Request;

class MateriSertifikasiController extends Controller
{
    public function create(Sertifikasi $sertifikasi)
    {
        return view('admin.materi.sertifikasi-form', compact('sertifikasi'));
    }

    public function store(Request $r, Sertifikasi $sertifikasi)
    {
        $r->validate([
            'judul_materi' => 'required|string|max:255',
            'isi'          => 'nullable|string',
            'file_materi'  => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,zip|max:20480',
        ]);
        $data = $r->only('judul_materi','isi');
        $data['sertifikasi_id'] = $sertifikasi->id;
        $data['urutan']         = $sertifikasi->materi()->max('urutan') + 1;
        if ($r->hasFile('file_materi')) {
            $data['file_materi'] = $r->file('file_materi')->store('materi/sertifikasi','public');
        }
        MateriSertifikasi::create($data);
        return redirect()->route('admin.sertifikasi.show', $sertifikasi->id)
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Sertifikasi $sertifikasi, MateriSertifikasi $materi)
    {
        return view('admin.materi.sertifikasi-form', compact('sertifikasi','materi'));
    }

    public function update(Request $r, Sertifikasi $sertifikasi, MateriSertifikasi $materi)
    {
        $r->validate(['judul_materi'=>'required']);
        $data = $r->only('judul_materi','isi');
        if ($r->hasFile('file_materi')) {
            $data['file_materi'] = $r->file('file_materi')->store('materi/sertifikasi','public');
        }
        $materi->update($data);
        return redirect()->route('admin.sertifikasi.show', $sertifikasi->id)
            ->with('success', 'Materi diperbarui.');
    }

    public function destroy(Sertifikasi $sertifikasi, MateriSertifikasi $materi)
    {
        $materi->delete();
        return back()->with('success', 'Materi dihapus.');
    }
}
