@extends('layouts.peserta')
@section('title','Sertifikat Saya')
@section('page-title','Sertifikat Saya')
@section('page-content')
<div style="padding:24px 28px;background:#F6F8FB;min-height:100vh;font-family:'Inter',sans-serif;position:relative;">

    {{-- ═══ SKELETON LOADING OVERLAY ═════════════════════════════════ --}}
    <style>
      @keyframes skeletonShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
      }
      .fcc-skeleton-box {
        background: linear-gradient(90deg, #E2E8F0 25%, #F1F5F9 50%, #E2E8F0 75%);
        background-size: 200% 100%;
        animation: skeletonShimmer 1.4s infinite ease-in-out;
        border-radius: 12px;
      }
      #sertifikat-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="sertifikat-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:280px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:220px;height:12px;"></div>
        </div>
      </div>
      {{-- Grid Cards Skeleton --}}
      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:20px;">
        @for($s=0;$s<3;$s++)
        <div style="padding:26px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;text-align:center;">
          <div class="fcc-skeleton-box" style="width:60px;height:60px;border-radius:16px;margin:0 auto 16px;"></div>
          <div class="fcc-skeleton-box" style="width:80%;height:18px;margin:0 auto 10px;"></div>
          <div class="fcc-skeleton-box" style="width:60%;height:14px;margin:0 auto 18px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:40px;border-radius:12px;"></div>
        </div>
        @endfor
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('sertifikat-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Pencapaian &amp; Kompetensi</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Sertifikat Saya</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Lihat dan unduh sertifikat resmi pelatihan dan sertifikasi kompetensi yang telah Anda selesaikan.</p>
        </div>
    </div>

    @if($sertifikat->isEmpty())
    <div class="fcc-card" style="text-align:center;padding:64px;background:#FFFFFF;border-radius:20px;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div style="width:64px;height:64px;border-radius:20px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 6px 16px rgba(255,200,26,0.3);">
            @include('components.icon',['name'=>'award','size'=>30,'style'=>'color:#131218'])
        </div>
        <h3 style="font-size:17px;font-weight:900;color:#131218;margin:0 0 6px;">Belum Ada Sertifikat Diterbitkan</h3>
        <p style="color:#64748B;font-size:13.5px;margin:0 0 22px;font-weight:500;">Selesaikan program pelatihan atau kelulusan ujian sertifikasi untuk menerima sertifikat digital Anda.</p>
        <a href="{{ route('peserta.jelajahi') }}" class="fcc-btn-gold" style="padding:10px 24px;font-size:13.5px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;border-radius:30px;font-weight:900;box-shadow:0 4px 14px rgba(255,200,26,0.35);">
            @include('components.icon',['name'=>'compass','size'=>16]) Jelajahi Katalog Kegiatan &rarr;
        </a>
    </div>
    @else
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:20px;">
        @foreach($sertifikat as $s)
        <div class="fcc-card" style="padding:26px;text-align:center;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);display:flex;flex-direction:column;justify-content:space-between;transition:all .18s;"
             onmouseover="this.style.borderColor='#131218';this.style.transform='translateY(-3px)';"
             onmouseout="this.style.borderColor='#E5E7EB';this.style.transform='translateY(0)';">
            <div>
                <div style="width:60px;height:60px;border-radius:18px;background:#131218;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 6px 16px rgba(19,18,24,0.25);">
                    @include('components.icon',['name'=>'award','size'=>28,'style'=>'color:#FFC81A'])
                </div>
                <h3 style="font-size:15px;font-weight:900;color:#131218;margin:0 0 8px;line-height:1.35;">{{ Str::limit($s->pendaftaran->kegiatan->judul ?? '-', 42) }}</h3>
                <p style="font-size:12px;color:#64748B;margin:0 0 6px;font-weight:600;">
                    No. Sertifikat: <span style="font-family:monospace;font-weight:900;color:#131218;background:#F1F5F9;padding:2px 8px;border-radius:6px;border:1px solid #CBD5E1;">{{ $s->nomor_sertifikat }}</span>
                </p>
                <p style="font-size:11.5px;color:#94A3B8;margin:0 0 20px;font-weight:700;">Tanggal Terbit: {{ $s->tgl_terbit?->format('d M Y') ?? '-' }}</p>
            </div>
            <div>
                @if($s->file_sertifikat)
                <a href="{{ route('peserta.sertifikat.download', $s) }}" class="fcc-btn-gold" style="padding:10px 18px;font-size:13px;text-decoration:none;justify-content:center;width:100%;border-radius:12px;font-weight:900;box-shadow:0 4px 12px rgba(255,200,26,0.3);">
                    @include('components.icon',['name'=>'download','size'=>15]) Unduh Sertifikat (PDF) &rarr;
                </a>
                @else
                <span style="display:block;padding:10px;border-radius:10px;background:#F1F5F9;border:1px solid #CBD5E1;color:#94A3B8;font-size:12.5px;font-weight:800;">File Sertifikat Belum Tersedia</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
