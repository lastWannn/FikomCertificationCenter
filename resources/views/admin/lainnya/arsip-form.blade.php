@extends('layouts.admin')
@section('title', isset($arsip) ? 'Edit Arsip' : 'Tambah Arsip')
@section('page-content')
<div style="padding:24px;max-width:680px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.arsip.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
        </a>
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0;">{{ isset($arsip) ? 'Edit' : 'Tambah' }} Arsip Kegiatan</h1>
    </div>
    <div class="fcc-card" style="padding:28px;">
        <form action="{{ isset($arsip) ? route('admin.arsip.update', $arsip) : route('admin.arsip.store') }}" method="POST" enctype="multipart/form-data">
            @csrf @if(isset($arsip)) @method('PUT') @endif
            @if(!isset($arsip))
            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kegiatan *</label>
                <select name="kegiatan_id" required class="fcc-input">
                    <option value="">-- Pilih Kegiatan --</option>
                    @foreach($kegiatan as $k)
                    <option value="{{ $k->id }}">{{ $k->judul }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Judul Arsip *</label>
                <input type="text" name="judul" value="{{ old('judul',isset($arsip)?$arsip->judul:'') }}" placeholder="Judul berita / dokumentasi arsip" required class="fcc-input">
            </div>
            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Ringkasan</label>
                <textarea name="ringkasan" rows="4" placeholder="Ringkasan kegiatan yang diarsipkan..." class="fcc-input" style="resize:vertical;">{{ old('ringkasan',isset($arsip)?$arsip->ringkasan:'') }}</textarea>
            </div>
            <div style="margin-bottom:24px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Berita Acara (PDF)</label>
                <input type="file" name="berita_acara" accept=".pdf" class="fcc-input" style="padding:8px;">
                @if(isset($arsip) && $arsip->berita_acara)
                <p style="font-size:12px;color:#6B7280;margin:4px 0 0;">File sekarang: {{ basename($arsip->berita_acara) }}</p>
                @endif
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">
                    @include('components.icon',['name'=>'check','size'=>15]) {{ isset($arsip) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.arsip.index') }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
