@extends('layouts.admin')
@section('title','Detail Sertifikasi')
@section('page-content')
<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <a href="{{ route('admin.sertifikasi.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:8px;">
                @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
            </a>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0;">{{ $sertifikasi->judul }}</h1>
            <p style="color:#3B82F6;font-size:13px;font-weight:700;margin:4px 0 0;font-family:monospace;">{{ $sertifikasi->kode }}</p>
        </div>
        <a href="{{ route('admin.sertifikasi.edit', $sertifikasi) }}" class="fcc-btn-gold" style="padding:9px 20px;font-size:14px;text-decoration:none;">
            @include('components.icon',['name'=>'edit','size'=>14]) Edit
        </a>
    </div>
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:18px;">
        <div class="fcc-card" style="padding:24px;">
            <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 14px;">Deskripsi</h3>
            <div style="color:#6B7280;font-size:14px;line-height:1.85;">{!! nl2br(e($sertifikasi->isi)) !!}</div>
        </div>
        <div>
            <div class="fcc-card" style="padding:20px;margin-bottom:14px;">
                <p style="margin:0 0 4px;font-size:11px;font-weight:700;color:#A0A3AD;text-transform:uppercase;">Kategori</p>
                <p style="margin:0;font-size:14px;color:#0F0F14;font-weight:700;">{{ $sertifikasi->kategori->nama_kategori ?? '-' }}</p>
            </div>
            <div class="fcc-card" style="padding:20px;">
                <h4 style="font-size:13px;font-weight:800;color:#0F0F14;margin:0 0 12px;">Materi ({{ $sertifikasi->materi->count() }})</h4>
                @forelse($sertifikasi->materi as $m)
                <div style="padding:8px 0;border-top:1px solid #F0F1F3;font-size:13px;color:#6B7280;">{{ $m->urutan }}. {{ $m->judul_materi }}</div>
                @empty
                <p style="color:#A0A3AD;font-size:13px;">Belum ada materi.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
