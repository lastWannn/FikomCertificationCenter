<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Rekening;
use Illuminate\Http\Request;
class RekeningController extends Controller {
    public function index() { return view('admin.lainnya.rekening',['rekening'=>Rekening::all()]); }
    public function create() { return view('admin.lainnya.rekening-form'); }
    public function store(Request $r) {
        $r->validate(['nama_pemilik'=>'required','bank'=>'required','no_rekening'=>'required']);
        Rekening::create($r->only('nama_pemilik','bank','no_rekening'));
        return redirect()->route('admin.rekening.index')->with('success','Rekening ditambahkan.');
    }
    public function show(Rekening $rekening) { return redirect()->route('admin.rekening.index'); }
    public function edit(Rekening $rekening) { return view('admin.lainnya.rekening-form',compact('rekening')); }
    public function update(Request $r, Rekening $rekening) {
        $rekening->update($r->only('nama_pemilik','bank','no_rekening'));
        return redirect()->route('admin.rekening.index')->with('success','Rekening diperbarui.');
    }
    public function destroy(Rekening $rekening) { $rekening->delete(); return back()->with('success','Rekening dihapus.'); }
    public function aktifkan(Rekening $rekening) { $rekening->aktifkan(); return back()->with('success','Rekening '.$rekening->bank.' diaktifkan.'); }
}