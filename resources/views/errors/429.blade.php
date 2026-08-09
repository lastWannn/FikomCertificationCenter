@extends('layouts.app')
@section('title', '429 - Terlalu Banyak Percobaan')
@section('content')
<div style="min-height:100vh;background:#F7F8FA;display:flex;align-items:center;justify-content:center;font-family:'Inter',sans-serif;padding:24px;">
  <div style="text-align:center;max-width:500px;background:#FFF;padding:40px 36px;border-radius:24px;box-shadow:0 20px 50px rgba(0,0,0,0.06);border:1px solid #E2E8F0;">
    <div style="width:80px;height:80px;border-radius:22px;background:#FEF3C7;border:1.5px solid #FCD34D;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
      <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
    <p style="font-size:56px;font-weight:900;color:#131218;margin:0 0 4px;line-height:1;">429</p>
    <p style="font-size:20px;font-weight:800;color:#131218;margin:0 0 12px;">Terlalu Banyak Percobaan</p>
    <p style="color:#64748B;font-size:14.5px;margin:0 0 28px;line-height:1.75;">
      Untuk melindungi keamanan akun Anda dari percobaan berulang, sistem membatasi permintaan sementara waktu. Silakan tunggu <strong>1 menit</strong> sebelum mencoba kembali.
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
      <a href="{{ route('landing.index') }}" style="padding:12px 24px;font-size:14px;font-weight:800;background:linear-gradient(135deg,#FFC81A,#FFD84D);color:#131218;text-decoration:none;border-radius:12px;box-shadow:0 4px 14px rgba(255,200,26,.3);display:inline-flex;align-items:center;gap:6px;">
        Kembali ke Beranda
      </a>
    </div>
  </div>
</div>
@endsection
