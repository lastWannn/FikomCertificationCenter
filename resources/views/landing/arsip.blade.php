@extends('layouts.public')
@section('title','Arsip Kegiatan')
@section('page-content')
<div style="padding-top:68px; background:linear-gradient(180deg, #131218 0%, #0e0d14 120px, #0e0d14 100%); min-height:100vh;">
    <div style="background:#131218;padding:52px 24px 44px;text-align:center;">
        <h1 style="color:#FFF;font-size:clamp(28px,5vw,50px);font-weight:900;margin:0 0 10px;">Arsip <span style="color:#FFC81A;">Kegiatan</span></h1>
        <p style="color:rgba(255,255,255,.55);font-size:16px;margin:0;">Dokumentasi seluruh kegiatan yang telah selesai diselenggarakan</p>
    </div>
    <div style="padding:52px 24px;max-width:1100px;margin:0 auto;">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
            @forelse($arsips as $a)
            <div class="fcc-card-dark" style="overflow:hidden;transition:transform .22s;background:rgba(255,255,255,.03);border:1.5px solid rgba(255,255,255,.08);box-shadow:0 10px 30px rgba(0,0,0,0.2);" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
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
                    <p style="color:#FFF;font-size:14px;font-weight:800;margin:0 0 6px;">{{ $a->judul ?? $a->kegiatan->judul }}</p>
                    <p style="color:rgba(255,255,255,.4);font-size:11px;margin:0 0 10px;">{{ $a->created_at->format('d M Y') }}</p>
                    <p style="color:rgba(255,255,255,.6);font-size:13px;line-height:1.65;margin:0;">{{ Str::limit($a->ringkasan ?? 'Kegiatan telah selesai dilaksanakan.',100) }}</p>
                </div>
            </div>
            @empty
            <div style="grid-column:span 3;text-align:center;padding:48px;color:rgba(255,255,255,.5);font-size:15px;background:rgba(255,255,255,.03);border:1.5px solid rgba(255,255,255,.08);border-radius:20px;">Belum ada arsip kegiatan.</div>
            @endforelse
        </div>
        @if($arsips->hasPages())
        <div style="margin-top:28px;" class="fcc-pagination-dark">{{ $arsips->links() }}</div>
        @endif
    </div>
</div>

<style>
/* Temporary style override for pagination to look good on dark background */
.fcc-pagination-dark nav { display: flex; align-items: center; justify-content: center; }
.fcc-pagination-dark nav svg { width: 20px; height: 20px; }
.fcc-pagination-dark nav a, .fcc-pagination-dark nav span.relative { background: rgba(255,255,255,.03) !important; border: 1px solid rgba(255,255,255,.08) !important; color: #FFF !important; margin: 0 4px; border-radius: 8px !important; box-shadow: none !important; }
.fcc-pagination-dark nav span[aria-current="page"] span { background: #FFC81A !important; color: #131218 !important; border-color: #FFC81A !important; }
.fcc-pagination-dark nav a:hover { background: rgba(255,255,255,.1) !important; border-color: rgba(255,255,255,.15) !important; }
</style>
@endsection
