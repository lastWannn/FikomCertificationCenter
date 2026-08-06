@extends('layouts.admin')
@section('title','Presensi Per Kegiatan')
@section('page-title','Presensi Per Kegiatan')

@section('page-content')
<div style="padding:24px;">

    {{-- Header & Title --}}
    <div style="margin-bottom:20px;">
        <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">Presensi Per Kegiatan</h1>
        <p style="color:#6B7280;font-size:13.5px;margin:0;">Pilih kegiatan untuk mencetak lembar presensi fisik (kertas), mengunduh data, atau mengelola presensi real-time.</p>
    </div>

    {{-- Livewire Presensi Kegiatan List Component --}}
    @livewire('admin.presensi-kegiatan-list')

</div>
@endsection
