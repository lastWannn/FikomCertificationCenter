@extends('layouts.admin')
@section('title', isset($informasi) ? 'Edit Informasi' : 'Tambah Informasi')
@section('page-content')
<div style="padding:24px;max-width:760px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.informasi.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
        </a>
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0;">{{ isset($informasi) ? 'Edit' : 'Tambah' }} Informasi / FAQ</h1>
    </div>
    <div class="fcc-card" style="padding:28px;">
        <form action="{{ isset($informasi) ? route('admin.informasi.update', $informasi) : route('admin.informasi.store') }}" method="POST">
            @csrf @if(isset($informasi)) @method('PUT') @endif
            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Jenis *</label>
                <div style="display:flex;gap:12px;">
                    @foreach(['info'=>'Informasi','faq'=>'FAQ'] as $v=>$l)
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14px;color:#0F0F14;padding:10px 16px;border:1.5px solid #E2E4EB;border-radius:9px;flex:1;transition:border-color .18s;"
                           onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
                        <input type="radio" name="jenis" value="{{ $v }}" {{ old('jenis',isset($informasi)?$informasi->jenis:'info')===$v?'checked':'' }} required style="accent-color:#FFC81A;">
                        {{ $l }}
                    </label>
                    @endforeach
                </div>
            </div>
            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Judul *</label>
                <input type="text" name="judul" value="{{ old('judul',isset($informasi)?$informasi->judul:'') }}" placeholder="Judul informasi atau pertanyaan FAQ" required class="fcc-input">
            </div>
            <div style="margin-bottom:24px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Isi / Jawaban *</label>
                <textarea name="isi" rows="8" placeholder="Isi konten atau jawaban..." required class="fcc-input" style="resize:vertical;">{{ old('isi',isset($informasi)?$informasi->isi:'') }}</textarea>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">
                    @include('components.icon',['name'=>'check','size'=>15]) {{ isset($informasi) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.informasi.index') }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
