<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Sertifikasi,KategoriSertifikasi};
use Illuminate\Http\Request;
class SertifikasiController extends Controller {
    public function index()  { return view('admin.sertifikasi.index',['sertifikasi'=>Sertifikasi::with('kategori')->paginate(10)]); }
    public function create() { return view('admin.sertifikasi.create',['kategori'=>KategoriSertifikasi::all()]); }
    public function store(Request $r) {
        $r->validate(['kode'=>'required|unique:sertifikasi','judul'=>'required','isi'=>'required','kategori_sertifikasi_id'=>'required']);
        $data = $r->except(['_token','gambar']);
        if ($r->hasFile('gambar')) $data['gambar'] = $r->file('gambar')->store('sertifikasi','public');
        Sertifikasi::create($data);
        return redirect()->route('admin.sertifikasi.index')->with('success','Sertifikasi berhasil ditambahkan.');
    }
    public function show(Sertifikasi $s) { return view('admin.sertifikasi.show',['sertifikasi'=>$s]); }
    public function edit(Sertifikasi $sertifikasi) { return view('admin.sertifikasi.edit',compact('sertifikasi'),['kategori'=>KategoriSertifikasi::all()]); }
    public function update(Request $r, Sertifikasi $sertifikasi) {
        $data = $r->except(['_token','_method','gambar']);
        if ($r->hasFile('gambar')) $data['gambar'] = $r->file('gambar')->store('sertifikasi','public');
        $sertifikasi->update($data);
        return redirect()->route('admin.sertifikasi.index')->with('success','Sertifikasi diperbarui.');
    }
    public function destroy(Sertifikasi $sertifikasi) { $sertifikasi->delete(); return redirect()->route('admin.sertifikasi.index')->with('success','Sertifikasi dihapus.'); }
}