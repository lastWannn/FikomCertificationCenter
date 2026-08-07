@extends('layouts.admin')
@section('title','Detail Presensi Peserta')
@section('page-title','Detail Presensi Peserta')

@section('page-content')
<div style="padding:24px;">

    {{-- Navigasi Kembali --}}
    <div style="margin-bottom:14px;">
        <a href="{{ route('admin.presensi.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;font-weight:600;transition:color 0.2s;"
           onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#6B7280'">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Daftar Kegiatan Presensi
        </a>
    </div>

    {{-- Header & Title --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:14px;">
        <div>
            <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">{{ $kegiatan->judul }}</h1>
            <p style="color:#6B7280;font-size:13.5px;margin:0;">Kelola daftar hadir dan verifikasi presensi peserta secara live real-time.</p>
        </div>

        {{-- Action Buttons --}}
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <a href="{{ route('admin.cetak.presensi', $kegiatan) }}" target="_blank" class="fcc-btn-gold"
               style="padding:8px 16px;font-size:12.5px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;border-radius:10px;font-weight:800;"
               title="Cetak Lembar Presensi Kertas PDF">
                @include('components.icon',['name'=>'printer','size'=>14]) Cetak PDF
            </a>
            <a href="{{ route('admin.presensi.export', $kegiatan) }}" class="fcc-btn-outline-dark"
               style="padding:8px 14px;font-size:12.5px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;border-radius:10px;font-weight:700;background:#FFF;border:1.5px solid #E2E4EB;"
               title="Export Data CSV">
                @include('components.icon',['name'=>'download','size'=>14]) Export CSV
            </a>
        </div>
    </div>

    {{-- Livewire Presensi Detail Component --}}
    @livewire('admin.presensi-detail-manager', ['kegiatan' => $kegiatan])

</div>
@endsection
