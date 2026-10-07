@extends('layouts.admin')
@section('title','QR Presensi')
@section('page-title','QR Presensi')
@section('page-content')
<style>
  .fcc-qr-container {
    padding: 24px;
    box-sizing: border-box;
    width: 100%;
  }
  .fcc-qr-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
  }
  .fcc-qr-header-actions {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
  }

  /* ═══ SMALL LAPTOP (1024px – 1279px) ═══ */
  @media (min-width: 1024px) and (max-width: 1279px) {
    .fcc-qr-grid {
      grid-template-columns: repeat(3, 1fr) !important;
      gap: 14px !important;
    }
  }

  /* ═══ TABLET (768px – 1023px) ═══ */
  @media (min-width: 768px) and (max-width: 1023px) {
    .fcc-qr-container {
      padding: 18px 16px !important;
    }
    .fcc-qr-grid {
      grid-template-columns: repeat(2, 1fr) !important;
      gap: 12px !important;
    }
  }

  /* ═══ SMALL TABLET & MOBILE (< 768px) ═══ */
  @media (max-width: 767px) {
    .fcc-qr-container {
      padding: 14px 10px !important;
    }
    .fcc-qr-header-actions {
      width: 100% !important;
    }
    .fcc-qr-header-actions > * {
      flex: 1 1 auto !important;
      justify-content: center !important;
      text-align: center !important;
    }
    .fcc-qr-header-actions form {
      display: flex !important;
      flex: 1 1 auto !important;
    }
    .fcc-qr-header-actions form button {
      width: 100% !important;
      justify-content: center !important;
    }
    .fcc-qr-grid {
      grid-template-columns: repeat(2, 1fr) !important;
      gap: 10px !important;
    }
  }

  /* ═══ COMPACT MOBILE (< 480px) ═══ */
  @media (max-width: 479px) {
    .fcc-qr-container {
      padding: 12px 8px !important;
    }
    .fcc-qr-grid {
      grid-template-columns: 1fr !important;
      gap: 10px !important;
    }
  }
</style>

<div class="fcc-qr-container">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:14px;">
    <div>
      <a href="{{ route('admin.kegiatan.show', $kegiatan) }}" style="display:inline-flex;align-items:center;gap:6px;color:#64748B;font-size:12.5px;font-weight:700;text-decoration:none;margin-bottom:8px;background:#F1F5F9;padding:4px 12px;border-radius:20px;border:1px solid #CBD5E1;transition:all .18s;"
         onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
        @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
      </a>
      <h2 style="font-size:20px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">QR Code Presensi</h2>
      <p style="color:#64748B;font-size:13px;margin:3px 0 0;font-weight:500;">{{ $kegiatan->judul }}</p>
    </div>
    <div class="fcc-qr-header-actions">
      <a href="{{ route('admin.qr.cetak-sheet', $kegiatan) }}" target="_blank" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;font-weight:800;border-radius:30px;border:1.5px solid #131218;background:#FFC81A;color:#131218;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 4px 14px rgba(255,200,26,0.35);">
        @include('components.icon',['name'=>'printer','size'=>14]) Cetak Semua QR
      </a>
      <form action="{{ route('admin.qr.regenerate', $kegiatan) }}" method="POST" style="margin:0;">
        @csrf
        <button type="submit" onclick="return fccConfirmAction(event, this, 'Regenerate QR', 'Generate ulang semua QR Code presensi? QR lama tidak akan bisa digunakan lagi.', 'Ya, Generate', true)" style="padding:9px 16px;border-radius:30px;border:1.5px solid #CBD5E1;background:#F8FAFC;color:#131218;font-size:13px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
          @include('components.icon',['name'=>'refresh-cw','size'=>14]) Regenerate
        </button>
      </form>
    </div>
  </div>

  <div class="fcc-card" style="padding:16px 20px;margin-bottom:20px;background:#FFFDF5;border:1.5px solid #FFC81A;border-radius:16px;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:34px;height:34px;border-radius:10px;background:#FFC81A;border:1px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;">
        @include('components.icon',['name'=>'info','size'=>16,'style'=>'color:#131218;'])
      </div>
      <p style="font-size:12.5px;color:#64748B;margin:0;font-weight:600;line-height:1.4;">QR Code unik per peserta. Saat peserta menunjukkan QR-nya, scan menggunakan kamera HP yang mengarah ke URL scan untuk mencatat kehadiran otomatis.</p>
    </div>
  </div>

  <div class="fcc-qr-grid">
    @forelse($kegiatan->pendaftaran->where('status_pendaftaran','terdaftar') as $pd)
    @php if(!$pd->qr_token) $pd->update(['qr_token'=>\Illuminate\Support\Str::random(32)]); @endphp
    <div class="fcc-card" style="padding:20px 16px;text-align:center;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);">
      {{-- QR di browser via JS --}}
      <div id="qr-{{ $pd->id }}" style="width:120px;height:120px;margin:0 auto 14px;display:flex;align-items:center;justify-content:center;background:#F8FAFC;border-radius:12px;padding:6px;border:1px solid #E2E8F0;"></div>
      <p style="font-size:13.5px;font-weight:900;color:#131218;margin:0 0 2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $pd->peserta->nama }}</p>
      <p style="font-size:11px;color:#64748B;margin:0 0 12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:500;">{{ $pd->peserta->email }}</p>
      @if($pd->status_kehadiran === 'hadir')
      <span style="font-size:10.5px;font-weight:900;padding:4px 12px;border-radius:20px;background:#ECFDF5;color:#10B981;border:1px solid #10B981;display:inline-block;">&#10003; Sudah Hadir</span>
      @else
      <span style="font-size:10.5px;font-weight:800;padding:4px 12px;border-radius:20px;background:#F8FAFC;color:#64748B;border:1px solid #CBD5E1;display:inline-block;">Belum Hadir</span>
      @endif
    </div>
    @empty
    <div style="grid-column:1 / -1;padding:40px;text-align:center;color:#94A3B8;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;" class="fcc-card">
      Belum ada peserta terdaftar yang memiliki QR Code.
    </div>
    @endforelse
  </div>
</div>
@endsection
@push('page-data')
<script>
window.PAGE_DATA = {!! json_encode([
    'qrList' => $kegiatan->pendaftaran
        ->where('status_pendaftaran', 'terdaftar')
        ->filter(fn($p) => $p->qr_token)
        ->map(fn($p) => [
            'id'  => $p->id,
            'url' => route('qr.scan', $p->qr_token),
        ])->values(),
    'qrSize' => 120,
]) !!};
</script>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
@vite('resources/js/pages/admin-qr.js')
@endpush
