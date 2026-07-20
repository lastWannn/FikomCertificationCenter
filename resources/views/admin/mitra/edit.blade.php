@extends('layouts.admin')
@section('title', 'Edit Mitra')
@section('page-breadcrumb', 'Mitra / Edit')
@section('page-content')
<div style="padding:24px;">
    <div class="fcc-card" style="padding:24px;max-width:600px;">
        <h2 style="font-size:18px;font-weight:800;color:#0F0F14;margin:0 0 20px;">Edit Mitra & Partner</h2>
        
        <form action="{{ route('admin.mitra.update', $mitra) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:700;color:#131218;margin-bottom:6px;">Nama Mitra <span style="color:#EF4444;">*</span></label>
                <input type="text" name="nama_mitra" class="fcc-input" value="{{ $mitra->nama_mitra }}" required style="width:100%;">
            </div>
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#131218;margin-bottom:6px;">Inisial (Singkatan) <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="inisial" class="fcc-input" value="{{ $mitra->inisial }}" required style="width:100%;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#131218;margin-bottom:6px;">Warna Utama (Hex)</label>
                    <input type="color" name="warna" class="fcc-input" value="{{ $mitra->warna ?? '#059669' }}" style="width:100%;height:38px;padding:0;">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#131218;margin-bottom:6px;">Urutan Tampil</label>
                    <input type="number" name="urutan" class="fcc-input" value="{{ $mitra->urutan }}" style="width:100%;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#131218;margin-bottom:6px;">Link Website</label>
                    <input type="url" name="link_website" class="fcc-input" value="{{ $mitra->link_website }}" style="width:100%;">
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:700;color:#131218;margin-bottom:6px;">Upload Logo Baru</label>
                @if($mitra->logo)
                    <div style="margin-bottom:10px;padding:10px;border:1px dashed #E2E4EB;border-radius:8px;display:inline-block;">
                        <img src="{{ asset('storage/'.$mitra->logo) }}" alt="Logo Saat Ini" style="height:50px;">
                    </div>
                @endif
                <input type="file" name="logo" class="fcc-input" accept="image/*" style="width:100%;padding:6px;">
                <p style="font-size:11px;color:#9CA3B0;margin:6px 0 0;">Biarkan kosong jika tidak ingin mengubah logo. Format: JPG/PNG, maks 2MB.</p>
            </div>

            <div style="border-top:1px solid #E2E4EB;padding-top:20px;display:flex;justify-content:flex-end;gap:12px;">
                <a href="{{ route('admin.mitra.index') }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;">Batal</a>
                <button type="submit" class="fcc-btn-gold" style="padding:11px 24px;font-size:14px;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
