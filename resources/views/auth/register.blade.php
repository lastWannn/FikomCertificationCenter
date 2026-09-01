@extends('layouts.app')
@section('title','Daftar Akun — FIKOM Certification Center')

@section('content')
<style>
    body, html {
        min-height: 100% !important;
        margin: 0 !important;
        background: #0E0D14;
    }
    .fcc-auth-page-wrap {
        min-height: 100vh;
        width: 100%;
        box-sizing: border-box;
        background: linear-gradient(135deg, rgba(10,9,13,0.88) 0%, rgba(14,13,20,0.94) 100%), url('{{ asset('images/herosection.webp') }}') center center / cover no-repeat fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 32px 20px;
        font-family: 'Inter', sans-serif;
        position: relative;
    }
    .fcc-auth-card-container {
        width: 100%;
        max-width: 1020px;
        background: rgba(14,13,18,0.92);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1.5px solid rgba(255,200,26,0.22);
        border-radius: 28px;
        padding: 32px 36px;
        display: flex;
        gap: 36px;
        box-shadow: 0 32px 80px rgba(0,0,0,0.7), 0 0 50px rgba(255,200,26,0.08);
        box-sizing: border-box;
        position: relative;
        overflow: hidden;
        align-items: stretch;
    }
    .fcc-yellow-input {
        width: 100%;
        box-sizing: border-box;
        background: rgba(255, 255, 255, 0.55);
        border: 1.5px solid rgba(19, 18, 24, 0.08);
        border-radius: 14px;
        padding: 9px 14px;
        color: #131218;
        font-size: 13px;
        font-weight: 700;
        outline: none;
        transition: background 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        font-family: inherit;
    }
    .fcc-yellow-input::placeholder {
        color: rgba(19, 18, 24, 0.45);
        font-weight: 500;
    }
    .fcc-yellow-input:focus {
        background: #FFFFFF;
        border-color: #131218;
        box-shadow: 0 0 0 3px rgba(19, 18, 24, 0.12);
    }
    .fcc-yellow-input:-webkit-autofill,
    .fcc-yellow-input:-webkit-autofill:hover, 
    .fcc-yellow-input:-webkit-autofill:focus, 
    .fcc-yellow-input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 1000px #FFE985 inset !important;
        -webkit-text-fill-color: #131218 !important;
        caret-color: #131218 !important;
        transition: background-color 5000s ease-in-out 0s;
    }
    .fcc-dark-pill-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #131218;
        color: #FFFFFF;
        font-weight: 800;
        font-size: 13.5px;
        padding: 10px 22px 10px 12px;
        border-radius: 100px;
        border: none;
        cursor: pointer;
        transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 6px 16px rgba(19, 18, 24, 0.25);
    }
    .fcc-dark-pill-btn:hover {
        transform: translateY(-2px);
        background: #000000;
        box-shadow: 0 10px 24px rgba(19, 18, 24, 0.35);
    }
    .fcc-contact-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 14px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        backdrop-filter: blur(10px);
        transition: all 0.25s ease;
        box-sizing: border-box;
    }
    .fcc-contact-card:hover {
        background: rgba(255, 255, 255, 0.09);
        border-color: rgba(255, 200, 26, 0.35);
        transform: translateX(4px);
    }
    .fcc-contact-icon-bg {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: rgba(255, 200, 26, 0.15);
        border: 1.5px solid rgba(255, 200, 26, 0.3);
        color: #FFC81A;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .fcc-gender-label input:checked + .fcc-gender-box {
        background: #131218 !important;
        color: #FFFFFF !important;
        box-shadow: 0 4px 14px rgba(19,18,24,0.2);
    }

    /* GPU ACCELERATED HEADLINE PANEL */
    .fcc-headline-panel {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.35s ease;
        will-change: transform, opacity;
    }
    .fcc-headline-active {
        opacity: 1;
        transform: translate3d(0, 0, 0);
        pointer-events: auto;
    }
    .fcc-headline-inactive-up {
        opacity: 0;
        transform: translate3d(0, -15px, 0);
        pointer-events: none;
    }
    .fcc-headline-inactive-down {
        opacity: 0;
        transform: translate3d(0, 15px, 0);
        pointer-events: none;
    }

    /* GPU ACCELERATED TRACK SLIDER */
    .fcc-gpu-track {
        display: flex;
        width: 200%;
        transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: transform;
    }
    .fcc-slide-item {
        width: 50%;
        box-sizing: border-box;
        padding: 0 28px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .otp-box {
        width: 48px;
        height: 52px;
        background: rgba(255, 255, 255, 0.05);
        border: 1.5px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        text-align: center;
        font-size: 22px;
        font-weight: 900;
        color: #FFFFFF;
        transition: all 0.2s ease;
        outline: none;
    }
    .otp-box:focus {
        border-color: #FFC81A;
        background: rgba(255, 200, 26, 0.08);
        box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.2);
    }

    /* Mobile & Tablet Responsiveness */
    @media (max-width: 991px) {
        .fcc-auth-page-wrap {
            padding: 20px 12px 40px !important;
            align-items: flex-start !important;
        }
        .fcc-auth-card-container {
            flex-direction: column !important;
            padding: 20px 14px !important;
            border-radius: 22px !important;
            max-width: 440px !important;
            gap: 16px !important;
            margin: 0 auto;
        }
        .fcc-auth-left-panel {
            text-align: center !important;
        }
        .fcc-headline-wrapper {
            min-height: auto !important;
            margin-bottom: 4px !important;
        }
        .fcc-headline-panel {
            position: relative !important;
        }
        .fcc-headline-panel.fcc-headline-inactive-up,
        .fcc-headline-panel.fcc-headline-inactive-down {
            display: none !important;
        }
        .fcc-headline-panel.fcc-headline-active {
            display: block !important;
        }
        .fcc-auth-left-panel h1 {
            font-size: 24px !important;
            margin-bottom: 6px !important;
        }
        .fcc-auth-left-panel p {
            font-size: 12.5px !important;
            margin: 0 auto !important;
            max-width: 340px !important;
        }
        .fcc-auth-contacts-wrap {
            display: none !important;
        }
        .fcc-auth-yellow-card {
            width: 100% !important;
            padding: 20px 0 16px !important;
            border-radius: 18px !important;
        }
        .fcc-slide-item {
            padding: 0 14px !important;
        }
    }
</style>

@php $activeTab = 'register'; @endphp

<div class="fcc-auth-page-wrap">
    
    {{-- MAIN CARD CONTAINER --}}
    <div class="fcc-auth-card-container">
        
        {{-- KIRI: CONTENT TEKS & STRUCTURED CONTACT LIST --}}
        <div class="fcc-auth-left-panel" style="flex:1.05;display:flex;flex-direction:column;justify-content:space-between;z-index:2;">
            <div>
                {{-- Top Badge --}}
                <div style="margin-bottom:16px;">
                    <a href="{{ route('landing.index') }}" style="display:inline-flex;align-items:center;gap:10px;padding:6px 16px;border-radius:100px;border:1.5px solid #FFC81A;background:rgba(255,200,26,0.1);backdrop-filter:blur(10px);color:#FFC81A;font-size:11.5px;font-weight:800;letter-spacing:0.5px;text-decoration:none;">
                        <div style="width:20px;height:20px;border-radius:50%;background:#FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        FIKOM Certification Center UMI
                    </a>
                </div>

                {{-- Headline Dynamic --}}
                <div style="position:relative;min-height:140px;" class="fcc-headline-wrapper">
                    <div id="left-login-text" class="fcc-headline-panel fcc-headline-inactive-up">
                        <h1 style="color:#FFFFFF;font-size:clamp(26px, 3.5vw, 36px);font-weight:900;line-height:1.15;margin:0 0 12px;letter-spacing:-0.8px;text-shadow:0 2px 10px rgba(0,0,0,0.5);">
                            Selamat Datang<br/>di FCC UMI 👋
                        </h1>
                        <p style="color:rgba(255,255,255,0.7);font-size:13.5px;line-height:1.6;margin:0;max-width:420px;">
                            Platform sertifikasi &amp; pelatihan profesional FIKOM Universitas Muslim Indonesia. Masuk untuk mengelola pendaftaran dan sertifikat Anda.
                        </p>
                    </div>

                    <div id="left-register-text" class="fcc-headline-panel fcc-headline-active">
                        <h1 style="color:#FFFFFF;font-size:clamp(26px, 3.5vw, 36px);font-weight:900;line-height:1.15;margin:0 0 12px;letter-spacing:-0.8px;text-shadow:0 2px 10px rgba(0,0,0,0.5);">
                            Mulai Masa Depan<br/>Digital Anda 🚀
                        </h1>
                        <p style="color:rgba(255,255,255,0.7);font-size:13.5px;line-height:1.6;margin:0;max-width:420px;">
                            Bergabunglah sebagai peserta FCC UMI. Dapatkan akses ke program pelatihan berkualitas dan sertifikat digital resmi terverifikasi.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Bottom Contact Feature List (Structured & Compact) --}}
            <div class="fcc-auth-contacts-wrap" style="display:flex;flex-direction:column;gap:8px;margin-top:16px;">
                <div class="fcc-contact-card">
                    <div class="fcc-contact-icon-bg">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div>
                        <span style="display:block;font-size:9.5px;font-weight:800;color:#FFC81A;text-transform:uppercase;letter-spacing:0.5px;">Layanan Telepon / Hotline</span>
                        <span style="font-size:12.5px;font-weight:700;color:#FFFFFF;">(0411) 455 855</span>
                    </div>
                </div>

                <div class="fcc-contact-card">
                    <div class="fcc-contact-icon-bg">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <span style="display:block;font-size:9.5px;font-weight:800;color:#FFC81A;text-transform:uppercase;letter-spacing:0.5px;">Lokasi Kampus</span>
                        <span style="font-size:12.5px;font-weight:700;color:#FFFFFF;">Makassar, Sulawesi Selatan, Indonesia</span>
                    </div>
                </div>

                <div class="fcc-contact-card">
                    <div class="fcc-contact-icon-bg">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div>
                        <span style="display:block;font-size:9.5px;font-weight:800;color:#FFC81A;text-transform:uppercase;letter-spacing:0.5px;">Email Resmi Support</span>
                        <span style="font-size:12.5px;font-weight:700;color:#FFFFFF;">fcc@fikom.umi.ac.id</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN: VIBRANT YELLOW CARD WITH SMOOTH TRANSITION & TRUST FOOTER --}}
        <div class="fcc-auth-yellow-card" style="flex:0.95;background:#FFC81A;border-radius:24px;padding:26px 0 20px;display:flex;flex-direction:column;justify-content:center;z-index:2;box-sizing:border-box;box-shadow:0 16px 40px rgba(0,0,0,0.3);overflow:hidden;position:relative;">
            
            <div id="authSliderTrack" class="fcc-gpu-track" style="{{ $activeTab === 'register' ? 'transform:translate3d(-50%,0,0);' : 'transform:translate3d(0,0,0);' }}">
                
                {{-- SLIDE 1: LOGIN FORM --}}
                <div class="fcc-slide-item">
                    <div>
                        <div style="margin-bottom:14px;display:flex;align-items:center;justify-content:space-between;">
                            <a href="{{ route('landing.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#131218;font-size:12px;font-weight:900;text-decoration:none;background:rgba(19,18,24,0.08);padding:4px 12px;border-radius:100px;transition:background 0.2s;" onmouseover="this.style.background='rgba(19,18,24,0.15)';" onmouseout="this.style.background='rgba(19,18,24,0.08)';">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                                <span>Beranda</span>
                            </a>
                        </div>
                        <div style="margin-bottom:16px;">
                            <h2 style="color:#131218;font-size:24px;font-weight:900;margin:0 0 4px;letter-spacing:-0.5px;">Masuk Akun</h2>
                            <p style="color:rgba(19,18,24,0.65);font-size:13px;margin:0;font-weight:600;">
                                Belum punya akun?
                                <a href="javascript:void(0)" onclick="switchAuthSlide('register')" style="color:#131218;font-weight:900;text-decoration:underline;">Daftar gratis</a>
                            </p>
                        </div>

                        @if($errors->any() && session('form_type') !== 'register')
                        <div style="background:rgba(239,68,68,0.15);border:1.5px solid rgba(239,68,68,0.4);border-radius:12px;padding:8px 12px;margin-bottom:12px;color:#991B1B;font-size:12px;font-weight:700;line-height:1.4;">
                            {{ $errors->first() }}
                        </div>
                        @endif

                        <form action="{{ route('auth.login.post') }}" method="POST">
                            @csrf
                            {{-- Email --}}
                            <div style="margin-bottom:12px;">
                                <label style="display:block;font-size:10.5px;font-weight:800;color:rgba(19,18,24,0.75);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px;">
                                    Email Anda
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com" class="fcc-yellow-input">
                            </div>

                            {{-- Password dengan Icon Mata --}}
                            <div style="margin-bottom:10px;">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                                    <label style="font-size:10.5px;font-weight:800;color:rgba(19,18,24,0.75);text-transform:uppercase;letter-spacing:0.5px;">
                                        Password Anda
                                    </label>
                                    <a href="{{ route('auth.forgot') }}" style="font-size:11.5px;color:#131218;font-weight:800;text-decoration:none;">
                                        Lupa password?
                                    </a>
                                </div>
                                <div style="position:relative;">
                                    <input type="password" name="password" id="login-pw-inp" required placeholder="Masukkan password" class="fcc-yellow-input" style="padding-right:42px;">
                                    <button type="button" onclick="togglePasswordVisibility('login-pw-inp', 'login-eye-svg')" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:#131218;cursor:pointer;display:flex;align-items:center;justify-content:center;padding:4px;opacity:0.75;transition:opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.75'" title="Lihat password">
                                        <svg id="login-eye-svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Remember Me --}}
                            <div style="margin-bottom:14px;">
                                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:12px;color:#131218;font-weight:700;user-select:none;">
                                    <input type="checkbox" name="remember" style="accent-color:#131218;width:14px;height:14px;cursor:pointer;">
                                    Ingat Saya
                                </label>
                            </div>

                            {{-- Dark Pill Submit Button --}}
                            <button type="submit" class="fcc-dark-pill-btn" style="width:100%;justify-content:center;">
                                <span style="width:26px;height:26px;border-radius:50%;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </span>
                                Masuk Sekarang
                            </button>
                        </form>

                        {{-- DIVIDER ATAS DENGAN GOOGLE --}}
                        <div style="display:flex;align-items:center;margin:12px 0 10px;gap:12px;">
                            <div style="flex:1;height:1px;background:rgba(19,18,24,0.15);"></div>
                            <span style="font-size:10.5px;font-weight:800;color:rgba(19,18,24,0.6);text-transform:uppercase;letter-spacing:0.5px;">Atau masuk dengan</span>
                            <div style="flex:1;height:1px;background:rgba(19,18,24,0.15);"></div>
                        </div>

                        {{-- GOOGLE LOGIN BUTTON --}}
                        <a href="{{ route('auth.google') }}" style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:9.5px 16px;background:#FFFFFF;border:1.5px solid rgba(19,18,24,0.12);border-radius:100px;color:#131218;font-size:13px;font-weight:800;text-decoration:none;box-shadow:0 4px 14px rgba(0,0,0,0.06);transition:all 0.2s ease;box-sizing:border-box;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 14px rgba(0,0,0,0.06)'">
                            <svg width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.24v3.15C3.26 21.39 7.37 24 12 24z"/>
                                <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.24C.45 8.16 0 9.99 0 12s.45 3.84 1.24 5.42l4.04-3.15z"/>
                                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.37 0 3.26 2.61 1.24 6.58l4.04 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                            </svg>
                            Lanjutkan dengan Google
                        </a>
                    </div>

                    {{-- BOTTOM TRUST FOOTER --}}
                    <div style="margin-top:14px;padding-top:10px;border-top:1px dashed rgba(19,18,24,0.18);display:flex;align-items:center;justify-content:center;gap:6px;color:rgba(19,18,24,0.7);font-size:11px;font-weight:800;text-align:center;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>Keamanan Terenkripsi &amp; Terverifikasi UMI</span>
                    </div>
                </div>

                {{-- SLIDE 2: REGISTER FORM --}}
                <div class="fcc-slide-item">
                    <div>
                        <div style="margin-bottom:10px;display:flex;align-items:center;justify-content:space-between;">
                            <a href="{{ route('landing.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#131218;font-size:12px;font-weight:900;text-decoration:none;background:rgba(19,18,24,0.08);padding:4px 12px;border-radius:100px;transition:background 0.2s;" onmouseover="this.style.background='rgba(19,18,24,0.15)';" onmouseout="this.style.background='rgba(19,18,24,0.08)';">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                                <span>Beranda</span>
                            </a>
                        </div>
                        <div style="margin-bottom:10px;">
                            <h2 style="color:#131218;font-size:22px;font-weight:900;margin:0 0 3px;letter-spacing:-0.5px;">Buat Akun Peserta</h2>
                            <p style="color:rgba(19,18,24,0.65);font-size:12.5px;margin:0;font-weight:600;">
                                Sudah punya akun?
                                <a href="javascript:void(0)" onclick="switchAuthSlide('login')" style="color:#131218;font-weight:900;text-decoration:underline;">Masuk di sini</a>
                            </p>
                        </div>

                        <div id="registerErrorAlert" style="{{ $errors->any() && session('form_type') === 'register' ? 'display:block;' : 'display:none;' }}background:rgba(239,68,68,0.15);border:1.5px solid rgba(239,68,68,0.4);border-radius:12px;padding:6px 10px;margin-bottom:8px;color:#991B1B;font-size:11.5px;font-weight:700;line-height:1.35;">
                            @if($errors->any() && session('form_type') === 'register')
                            <ul style="margin:0;padding:0 0 0 14px;">
                                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                            </ul>
                            @endif
                        </div>

                        <form id="registerForm" action="{{ route('auth.register.post') }}" method="POST" onsubmit="handleRegisterFormSubmit(event)">
                            @csrf
                            
                            {{-- Nama --}}
                            <div style="margin-bottom:6px;">
                                <label style="display:block;font-size:10px;font-weight:800;color:rgba(19,18,24,0.75);margin-bottom:2px;text-transform:uppercase;letter-spacing:0.5px;">
                                    Nama Lengkap <span style="color:#B91C1C;">*</span>
                                </label>
                                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Nama lengkap Anda" class="fcc-yellow-input" style="padding:7px 11px;">
                            </div>

                            {{-- Email --}}
                            <div style="margin-bottom:6px;">
                                <label style="display:block;font-size:10px;font-weight:800;color:rgba(19,18,24,0.75);margin-bottom:2px;text-transform:uppercase;letter-spacing:0.5px;">
                                    Email <span style="color:#B91C1C;">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com" class="fcc-yellow-input" style="padding:7px 11px;">
                            </div>

                            {{-- No. WhatsApp --}}
                            <div style="margin-bottom:6px;">
                                <label style="display:block;font-size:10px;font-weight:800;color:rgba(19,18,24,0.75);margin-bottom:2px;text-transform:uppercase;letter-spacing:0.5px;">
                                    No. WhatsApp <span style="color:#B91C1C;">*</span>
                                </label>
                                <input type="tel" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx" class="fcc-yellow-input" style="padding:7px 11px;">
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div style="margin-bottom:6px;">
                                <label style="display:block;font-size:10px;font-weight:800;color:rgba(19,18,24,0.75);margin-bottom:2px;text-transform:uppercase;letter-spacing:0.5px;">
                                    Jenis Kelamin <span style="color:#B91C1C;">*</span>
                                </label>
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;">
                                    @foreach(['L'=>'Laki-laki','P'=>'Perempuan'] as $v=>$l)
                                    <label class="fcc-gender-label" style="cursor:pointer;position:relative;">
                                        <input type="radio" name="kelamin" value="{{ $v }}" required style="position:absolute;opacity:0;">
                                        <div class="fcc-gender-box" style="padding:5px;text-align:center;border-radius:8px;background:rgba(255,255,255,0.45);border:1.5px solid rgba(19,18,24,0.08);color:#131218;font-size:11px;font-weight:800;transition:all 0.2s;box-sizing:border-box;">
                                            {{ $l }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Password Grid dengan Icon Mata --}}
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;margin-bottom:6px;">
                                <div>
                                    <label style="display:block;font-size:10px;font-weight:800;color:rgba(19,18,24,0.75);margin-bottom:2px;text-transform:uppercase;letter-spacing:0.5px;">
                                        Password <span style="color:#B91C1C;">*</span>
                                    </label>
                                    <div style="position:relative;">
                                        <input type="password" name="password" id="reg-pw-inp" required placeholder="Min. 8 karakter" class="fcc-yellow-input" style="padding:7px 11px;padding-right:34px;">
                                        <button type="button" onclick="togglePasswordVisibility('reg-pw-inp', 'reg-eye-svg')" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:#131218;cursor:pointer;display:flex;align-items:center;justify-content:center;padding:2px;opacity:0.75;transition:opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.75'" title="Lihat password">
                                            <svg id="reg-eye-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label style="display:block;font-size:10px;font-weight:800;color:rgba(19,18,24,0.75);margin-bottom:2px;text-transform:uppercase;letter-spacing:0.5px;">
                                        Ulangi Password <span style="color:#B91C1C;">*</span>
                                    </label>
                                    <div style="position:relative;">
                                        <input type="password" name="password_confirmation" id="reg-pw-confirm-inp" required placeholder="Ulangi" class="fcc-yellow-input" style="padding:7px 11px;padding-right:34px;">
                                        <button type="button" onclick="togglePasswordVisibility('reg-pw-confirm-inp', 'reg-confirm-eye-svg')" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:#131218;cursor:pointer;display:flex;align-items:center;justify-content:center;padding:2px;opacity:0.75;transition:opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.75'" title="Lihat password">
                                            <svg id="reg-confirm-eye-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Checkbox Persetujuan --}}
                            <div style="margin-bottom:8px;">
                                <label style="display:flex;align-items:flex-start;gap:6px;cursor:pointer;font-size:10.5px;color:#131218;font-weight:700;line-height:1.3;user-select:none;">
                                    <input type="checkbox" name="agree" required style="accent-color:#131218;width:13px;height:13px;flex-shrink:0;margin-top:1px;cursor:pointer;">
                                    <span>
                                        Saya menyetujui <a href="javascript:void(0)" onclick="openTnCModal()" style="color:#131218;font-weight:900;text-decoration:underline;">syarat &amp; ketentuan</a> FCC UMI.
                                    </span>
                                </label>
                            </div>

                            {{-- Dark Pill Submit Button --}}
                            <button id="btnSubmit" type="submit" class="fcc-dark-pill-btn" style="width:100%;justify-content:center;padding:9px 18px;">
                                <span style="width:24px;height:24px;border-radius:50%;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </span>
                                Daftar Akun Sekarang
                            </button>
                        </form>

                        {{-- DIVIDER DENGAN GOOGLE ON REGISTER --}}
                        <div style="display:flex;align-items:center;margin:8px 0 6px;gap:12px;">
                            <div style="flex:1;height:1px;background:rgba(19,18,24,0.15);"></div>
                            <span style="font-size:10px;font-weight:800;color:rgba(19,18,24,0.6);text-transform:uppercase;letter-spacing:0.5px;">Atau daftar dengan</span>
                            <div style="flex:1;height:1px;background:rgba(19,18,24,0.15);"></div>
                        </div>

                        {{-- GOOGLE REGISTER BUTTON --}}
                        <a href="{{ route('auth.google') }}" style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:8px 16px;background:#FFFFFF;border:1.5px solid rgba(19,18,24,0.12);border-radius:100px;color:#131218;font-size:12px;font-weight:800;text-decoration:none;box-shadow:0 4px 14px rgba(0,0,0,0.06);transition:all 0.2s ease;box-sizing:border-box;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 14px rgba(0,0,0,0.06)'">
                            <svg width="15" height="15" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.24v3.15C3.26 21.39 7.37 24 12 24z"/>
                                <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.24C.45 8.16 0 9.99 0 12s.45 3.84 1.24 5.42l4.04-3.15z"/>
                                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.37 0 3.26 2.61 1.24 6.58l4.04 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                            </svg>
                            Daftar dengan Google
                        </a>
                    </div>

                    {{-- BOTTOM TRUST FOOTER --}}
                    <div style="margin-top:10px;padding-top:8px;border-top:1px dashed rgba(19,18,24,0.18);display:flex;align-items:center;justify-content:center;gap:6px;color:rgba(19,18,24,0.7);font-size:10.5px;font-weight:800;text-align:center;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>Keamanan Terenkripsi &amp; Terverifikasi UMI</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

{{-- MODAL OTP DEDICATED PAGE --}}
<div id="otpModal" style="display:none;position:fixed;inset:0;background:rgba(14,13,20,0.88);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);z-index:99999;align-items:center;justify-content:center;padding:20px;">
    <div style="background:#131218;width:100%;max-width:420px;border-radius:24px;padding:40px;box-shadow:0 24px 64px rgba(0,0,0,0.7);border:1.5px solid rgba(255,200,26,0.25);text-align:center;position:relative;">
        <div style="width:68px;height:68px;border-radius:20px;background:rgba(255,200,26,0.12);border:1.5px solid rgba(255,200,26,0.3);display:flex;align-items:center;justify-content:center;margin:0 auto 22px;">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <h3 style="color:#FFFFFF;font-size:22px;font-weight:900;margin:0 0 10px;letter-spacing:-0.5px;">Verifikasi Email</h3>
        <p style="color:rgba(255,255,255,0.6);font-size:13.5px;line-height:1.6;margin:0 0 26px;">
            Kami telah mengirimkan 4 digit kode OTP ke <br>
            <strong id="otpEmailDisplay" style="color:#FFC81A;font-weight:800;"></strong>
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
            <div id="otpError" style="color:#EF4444;font-size:13px;margin-bottom:18px;display:none;font-weight:700;"></div>
            
            <button id="btnVerify" type="submit" class="fcc-dark-pill-btn" style="width:100%;justify-content:center;background:#FFC81A;color:#131218;">
                Verifikasi &amp; Masuk
            </button>
        </form>
    </div>
</div>

{{-- MODAL TERMS & CONDITIONS --}}
<div id="tncModal" style="display:none;position:fixed;inset:0;background:rgba(14,13,20,0.85);backdrop-filter:blur(8px);z-index:99999;align-items:center;justify-content:center;padding:20px;">
    <div style="background:#131218;width:100%;max-width:540px;border-radius:24px;padding:36px;box-shadow:0 24px 64px rgba(0,0,0,0.7);border:1.5px solid rgba(255,200,26,0.2);position:relative;">
        <button type="button" onclick="closeTnCModal()" style="position:absolute;top:20px;right:20px;background:none;border:none;color:rgba(255,255,255,0.4);cursor:pointer;padding:6px;border-radius:50%;display:flex;align-items:center;justify-content:center;" onmouseover="this.style.color='#FFF';this.style.background='rgba(255,255,255,0.08)'" onmouseout="this.style.color='rgba(255,255,255,0.4)';this.style.background='none'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <h3 style="color:#FFFFFF;font-size:20px;font-weight:900;margin:0 0 16px;">Syarat &amp; Ketentuan Peserta</h3>
        <div style="max-height:300px;overflow-y:auto;color:rgba(255,255,255,0.7);font-size:13.5px;line-height:1.7;padding-right:10px;margin-bottom:24px;">
            <p style="margin:0 0 12px;">1. Pendaftaran akun wajib menggunakan data identitas dan email aktif yang valid.</p>
            <p style="margin:0 0 12px;">2. Kode OTP verifikasi akan dikirimkan ke email terdaftar untuk aktivasi akun.</p>
            <p style="margin:0 0 12px;">3. Peserta wajib menjaga kerahasiaan password akun masing-masing.</p>
            <p style="margin:0;">4. Penggunaan akun sepenuhnya merupakan tanggung jawab pemilik akun terdaftar di FCC UMI.</p>
        </div>
        <button type="button" onclick="closeTnCModal()" class="fcc-dark-pill-btn" style="background:#FFC81A;color:#131218;">
            Saya Mengerti
        </button>
    </div>
</div>

<script>
window.togglePasswordVisibility = function(inputId, eyeIconId) {
    const input = document.getElementById(inputId);
    const eyeSvg = document.getElementById(eyeIconId);
    if (!input || !eyeSvg) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeSvg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        eyeSvg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
};

window.switchAuthSlide = function(target) {
    const track = document.getElementById('authSliderTrack');
    const headLogin = document.getElementById('left-login-text');
    const headReg = document.getElementById('left-register-text');

    if (target === 'register') {
        if (track) track.style.transform = 'translate3d(-50%, 0, 0)';
        if (headLogin) headLogin.className = 'fcc-headline-panel fcc-headline-inactive-up';
        if (headReg) headReg.className = 'fcc-headline-panel fcc-headline-active';
        window.history.pushState(null, '', '/daftar');
        document.title = 'Daftar Akun — FIKOM Certification Center';
    } else {
        if (track) track.style.transform = 'translate3d(0, 0, 0)';
        if (headReg) headReg.className = 'fcc-headline-panel fcc-headline-inactive-down';
        if (headLogin) headLogin.className = 'fcc-headline-panel fcc-headline-active';
        window.history.pushState(null, '', '/masuk');
        document.title = 'Masuk — FIKOM Certification Center';
    }
};

window.onpopstate = function() {
    if (window.location.pathname.includes('daftar')) {
        switchAuthSlide('register');
    } else {
        switchAuthSlide('login');
    }
};

function openTnCModal() { document.getElementById('tncModal').style.display = 'flex'; }
function closeTnCModal() { document.getElementById('tncModal').style.display = 'none'; }

window.handleRegisterFormSubmit = async function(e) {
    if (e) e.preventDefault();
    const form = document.getElementById('registerForm');
    if (!form) return;
    const btn = document.getElementById('btnSubmit');
    const oriText = btn ? btn.innerHTML : '';
    if (btn) {
        btn.innerHTML = '<span style="display:flex;align-items:center;gap:8px;">Memproses...</span>';
        btn.disabled = true;
    }

    try {
        const formData = new FormData(form);
        const res = await fetch(form.action, {
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
        } catch(jsonErr) {}

        const errorContainer = document.getElementById('registerErrorAlert');
        if (errorContainer) errorContainer.style.display = 'none';

        if (data.require_otp) {
            document.getElementById('otpEmailDisplay').innerText = data.email;
            document.getElementById('otpEmailInput').value = data.email;
            document.getElementById('otpModal').style.display = 'flex';
            const firstBox = document.querySelector('.otp-box');
            if (firstBox) firstBox.focus();
        } else if (data.errors) {
            const msg = Object.values(data.errors).flat().join('<br>');
            if (errorContainer) {
                errorContainer.innerHTML = msg;
                errorContainer.style.display = 'block';
            } else {
                alert(Object.values(data.errors).flat().join('\n'));
            }
        } else if (data.message) {
            if (errorContainer) {
                errorContainer.innerHTML = data.message;
                errorContainer.style.display = 'block';
            } else {
                alert(data.message);
            }
        } else {
            alert('Gagal memproses pendaftaran. Silakan periksa kembali data Anda.');
        }
    } catch (err) {
        alert('Terjadi kesalahan koneksi/sistem: ' + (err.message || err));
    } finally {
        if (btn) {
            btn.innerHTML = oriText;
            btn.disabled = false;
        }
    }
};

(function initRegisterPage() {
    const otpBoxes = document.querySelectorAll('.otp-box');
    otpBoxes.forEach((box, i) => {
        if (!box.dataset.initialized) {
            box.dataset.initialized = 'true';
            box.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value && i < otpBoxes.length - 1) otpBoxes[i + 1].focus();
            });
            box.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && i > 0) {
                    otpBoxes[i - 1].focus();
                }
            });
        }
    });

    const otpForm = document.getElementById('otpForm');
    if (otpForm && !otpForm.dataset.initialized) {
        otpForm.dataset.initialized = 'true';
        otpForm.addEventListener('submit', async function(e) {
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
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                const data = await res.json();
                
                if (data.success) {
                    window.location.href = data.redirect || '/peserta/dashboard';
                } else if (data.errors) {
                    document.getElementById('otpError').innerText = data.errors.otp ? data.errors.otp[0] : 'Kode tidak valid.';
                    document.getElementById('otpError').style.display = 'block';
                    otpBoxes.forEach(b => b.value = '');
                    if (otpBoxes[0]) otpBoxes[0].focus();
                }
            } catch (err) {
                document.getElementById('otpError').innerText = 'Terjadi kesalahan jaringan.';
                document.getElementById('otpError').style.display = 'block';
            } finally {
                btn.innerHTML = oriText;
                btn.disabled = false;
            }
        });
    }
})();

@if(session('require_otp'))
document.addEventListener('DOMContentLoaded', function() {
    const email = "{{ session('email') }}";
    if (email) {
        document.getElementById('otpEmailDisplay').innerText = email;
        document.getElementById('otpEmailInput').value = email;
        document.getElementById('otpModal').style.display = 'flex';
        const firstBox = document.querySelector('.otp-box');
        if (firstBox) firstBox.focus();
    }
});
@endif
</script>
@endsection
