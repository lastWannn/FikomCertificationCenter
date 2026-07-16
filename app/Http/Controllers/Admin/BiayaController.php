<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{BiayaKegiatan,Kegiatan};
use Illuminate\Http\Request;
class BiayaController extends Controller {
    public function index() { return view('admin.lainnya.biaya',['biaya'=>BiayaKegiatan::with('kegiatan')->paginate(15)]); }
    public function create() { return view('admin.lainnya.biaya-form',['kegiatan'=>Kegiatan::all()]); }
    public function store(Request $r) {
        $r->validate(['kegiatan_id'=>'required','nama_jenis'=>'required','nominal'=>'required|numeric|min:0']);
        BiayaKegiatan::create($r->only('kegiatan_id','nama_jenis','nominal'));
        return redirect()->route('admin.biaya.index')->with('success','Biaya ditambahkan.');
    }
    public function show(BiayaKegiatan $biaya) { return redirect()->route('admin.biaya.index'); }
    public function edit(BiayaKegiatan $biaya) { return view('admin.lainnya.biaya-form',['biaya'=>$biaya,'kegiatan'=>Kegiatan::all()]); }
    public function update(Request $r, BiayaKegiatan $biaya) {
        $r->validate(['nama_jenis'=>'required','nominal'=>'required|numeric|min:0']);
        $biaya->update($r->only('nama_jenis','nominal'));
        return redirect()->route('admin.biaya.index')->with('success','Biaya diperbarui.');
    }
    public function destroy(BiayaKegiatan $biaya) { $biaya->delete(); return back()->with('success','Biaya dihapus.'); }
}