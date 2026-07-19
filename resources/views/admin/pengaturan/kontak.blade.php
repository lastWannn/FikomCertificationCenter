@extends('layouts.admin')
@section('title', 'Pengaturan Kontak & Alamat')
@section('page-breadcrumb', 'Pengaturan / Kontak')
@section('page-content')
<div style="padding:24px;">
    <div class="fcc-card" style="padding:24px;max-width:700px;">
        <h2 style="font-size:18px;font-weight:900;color:#0F0F14;margin:0 0 4px;">Informasi Kontak Institusi</h2>
        <p style="color:#6B7280;font-size:13px;margin:0 0 24px;">Atur email, telepon, dan alamat yang akan ditampilkan di halaman depan (Landing Page).</p>
        
        <form action="{{ route('admin.kontak.update') }}" method="POST">
            @csrf @method('PUT')
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#131218;margin-bottom:6px;">Alamat Email</label>
                    <input type="email" name="email" class="fcc-input" value="{{ old('email', $kontak->email ?? '') }}" placeholder="contoh: fcc@fikom.umi.ac.id" style="width:100%;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#131218;margin-bottom:6px;">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="telepon" class="fcc-input" value="{{ old('telepon', $kontak->telepon ?? '') }}" placeholder="contoh: (0411) 455 855" style="width:100%;">
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:13px;font-weight:700;color:#131218;margin-bottom:6px;">Alamat Lengkap</label>
                <textarea name="alamat" class="fcc-input" rows="3" placeholder="Jl. Urip Sumoharjo No.225..." style="width:100%;resize:vertical;">{{ old('alamat', $kontak->alamat ?? '') }}</textarea>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:700;color:#131218;margin-bottom:6px;">Google Maps Embed Link (iframe)</label>
                <textarea name="maps_embed" class="fcc-input" rows="4" placeholder='<iframe src="https://maps.google.com/..." ></iframe>' style="width:100%;resize:vertical;font-family:monospace;font-size:12px;">{{ old('maps_embed', $kontak->maps_embed ?? '') }}</textarea>
                <p style="font-size:11px;color:#9CA3B0;margin:6px 0 0;">Dapatkan kode embed dari Google Maps -> Share -> Embed a map, lalu copy kode HTML iframe.</p>
            </div>

            <div style="border-top:1px solid #E2E4EB;padding-top:20px;display:flex;justify-content:flex-end;">
                <button type="submit" class="fcc-btn-gold" style="padding:11px 24px;font-size:14px;">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection
