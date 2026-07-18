@extends('layouts.instruktur')

@section('page-title', 'Dashboard Instruktur')

@section('page-content')
<div style="padding:24px;">
    <p style="margin:0 0 20px;color:#4B5563;font-size:14px;">Selamat datang, {{ $instruktur->nama }}.</p>

    <div style="background:#FFF;border:1px solid #E2E4EB;border-radius:12px;overflow:hidden;">
        <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;">
            <p style="margin:0;font-size:14px;font-weight:700;color:#0F0F14;">Pelatihan yang Diampu</p>
        </div>
        @forelse($pelatihan as $item)
        <div style="padding:14px 18px;border-bottom:1px solid #F1F2F5;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:13px;color:#0F0F14;">{{ $item->judul }}</span>
            <span style="font-size:11px;color:#6B7280;">{{ $item->kode }}</span>
        </div>
        @empty
        <div style="padding:18px;text-align:center;color:#9CA3AF;font-size:13px;">Belum ada pelatihan yang diampu.</div>
        @endforelse
    </div>
</div>
@endsection
