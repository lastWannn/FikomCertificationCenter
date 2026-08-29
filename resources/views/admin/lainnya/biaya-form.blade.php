@extends('layouts.admin')
@section('title', isset($biaya) ? 'Edit Biaya' : 'Tambah Biaya')
@section('page-content')
<div style="padding:24px;max-width:680px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.biaya.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
        </a>
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0;">{{ isset($biaya) ? 'Edit' : 'Tambah' }} Biaya Kegiatan</h1>
    </div>
    <div class="fcc-card" style="padding:28px;">
        <form action="{{ isset($biaya) ? route('admin.biaya.update', $biaya) : route('admin.biaya.store') }}" method="POST">
            @csrf @if(isset($biaya)) @method('PUT') @endif
            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kegiatan *</label>
                <select name="kegiatan_id" required class="fcc-input">
                    <option value="">-- Pilih Kegiatan --</option>
                    @foreach($kegiatan as $k)
                    <option value="{{ $k->id }}" {{ (old('kegiatan_id', $selected_kegiatan_id ?? (isset($biaya)?$biaya->kegiatan_id:''))) == $k->id ? 'selected' : '' }}>{{ $k->judul }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Nama Jenis *</label>
                <input type="text" name="nama_jenis" value="{{ old('nama_jenis',isset($biaya)?$biaya->nama_jenis:'') }}" placeholder="contoh: Mahasiswa UMI, Umum, dll." required class="fcc-input">
            </div>
            <div style="margin-bottom:24px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Nominal (Rp) *</label>
                <input type="number" name="nominal" value="{{ old('nominal',isset($biaya)?$biaya->nominal:'') }}" placeholder="contoh: 200000" required min="0" max="999999999" class="fcc-input">
                @error('nominal')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">
                    @include('components.icon',['name'=>'check','size'=>15]) {{ isset($biaya) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.biaya.index') }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
