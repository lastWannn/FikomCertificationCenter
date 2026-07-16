@extends('layouts.app')
@section('content')
<div style="min-height:100vh;background:#131218;display:flex;align-items:center;justify-content:center;font-family:'Inter',sans-serif;padding:24px;">
  <div style="text-align:center;max-width:480px;">
    <div style="width:80px;height:80px;border-radius:22px;background:rgba(255,200,26,.12);border:1.5px solid rgba(255,200,26,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
      <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    </div>
    <p style="font-size:72px;font-weight:900;color:#FFF;margin:0 0 6px;line-height:1;">500</p>
    <p style="font-size:20px;font-weight:800;color:#FFF;margin:0 0 12px;">Terjadi Kesalahan Server</p>
    <p style="color:rgba(255,255,255,.55);font-size:15px;margin:0 0 28px;line-height:1.7;">
      Server mengalami masalah saat memproses permintaanmu. Tim teknis kami sudah diberitahu.
    </p>
    <a href="{{ route('landing.index') }}" style="padding:12px 24px;font-size:14px;font-weight:800;background:linear-gradient(135deg,#FFC81A,#FFD84D);color:#131218;text-decoration:none;border-radius:10px;box-shadow:0 4px 14px rgba(255,200,26,.35);display:inline-flex;align-items:center;gap:6px;">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Kembali ke Beranda
    </a>
  </div>
</div>
@endsection
