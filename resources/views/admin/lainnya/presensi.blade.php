@extends('layouts.admin')
@section('title','Presensi Per Kegiatan')
@section('page-title','Presensi Per Kegiatan')

@section('page-content')
<div style="padding:24px;">

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Presensi &amp; Kehadiran</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Presensi Per Kegiatan</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Pilih kegiatan untuk mencetak lembar presensi fisik (kertas), mengunduh data, atau mengelola presensi real-time.</p>
        </div>
    </div>

    {{-- Livewire Presensi Kegiatan List Component --}}
    @livewire('admin.presensi-kegiatan-list')

</div>
@endsection
