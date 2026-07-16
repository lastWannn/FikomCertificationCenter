@extends('layouts.admin')
@section('title','QR Presensi')
@section('page-title','QR Presensi')
@section('page-content')
<div style="padding:20px 24px;">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:12px;">
    <div>
      <a href="{{ route('admin.kegiatan.show', $kegiatan) }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:8px;">
        @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
      </a>
      <h2 style="font-size:18px;font-weight:900;color:#131218;margin:0;">QR Code Presensi</h2>
      <p style="color:#6B7280;font-size:13px;margin:4px 0 0;">{{ $kegiatan->judul }}</p>
    </div>
    <div style="display:flex;gap:8px;">
      <a href="{{ route('admin.qr.cetak-sheet', $kegiatan) }}" target="_blank" class="fcc-btn-gold" style="padding:9px 16px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'printer','size'=>13]) Cetak Semua QR
      </a>
      <form action="{{ route('admin.qr.regenerate', $kegiatan) }}" method="POST">
        @csrf
        <button type="submit" onclick="return confirm('Generate ulang semua QR? QR lama tidak akan bisa digunakan.')" style="padding:9px 14px;border-radius:10px;border:1.5px solid #E2E4EB;background:#F7F8FA;color:#6B7280;font-size:13px;font-weight:700;cursor:pointer;">
          @include('components.icon',['name'=>'refresh-cw','size'=>13]) Regenerate
        </button>
      </form>
    </div>
  </div>

  <div class="fcc-card" style="padding:18px;margin-bottom:16px;background:rgba(255,200,26,.04);border-color:rgba(255,200,26,.25);">
    <div style="display:flex;align-items:center;gap:10px;">
      @include('components.icon',['name'=>'info','size'=>16,'style'=>'color:#FFC81A;flex-shrink:0'])
      <p style="font-size:13px;color:#6B7280;margin:0;">QR Code unik per peserta. Saat peserta menunjukkan QR-nya, scan menggunakan kamera HP yang mengarah ke URL scan untuk mencatat kehadiran otomatis.</p>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;">
    @forelse($kegiatan->pendaftaran->where('status_pendaftaran','terdaftar') as $pd)
    @php if(!$pd->qr_token) $pd->update(['qr_token'=>\Illuminate\Support\Str::random(32)]); @endphp
    <div class="fcc-card" style="padding:18px;text-align:center;">
      {{-- QR di browser via JS --}}
      <div id="qr-{{ $pd->id }}" style="width:120px;height:120px;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;"></div>
      <p style="font-size:13px;font-weight:700;color:#131218;margin:0 0 3px;">{{ $pd->peserta->nama }}</p>
      <p style="font-size:10px;color:#9CA3B0;margin:0 0 10px;">{{ $pd->peserta->email }}</p>
      @if($pd->status_kehadiran === 'hadir')
      <span style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;background:rgba(16,185,129,.12);color:#10B981;">&#10003; Sudah Hadir</span>
      @else
      <span style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;background:#F7F8FA;color:#9CA3B0;border:1px solid #E2E4EB;">Belum Hadir</span>
      @endif
    </div>
    @empty
    <div style="grid-column:span 4;padding:40px;text-align:center;color:#9CA3B0;" class="fcc-card">
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
