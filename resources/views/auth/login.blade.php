@extends('layouts.app')
@section('title','Masuk')
@section('content')
<div style="display:flex;min-height:100vh;font-family:'Inter',sans-serif;">
    {{-- KIRI: #131218 + #FFC81A — brand statement (bagian ini sengaja gelap) --}}
    <div style="flex:1;background:#131218;position:relative;overflow:hidden;
        display:flex;flex-direction:column;justify-content:center;align-items:center;
        padding:60px 48px;">
        {{-- Ornamen --}}
        <div style="position:absolute;inset:0;opacity:.04;
            background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),
                             linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);
            background-size:60px 60px;"></div>
        <div style="position:absolute;top:8%;right:6%;width:270px;height:270px;animation:spin 22s linear infinite;">
            <svg width="270" height="270" viewBox="0 0 270 270">
                <circle cx="135" cy="135" r="125" fill="none" stroke="rgba(255,200,26,.1)" stroke-width="1" stroke-dasharray="8 7"/>
                <circle cx="135" cy="135" r="95" fill="none" stroke="rgba(255,200,26,.07)" stroke-width="1" stroke-dasharray="4 11"/>
            </svg>
        </div>
        <div class="hex" style="position:absolute;top:17%;right:13%;width:42px;height:42px;
            background:rgba(255,200,26,.18);animation:float1 6s ease-in-out infinite;"></div>
        <div class="dia" style="position:absolute;top:38%;right:2%;width:18px;height:18px;
            background:rgba(255,200,26,.22);animation:float3 5s ease-in-out infinite .7s;"></div>
        <div class="dia" style="position:absolute;top:65%;right:10%;width:14px;height:14px;
            background:rgba(255,200,26,.18);animation:float2 7s ease-in-out infinite 1.5s;"></div>
        {{-- Dot grid --}}
        <div style="position:absolute;bottom:7%;left:4%;opacity:.3;">
            <svg width="96" height="96" viewBox="0 0 96 96">
                @for($x=0;$x<5;$x++) @for($y=0;$y<5;$y++)
                <circle cx="{{ $x*22+6 }}" cy="{{ $y*22+6 }}" r="1.8" fill="#FFC81A"/>
                @endfor @endfor
            </svg>
        </div>

        {{-- Content --}}
        <div style="position:relative;z-index:2;text-align:center;max-width:360px;width:100%;">
            {{-- Logo --}}
            <a href="{{ route('landing.index') }}" style="display:inline-flex;align-items:center;gap:12px;margin-bottom:42px;text-decoration:none;">
                <img src="{{ asset('images/logo.png') }}" alt="Logo FCC UMI" style="height:48px;width:auto;object-fit:contain;flex-shrink:0;">
                <div style="text-align:left;">
                    <p style="margin:0;color:#FFF;font-weight:900;font-size:18px;">FIKOM Certification</p>
                    <p style="margin:0;color:#FFC81A;font-size:9px;letter-spacing:3px;text-transform:uppercase;">Center &middot; UMI</p>
                </div>
            </a>

            <h2 style="color:#FFF;font-size:27px;font-weight:900;margin:0 0 12px;line-height:1.2;">
                Selamat Datang<br/>Kembali &#128075;
            </h2>
            <p style="color:rgba(255,255,255,.5);font-size:15px;line-height:1.75;margin:0 0 40px;">
                Platform sertifikasi &amp; pelatihan profesional FIKOM Universitas Muslim Indonesia
            </p>

            {{-- Stats grid --}}
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
                @foreach([['18+','Program'],['342+','Peserta'],['12','Mitra']] as [$n,$l])
                <div style="background:rgba(255,200,26,.08);border:1px solid rgba(255,200,26,.2);
                    border-radius:12px;padding:14px 8px;">
                    <p style="margin:0;color:#FFC81A;font-size:22px;font-weight:900;">{{ $n }}</p>
                    <p style="margin:3px 0 0;color:rgba(255,255,255,.45);font-size:11px;">{{ $l }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div style="width:460px;min-width:460px;background:#0e0d14;display:flex;flex-direction:column;
        justify-content:center;padding:60px 48px;position:relative;border-left:1px solid rgba(255,255,255,.05);">
        {{-- Back link --}}
        <a href="{{ route('landing.index') }}"
           style="position:absolute;top:24px;left:24px;display:flex;align-items:center;gap:6px;
                  color:rgba(255,255,255,.5);font-size:13px;text-decoration:none;font-weight:500;transition:color .18s;"
           onmouseover="this.style.color='#FFF'" onmouseout="this.style.color='rgba(255,255,255,.5)'">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Beranda
        </a>

        <div style="max-width:340px;margin:0 auto;width:100%;">
            {{-- Heading --}}
            <div style="margin-bottom:30px;">
                <h1 style="color:#FFF;font-size:28px;font-weight:900;margin:0 0 8px;">Masuk</h1>
                <p style="color:rgba(255,255,255,.5);font-size:14px;margin:0;">
                    Belum punya akun?
                    <a href="{{ route('auth.register') }}" style="color:#FFC81A;font-weight:700;text-decoration:none;">Daftar gratis</a>
                </p>
            </div>

            {{-- Error --}}
            @if($errors->any())
            <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);
                border-radius:10px;padding:12px 14px;margin-bottom:20px;color:#EF4444;font-size:13px;font-weight:600;">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('auth.login.post') }}" method="POST">
                @csrf
                {{-- Email --}}
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                        Email <span style="color:#FFC81A;">*</span>
                    </label>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;"
                             width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="email@example.com" class="fcc-input-dark" style="padding-left:42px;width:100%;box-sizing:border-box;"
                               onkeydown="if(event.key==='Enter')event.preventDefault();">
                    </div>
                </div>

                {{-- Password --}}
                <div style="margin-bottom:8px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                        Password <span style="color:#FFC81A;">*</span>
                    </label>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;"
                             width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" name="password" id="pw-inp" required
                               placeholder="Password" class="fcc-input-dark" style="padding-left:42px;padding-right:42px;width:100%;box-sizing:border-box;"
                               onkeydown="if(event.key==='Enter')event.preventDefault();">
                        <button type="button" onclick="togglePw()"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);
                                       background:none;border:none;color:rgba(255,255,255,.4);cursor:pointer;display:flex;padding:0;">
                            <svg id="eye-svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember + Forgot --}}
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:rgba(255,255,255,.6);">
                        <input type="checkbox" name="remember" style="accent-color:#FFC81A;width:14px;height:14px;">
                        Ingat saya
                    </label>
                    <a href="{{ route('auth.forgot') }}" style="font-size:13px;color:#FFC81A;font-weight:700;text-decoration:none;">
                        Lupa password?
                    </a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="fcc-btn-gold btn-shine" style="width:100%;justify-content:center;padding:13px;font-size:15px;border-radius:12px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Masuk ke Akun
                </button>
            </form>

            {{-- Info --}}
            <div style="margin-top:22px;padding:14px 16px;background:rgba(255,255,255,.04);border-radius:10px;border:1px solid rgba(255,255,255,.08);">
                <p style="margin:0;font-size:12px;color:rgba(255,255,255,.5);text-align:center;line-height:1.7;">
                    Akses role (Admin/Peserta) ditentukan otomatis oleh sistem berdasarkan akun yang terdaftar.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@vite('resources/js/pages/auth-login.js')
@endpush
