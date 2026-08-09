@extends('layouts.peserta')
@section('title','QR Kehadiran')
@section('page-title','QR Kehadiran')
@section('page-content')
<div style="padding:24px 28px;background:#F6F8FB;min-height:100vh;font-family:'Inter',sans-serif;position:relative;display:flex;flex-direction:column;align-items:center;">

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
      #qr-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="qr-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;display:flex;justify-content:center;">
      <div style="padding:28px;border-radius:24px;background:#FFFFFF;border:2px solid #E5E7EB;max-width:480px;width:100%;text-align:center;">
        <div class="fcc-skeleton-box" style="width:52px;height:52px;border-radius:16px;margin:0 auto 16px;"></div>
        <div class="fcc-skeleton-box" style="width:60%;height:22px;margin:0 auto 10px;"></div>
        <div class="fcc-skeleton-box" style="width:220px;height:220px;margin:0 auto 20px;border-radius:16px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:100px;border-radius:14px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('qr-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    <div style="max-width:480px;width:100%;">
      <div class="fcc-card" style="padding:32px 28px;text-align:center;width:100%;border-radius:24px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div style="width:52px;height:52px;border-radius:16px;background:#131218;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 4px 14px rgba(19,18,24,0.2);">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        </div>
        <h2 style="font-size:20px;font-weight:900;color:#131218;margin:0 0 6px;">QR Code Kehadiran</h2>
        <p style="font-size:13px;color:#64748B;margin:0 0 22px;font-weight:500;">Tunjukkan QR Code ini kepada panitia saat registrasi di lokasi acara.</p>

        <div id="my-qr" style="display:inline-block;padding:16px;background:#FFFFFF;border:2px solid #131218;border-radius:18px;margin-bottom:20px;box-shadow:0 4px 16px rgba(0,0,0,0.06);"></div>

        <div style="background:#F8FAFC;border-radius:14px;padding:16px;text-align:left;margin-bottom:20px;border:1.5px solid #E2E8F0;">
          @foreach([['Kegiatan',Str::limit($pendaftaran->kegiatan->judul,36)],['Tanggal',$pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->format('d M Y')??'Jadwal Menyusul'],['Status Kehadiran',ucfirst(str_replace('_',' ',$pendaftaran->status_kehadiran??'belum hadir'))]] as [$l,$v])
          <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #E2E8F0;">
            <span style="font-size:11px;color:#64748B;font-weight:800;text-transform:uppercase;letter-spacing:.5px;">{{ $l }}</span>
            <span style="font-size:13px;font-weight:900;color:#131218;">{{ $v }}</span>
          </div>
          @endforeach
        </div>

        @if($pendaftaran->status_kehadiran === 'hadir')
        <div style="background:#ECFDF5;border:1.5px solid #10B981;border-radius:12px;padding:14px;margin-bottom:20px;">
          <p style="color:#059669;font-weight:900;margin:0;font-size:14px;">✓ Kehadiran Sudah Tercatat</p>
        </div>
        @endif

        <a href="{{ route('peserta.qr.cetak', $pendaftaran) }}" target="_blank" style="display:flex;align-items:center;justify-content:center;gap:8px;text-align:center;padding:12px;font-size:13.5px;text-decoration:none;border-radius:12px;font-weight:900;background:#131218;color:#FFFFFF;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(19,18,24,0.2);">
          @include('components.icon',['name'=>'download','size'=>15,'style'=>'color:#FFC81A']) Simpan QR Code (PDF) &rarr;
        </a>
      </div>
    </div>
</div>
@endsection
@push('page-data')
<script>
window.PAGE_DATA = {!! json_encode([
    'qrList' => [['id' => $pendaftaran->id, 'url' => route('qr.scan', $pendaftaran->qr_token)]],
    'qrSize' => 200,
]) !!};
</script>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
@vite('resources/js/pages/admin-qr.js')
@endpush
