@extends('layouts.admin')
@section('title', isset($materi) ? 'Edit Materi' : 'Tambah Materi Pelatihan')
@section('page-title', isset($materi) ? 'Edit Materi' : 'Tambah Materi Pelatihan')
@section('page-content')
@php $edit = isset($materi); @endphp
<div style="padding:20px 24px;max-width:680px;">
  <a href="{{ route('admin.pelatihan.show', $pelatihan) }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:16px;">
    @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke {{ Str::limit($pelatihan->judul,30) }}
  </a>
  <div class="fcc-card" style="padding:26px;">
    <form action="{{ $edit ? route('admin.materi-pelatihan.update',[$pelatihan->id,$materi->id]) : route('admin.materi-pelatihan.store', $pelatihan) }}"
          method="POST" enctype="multipart/form-data">
      @csrf @if($edit) @method('PUT') @endif
      <div style="margin-bottom:14px;">
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Judul Materi *</label>
        <input type="text" name="judul_materi" value="{{ old('judul_materi',$materi->judul_materi??'') }}" required class="fcc-input"
               placeholder="contoh: Pengenalan Laravel, Instalasi Tools, dll."
               onkeydown="if(event.key==='Enter')event.preventDefault();">
      </div>
      <div style="margin-bottom:14px;">
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Jam Pelajaran *</label>
        <input type="number" name="jam_pelajaran" value="{{ old('jam_pelajaran',$materi->jam_pelajaran??1) }}" min="1" max="99" required class="fcc-input"
               onkeydown="if(event.key==='Enter')event.preventDefault();">
      </div>
      <div style="margin-bottom:20px;">
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">File Materi (PDF, PPT, ZIP, maks. 20MB)</label>
        @if($edit && $materi->file_materi)
        <p style="font-size:12px;color:#6B7280;margin:0 0 6px;">File sekarang: <a href="{{ asset('storage/'.$materi->file_materi) }}" target="_blank" style="color:#FFC81A;font-weight:700;">Lihat File</a></p>
        @endif
        <input type="file" name="file_materi" accept=".pdf,.ppt,.pptx,.doc,.docx,.zip" class="fcc-input" style="padding:8px;">
      </div>
      <div style="display:flex;gap:10px;">
        <button type="submit" class="fcc-btn-dark" style="padding:11px 24px;font-size:14px;">
          @include('components.icon',['name'=>'check','size'=>14,'style'=>'color:#FFC81A'])
          {{ $edit ? 'Perbarui Materi' : 'Simpan Materi' }}
        </button>
        <a href="{{ route('admin.pelatihan.show', $pelatihan) }}" style="padding:11px 18px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1.5px solid #E2E4EB;border-radius:10px;">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
