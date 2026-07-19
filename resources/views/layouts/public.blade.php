@extends('layouts.app')
@section('content')

{{-- ═══ NAVBAR ══════════════════════════════════════════════════ --}}
<nav id="fcc-nav" style="position:fixed;top:0;left:0;right:0;z-index:500;height:64px;display:flex;align-items:center;padding:0 24px;gap:16px;background:#131218;box-shadow:0 1px 0 rgba(255,200,26,.15);">
    <div style="max-width:1200px;margin:0 auto;width:100%;padding:0 24px;
        display:flex;align-items:center;gap:24px;">

        {{-- Logo --}}
        <a href="{{ route('landing.index') }}" id="nav-logo" style="display:flex;align-items:center;gap:10px;text-decoration:none;flex-shrink:0;">
            <div style="width:36px;height:36px;border-radius:10px;
                background:linear-gradient(135deg,#FFC81A,#FFD84D);
                display:flex;align-items:center;justify-content:center;
                box-shadow:0 0 12px rgba(255,200,26,.3);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="#131218" stroke-width="2.5" stroke-linecap="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div>
                <p id="nav-brand" style="margin:0;font-weight:900;font-size:12.5px;color:#FFF;transition:color .3s;">FIKOM Certification</p>
                <p style="margin:0;color:#FFC81A;font-size:8px;letter-spacing:2.5px;text-transform:uppercase;">Center · UMI</p>
            </div>
        </a>

        {{-- Nav links --}}
        <div style="display:flex;align-items:center;gap:2px;flex:1;">
            @php
            $navLinks = [
                ['landing.index',    'Home'],
                ['landing.profil',   'Profil'],
                ['landing.kegiatan', 'Kegiatan'],
                ['landing.pendaftaran','Pendaftaran'],
                ['landing.arsip',    'Arsip'],
                ['landing.kontak',   'Hubungi Kami'],
            ];
            @endphp
            @foreach($navLinks as [$route,$label])
            @php $isActive = request()->routeIs($route); @endphp
            <a href="{{ route($route) }}"
               class="nav-lnk {{ $isActive?'nav-active':'' }}"
               style="padding:8px 10px;border-radius:8px;text-decoration:none;font-size:13.5px;
                      font-weight:{{ $isActive?700:500 }};transition:color .2s;">
                {{ $label }}
            </a>
            @endforeach
        </div>


        {{-- Search box --}}
        <div style="position:relative;flex:1;max-width:280px;display:none;" id="nav-search-box">
          <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);pointer-events:none;" id="nav-search-icon"
               width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.5)" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
          <input type="text" id="nav-search-inp" placeholder="Cari kegiatan..." autocomplete="off"
                 style="width:100%;background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.2);
                        border-radius:9px;padding:7px 12px 7px 32px;color:#FFF;font-size:13px;outline:none;font-family:inherit;"
                 onfocus="this.style.borderColor='#FFC81A'"
                 onblur="setTimeout(()=>document.getElementById('nav-dropdown').innerHTML='',300)"
                 onkeydown="if(event.key==='Enter')window.location='/api/search?q='+encodeURIComponent(this.value)">
          <div id="nav-dropdown" style="display:none;position:absolute;top:calc(100% + 6px);left:0;right:0;background:#FFF;border-radius:12px;box-shadow:0 12px 36px rgba(0,0,0,.15);z-index:999;overflow:hidden;max-height:300px;overflow-y:auto;"></div>
        </div>

        {{-- CTA right --}}
        <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
            @auth('peserta')
            <a href="{{ route('peserta.dashboard') }}" class="fcc-btn-gold" style="padding:8px 18px;font-size:13px;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Portal Saya
            </a>
            @elseauth('admin')
            <a href="{{ route('admin.dashboard') }}" class="fcc-btn-gold" style="padding:8px 18px;font-size:13px;">Admin Panel</a>
            @else
            {{-- Navbar pojok kanan: hanya tombol Masuk --}}
            <a href="{{ route('auth.login') }}" class="fcc-btn-gold"
               style="padding:8px 20px;font-size:13px;font-weight:700;text-decoration:none;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="display:inline;margin-right:5px;vertical-align:middle;">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Masuk
            </a>
            @endauth
        </div>
    </div>
</nav>

{{-- Page Content --}}
@yield('page-content')

{{-- ═══ FOOTER ════════════════════════════════════════════════════ --}}
<footer style="background:#131218;border-top:1px solid rgba(255,200,26,.14);padding:52px 24px 28px;">
    <div style="max-width:1100px;margin:0 auto;">
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:44px;margin-bottom:36px;">
            {{-- Brand --}}
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                    <div style="width:38px;height:38px;border-radius:11px;
                        background:linear-gradient(135deg,#FFC81A,#FFD84D);
                        display:flex;align-items:center;justify-content:center;">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none"
                             stroke="#131218" stroke-width="2.5" stroke-linecap="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div>
                        <p style="margin:0;color:#FFF;font-weight:900;font-size:13px;">FIKOM Certification Center</p>
                        <p style="margin:0;color:#FFC81A;font-size:8px;letter-spacing:2px;">UNIVERSITAS MUSLIM INDONESIA</p>
                    </div>
                </div>
                <p style="color:rgba(255,255,255,.38);font-size:13px;line-height:1.8;max-width:285px;margin:0 0 20px;">
                    Platform resmi sertifikasi dan pelatihan FIKOM UMI Makassar untuk meningkatkan kompetensi SDM digital.
                </p>
                {{-- Social --}}
                <div style="display:flex;gap:10px;">
                    @foreach(['M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z',
                                'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z',
                                'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814z'] as $path)
                    <div style="width:34px;height:34px;border-radius:9px;background:rgba(255,255,255,.06);
                        border:1px solid rgba(255,200,26,.14);display:flex;align-items:center;
                        justify-content:center;cursor:pointer;transition:all .2s;"
                         onmouseover="this.style.background='rgba(255,200,26,.14)';this.style.borderColor='rgba(255,200,26,.35)';"
                         onmouseout="this.style.background='rgba(255,255,255,.06)';this.style.borderColor='rgba(255,200,26,.14)';">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="rgba(255,255,255,.5)">
                            <path d="{{ $path }}"/>
                        </svg>
                    </div>
                    @endforeach
                </div>
            </div>
            {{-- Nav col --}}
            @foreach([
                ['Navigasi', [['Home','landing.index'],['Kegiatan','landing.kegiatan'],['Profil','landing.profil'],['Arsip','landing.arsip']]],
                ['Layanan',  [['Pelatihan','landing.kegiatan'],['Sertifikasi','landing.kegiatan'],['Tata Cara Daftar','landing.pendaftaran'],['Hubungi Kami','landing.kontak']]],
            ] as [$title,$links])
            <div>
                <p style="color:#FFF;font-weight:800;font-size:12px;margin:0 0 14px;text-transform:uppercase;letter-spacing:1px;">{{ $title }}</p>
                @foreach($links as [$l,$r])
                <a href="{{ route($r) }}"
                   style="display:block;color:rgba(255,255,255,.4);font-size:13px;text-decoration:none;margin-bottom:9px;transition:color .18s;"
                   onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='rgba(255,255,255,.4)'">
                    {{ $l }}
                </a>
                @endforeach
            </div>
            @endforeach
        </div>
        <div style="border-top:1px solid rgba(255,255,255,.06);padding-top:20px;
            display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
            <p style="color:rgba(255,255,255,.24);font-size:12px;margin:0;">
                &copy; {{ date('Y') }} FIKOM Certification Center &middot; Universitas Muslim Indonesia
            </p>
            <div style="display:flex;gap:18px;">
                @foreach(['Kebijakan Privasi','Syarat & Ketentuan'] as $l)
                <span style="color:rgba(255,255,255,.24);font-size:12px;cursor:pointer;transition:color .18s;"
                      onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='rgba(255,255,255,.24)'">
                    {{ $l }}
                </span>
                @endforeach
            </div>
        </div>
    </div>
</footer>
{{-- ═══ MODAL LOGIN & REGISTER ════════════════════════════════════ --}}
<div id="fcc-auth-modal" style="position:fixed;inset:0;background:rgba(14,13,20,0.8);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);z-index:9999;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:all 0.3s cubic-bezier(0.16,1,0.3,1);">
    <div id="fcc-auth-dialog" style="width:100%;max-width:440px;background:#131218;border:1.5px solid rgba(255,200,26,.15);border-radius:20px;padding:36px;box-sizing:border-box;position:relative;transform:scale(0.92);transition:all 0.3s cubic-bezier(0.34,1.56,0.64,1);box-shadow:0 24px 64px rgba(0,0,0,.6), 0 0 40px rgba(255,200,26,.03);">
        {{-- Close Button --}}
        <button id="fcc-auth-close" onclick="closeAuthModal()" style="position:absolute;top:20px;right:20px;background:none;border:none;color:rgba(255,255,255,.4);cursor:pointer;padding:6px;transition:color .2s;border-radius:50%;display:flex;align-items:center;justify-content:center;" onmouseover="this.style.color='#FFF';this.style.background='rgba(255,255,255,.05)'" onmouseout="this.style.color='rgba(255,255,255,.4)';this.style.background='none'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>

        {{-- Brand --}}
        <div style="text-align:center;margin-bottom:28px;">
            <div style="width:46px;height:46px;border-radius:12px;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;box-shadow:0 0 16px rgba(255,200,26,.35);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <h3 style="color:#FFF;font-size:15px;font-weight:900;margin:0;letter-spacing:0.5px;">FIKOM Certification Center</h3>
            <p style="color:#FFC81A;font-size:8.5px;letter-spacing:2.5px;text-transform:uppercase;margin:3px 0 0;">Universitas Muslim Indonesia</p>
        </div>

        {{-- Alert Container --}}
        <div id="fcc-auth-alert" style="display:none;padding:12px 14px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);border-radius:10px;color:#EF4444;font-size:13px;font-weight:600;margin-bottom:20px;line-height:1.45;"></div>

        {{-- FORM LOGIN --}}
        <div id="fcc-login-container">
            <h2 style="color:#FFF;font-size:22px;font-weight:900;margin:0 0 6px;">Masuk</h2>
            <p style="color:rgba(255,255,255,.5);font-size:13.5px;margin:0 0 24px;">Belum punya akun? <a href="javascript:void(0)" onclick="switchAuthTab('register')" style="color:#FFC81A;font-weight:700;text-decoration:none;">Daftar gratis</a></p>

            <form id="fcc-login-form" onsubmit="submitAuthForm(event, '/masuk')">
                @csrf
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Email *</label>
                    <div style="position:relative;">
                        @include('components.icon',['name'=>'mail','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                        <input type="email" name="email" required placeholder="email@example.com" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div style="margin-bottom:18px;">
                    <div style="display:flex;justify-content:between;align-items:center;margin-bottom:6px;">
                        <label style="font-size:11px;font-weight:700;color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:.7px;">Password *</label>
                    </div>
                    <div style="position:relative;">
                        @include('components.icon',['name'=>'lock','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                        <input type="password" name="password" required placeholder="••••••••" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div style="display:flex;align-items:center;justify-content:between;margin-bottom:22px;gap:8px;">
                    <label style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,.6);font-size:13px;cursor:pointer;user-select:none;">
                        <input type="checkbox" name="remember" style="accent-color:#FFC81A;width:15px;height:15px;cursor:pointer;">
                        Ingat Saya
                    </label>
                </div>
                <button type="submit" class="fcc-btn-gold btn-shine" style="width:100%;justify-content:center;padding:12px;font-size:14.5px;border-radius:12px;font-weight:800;">
                    Masuk
                </button>
            </form>
        </div>

        {{-- FORM REGISTER --}}
        <div id="fcc-register-container" style="display:none;">
            <h2 style="color:#FFF;font-size:22px;font-weight:900;margin:0 0 6px;">Daftar Akun</h2>
            <p style="color:rgba(255,255,255,.5);font-size:13.5px;margin:0 0 24px;">Sudah punya akun? <a href="javascript:void(0)" onclick="switchAuthTab('login')" style="color:#FFC81A;font-weight:700;text-decoration:none;">Masuk</a></p>

            <form id="fcc-register-form" onsubmit="submitAuthForm(event, '/daftar')">
                @csrf
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Nama Lengkap *</label>
                    <div style="position:relative;">
                        @include('components.icon',['name'=>'user','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                        <input type="text" name="nama" required placeholder="Nama lengkap Anda" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Email *</label>
                    <div style="position:relative;">
                        @include('components.icon',['name'=>'mail','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                        <input type="email" name="email" required placeholder="email@example.com" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Password *</label>
                    <div style="position:relative;">
                        @include('components.icon',['name'=>'lock','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                        <input type="password" name="password" required placeholder="Min. 8 karakter" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div style="margin-bottom:22px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Konfirmasi Password *</label>
                    <div style="position:relative;">
                        @include('components.icon',['name'=>'lock','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                        <input type="password" name="password_confirmation" required placeholder="Ulangi password" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <button type="submit" class="fcc-btn-gold btn-shine" style="width:100%;justify-content:center;padding:12px;font-size:14.5px;border-radius:12px;font-weight:800;">
                    Daftar Sekarang
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('fcc-auth-modal');
    const dialog = document.getElementById('fcc-auth-dialog');
    const alertBox = document.getElementById('fcc-auth-alert');

    function openAuthModal(tab = 'login') {
        switchAuthTab(tab);
        alertBox.style.display = 'none';
        modal.style.opacity = '1';
        modal.style.pointerEvents = 'auto';
        dialog.style.transform = 'scale(1)';
        document.body.style.overflow = 'hidden';
    }

    function closeAuthModal() {
        modal.style.opacity = '0';
        modal.style.pointerEvents = 'none';
        dialog.style.transform = 'scale(0.92)';
        document.body.style.overflow = '';
    }

    function switchAuthTab(tab) {
        alertBox.style.display = 'none';
        if (tab === 'login') {
            document.getElementById('fcc-login-container').style.display = 'block';
            document.getElementById('fcc-register-container').style.display = 'none';
        } else {
            document.getElementById('fcc-login-container').style.display = 'none';
            document.getElementById('fcc-register-container').style.display = 'block';
        }
    }

    // Intercept clicks on links that match /masuk or /daftar
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href) {
            try {
                const url = new URL(link.href);
                if (url.origin === window.location.origin) {
                    if (url.pathname === '/masuk') {
                        e.preventDefault();
                        openAuthModal('login');
                    } else if (url.pathname === '/daftar') {
                        e.preventDefault();
                        openAuthModal('register');
                    }
                }
            } catch (err) {}
        }
    });

    // Close modal on clicking backdrop
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeAuthModal();
        }
    });

    // Submit Auth Form via AJAX
    function submitAuthForm(e, url) {
        e.preventDefault();
        alertBox.style.display = 'none';
        
        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerText;
        
        submitBtn.disabled = true;
        submitBtn.innerText = 'Memproses...';

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            return response.json().then(data => {
                if (!response.ok) {
                    throw { status: response.status, data: data };
                }
                return data;
            });
        })
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect || '/';
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerText = originalText;
            
            let errMsg = 'Terjadi kesalahan sistem. Silakan coba lagi.';
            if (err.data && err.data.errors) {
                errMsg = Object.values(err.data.errors).flat().join('<br>');
            } else if (err.data && err.data.message) {
                errMsg = err.data.message;
            }
            
            alertBox.innerHTML = errMsg;
            alertBox.style.display = 'block';
        });
    }
</script>

@endsection

{{-- JS Navbar dimuat via resources/js/components/navbar.js (diimport app.js) --}}
