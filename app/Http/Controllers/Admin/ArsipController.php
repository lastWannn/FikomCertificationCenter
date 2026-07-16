<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{ArsipKegiatan,Kegiatan};
use Illuminate\Http\Request;
class ArsipController extends Controller {
    public function index() { return view('admin.lainnya.arsip',['arsip'=>ArsipKegiatan::with('kegiatan')->paginate(10)]); }
    public function create() { return view('admin.lainnya.arsip-form',['kegiatan'=>Kegiatan::doesntHave('arsip')->get()]); }
    public function store(Request $r) {
        $r->validate(['kegiatan_id'=>'required','judul'=>'required']);
        $data = $r->only('kegiatan_id','judul','ringkasan');
        if ($r->hasFile('berita_acara')) $data['berita_acara'] = $r->file('berita_acara')->store('arsip','public');
        ArsipKegiatan::create($data);
        return redirect()->route('admin.arsip.index')->with('success','Arsip dibuat.');
    }
    public function show(ArsipKegiatan $arsip) { return view('admin.lainnya.arsip-form',compact('arsip')); }
    public function edit(ArsipKegiatan $arsip) { return view('admin.lainnya.arsip-form',compact('arsip'),['kegiatan'=>Kegiatan::all()]); }
    public function update(Request $r, ArsipKegiatan $arsip) {
        $data = $r->only('judul','ringkasan');
        if ($r->hasFile('berita_acara')) $data['berita_acara'] = $r->file('berita_acara')->store('arsip','public');
        $arsip->update($data);
        return redirect()->route('admin.arsip.index')->with('success','Arsip diperbarui.');
    }
    public function destroy(ArsipKegiatan $arsip) { $arsip->delete(); return back()->with('success','Arsip dihapus.'); }
}