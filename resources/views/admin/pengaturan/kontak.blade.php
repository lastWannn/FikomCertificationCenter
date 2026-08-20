@extends('layouts.admin')
@section('title', 'Pengaturan Kontak & Alamat')
@section('page-breadcrumb', 'Pengaturan / Kontak')
@section('page-content')
<div style="padding:24px;">

    <div style="max-width:760px;margin:0 auto;">

        {{-- Flash Messages --}}
        @if(session('success'))
        <div style="padding:12px 18px;border-radius:12px;background:rgba(16,185,129,0.12);border:1.5px solid rgba(16,185,129,0.3);color:#059669;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#059669;cursor:pointer;font-size:18px;font-weight:900;">&times;</button>
        </div>
        @endif
        @if(session('error'))
        <div style="padding:12px 18px;border-radius:12px;background:rgba(239,68,68,0.12);border:1.5px solid rgba(239,68,68,0.3);color:#DC2626;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
            <span>{{ session('error') }}</span>
            <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#DC2626;cursor:pointer;font-size:18px;font-weight:900;">&times;</button>
        </div>
        @endif

        {{-- Header --}}
        <div style="margin-bottom:24px;text-align:center;">
            <div style="display:inline-flex;align-items:center;gap:10px;margin-bottom:8px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 12px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Pengaturan Website</span>
            </div>
            <h1 style="font-size:24px;font-weight:900;color:#131218;margin:0 0 6px;letter-spacing:-0.02em;">Informasi Kontak Institusi</h1>
            <p style="color:#64748B;font-size:13.5px;margin:0;font-weight:500;">Atur email, nomor telepon, alamat, dan lokasi Google Maps yang akan ditampilkan di Landing Page.</p>
        </div>

        {{-- Centered Form Card --}}
        <div class="fcc-card" style="padding:36px;border-radius:24px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 6px 24px rgba(0,0,0,0.04);">
            <form action="{{ route('admin.kontak.update') }}" method="POST">
                @csrf @method('PUT')
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
                    <div>
                        <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.6px;">Alamat Email Resmi *</label>
                        <input type="email" name="email" class="fcc-input" value="{{ old('email', $kontak->email ?? '') }}" placeholder="contoh: fcc@fikom.umi.ac.id" style="width:100%;font-size:13.5px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.6px;">Nomor Telepon / WhatsApp *</label>
                        <input type="text" name="telepon" class="fcc-input" value="{{ old('telepon', $kontak->telepon ?? '') }}" placeholder="contoh: (0411) 455 855" style="width:100%;font-size:13.5px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;box-sizing:border-box;">
                    </div>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.6px;">Alamat Lengkap Kantor / Kampus *</label>
                    <textarea name="alamat" class="fcc-input" rows="3" placeholder="Jl. Urip Sumoharjo No.225..." style="width:100%;font-size:13.5px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;padding:10px 14px;resize:vertical;box-sizing:border-box;">{{ old('alamat', $kontak->alamat ?? '') }}</textarea>
                </div>

                <div style="margin-bottom:28px;">
                    <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.6px;">Google Maps Embed Code (iframe) *</label>
                    <textarea name="maps_embed" class="fcc-input" rows="4" placeholder='<iframe src="https://maps.google.com/..." ></iframe>' style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:10px 14px;resize:vertical;font-family:monospace;font-size:12px;color:#131218;box-sizing:border-box;">{{ old('maps_embed', $kontak->maps_embed ?? '') }}</textarea>
                    <p style="font-size:11px;color:#94A3B8;margin:6px 0 0;font-weight:500;">💡 Cara mendapatkan embed: Buka Google Maps &rarr; Bagikan (Share) &rarr; Sematkan Peta (Embed a map) &rarr; Salin kode HTML iframe.</p>
                </div>

                <div style="border-top:1.5px solid #E2E4EB;padding-top:20px;display:flex;justify-content:flex-end;">
                    <button type="submit" style="padding:10px 24px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;transition:all .18s;display:inline-flex;align-items:center;gap:6px;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                        @include('components.icon',['name'=>'check','size'=>15]) Simpan Pengaturan Kontak
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection



