@extends('layouts.peserta')
@section('title','Pembayaran')
@section('page-title','Pembayaran Saya')
@section('page-content')
<div style="padding:24px;">
    @forelse($pembayaran as $p)
    @php
    $sc = match($p->status_pembayaran) {
        'terverifikasi'=>['#10B981','Terverifikasi'],
        'menunggu_verifikasi'=>['#F59E0B','Menunggu Verifikasi'],
        'ditolak'=>['#EF4444','Ditolak'],
        'kadaluarsa'=>['#6B7280','Kadaluarsa'],
        default=>['#3B82F6','Menunggu Bayar'],
    };
    @endphp
    <div class="fcc-card" style="padding:20px 24px;margin-bottom:14px;display:flex;align-items:center;gap:18px;">
        <div style="width:46px;height:46px;border-radius:12px;flex-shrink:0;background:rgba(255,200,26,.12);display:flex;align-items:center;justify-content:center;">
            @include('components.icon',['name'=>'credit-card','size'=>22,'style'=>'color:#FFC81A'])
        </div>
        <div style="flex:1;min-width:0;">
            <p style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p->pendaftaran->kegiatan->judul ?? '-' }}</p>
            <p style="font-size:12px;color:#A0A3AD;margin:0;">Kode: <span style="font-family:monospace;font-weight:700;color:#FFC81A;">{{ $p->kode_pembayaran }}</span></p>
        </div>
        <div style="text-align:right;">
            <p style="font-size:16px;font-weight:900;color:#FFC81A;margin:0 0 4px;">{{ $p->jumlah_bayar_format }}</p>
            <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">{{ $sc[1] }}</span>
        </div>
        <a href="{{ route('peserta.pembayaran.show', $p) }}" style="flex-shrink:0;">
            @include('components.icon',['name'=>'chevron-right','size'=>18,'style'=>'color:#6B7280'])
        </a>
    </div>
    @empty
    <div style="text-align:center;padding:60px;color:#A0A3AD;">
        <div style="width:64px;height:64px;border-radius:18px;background:rgba(255,200,26,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            @include('components.icon',['name'=>'credit-card','size'=>28,'style'=>'color:#FFC81A'])
        </div>
        <p style="font-size:16px;font-weight:700;color:#0F0F14;margin:0 0 8px;">Belum Ada Pembayaran</p>
        <p style="color:#A0A3AD;font-size:14px;margin:0 0 20px;">Daftarkan diri ke kegiatan untuk memulai.</p>
        <a href="{{ route('peserta.jelajahi') }}" class="fcc-btn-gold" style="padding:10px 22px;font-size:14px;text-decoration:none;">Jelajahi Kegiatan</a>
    </div>
    @endforelse
    @if($pembayaran->hasPages())
    <div style="margin-top:16px;">{{ $pembayaran->links() }}</div>
    @endif
</div>
@endsection
