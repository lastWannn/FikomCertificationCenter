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
            <p style="color:#6B7280;font-size:14px;margin:0;">Masukkan email Anda. Kami akan mengirimkan kode OTP untuk mereset password.</p>
        </div>
        
        <div id="forgotError" style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:10px;padding:12px 14px;margin-bottom:18px;color:#EF4444;font-size:13px;display:none;"></div>

        <form id="forgotForm" action="{{ route('auth.forgot.post') }}" method="POST">
            @csrf
            <label style="display:block;font-size:11px;font-weight:700;color:#6B7280;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Email *</label>
            <div style="position:relative;margin-bottom:20px;">
                <svg style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#A0A3AD;pointer-events:none;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <input type="email" name="email" id="emailInput" value="{{ old('email') }}" required placeholder="email@example.com"
                       class="fcc-input" style="padding-left:42px;"
                       onkeydown="if(event.key==='Enter')event.preventDefault();">
            </div>
            <button id="btnSubmitForgot" type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:12px;font-size:15px;">Kirim Kode OTP</button>
        </form>
        <p style="text-align:center;margin-top:18px;font-size:14px;color:#6B7280;">
            <a href="{{ route('auth.login') }}" style="color:#FFC81A;font-weight:700;text-decoration:none;">&larr; Kembali ke Login</a>
        </p>
    </div>
</div>

{{-- MODAL OTP RESET --}}
<div id="otpResetModal" style="display:none;position:fixed;inset:0;background:rgba(14,13,20,.8);backdrop-filter:blur(5px);z-index:9999;align-items:center;justify-content:center;padding:20px;">
    <div style="background:#FFF;width:100%;max-width:400px;border-radius:24px;padding:40px;box-shadow:0 24px 64px rgba(0,0,0,.15);text-align:center;position:relative;">
        <h3 style="color:#0F0F14;font-size:20px;font-weight:900;margin:0 0 8px;">Reset Password</h3>
        <p style="color:#6B7280;font-size:13px;line-height:1.6;margin:0 0 24px;">
            Kode OTP telah dikirim ke <br>
            <strong id="resetEmailDisplay" style="color:#131218;"></strong>
        </p>
        
        <form id="otpResetForm" action="{{ route('auth.forgot.verify') }}" method="POST">
            @csrf
            <input type="hidden" name="email" id="resetEmailInput">
            
            <div style="display:flex;gap:12px;justify-content:center;margin-bottom:20px;" id="resetOtpInputs">
                <input type="text" maxlength="1" class="otp-box-light" required autofocus>
                <input type="text" maxlength="1" class="otp-box-light" required>
                <input type="text" maxlength="1" class="otp-box-light" required>
                <input type="text" maxlength="1" class="otp-box-light" required>
            </div>
            <input type="hidden" name="otp" id="finalResetOtp">

            <div style="text-align:left;margin-bottom:12px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;">Password Baru</label>
                <input type="password" name="password" required class="fcc-input" style="width:100%;box-sizing:border-box;">
            </div>
            <div style="text-align:left;margin-bottom:24px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required class="fcc-input" style="width:100%;box-sizing:border-box;">
            </div>

            <div id="resetError" style="color:#EF4444;font-size:12px;margin-bottom:16px;display:none;font-weight:600;"></div>
            
            <button id="btnVerifyReset" type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:12px;font-size:14px;border-radius:10px;">
                Simpan Password Baru
            </button>
        </form>
    </div>
</div>

<style>
.otp-box-light {
    width:48px;height:54px;background:#F9FAFB;border:1.5px solid #E5E7EB;
    border-radius:12px;text-align:center;font-size:24px;font-weight:900;color:#111827;
    transition:all .2s;outline:none;
}
.otp-box-light:focus { border-color:#FFC81A;background:#FFF;box-shadow:0 0 0 4px rgba(255,200,26,.15); }
</style>

<script>
document.getElementById('forgotForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmitForgot');
    const oriText = btn.innerHTML;
    btn.innerHTML = 'Memproses...';
    btn.disabled = true;
    document.getElementById('forgotError').style.display = 'none';

    try {
        const formData = new FormData(this);
        const res = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        
        if (data.require_otp) {
            document.getElementById('resetEmailDisplay').innerText = data.email;
            document.getElementById('resetEmailInput').value = data.email;
            document.getElementById('otpResetModal').style.display = 'flex';
            document.querySelector('.otp-box-light').focus();
        } else if (data.errors) {
            document.getElementById('forgotError').innerText = Object.values(data.errors).flat()[0];
            document.getElementById('forgotError').style.display = 'block';
        }
    } catch (err) {
        document.getElementById('forgotError').innerText = 'Terjadi kesalahan.';
        document.getElementById('forgotError').style.display = 'block';
    } finally {
        btn.innerHTML = oriText;
        btn.disabled = false;
    }
});

// OTP Input Logic
const roBoxes = document.querySelectorAll('.otp-box-light');
roBoxes.forEach((box, i) => {
    box.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value && i < roBoxes.length - 1) roBoxes[i + 1].focus();
    });
    box.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && i > 0) {
            roBoxes[i - 1].focus();
        }
    });
});

document.getElementById('otpResetForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnVerifyReset');
    const oriText = btn.innerHTML;
    
    let otp = '';
    roBoxes.forEach(b => otp += b.value);
    document.getElementById('finalResetOtp').value = otp;
    
    if (otp.length < 4) return;

    btn.innerHTML = 'Memverifikasi...';
    btn.disabled = true;
    document.getElementById('resetError').style.display = 'none';

    try {
        const formData = new FormData(this);
        const res = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        
        if (data.success) {
            alert(data.message);
            window.location.href = data.redirect;
        } else if (data.errors) {
            let errMsg = data.errors.otp ? data.errors.otp[0] : '';
            if (data.errors.password) errMsg += ' ' + data.errors.password[0];
            document.getElementById('resetError').innerText = errMsg || 'Input tidak valid.';
            document.getElementById('resetError').style.display = 'block';
        }
    } catch (err) {
        document.getElementById('resetError').innerText = 'Terjadi kesalahan jaringan.';
        document.getElementById('resetError').style.display = 'block';
    } finally {
        btn.innerHTML = oriText;
        btn.disabled = false;
    }
});
</script>
@endsection
