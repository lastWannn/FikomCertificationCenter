@extends('layouts.admin')
@section('title','Detail Presensi Peserta')
@section('page-title','Detail Presensi Peserta')

@section('page-content')
<div style="padding:24px;">

    {{-- Navigasi Kembali --}}
    <div style="margin-bottom:16px;">
        <a href="{{ route('admin.presensi.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#131218;background:#FFFFFF;border:1.5px solid #131218;padding:6px 14px;border-radius:20px;font-size:12.5px;text-decoration:none;font-weight:800;transition:all 0.18s;box-shadow:0 2px 8px rgba(0,0,0,0.03);"
           onmouseover="this.style.background='#FFC81A';this.style.transform='translateX(-2px)'" onmouseout="this.style.background='#FFFFFF';this.style.transform='translateX(0)'">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) &larr; Kembali ke Daftar Kegiatan Presensi
        </a>
    </div>

    {{-- Header & Title --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Presensi Real-Time</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">{{ $kegiatan->judul }}</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola daftar hadir dan verifikasi presensi peserta secara live real-time.</p>
        </div>

        {{-- Action Buttons --}}
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <a href="{{ route('admin.cetak.presensi', $kegiatan) }}" target="_blank"
               style="padding:10px 18px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.1);text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
               onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';"
               title="Cetak Lembar Presensi Kertas PDF">
                @include('components.icon',['name'=>'printer','size'=>15]) Cetak PDF
            </a>
            <a href="{{ route('admin.presensi.export', $kegiatan) }}"
               style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.04);text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
               onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'"
               title="Export Data CSV">
                @include('components.icon',['name'=>'download','size'=>15]) Export CSV
            </a>
        </div>
    </div>

    {{-- Livewire Presensi Detail Component --}}
    @livewire('admin.presensi-detail-manager', ['kegiatan' => $kegiatan])

</div>
@endsection
