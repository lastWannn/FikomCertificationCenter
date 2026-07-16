@extends('layouts.peserta')
@section('title','Dashboard Peserta')
@section('page-title','Dashboard')
@section('page-content')
<div style="padding:24px;">
    {{-- Welcome --}}
    <div style="background:linear-gradient(135deg,#131218,#1A1920);border-radius:16px;padding:24px 28px;margin-bottom:18px;position:relative;overflow:hidden;">
        <div style="position:absolute;top:-20px;right:-20px;width:160px;height:160px;border-radius:50%;background:rgba(255,200,26,.06);"></div>
        <div style="position:absolute;bottom:-30px;right:80px;width:100px;height:100px;border-radius:50%;background:rgba(255,200,26,.04);"></div>
        <div style="position:relative;z-index:1;">
            <p style="color:rgba(255,255,255,.55);font-size:13px;margin:0 0 6px;">Selamat datang kembali,</p>
            <h1 style="color:#FFF;font-size:22px;font-weight:900;margin:0 0 14px;">{{ $peserta->nama }} &#128075;</h1>
            <a href="{{ route('peserta.jelajahi') }}" class="fcc-btn-gold" style="padding:9px 20px;font-size:13px;text-decoration:none;">
                @include('components.icon',['name'=>'search','size'=>14']) Jelajahi Kegiatan
            </a>
        </div>
    </div>
    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:18px;">
        @foreach([
            ['Terdaftar Aktif',$stats['terdaftar'],'check','#10B981'],
            ['Menunggu Verifikasi',$stats['menunggu'],'clock','#F59E0B'],
            ['Sertifikat Diterima',$stats['sertifikat'],'award','#FFC81A'],
        ] as [$label,$val,$icon,$color])
        <div class="fcc-card" style="padding:16px 18px;display:flex;align-items:center;gap:14px;">
            <div style="width:42px;height:42px;border-radius:12px;background:{{ $color }}18;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                @include('components.icon',['name'=>$icon,'size'=>20,'style'=>"color:{$color}"])
            </div>
            <div>
                <p style="font-size:24px;font-weight:900;color:#0F0F14;margin:0;line-height:1;">{{ $val }}</p>
                <p style="font-size:12px;color:#6B7280;margin:3px 0 0;">{{ $label }}</p>
            </div>
        </div>
        @endforeach
    </div>
    {{-- Pendaftaran Terbaru --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;margin-bottom:18px;">
        <div style="padding:14px 20px;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;">
            <p style="font-size:15px;font-weight:700;color:#0F0F14;margin:0;">Pendaftaran Terakhir</p>
            <a href="{{ route('peserta.pendaftaran') }}" style="font-size:12px;color:#FFC81A;font-weight:700;text-decoration:none;">Lihat semua &rarr;</a>
        </div>
        @forelse($pendaftaranTerbaru as $pd)
        <div style="padding:14px 20px;border-top:1px solid #F0F1F3;display:flex;align-items:center;gap:14px;">
            <div style="width:40px;height:40px;border-radius:11px;flex-shrink:0;
                background:{{ $pd->kegiatan->jenis_kegiatan==='pelatihan' ? 'rgba(255,200,26,.15)' : 'rgba(59,130,246,.12)' }};
                display:flex;align-items:center;justify-content:center;">
                @include('components.icon',['name'=>$pd->kegiatan->jenis_kegiatan==='pelatihan'?'book-open':'award','size'=>18,'style'=>"color:".($pd->kegiatan->jenis_kegiatan==='pelatihan'?'#B38F00':'#3B82F6')])
            </div>
            <div style="flex:1;min-width:0;">
                <p style="font-size:14px;font-weight:700;color:#0F0F14;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $pd->kegiatan->judul }}</p>
                <p style="font-size:11px;color:#A0A3AD;margin:2px 0 0;">Daftar: {{ $pd->tgl_daftar->format('d M Y') }}</p>
            </div>
            @php
            $sc = match($pd->status_pendaftaran) {
                'terdaftar'=>['#10B981','Terdaftar'],
                'menunggu_verifikasi'=>['#F59E0B','Menunggu Verifikasi'],
                'ditolak'=>['#EF4444','Ditolak'],
                default=>['#6B7280','Menunggu Bayar'],
            };
            @endphp
            <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">{{ $sc[1] }}</span>
        </div>
        @empty
        <div style="padding:28px;text-align:center;color:#A0A3AD;font-size:14px;">
            Belum ada pendaftaran.
            <a href="{{ route('peserta.jelajahi') }}" style="color:#FFC81A;font-weight:700;text-decoration:none;"> Jelajahi kegiatan &rarr;</a>
        </div>
        @endforelse
    </div>
</div>
@endsection
