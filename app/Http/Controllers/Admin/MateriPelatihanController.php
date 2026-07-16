<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{MateriPelatihan, Pelatihan};
use Illuminate\Http\Request;

class MateriPelatihanController extends Controller
{
    public function create(Pelatihan $pelatihan)
    {
        return view('admin.materi.pelatihan-form', compact('pelatihan'));
    }

    public function store(Request $r, Pelatihan $pelatihan)
    {
        $r->validate([
            'judul_materi'  => 'required|string|max:255',
            'jam_pelajaran' => 'required|integer|min:1',
            'file_materi'   => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,zip|max:20480',
        ]);
        $data = $r->only('judul_materi','jam_pelajaran');
        $data['pelatihan_id'] = $pelatihan->id;
        $data['urutan']       = $pelatihan->materi()->max('urutan') + 1;
        if ($r->hasFile('file_materi')) {
            $data['file_materi'] = $r->file('file_materi')->store('materi/pelatihan','public');
        }
        MateriPelatihan::create($data);
        return redirect()->route('admin.pelatihan.show', $pelatihan->id)
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Pelatihan $pelatihan, MateriPelatihan $materi)
    {
        return view('admin.materi.pelatihan-form', compact('pelatihan','materi'));
    }

    public function update(Request $r, Pelatihan $pelatihan, MateriPelatihan $materi)
    {
        $r->validate(['judul_materi'=>'required','jam_pelajaran'=>'required|integer|min:1']);
        $data = $r->only('judul_materi','jam_pelajaran');
        if ($r->hasFile('file_materi')) {
            $data['file_materi'] = $r->file('file_materi')->store('materi/pelatihan','public');
        }
        $materi->update($data);
        return redirect()->route('admin.pelatihan.show', $pelatihan->id)
            ->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Pelatihan $pelatihan, MateriPelatihan $materi)
    {
        $materi->delete();
        // Re-urutan
        $pelatihan->materi()->orderBy('urutan')->get()->each(function($m,$i){$m->update(['urutan'=>$i+1]);});
        return back()->with('success', 'Materi dihapus.');
    }

    public function reorder(Request $r, Pelatihan $pelatihan)
    {
        $r->validate(['order'=>'required|array']);
        foreach ($r->order as $i => $id) {
            MateriPelatihan::where('id',$id)->update(['urutan' => $i+1]);
        }
        return response()->json(['ok'=>true]);
    }
}
