@extends('layouts.peserta')
@section('title','Detail Pendaftaran')
@section('page-title','Detail Pendaftaran')
@section('page-content')
<div style="padding:24px;max-width:680px;">
    <a href="{{ route('peserta.pendaftaran') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:16px;">
        @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
    </a>
    <div class="fcc-card" style="padding:28px;">
        <h2 style="font-size:18px;font-weight:900;color:#0F0F14;margin:0 0 18px;">{{ $pendaftaran->kegiatan->judul }}</h2>
        @foreach([
            ['Jenis',ucfirst($pendaftaran->kegiatan->jenis_kegiatan)],
            ['Jenis Biaya',$pendaftaran->biaya?->nama_jenis??'Gratis'],
            ['Tanggal Daftar',$pendaftaran->tgl_daftar->format('d M Y H:i')],
        ] as [$l,$v])
        <div style="display:flex;justify-content:space-between;padding:12px 0;border-top:1px solid #F0F1F3;">
            <span style="color:#A0A3AD;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">{{ $l }}</span>
            <span style="color:#0F0F14;font-size:14px;font-weight:700;">{{ $v }}</span>
        </div>
        @endforeach
        @php
        $sc=match($pendaftaran->status_pendaftaran){
            'terdaftar'=>['#10B981','Terdaftar ✓'],
            'menunggu_verifikasi'=>['#F59E0B','Menunggu Verifikasi'],
            'ditolak'=>['#EF4444','Ditolak'],
            default=>['#3B82F6','Menunggu Pembayaran'],
        };
        @endphp
        <div style="margin-top:16px;background:{{ $sc[0] }}10;border:1px solid {{ $sc[0] }}25;border-radius:10px;padding:14px 16px;text-align:center;">
            <p style="color:{{ $sc[0] }};font-size:15px;font-weight:800;margin:0;">{{ $sc[1] }}</p>
        </div>
        @if($pendaftaran->pembayaran)
        <div style="margin-top:14px;">
            <a href="{{ route('peserta.pembayaran.show',$pendaftaran->pembayaran->id) }}" class="fcc-btn-gold" style="display:block;text-align:center;text-decoration:none;padding:11px;justify-content:center;font-size:14px;">
                @include('components.icon',['name'=>'credit-card','size'=>15]) Lihat Pembayaran
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
