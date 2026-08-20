@extends('layouts.peserta')
@section('title','Detail Pendaftaran')
@section('page-title','Detail Pendaftaran')
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
      #pendaftaran-detail-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="pendaftaran-detail-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
      <div class="fcc-skeleton-box" style="width:180px;height:32px;border-radius:20px;margin-bottom:16px;"></div>
      <div style="padding:32px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;max-width:680px;">
        <div class="fcc-skeleton-box" style="width:60%;height:24px;margin-bottom:20px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:40px;margin-bottom:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:40px;margin-bottom:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:40px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('pendaftaran-detail-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Navigasi Kembali --}}
    <div style="margin-bottom:18px;">
        <a href="{{ route('peserta.pendaftaran') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#131218;background:#FFFFFF;border:1.5px solid #131218;padding:6px 16px;border-radius:20px;font-size:12.5px;text-decoration:none;font-weight:900;transition:all 0.18s;box-shadow:0 2px 8px rgba(0,0,0,0.03);"
           onmouseover="this.style.background='#FFC81A';this.style.transform='translateX(-2px)'" onmouseout="this.style.background='#FFFFFF';this.style.transform='translateX(0)'">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) &larr; Kembali ke Pendaftaran Saya
        </a>
    </div>

    {{-- Main Detail Card --}}
    <div style="max-width:720px;">
        <div class="fcc-card" style="padding:32px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Rincian Pendaftaran</span>
                <span style="font-size:11px;font-weight:800;color:#64748B;">ID: #{{ $pendaftaran->hashid }}</span>
            </div>
            <h2 style="font-size:20px;font-weight:900;color:#131218;margin:0 0 20px;line-height:1.35;">{{ $pendaftaran->kegiatan->judul }}</h2>

            <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:24px;">
                @foreach([
                    ['Jenis Kegiatan', ucfirst($pendaftaran->kegiatan->jenis_kegiatan)],
                    ['Paket Biaya', $pendaftaran->biaya?->nama_jenis ?? 'Gratis'],
                    ['Tanggal Pendaftaran', $pendaftaran->tgl_daftar->format('d F Y - H:i WIB')],
                ] as [$l,$v])
                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;">
                    <span style="color:#64748B;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">{{ $l }}</span>
                    <span style="color:#131218;font-size:13.5px;font-weight:800;">{{ $v }}</span>
                </div>
                @endforeach
            </div>

            @php
            $sc=match($pendaftaran->status_pendaftaran){
                'terdaftar'           => ['#ECFDF5','#059669','#10B981','Terdaftar Aktif ✓'],
                'menunggu_verifikasi' => ['#FFFDF5','#D97706','#F59E0B','Menunggu Verifikasi Admin'],
                'ditolak'             => ['#FEF2F2','#DC2626','#EF4444','Pendaftaran Ditolak'],
                default               => ['#F1F5F9','#3B82F6','#CBD5E1','Menunggu Pembayaran'],
            };
            @endphp
            <div style="background:{{ $sc[0] }};border:1.5px solid {{ $sc[2] }};border-radius:14px;padding:16px;text-align:center;margin-bottom:24px;">
                <p style="color:{{ $sc[1] }};font-size:15px;font-weight:900;margin:0;letter-spacing:0.3px;">STATUS: {{ strtoupper($sc[3]) }}</p>
            </div>

            @if($pendaftaran->pembayaran)
            <div style="display:flex;flex-direction:column;gap:12px;">
                <a href="{{ route('peserta.pembayaran.show',$pendaftaran->pembayaran->id) }}" class="fcc-btn-gold" style="display:flex;text-align:center;text-decoration:none;padding:12px;justify-content:center;font-size:14px;align-items:center;gap:8px;border-radius:12px;font-weight:900;box-shadow:0 4px 12px rgba(255,200,26,0.3);">
                    @include('components.icon',['name'=>'credit-card','size'=>16]) Lihat Detail Pembayaran
                </a>
                <a href="{{ route('peserta.pembayaran.invoice',$pendaftaran->pembayaran->id) }}" target="_blank" style="display:flex;text-align:center;text-decoration:none;padding:11px;justify-content:center;font-size:13px;align-items:center;gap:8px;border-radius:12px;font-weight:800;background:#131218;color:#FFF;border:1.5px solid #131218;">
                    @include('components.icon',['name'=>'download','size'=>15,'style'=>'color:#FFC81A']) Unduh Invoice Resmi (PDF)
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
