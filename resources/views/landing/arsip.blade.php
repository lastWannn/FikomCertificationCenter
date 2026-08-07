@extends('layouts.public')
@section('title','Arsip Kegiatan')
@section('page-content')
<div style="padding-top:84px; background:#131218; min-height:100vh;">
    {{-- Hero Header --}}
    <div style="background:#131218; padding:40px 24px 44px; text-align:center; position:relative; overflow:hidden; border-bottom:1.5px solid rgba(255,200,26,0.2);">
        <!-- Subtle Glow -->
        <div style="position:absolute; top:-50%; left:50%; transform:translateX(-50%); width:600px; height:600px; border-radius:50%; background:radial-gradient(circle, rgba(255,200,26,0.07), transparent 70%); pointer-events:none;"></div>
        
        <div style="position:relative; z-index:1; max-width:800px; margin:0 auto;">
            <div style="display:inline-block; font-size:10.5px; font-weight:900; padding:5px 16px; border-radius:100px; text-transform:uppercase; letter-spacing:1.5px; background:#FFC81A; color:#131218; margin-bottom:14px; box-shadow:0 4px 12px rgba(255,200,26,0.25);">
                ARSIP KEGIATAN
            </div>
            <h1 style="color:#FFFFFF; font-size:clamp(26px,4vw,40px); font-weight:900; margin:0 0 12px; letter-spacing:-0.5px; line-height:1.2;">
                Dokumentasi <span style="color:#FFC81A;">Kegiatan Selesai</span>
            </h1>
            <p style="color:rgba(255,255,255,0.75); font-size:15px; margin:0; line-height:1.6; font-weight:500;">
                Arsip &amp; riwayat seluruh program pelatihan dan sertifikasi kompetensi yang telah berhasil dilaksanakan oleh FIKOM UMI.
            </p>
        </div>
    </div>

    {{-- Main Body Section (Clean Light Surface Theme) --}}
    <div style="background:#F8F9FA; padding:48px 24px 72px;">
        <div style="max-width:1100px; margin:0 auto;">
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(320px, 1fr)); gap:24px;">
                @forelse($arsips as $a)
                <div style="overflow:hidden; transition:all 0.3s ease; background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:20px; box-shadow:0 6px 20px rgba(0,0,0,0.04); display:flex; flex-direction:column; justify-content:space-between;" 
                     onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='#FFC81A'; this.style.boxShadow='0 12px 28px rgba(0,0,0,0.08)';" 
                     onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.04)';">
                    <div>
                        <div style="height:180px; position:relative; background:#131218; display:flex; align-items:center; justify-content:center; flex-direction:column; gap:8px;">
                            @include('components.icon',['name'=>'file-text','size'=>40,'style'=>'color:#FFC81A'])
                            <span style="color:#FFC81A; font-size:10px; letter-spacing:1.5px; text-transform:uppercase; font-weight:900;">DOKUMENTASI PROGRAM</span>
                            <div style="position:absolute; bottom:12px; left:12px;">
                                <span style="font-size:10.5px; font-weight:900; padding:4px 10px; border-radius:6px; background:#FFC81A; color:#131218; border:1px solid #131218; text-transform:uppercase;">
                                    {{ ucfirst($a->kegiatan->jenis_kegiatan ?? 'Kegiatan') }}
                                </span>
                            </div>
                        </div>
                        <div style="padding:22px 22px 14px;">
                            <h3 style="color:#0F172A; font-size:16px; font-weight:900; margin:0 0 6px; line-height:1.4;">
                                {{ $a->judul ?? $a->kegiatan->judul }}
                            </h3>
                            <div style="display:flex; align-items:center; gap:6px; color:#D97706; font-size:12px; font-weight:800; margin-bottom:12px;">
                                @include('components.icon',['name'=>'calendar','size'=>13,'style'=>'color:#D97706'])
                                <span>{{ $a->created_at->format('d M Y') }}</span>
                            </div>
                            <p style="color:#475569; font-size:13.5px; line-height:1.65; margin:0; font-weight:500;">
                                {{ Str::limit($a->ringkasan ?? 'Kegiatan telah selesai dilaksanakan dengan sukses oleh panitia FIKOM UMI.', 110) }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div style="grid-column:1 / -1; text-align:center; padding:64px 24px; color:#64748B; font-size:15px; font-weight:600; background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:20px;">
                    Belum ada arsip kegiatan yang dipublikasikan.
                </div>
                @endforelse
            </div>

            @if($arsips->hasPages())
            <div style="margin-top:36px; display:flex; justify-content:center;" class="fcc-pagination-light">
                {{ $arsips->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

<style>
/* Temporary style override for pagination to look good on dark background */
.fcc-pagination-dark nav { display: flex; align-items: center; justify-content: center; }
.fcc-pagination-dark nav svg { width: 20px; height: 20px; }
.fcc-pagination-dark nav a, .fcc-pagination-dark nav span.relative { background: rgba(255,255,255,.03) !important; border: 1px solid rgba(255,255,255,.08) !important; color: #FFF !important; margin: 0 4px; border-radius: 8px !important; box-shadow: none !important; }
.fcc-pagination-dark nav span[aria-current="page"] span { background: #FFC81A !important; color: #131218 !important; border-color: #FFC81A !important; }
.fcc-pagination-dark nav a:hover { background: rgba(255,255,255,.1) !important; border-color: rgba(255,255,255,.15) !important; }
</style>
