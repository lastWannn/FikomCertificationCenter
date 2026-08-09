@extends('layouts.admin')
@section('title','Status Pembayaran')
@section('page-title','Status Pembayaran')

@section('page-content')

<div style="padding:24px;">
    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Transaksi &amp; Finansial</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Status Pembayaran</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Verifikasi, cari, dan kelola semua transaksi pembayaran peserta secara real-time.</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <a href="{{ route('admin.rekening.index') }}"
               style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.04);text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
               onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                @include('components.icon',['name'=>'credit-card','size'=>15,'style'=>'color:#131218']) Kelola Rekening Tujuan
            </a>
        </div>
    </div>

    {{-- Livewire Pembayaran Manager Component --}}
    @livewire('admin.pembayaran-manager')
</div>

@endsection
