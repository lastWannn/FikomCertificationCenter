@extends('layouts.app')
@section('title','Daftar Akun')
@section('content')
<div style="display:flex;min-height:100vh;font-family:'Inter',sans-serif;">
    {{-- KIRI: #131218 + #FFC81A --}}
    <div style="flex:1;background:#131218;position:relative;overflow:hidden;
        display:flex;flex-direction:column;justify-content:center;align-items:center;padding:60px 40px;">
        <div style="position:absolute;inset:0;opacity:.04;
            background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),
                             linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);
            background-size:60px 60px;"></div>
        <div style="position:absolute;top:8%;right:6%;width:240px;height:240px;animation:spin 22s linear infinite;">
            <svg width="240" height="240" viewBox="0 0 240 240"><circle cx="120" cy="120" r="110" fill="none" stroke="rgba(255,200,26,.1)" stroke-width="1" stroke-dasharray="8 7"/></svg>
        </div>
        <div class="hex" style="position:absolute;top:18%;right:12%;width:38px;height:38px;background:rgba(255,200,26,.18);animation:float1 6s ease-in-out infinite;"></div>
        <div class="dia" style="position:absolute;top:60%;right:5%;width:18px;height:18px;background:rgba(255,200,26,.22);animation:float3 5s ease-in-out infinite .8s;"></div>

        <div style="position:relative;z-index:2;text-align:center;max-width:340px;width:100%;">
            <a href="{{ route('landing.index') }}" style="display:inline-flex;align-items:center;gap:12px;margin-bottom:36px;text-decoration:none;">
                <div style="width:48px;height:48px;border-radius:13px;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center;box-shadow:0 0 22px rgba(255,200,26,.35);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div style="text-align:left;">
                    <p style="margin:0;color:#FFF;font-weight:900;font-size:17px;">FIKOM Certification</p>
                    <p style="margin:0;color:#FFC81A;font-size:9px;letter-spacing:3px;text-transform:uppercase;">Center &middot; UMI</p>
                </div>
            </a>
            <h2 style="color:#FFF;font-size:25px;font-weight:900;margin:0 0 12px;">Bergabung<br/>bersama kami &#127919;</h2>
            <p style="color:rgba(255,255,255,.48);font-size:14px;line-height:1.75;margin:0 0 32px;">
                Daftarkan dirimu sebagai peserta FCC dan mulai perjalanan sertifikasi profesionalmu.
            </p>
            {{-- Keuntungan --}}
            <div style="background:rgba(255,200,26,.08);border:1px solid rgba(255,200,26,.2);border-radius:12px;padding:18px 16px;text-align:left;">
                <p style="margin:0 0 10px;color:#FFC81A;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1px;">Keuntungan Bergabung</p>
                @foreach(['Akses semua program pelatihan & sertifikasi','Pembayaran mudah dengan kode unik','Sertifikat digital resmi dari FCC','Pantau progres kegiatan real-time'] as $b)
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:7px;">
                    <div style="width:18px;height:18px;border-radius:5px;background:rgba(255,200,26,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <span style="color:rgba(255,255,255,.65);font-size:13px;">{{ $b }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- KANAN: PUTIH --}}
    <div style="width:500px;min-width:500px;background:#0e0d14;display:flex;flex-direction:column;
        justify-content:center;padding:48px 48px;overflow-y:auto;border-left:1px solid rgba(255,255,255,.05);">
        <a href="{{ route('landing.index') }}" style="display:flex;align-items:center;gap:6px;color:rgba(255,255,255,.5);font-size:13px;text-decoration:none;font-weight:500;margin-bottom:28px;transition:color .18s;"
           onmouseover="this.style.color='#FFF'" onmouseout="this.style.color='rgba(255,255,255,.5)'">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Beranda
        </a>
        <div style="max-width:380px;margin:0 auto;width:100%;">
            <h1 style="color:#FFF;font-size:26px;font-weight:900;margin:0 0 6px;">Buat Akun</h1>
            <p style="color:rgba(255,255,255,.5);font-size:14px;margin:0 0 26px;">
                Sudah punya akun?
                <a href="{{ route('auth.login') }}" style="color:#FFC81A;font-weight:700;text-decoration:none;">Masuk di sini</a>
            </p>

            @if($errors->any())
            <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:10px;padding:12px 14px;margin-bottom:18px;color:#EF4444;font-size:13px;">
                <ul style="margin:0;padding:0 0 0 16px;">
                    @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form id="registerForm" action="{{ route('auth.register.post') }}" method="POST">
                @csrf
                {{-- Nama --}}
                <div style="margin-bottom:13px;">
                    <label style="font-size:11px;font-weight:700;color:rgba(255,255,255,.6);display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Nama Lengkap <span style="color:#FFC81A;">*</span></label>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Sesuai KTP" required class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;" onkeydown="if(event.key==='Enter')event.preventDefault();">
                    </div>
                </div>
                {{-- Email --}}
                <div style="margin-bottom:13px;">
                    <label style="font-size:11px;font-weight:700;color:rgba(255,255,255,.6);display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Email <span style="color:#FFC81A;">*</span></label>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;" onkeydown="if(event.key==='Enter')event.preventDefault();">
                    </div>
                </div>
                {{-- HP --}}
                <div style="margin-bottom:13px;">
                    <label style="font-size:11px;font-weight:700;color:rgba(255,255,255,.6);display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">No. HP <span style="color:#FFC81A;">*</span></label>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.17 11.83 19.79 19.79 0 0 1 1.1 3.23 2 2 0 0 1 3.1 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg>
                        <input type="tel" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;" onkeydown="if(event.key==='Enter')event.preventDefault();">
                    </div>
                </div>
                {{-- Instansi --}}
                <div style="margin-bottom:13px;">
                    <label style="font-size:11px;font-weight:700;color:rgba(255,255,255,.6);display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Instansi / Asal</label>
                    <input type="text" name="instansi" value="{{ old('instansi') }}" placeholder="Universitas / Perusahaan (opsional)" class="fcc-input-dark" style="width:100%;box-sizing:border-box;" onkeydown="if(event.key==='Enter')event.preventDefault();">
                </div>
                {{-- Kelamin --}}
                <div style="margin-bottom:13px;">
                    <label style="font-size:11px;font-weight:700;color:rgba(255,255,255,.6);display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Jenis Kelamin <span style="color:#FFC81A;">*</span></label>
                    <div style="display:flex;gap:10px;">
                        @foreach(['L'=>'Laki-laki','P'=>'Perempuan'] as $v=>$l)
                        <label style="flex:1;display:flex;align-items:center;gap:8px;padding:10px 14px;
                            border:1.5px solid rgba(255,255,255,.1);border-radius:9px;cursor:pointer;font-size:14px;
                            color:#FFF;transition:all .18s;background:rgba(255,255,255,.04);"
                               onmouseover="this.style.borderColor='#FFC81A';this.style.background='rgba(255,255,255,.08)'" onmouseout="this.style.borderColor='rgba(255,255,255,.1)';this.style.background='rgba(255,255,255,.04)'">
                            <input type="radio" name="kelamin" value="{{ $v }}" required style="accent-color:#FFC81A;">
                            {{ $l }}
                        </label>
                        @endforeach
                    </div>
                </div>
                {{-- Password --}}
                <div style="margin-bottom:13px;">
                    <label style="font-size:11px;font-weight:700;color:rgba(255,255,255,.6);display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Password <span style="color:#FFC81A;">*</span></label>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" name="password" placeholder="Minimal 8 karakter" required class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;" onkeydown="if(event.key==='Enter')event.preventDefault();">
                    </div>
                </div>
                <div style="margin-bottom:18px;">
                    <label style="font-size:11px;font-weight:700;color:rgba(255,255,255,.6);display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Konfirmasi Password <span style="color:#FFC81A;">*</span></label>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password" required class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;" onkeydown="if(event.key==='Enter')event.preventDefault();">
                    </div>
                </div>
                {{-- Agree --}}
                <div style="margin-bottom:22px;">
                    <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;font-size:13px;color:rgba(255,255,255,.6);line-height:1.6;">
                        <input type="checkbox" name="agree" required style="accent-color:#FFC81A;width:15px;height:15px;flex-shrink:0;margin-top:2px;">
                        Saya menyetujui
                        <a href="#" style="color:#FFC81A;font-weight:700;text-decoration:none;">Syarat &amp; Ketentuan</a>
                        dan
                        <a href="#" style="color:#FFC81A;font-weight:700;text-decoration:none;">Kebijakan Privasi</a>
                        FCC
                    </label>
                </div>
                <button id="btnSubmit" type="submit" class="fcc-btn-gold btn-shine" style="width:100%;justify-content:center;padding:13px;font-size:15px;border-radius:12px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    Buat Akun Peserta
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL OTP --}}
<div id="otpModal" style="display:none;position:fixed;inset:0;background:rgba(14,13,20,.8);backdrop-filter:blur(5px);z-index:9999;align-items:center;justify-content:center;padding:20px;">
    <div style="background:#131218;width:100%;max-width:400px;border-radius:24px;padding:40px;box-shadow:0 24px 64px rgba(0,0,0,.4);border:1px solid rgba(255,200,26,.2);text-align:center;position:relative;">
        <div style="width:64px;height:64px;border-radius:18px;background:rgba(255,200,26,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <h3 style="color:#FFF;font-size:20px;font-weight:900;margin:0 0 8px;">Verifikasi Email</h3>
        <p style="color:rgba(255,255,255,.5);font-size:13px;line-height:1.6;margin:0 0 24px;">
            Kami telah mengirimkan 4 digit kode OTP ke <br>
            <strong id="otpEmailDisplay" style="color:#FFC81A;"></strong>
        </p>
        
        <form id="otpForm" action="{{ route('auth.register.verify') }}" method="POST">
            @csrf
            <input type="hidden" name="email" id="otpEmailInput">
            <div style="display:flex;gap:12px;justify-content:center;margin-bottom:24px;" id="otpInputs">
                <input type="text" maxlength="1" class="otp-box" required autofocus>
                <input type="text" maxlength="1" class="otp-box" required>
                <input type="text" maxlength="1" class="otp-box" required>
                <input type="text" maxlength="1" class="otp-box" required>
            </div>
            <input type="hidden" name="otp" id="finalOtp">
            <div id="otpError" style="color:#EF4444;font-size:12px;margin-bottom:16px;display:none;font-weight:600;"></div>
            
            <button id="btnVerify" type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:12px;font-size:14px;border-radius:10px;">
                Verifikasi & Masuk
            </button>
        </form>
    </div>
</div>

<style>
.otp-box {
    width:50px;height:56px;background:rgba(255,255,255,.04);border:1.5px solid rgba(255,255,255,.1);
    border-radius:12px;text-align:center;font-size:24px;font-weight:900;color:#FFF;
    transition:all .2s;outline:none;
}
.otp-box:focus { border-color:#FFC81A;background:rgba(255,200,26,.05);box-shadow:0 0 0 4px rgba(255,200,26,.1); }
</style>

<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmit');
    const oriText = btn.innerHTML;
    btn.innerHTML = '<span style="display:flex;align-items:center;gap:8px;">Memproses <div style="width:14px;height:14px;border:2px solid #131218;border-top-color:transparent;border-radius:50%;animation:spin 1s linear infinite;"></div></span>';
    btn.disabled = true;

    try {
        const formData = new FormData(this);
        const res = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        let data = {};
        try {
            data = await res.json();
        } catch(jsonErr) {
            console.error('Non-JSON response:', jsonErr);
        }

        if (data.require_otp) {
            document.getElementById('otpEmailDisplay').innerText = data.email;
            document.getElementById('otpEmailInput').value = data.email;
            document.getElementById('otpModal').style.display = 'flex';
            document.querySelector('.otp-box').focus();
        } else if (data.errors) {
            alert(Object.values(data.errors).flat().join('\n'));
        } else if (data.message) {
            alert(data.message);
        } else {
            alert('Gagal memproses pendaftaran. Silakan periksa kembali data Anda.');
        }
    } catch (err) {
        console.error('Fetch error:', err);
        alert('Terjadi kesalahan koneksi/sistem: ' + (err.message || err));
    } finally {
        btn.innerHTML = oriText;
        btn.disabled = false;
    }
});

// OTP Input Logic
const otpBoxes = document.querySelectorAll('.otp-box');
otpBoxes.forEach((box, i) => {
    box.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value && i < otpBoxes.length - 1) otpBoxes[i + 1].focus();
    });
    box.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && i > 0) {
            otpBoxes[i - 1].focus();
        }
    });
});

document.getElementById('otpForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnVerify');
    const oriText = btn.innerHTML;
    
    let otp = '';
    otpBoxes.forEach(b => otp += b.value);
    document.getElementById('finalOtp').value = otp;
    
    if (otp.length < 4) return;

    btn.innerHTML = 'Verifikasi...';
    btn.disabled = true;
    document.getElementById('otpError').style.display = 'none';

    try {
        const formData = new FormData(this);
        const res = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        
        if (data.success) {
            window.location.href = data.redirect;
        } else if (data.errors) {
            document.getElementById('otpError').innerText = data.errors.otp ? data.errors.otp[0] : 'Kode tidak valid.';
            document.getElementById('otpError').style.display = 'block';
            otpBoxes.forEach(b => b.value = '');
            otpBoxes[0].focus();
        }
    } catch (err) {
        document.getElementById('otpError').innerText = 'Terjadi kesalahan jaringan.';
        document.getElementById('otpError').style.display = 'block';
    } finally {
        btn.innerHTML = oriText;
        btn.disabled = false;
    }
});
</script>
@endsection
