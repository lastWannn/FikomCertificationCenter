@extends('layouts.peserta')
@section('title','Pembayaran Saya')
@section('page-title','Pembayaran Saya')
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
      #pembayaran-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="pembayaran-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:280px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:220px;height:12px;"></div>
        </div>
      </div>
      {{-- List Cards Skeleton --}}
      <div style="display:flex;flex-direction:column;gap:16px;">
        @for($s=0;$s<3;$s++)
        <div style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;align-items:center;gap:18px;">
          <div class="fcc-skeleton-box" style="width:48px;height:48px;border-radius:14px;flex-shrink:0;"></div>
          <div style="flex:1;">
            <div class="fcc-skeleton-box" style="width:60%;height:16px;margin-bottom:8px;"></div>
            <div class="fcc-skeleton-box" style="width:30%;height:12px;"></div>
          </div>
          <div style="width:120px;text-align:right;">
            <div class="fcc-skeleton-box" style="width:100%;height:20px;margin-bottom:6px;"></div>
            <div class="fcc-skeleton-box" style="width:70%;height:14px;margin-left:auto;"></div>
          </div>
        </div>
        @endfor
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('pembayaran-skeleton-overlay');
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
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Finansial &amp; Transaksi</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Pembayaran Saya</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola transaksi tagihan, upload bukti transfer, dan pantau verifikasi status pembayaran kegiatan Anda.</p>
        </div>
    </div>

    {{-- Main Payments List --}}
    <div style="display:flex;flex-direction:column;gap:16px;">
        @forelse($pembayaran as $p)
        @php
        $sc = match($p->status_pembayaran) {
            'terverifikasi'       => ['#ECFDF5','#059669','#10B981','Terverifikasi'],
            'menunggu_verifikasi' => ['#FFFDF5','#D97706','#F59E0B','Menunggu Verifikasi'],
            'ditolak'             => ['#FEF2F2','#DC2626','#EF4444','Ditolak'],
            'kadaluarsa'          => ['#F1F5F9','#64748B','#94A3B8','Kadaluarsa'],
            default               => ['#F8FAFC','#2563EB','#3B82F6','Menunggu Bayar'],
        };
        @endphp
        <a href="{{ route('peserta.pembayaran.show', $p) }}" style="text-decoration:none;color:inherit;display:block;outline:none;"
           onmouseover="this.querySelector('.fcc-card').style.borderColor='#131218';this.querySelector('.fcc-card').style.transform='translateY(-2px)';"
           onmouseout="this.querySelector('.fcc-card').style.borderColor='#E5E7EB';this.querySelector('.fcc-card').style.transform='translateY(0)';">
            <div class="fcc-card" style="padding:22px 26px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);display:flex;align-items:center;gap:20px;transition:all .18s;">
                <div style="width:50px;height:50px;border-radius:14px;flex-shrink:0;background:#131218;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(19,18,24,0.2);">
                    @include('components.icon',['name'=>'credit-card','size'=>22,'style'=>'color:#FFC81A'])
                </div>
                <div style="flex:1;min-width:0;">
                    <p style="font-size:15px;font-weight:900;color:#131218;margin:0 0 4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p->pendaftaran->kegiatan->judul ?? '-' }}</p>
                    <p style="font-size:12px;color:#64748B;margin:0;font-weight:600;">Kode Pembayaran: <span style="font-family:monospace;font-weight:900;color:#131218;background:#F1F5F9;padding:2px 8px;border-radius:6px;border:1px solid #CBD5E1;">{{ $p->kode_pembayaran }}</span></p>
                </div>
                <div style="text-align:right;">
                    <p style="font-size:17px;font-weight:900;color:#131218;margin:0 0 4px;letter-spacing:-0.02em;">{{ $p->jumlah_bayar_format }}</p>
                    <span style="font-size:10.5px;font-weight:900;padding:4px 10px;border-radius:6px;background:{{ $sc[0] }};color:{{ $sc[1] }};border:1px solid {{ $sc[2] }};text-transform:uppercase;letter-spacing:0.5px;">{{ $sc[3] }}</span>
                </div>
                <div style="flex-shrink:0;width:32px;height:32px;border-radius:10px;background:#F8FAFC;border:1px solid #CBD5E1;display:flex;align-items:center;justify-content:center;">
                    @include('components.icon',['name'=>'chevron-right','size'=>16,'style'=>'color:#131218'])
                </div>
            </div>
        </a>
        @empty
        <div class="fcc-card" style="text-align:center;padding:64px;background:#FFFFFF;border-radius:20px;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
            <div style="width:64px;height:64px;border-radius:20px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 6px 16px rgba(255,200,26,0.3);">
                @include('components.icon',['name'=>'credit-card','size'=>28,'style'=>'color:#131218'])
            </div>
            <h3 style="font-size:17px;font-weight:900;color:#131218;margin:0 0 6px;">Belum Ada Transaksi Pembayaran</h3>
            <p style="color:#64748B;font-size:13.5px;margin:0 0 22px;font-weight:500;">Daftarkan diri Anda ke program pelatihan atau sertifikasi untuk memulai transaksi.</p>
            <a href="{{ route('peserta.jelajahi') }}" class="fcc-btn-gold" style="padding:10px 24px;font-size:13.5px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;border-radius:30px;font-weight:900;box-shadow:0 4px 14px rgba(255,200,26,0.35);">
                @include('components.icon',['name'=>'compass','size'=>16]) Jelajahi Katalog Kegiatan &rarr;
            </a>
        </div>
        @endforelse
    </div>

    @if($pembayaran->hasPages())
    <div style="margin-top:24px;">{{ $pembayaran->links() }}</div>
    @endif
</div>
@endsection
