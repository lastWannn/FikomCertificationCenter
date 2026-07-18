@extends('layouts.admin')
@section('title','Edit Sertifikasi')
@section('page-content')
<div style="padding:24px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.sertifikasi.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
        </a>
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Edit Sertifikasi</h1>
    </div>
    
    @php $edit = isset($sertifikasi); @endphp
    <form action="{{ $edit ? route('admin.sertifikasi.update', $sertifikasi) : route('admin.sertifikasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf @if($edit) @method('PUT') @endif
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
            <div>
                <div class="fcc-card" style="padding:24px;margin-bottom:16px;">
                    <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 18px;">Informasi Sertifikasi</h3>
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kode *</label>
                        <input type="text" name="kode" value="{{ old('kode',$sertifikasi->kode??'') }}" placeholder="CERT-001" required class="fcc-input" {{ $edit?'readonly':'' }}>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Judul *</label>
                        <input type="text" name="judul" value="{{ old('judul',$sertifikasi->judul??'') }}" placeholder="Judul program sertifikasi" required class="fcc-input">
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Deskripsi *</label>
                        <textarea name="isi" rows="7" placeholder="Deskripsi program sertifikasi..." required class="fcc-input" style="resize:vertical;">{{ old('isi',$sertifikasi->isi??'') }}</textarea>
                    </div>
                </div>
            </div>
            <div>
                <div class="fcc-card" style="padding:24px;margin-bottom:16px;">
                    <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 18px;">Pengaturan</h3>
                    <div>
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kategori *</label>
                        <select name="kategori_id" required class="fcc-input">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id',$sertifikasi->kategori_id??'')==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="fcc-card" style="padding:24px;">
                    <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 14px;">Gambar / Poster</h3>
                    @if($edit && isset($sertifikasi->gambar) && $sertifikasi->gambar)
                    <img src="{{ asset('storage/'.$sertifikasi->gambar) }}" style="width:100%;border-radius:10px;margin-bottom:12px;max-height:160px;object-fit:cover;">
                    @endif
                    <label style="display:flex;flex-direction:column;align-items:center;border:2px dashed #E2E4EB;border-radius:10px;padding:20px;cursor:pointer;gap:6px;transition:border-color .2s;"
                           onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
                        @include('components.icon',['name'=>'image','size'=>24,'style'=>'color:#A0A3AD'])
                        <span style="font-size:12px;color:#6B7280;">Upload Gambar</span>
                        <input type="file" name="gambar" accept="image/*" style="display:none;">
                    </label>
                </div>
            </div>
        </div>
        <div style="display:flex;gap:10px;margin-top:18px;">
            <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">
                @include('components.icon',['name'=>'check','size'=>15]) {{ $edit ? 'Perbarui' : 'Simpan' }}
            </button>
            <a href="{{ route('admin.sertifikasi.index') }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;">Batal</a>
        </div>
    </form>

</div>
@endsection
