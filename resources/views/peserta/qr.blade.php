@extends('layouts.peserta')
@section('title','QR Kehadiran')
@section('page-title','QR Kehadiran')
@section('page-content')
<div style="padding:24px;display:flex;flex-direction:column;align-items:center;max-width:480px;margin:0 auto;">
  <div class="fcc-card" style="padding:28px;text-align:center;width:100%;">
    <div style="width:50px;height:50px;border-radius:14px;background:#131218;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
    </div>
    <h2 style="font-size:18px;font-weight:900;color:#131218;margin:0 0 6px;">QR Code Kehadiran</h2>
    <p style="font-size:13px;color:#9CA3B0;margin:0 0 20px;">Tunjukkan QR ini saat registrasi on-site</p>

    <div id="my-qr" style="display:inline-block;padding:14px;background:#FFF;border:2px solid #E2E4EB;border-radius:14px;margin-bottom:16px;"></div>

    <div style="background:#F7F8FA;border-radius:10px;padding:14px 16px;text-align:left;margin-bottom:16px;">
      @foreach([['Kegiatan',Str::limit($pendaftaran->kegiatan->judul,36)],['Tanggal',$pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->format('d M Y')??'TBA'],['Status Kehadiran',ucfirst(str_replace('_',' ',$pendaftaran->status_kehadiran??'belum'))]] as [$l,$v])
      <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #E2E4EB;">
        <span style="font-size:11px;color:#9CA3B0;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">{{ $l }}</span>
        <span style="font-size:13px;font-weight:700;color:#131218;">{{ $v }}</span>
      </div>
      @endforeach
    </div>

    @if($pendaftaran->status_kehadiran === 'hadir')
    <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);border-radius:10px;padding:12px;margin-bottom:16px;">
      <p style="color:#10B981;font-weight:800;margin:0;font-size:14px;">&#10003; Kehadiran Sudah Tercatat</p>
    </div>
    @endif

    <a href="{{ route('peserta.qr.cetak', $pendaftaran) }}" target="_blank" class="fcc-btn-outline-dark" style="display:block;text-align:center;padding:10px;font-size:14px;text-decoration:none;">
      @include('components.icon',['name'=>'download','size'=>14]) Simpan QR
    </a>
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
