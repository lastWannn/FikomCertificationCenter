@extends('layouts.admin')
@section('title','Status Pembayaran')
@section('page-title','Status Pembayaran')

@section('page-content')

<div style="padding:24px;">
    {{-- Header & Title --}}
    <div style="margin-bottom:20px;">
        <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">Status Pembayaran</h1>
        <p style="color:#6B7280;font-size:13.5px;margin:0;">Verifikasi, cari, dan kelola semua transaksi pembayaran peserta secara real-time.</p>
    </div>

    {{-- Livewire Pembayaran Manager Component --}}
    @livewire('admin.pembayaran-manager')
</div>

@endsection
