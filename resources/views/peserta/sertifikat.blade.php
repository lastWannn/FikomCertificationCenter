@extends('layouts.peserta')
@section('title','Sertifikat Saya')
@section('page-title','Sertifikat Saya')
@section('page-content')
<div style="padding:24px;">
    @if($sertifikat->isEmpty())
    <div style="text-align:center;padding:60px;">
        <div style="width:64px;height:64px;border-radius:18px;background:rgba(255,200,26,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            @include('components.icon',['name'=>'award','size'=>28,'style'=>'color:#FFC81A'])
        </div>
        <p style="font-size:16px;font-weight:700;color:#0F0F14;margin:0 0 8px;">Belum Ada Sertifikat</p>
        <p style="color:#A0A3AD;font-size:14px;margin:0 0 20px;">Selesaikan kegiatan untuk memperoleh sertifikat.</p>
        <a href="{{ route('peserta.jelajahi') }}" class="fcc-btn-gold" style="padding:10px 22px;font-size:14px;text-decoration:none;">Jelajahi Kegiatan</a>
    </div>
    @else
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
        @foreach($sertifikat as $s)
        <div class="fcc-card" style="padding:22px;text-align:center;">
            <div style="width:58px;height:58px;border-radius:16px;background:rgba(255,200,26,.12);border:1.5px solid rgba(255,200,26,.25);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                @include('components.icon',['name'=>'award','size'=>26,'style'=>'color:#FFC81A'])
            </div>
            <p style="font-size:14px;font-weight:800;color:#0F0F14;margin:0 0 4px;">{{ Str::limit($s->pendaftaran->kegiatan->judul ?? '-',35) }}</p>
            <p style="font-size:12px;color:#A0A3AD;margin:0 0 4px;">No: {{ $s->nomor_sertifikat }}</p>
            <p style="font-size:11px;color:#A0A3AD;margin:0 0 16px;">Terbit: {{ $s->tgl_terbit?->format('d M Y') }}</p>
            @if($s->file_sertifikat)
            <a href="{{ route('peserta.sertifikat.download', $s) }}" class="fcc-btn-gold" style="padding:8px 18px;font-size:13px;text-decoration:none;justify-content:center;width:100%;">
                @include('components.icon',['name'=>'download','size'=>14]) Unduh
            </a>
            @else
            <span style="display:block;padding:8px;border-radius:9px;background:#F7F8FA;color:#A0A3AD;font-size:13px;">File belum tersedia</span>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
