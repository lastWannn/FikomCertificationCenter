@extends('layouts.app')
@section('content')
<div style="min-height:100vh;background:#F7F8FA;display:flex;align-items:center;justify-content:center;font-family:'Inter',sans-serif;padding:24px;">
  <div style="text-align:center;max-width:480px;">
    <div style="width:80px;height:80px;border-radius:22px;background:#131218;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
      <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    </div>
    <p style="font-size:72px;font-weight:900;color:#131218;margin:0 0 6px;line-height:1;">404</p>
    <p style="font-size:20px;font-weight:800;color:#131218;margin:0 0 12px;">Halaman Tidak Ditemukan</p>
    <p style="color:#6B7280;font-size:15px;margin:0 0 28px;line-height:1.7;">
      Halaman yang kamu cari mungkin telah dipindahkan, dihapus, atau tidak pernah ada.
    </p>
    <div style="display:flex;gap:10px;justify-content:center;">
      <a href="{{ url()->previous() }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#FFF;border:1.5px solid #E2E4EB;border-radius:10px;display:inline-flex;align-items:center;gap:6px;">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
      </a>
      <a href="{{ route('landing.index') }}" style="padding:11px 22px;font-size:14px;font-weight:800;background:linear-gradient(135deg,#FFC81A,#FFD84D);color:#131218;text-decoration:none;border-radius:10px;box-shadow:0 4px 14px rgba(255,200,26,.3);display:inline-flex;align-items:center;gap:6px;">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        Beranda
      </a>
    </div>
  </div>
</div>
@endsection
