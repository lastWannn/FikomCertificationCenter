<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class InformasiController extends Controller {
    public function index(Request $r) {
        $q = Informasi::with('admin')->orderBy('created_at','desc');
        if ($r->jenis) $q->where('jenis',$r->jenis);
        return view('admin.lainnya.informasi',['informasi'=>$q->paginate(15)]);
    }
    public function create() { return view('admin.lainnya.informasi-form'); }
    public function store(Request $r) {
        $r->validate(['judul'=>'required','isi'=>'required','jenis'=>'required|in:info,faq']);
        Informasi::create(['judul'=>$r->judul,'isi'=>$r->isi,'jenis'=>$r->jenis,'admin_id'=>Auth::guard('admin')->id()]);
        return redirect()->route('admin.informasi.index')->with('success','Informasi ditambahkan.');
    }
    public function show(Informasi $informasi) { return redirect()->route('admin.informasi.index'); }
    public function edit(Informasi $informasi) { return view('admin.lainnya.informasi-form',compact('informasi')); }
    public function update(Request $r, Informasi $informasi) {
        $r->validate(['judul'=>'required','isi'=>'required','jenis'=>'required|in:info,faq']);
        $informasi->update($r->only('judul','isi','jenis'));
        return redirect()->route('admin.informasi.index')->with('success','Informasi diperbarui.');
    }
    public function destroy(Informasi $informasi) { $informasi->delete(); return back()->with('success','Informasi dihapus.'); }
}