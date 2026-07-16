@extends('layouts.public')
@section('title','Arsip Kegiatan')
@section('page-content')
<div style="padding-top:68px;">
    <div style="background:#F7F8FA;padding:52px 24px 44px;text-align:center;">
        <h1 style="color:#0F0F14;font-size:clamp(28px,5vw,50px);font-weight:900;margin:0 0 10px;">Arsip <span style="color:#FFC81A;">Kegiatan</span></h1>
        <p style="color:#6B7280;font-size:16px;margin:0;">Dokumentasi seluruh kegiatan yang telah selesai diselenggarakan</p>
    </div>
    <div style="padding:52px 24px;max-width:1100px;margin:0 auto;">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
            @forelse($arsips as $a)
            <div class="fcc-card" style="overflow:hidden;transition:transform .22s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="height:190px;position:relative;background:linear-gradient(135deg,#131218,#1A1920);">
                    <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px;">
                        @include('components.icon',['name'=>'file-text','size'=>40,'style'=>'color:rgba(255,200,26,.4)'])
                        <span style="color:rgba(255,200,26,.5);font-size:9px;letter-spacing:2px;text-transform:uppercase;font-weight:700;">Dokumentasi</span>
                    </div>
                    <div style="position:absolute;bottom:10px;left:10px;">
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:5px;background:rgba(255,200,26,.85);color:#111;">{{ ucfirst($a->kegiatan->jenis_kegiatan ?? 'Kegiatan') }}</span>
                    </div>
                </div>
                <div style="padding:18px 20px;">
                    <p style="color:#0F0F14;font-size:14px;font-weight:800;margin:0 0 6px;">{{ $a->judul ?? $a->kegiatan->judul }}</p>
                    <p style="color:#A0A3AD;font-size:11px;margin:0 0 10px;">{{ $a->created_at->format('d M Y') }}</p>
                    <p style="color:#6B7280;font-size:13px;line-height:1.65;margin:0;">{{ Str::limit($a->ringkasan ?? 'Kegiatan telah selesai dilaksanakan.',100) }}</p>
                </div>
            </div>
            @empty
            <div style="grid-column:span 3;text-align:center;padding:48px;color:#A0A3AD;font-size:15px;">Belum ada arsip kegiatan.</div>
            @endforelse
        </div>
        @if($arsips->hasPages())
        <div style="margin-top:28px;">{{ $arsips->links() }}</div>
        @endif
    </div>
</div>
@endsection
