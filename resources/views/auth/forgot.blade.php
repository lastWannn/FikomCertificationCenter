@extends('layouts.app')
@section('title','Lupa Password')
@section('content')
<div style="display:flex;min-height:100vh;align-items:center;justify-content:center;background:#F4F5F7;font-family:'Inter',sans-serif;padding:24px;">
    <div style="background:#FFF;border-radius:20px;padding:44px 40px;max-width:420px;width:100%;box-shadow:0 12px 40px rgba(0,0,0,.08);border:1px solid #E0E2E8;">
        <div style="text-align:center;margin-bottom:28px;">
            <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 8px 20px rgba(255,200,26,.3);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h1 style="color:#0F0F14;font-size:24px;font-weight:900;margin:0 0 8px;">Lupa Password?</h1>
            <p style="color:#6B7280;font-size:14px;margin:0;">Masukkan email Anda. Kami akan mengirimkan link reset password.</p>
        </div>
        @if(session('status'))
        <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);border-radius:10px;padding:12px 14px;margin-bottom:20px;color:#10B981;font-size:13px;font-weight:600;">&#10003; {{ session('status') }}</div>
        @endif
        <form action="{{ route('auth.forgot') }}" method="POST">
            @csrf
            <label style="display:block;font-size:11px;font-weight:700;color:#6B7280;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Email *</label>
            <div style="position:relative;margin-bottom:20px;">
                <svg style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#A0A3AD;pointer-events:none;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com"
                       class="fcc-input" style="padding-left:42px;"
                       onkeydown="if(event.key==='Enter')event.preventDefault();">
            </div>
            <button type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:12px;font-size:15px;">Kirim Link Reset</button>
        </form>
        <p style="text-align:center;margin-top:18px;font-size:14px;color:#6B7280;">
            <a href="{{ route('auth.login') }}" style="color:#FFC81A;font-weight:700;text-decoration:none;">&larr; Kembali ke Login</a>
        </p>
    </div>
</div>
@endsection
