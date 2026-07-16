@extends('layouts.app')
@section('content')
<div style="min-height:100vh;background:#F7F8FA;display:flex;align-items:center;justify-content:center;font-family:'Inter',sans-serif;padding:24px;">
  <div style="text-align:center;max-width:480px;">
    <div style="width:80px;height:80px;border-radius:22px;background:#131218;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
      <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
    </div>
    <p style="font-size:72px;font-weight:900;color:#131218;margin:0 0 6px;line-height:1;">403</p>
    <p style="font-size:20px;font-weight:800;color:#131218;margin:0 0 12px;">Akses Ditolak</p>
    <p style="color:#6B7280;font-size:15px;margin:0 0 28px;line-height:1.7;">
      Kamu tidak memiliki izin untuk mengakses halaman ini. Pastikan kamu sudah masuk dengan akun yang benar.
    </p>
    <div style="display:flex;gap:10px;justify-content:center;">
      <a href="{{ route('auth.login') }}" style="padding:11px 22px;font-size:14px;font-weight:800;background:linear-gradient(135deg,#FFC81A,#FFD84D);color:#131218;text-decoration:none;border-radius:10px;box-shadow:0 4px 14px rgba(255,200,26,.3);">
        Masuk Ulang
      </a>
      <a href="{{ route('landing.index') }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#FFF;border:1.5px solid #E2E4EB;border-radius:10px;">Beranda</a>
    </div>
  </div>
</div>
@endsection
