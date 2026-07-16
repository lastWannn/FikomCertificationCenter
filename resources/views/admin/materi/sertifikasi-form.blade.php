@extends('layouts.admin')
@section('title', isset($materi) ? 'Edit Materi Sertifikasi' : 'Tambah Materi Sertifikasi')
@section('page-title', isset($materi) ? 'Edit Materi Sertifikasi' : 'Tambah Materi Sertifikasi')
@section('page-content')
@php $edit = isset($materi); @endphp
<div style="padding:20px 24px;max-width:760px;">
  <a href="{{ route('admin.sertifikasi.show', $sertifikasi) }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:16px;">
    @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke {{ Str::limit($sertifikasi->judul,30) }}
  </a>
  <div class="fcc-card" style="padding:26px;">
    <form action="{{ $edit ? route('admin.materi-sertifikasi.update',[$sertifikasi->id,$materi->id]) : route('admin.materi-sertifikasi.store', $sertifikasi) }}"
          method="POST" enctype="multipart/form-data">
      @csrf @if($edit) @method('PUT') @endif
      <div style="margin-bottom:14px;">
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Judul Materi *</label>
        <input type="text" name="judul_materi" value="{{ old('judul_materi',$materi->judul_materi??'') }}" required class="fcc-input"
               onkeydown="if(event.key==='Enter')event.preventDefault();">
      </div>
      <div style="margin-bottom:14px;">
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Isi / Deskripsi</label>
        <textarea name="isi" rows="5" class="fcc-input" style="resize:vertical;" placeholder="Deskripsi atau isi materi...">{{ old('isi',$materi->isi??'') }}</textarea>
      </div>
      <div style="margin-bottom:20px;">
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">File Materi (opsional)</label>
        @if($edit && $materi->file_materi)
        <p style="font-size:12px;color:#6B7280;margin:0 0 6px;">File sekarang: <a href="{{ asset('storage/'.$materi->file_materi) }}" target="_blank" style="color:#FFC81A;font-weight:700;">Lihat</a></p>
        @endif
        <input type="file" name="file_materi" accept=".pdf,.ppt,.pptx,.doc,.docx,.zip" class="fcc-input" style="padding:8px;">
      </div>
      <div style="display:flex;gap:10px;">
        <button type="submit" class="fcc-btn-dark" style="padding:11px 24px;font-size:14px;">
          @include('components.icon',['name'=>'check','size'=>14,'style'=>'color:#FFC81A'])
          {{ $edit ? 'Perbarui' : 'Simpan Materi' }}
        </button>
        <a href="{{ route('admin.sertifikasi.show', $sertifikasi) }}" style="padding:11px 18px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1.5px solid #E2E4EB;border-radius:10px;">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
