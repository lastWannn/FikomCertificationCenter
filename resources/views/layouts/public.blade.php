@extends('layouts.app')
@section('async-css', true)
@section('no-livewire', true)
@section('content')

<script>
window.switchAuthTab = function(tab) {
    const ab = document.getElementById('fcc-auth-alert');
    if (ab) ab.style.display = 'none';

    const loginC = document.getElementById('fcc-login-container');
    const regC = document.getElementById('fcc-register-container');
    const forgC = document.getElementById('fcc-forgot-container');

    if (loginC) loginC.style.display = 'none';
    if (regC) regC.style.display = 'none';
    if (forgC) forgC.style.display = 'none';

    if (tab === 'login') {
        if (loginC) loginC.style.display = 'block';
    } else if (tab === 'forgot') {
        if (forgC) forgC.style.display = 'block';
    } else {
        if (regC) regC.style.display = 'block';
    }
};

window.openAuthModal = function(tab = 'login', keepAlert = false) {
    if (window.switchAuthTab) window.switchAuthTab(tab);
    const ab = document.getElementById('fcc-auth-alert');
    if (!keepAlert && ab) ab.style.display = 'none';
    const m = document.getElementById('fcc-auth-modal');
    const d = document.getElementById('fcc-auth-dialog');
    if (m) {
        m.style.display = 'flex';
        m.style.opacity = '1';
        m.style.visibility = 'visible';
        m.style.pointerEvents = 'auto';
    }
    if (d) d.style.transform = 'scale(1)';
    document.body.style.overflow = 'hidden';
};

window.closeAuthModal = function() {
    const m = document.getElementById('fcc-auth-modal');
    const d = document.getElementById('fcc-auth-dialog');
    if (m) {
        m.style.opacity = '0';
        m.style.pointerEvents = 'none';
        setTimeout(() => {
            if (m && m.style.opacity === '0') {
                m.style.display = 'none';
            }
        }, 300);
    }
    if (d) d.style.transform = 'scale(0.92)';
    document.body.style.overflow = '';
};

window.openTnCModal = function() {
    const tnc = document.getElementById('tncModal');
    if (tnc) tnc.style.display = 'flex';
};

window.closeTnCModal = function() {
    const tnc = document.getElementById('tncModal');
    if (tnc) tnc.style.display = 'none';
};

window.toggleMobileMenu = function() {
    const menu = document.getElementById('fcc-mobile-menu');
    const btn = document.getElementById('fcc-mobile-menu-btn');
    const hamIcon = document.getElementById('fcc-ham-icon');
    const closeIcon = document.getElementById('fcc-close-icon');
    const ticker = document.getElementById('fcc-ticker');
    
    if (!menu) return;
    const isHidden = menu.style.display === 'none' || menu.style.display === '';
    
    if (isHidden) {
        const tickerVisible = (ticker && window.getComputedStyle(ticker).display !== 'none' && ticker.offsetHeight > 0);
        const tickerHeight = tickerVisible ? ticker.offsetHeight : 0;
        menu.style.top = (64 + tickerHeight) + 'px';
        menu.style.display = 'block';
        if (btn) btn.setAttribute('aria-expanded', 'true');
        if (hamIcon) hamIcon.style.display = 'none';
        if (closeIcon) closeIcon.style.display = 'block';
    } else {
        menu.style.display = 'none';
        if (btn) btn.setAttribute('aria-expanded', 'false');
        if (hamIcon) hamIcon.style.display = 'block';
        if (closeIcon) closeIcon.style.display = 'none';
    }
};

window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024) {
        const menu = document.getElementById('fcc-mobile-menu');
        const btn = document.getElementById('fcc-mobile-menu-btn');
        const hamIcon = document.getElementById('fcc-ham-icon');
        const closeIcon = document.getElementById('fcc-close-icon');
        if (menu) menu.style.display = 'none';
        if (btn) btn.setAttribute('aria-expanded', 'false');
        if (hamIcon) hamIcon.style.display = 'block';
        if (closeIcon) closeIcon.style.display = 'none';
    }
});
</script>

{{-- ═══ NAVBAR ══════════════════════════════════════════════════ --}}
<nav id="fcc-nav" role="navigation" aria-label="Navigasi utama" style="position:fixed;top:0;left:0;right:0;z-index:500;height:64px;display:flex;align-items:center;padding:0 24px;gap:16px;background:#131218;border-bottom:2px solid #1E1D26;box-shadow:0 4px 20px rgba(0,0,0,0.3);">
    <div style="max-width:1200px;margin:0 auto;width:100%;padding:0 24px;
        display:flex;align-items:center;justify-content:space-between;gap:24px;">

        {{-- Logo --}}
        <a href="{{ route('landing.index') }}" id="nav-logo" style="display:flex;align-items:center;gap:10px;text-decoration:none;flex-shrink:0;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo FCC UMI" width="36" height="36" style="height:36px;width:auto;object-fit:contain;flex-shrink:0;">
            <div>
                <p id="nav-brand" style="margin:0;font-weight:900;font-size:12.5px;color:#FFFFFF;transition:color .3s;">FIKOM Certification</p>
                <p style="margin:0;color:#FFC81A;font-size:8px;font-weight:800;letter-spacing:2.5px;text-transform:uppercase;">Center · UMI</p>
            </div>
        </a>

        {{-- Nav links (Centered Desktop) --}}
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
        <div class="nav-links-center" style="display:flex;align-items:center;justify-content:center;gap:4px;flex:1;">
            @foreach($navLinks as [$route,$label])
            @php $isActive = request()->routeIs($route); @endphp
            <a href="{{ route($route) }}"
               class="nav-lnk {{ $isActive?'nav-active':'' }}"
               style="padding:6px 16px;border-radius:20px;text-decoration:none;font-size:13.5px;transition:all .2s ease;
                      {{ $isActive ? 'background:#FFC81A;color:#131218 !important;font-weight:900;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(255,200,26,0.25);' : 'color:rgba(255,255,255,0.85);font-weight:600;' }}"
               @if(!$isActive)
               onmouseover="this.style.color='#FFC81A';this.style.background='rgba(255,255,255,0.06)'"
               onmouseout="this.style.color='rgba(255,255,255,0.85)';this.style.background='transparent'"
               @endif>
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

        {{-- CTA right & Mobile Hamburger Button --}}
        <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;">
            @auth('peserta')
            <a href="{{ route('peserta.dashboard') }}" style="padding:8px 18px;font-size:13px;font-weight:900;background:#FFC81A;color:#131218;border-radius:20px;text-decoration:none;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(255,200,26,0.3);display:inline-flex;align-items:center;gap:6px;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Portal
            </a>
            @elseauth('admin')
            <a href="{{ route('admin.dashboard') }}" style="padding:8px 18px;font-size:13px;font-weight:900;background:#FFC81A;color:#131218;border-radius:20px;text-decoration:none;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(255,200,26,0.3);">Admin Panel</a>
            @else
            <a href="{{ route('auth.login') }}" style="padding:8px 18px;font-size:13px;font-weight:900;background:#FFC81A;color:#131218;border-radius:20px;text-decoration:none;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(255,200,26,0.3);display:inline-flex;align-items:center;gap:6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align:middle;">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Masuk
            </a>
            @endauth

            {{-- Hamburger Toggle Button (Mobile Only) --}}
            <button id="fcc-mobile-menu-btn" onclick="toggleMobileMenu()" aria-label="Menu Navigasi" aria-expanded="false" class="mobile-menu-btn" style="display:none;width:38px;height:38px;border-radius:10px;background:#1E1D26;border:1.5px solid rgba(255,200,26,0.3);color:#FFC81A;cursor:pointer;align-items:center;justify-content:center;transition:all .2s ease;padding:0;" onmouseover="this.style.borderColor='#FFC81A';this.style.background='rgba(255,200,26,0.1)'" onmouseout="this.style.borderColor='rgba(255,200,26,0.3)';this.style.background='#1E1D26'">
                <svg id="fcc-ham-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
                <svg id="fcc-close-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
    </div>
</nav>

{{-- Mobile Menu Dropdown / Drawer --}}
<div id="fcc-mobile-menu" style="display:none;position:fixed;left:0;right:0;top:100px;background:#131218;border-bottom:2px solid #FFC81A;box-shadow:0 20px 50px rgba(0,0,0,0.7);z-index:501;max-height:calc(100vh - 100px);overflow-y:auto;padding:16px 20px 24px;transition:all 0.3s ease;">
    {{-- Mobile Links List --}}
    <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:16px;">
        @foreach($navLinks as [$route,$label])
        @php $isActive = request()->routeIs($route); @endphp
        <a href="{{ route($route) }}"
           style="display:flex;align-items:center;justify-content:space-between;padding:11px 16px;border-radius:12px;text-decoration:none;font-size:14px;font-weight:{{ $isActive ? '900' : '700' }};transition:all .2s ease;
                  {{ $isActive ? 'background:#FFC81A;color:#131218 !important;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(255,200,26,0.25);' : 'background:#1E1D26;color:rgba(255,255,255,0.9);border:1px solid rgba(255,200,26,0.15);' }}">
            <span>{{ $label }}</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        @endforeach
    </div>

    {{-- Brand footer info in mobile menu --}}
    <div style="border-top:1px solid rgba(255,200,26,0.2);padding-top:12px;display:flex;flex-direction:column;gap:4px;">
        <p style="margin:0;font-size:10px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:1.5px;">FIKOM Certification Center</p>
        <p style="margin:0;font-size:11.5px;color:rgba(255,255,255,0.6);line-height:1.4;">Fakultas Ilmu Komputer Universitas Muslim Indonesia</p>
    </div>
</div>

@php
    $dbInfos = \App\Models\Informasi::info()->aktif()->latest()->get();
    $kegiatanList = \App\Models\Kegiatan::upcoming()
        ->with(['kegiatanPelatihan.jadwalPelatihan.pelatihan', 'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi'])
        ->latest()
        ->take(6)
        ->get();

    $tickerItems = [];

    foreach ($kegiatanList as $k) {
        $tgl = $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Jadwal Menyusul';
        $jenis = strtoupper($k->jenis_kegiatan);
        $statusText = $k->isComingSoon() ? 'SEGERA HADIR' : ($k->isRegistrationClosed() ? 'PENDAFTARAN DITUTUP' : ($k->isFull() ? 'KUOTA PENUH' : 'DIBUKA (' . ($k->kuota - $k->terisi) . ' Kuota Sisa)'));
        $tickerItems[] = [
            'text'   => $k->judul . ' — Pelaksanaan: ' . $tgl,
            'badge'  => $jenis,
            'status' => $statusText,
            'url'    => route('landing.show', $k)
        ];
    }

    foreach ($dbInfos as $info) {
        $tickerItems[] = [
            'text'   => $info->judul,
            'badge'  => 'INFO',
            'status' => 'PENGUMUMAN',
            'url'    => route('landing.index')
        ];
    }
@endphp
@if(!empty($tickerItems))
{{-- Override padding top secara dinamis ketika ticker aktif --}}
<style>
    /* Untuk halaman umum */
    .page-content-wrap {
        padding-top: 104px !important;
    }
    /* Untuk halaman Home (Hero section) */
    [data-hero] {
        margin-top: 40px !important;
        min-height: calc(100vh - 40px) !important;
    }
</style>
<div id="fcc-ticker" style="position:fixed;top:64px;left:0;right:0;width:100vw;max-width:100vw;background:#1E1D26;border-bottom:1.5px solid #FFC81A;z-index:499;overflow:hidden;box-sizing:border-box;">
    <div style="display:flex;align-items:center;height:36px;width:100%;max-width:100vw;padding-right:36px;overflow:hidden;box-sizing:border-box;">

        {{-- Label kiri: ikon pulse + teks --}}
        <div style="flex-shrink:0;display:flex;align-items:center;gap:9px;padding:0 16px;height:100%;background:#FFC81A;border-right:1.5px solid #131218;box-sizing:border-box;">
            <span class="fcc-bell-wrap" style="position:relative;display:flex;align-items:center;justify-content:center;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </span>
            <span style="color:#131218;font-size:10px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;white-space:nowrap;">INFO</span>
        </div>

        {{-- Marquee wrapper dengan fade edges --}}
        <div class="fcc-marquee-wrap" style="flex:1 1 0%;min-width:0;width:0;overflow:hidden;position:relative;height:100%;display:flex;align-items:center;">
            {{-- Fade kiri --}}
            <div style="position:absolute;left:0;top:0;bottom:0;width:32px;background:linear-gradient(90deg,#131218,transparent);z-index:2;pointer-events:none;"></div>
            {{-- Fade kanan --}}
            <div style="position:absolute;right:0;top:0;bottom:0;width:32px;background:linear-gradient(270deg,#131218,transparent);z-index:2;pointer-events:none;"></div>

            <div class="fcc-ticker-track">
                @foreach(array_merge($tickerItems, $tickerItems) as $item)
                <a href="{{ $item['url'] }}" style="text-decoration:none;display:inline-flex;align-items:center;gap:10px;padding:0 24px;white-space:nowrap;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    <span style="background:#FFC81A;color:#131218;font-size:9.5px;font-weight:900;padding:2px 8px;border-radius:4px;text-transform:uppercase;letter-spacing:0.5px;">
                        {{ $item['badge'] }}
                    </span>
                    <span style="color:rgba(255,255,255,.92);font-size:12.5px;font-weight:700;letter-spacing:.3px;">
                        {{ $item['text'] }}
                    </span>
                    <span style="background:rgba(255,200,26,0.15);color:#FFC81A;font-size:10px;font-weight:800;padding:2px 8px;border-radius:4px;border:1px solid rgba(255,200,26,0.35);">
                        {{ $item['status'] }}
                    </span>
                    <span style="width:1px;height:12px;background:rgba(255,200,26,.35);flex-shrink:0;margin-left:8px;"></span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Tombol tutup --}}
        <button onclick="document.getElementById('fcc-ticker').style.display='none'" title="Tutup" style="position:absolute;top:0;right:0;width:36px;height:100%;background:#1E1D26;border:none;border-left:1px solid rgba(255,200,26,.1);color:rgba(255,255,255,.35);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:color .2s,background .2s;" onmouseover="this.style.color='#FFC81A';this.style.background='rgba(255,200,26,.06)'" onmouseout="this.style.color='rgba(255,255,255,.35)';this.style.background='#1E1D26'">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>
</div>
<style>
/* Ticker scroll */
.fcc-ticker-track {
    display: inline-flex;
    animation: fcc-ticker-scroll var(--fcc-ticker-duration, 45s) linear infinite;
    will-change: transform;
    flex-shrink: 0;
    white-space: nowrap;
}
.fcc-ticker-track:hover { animation-play-state: paused; }
@keyframes fcc-ticker-scroll {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}
/* Bell pulse */
.fcc-bell-pulse {
    position: absolute;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: rgba(255,200,26,.2);
    animation: fcc-pulse 2.2s ease-out infinite;
    pointer-events: none;
}
@keyframes fcc-pulse {
    0%   { transform: scale(.6); opacity: .8; }
    70%  { transform: scale(1.5); opacity: 0; }
    100% { transform: scale(.6); opacity: 0; }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tickerTrack = document.querySelector('.fcc-ticker-track');
    if (!tickerTrack) return;

    const setTickerSpeed = function () {
        const singleTrackWidth = tickerTrack.scrollWidth / 2;
        const pixelsPerSecond = 42;
        const duration = Math.max(singleTrackWidth / pixelsPerSecond, 20);

        tickerTrack.style.setProperty('--fcc-ticker-duration', duration + 's');
    };

    requestAnimationFrame(setTickerSpeed);
    window.addEventListener('resize', setTickerSpeed, { passive: true });
});
</script>
@endif

{{-- Page Content --}}
@yield('page-content')

{{-- ═══ FOOTER — High-Contrast Dark & Yellow (Selaras Seksi Landing Page) ═══════════════════════════════════════ --}}
<footer style="background:#131218;border-top:3px solid #FFC81A;position:relative;z-index:20;overflow:hidden;">
    {{-- Ambient Background Glow --}}
    <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:700px;height:140px;background:radial-gradient(ellipse,rgba(255,200,26,.06),transparent 70%);pointer-events:none;"></div>

    <div style="max-width:1180px;margin:0 auto;padding:64px 24px 0;position:relative;z-index:1;">
        
        {{-- Main 4-Column Grid --}}
        <div class="footer-grid">

            {{-- Brand Column --}}
            <div>
                <div style="display:flex;align-items:center;gap:14px;margin-bottom:20px;">
                    <div style="width:48px;height:48px;border-radius:12px;background:#1E1D26;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;padding:6px;box-shadow:0 4px 14px rgba(255,200,26,0.25);">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo FCC UMI" width="48" height="48" loading="lazy" decoding="async" style="width:100%;height:100%;object-fit:contain;">
                    </div>
                    <div>
                        <p style="margin:0;color:#FFFFFF;font-weight:900;font-size:15px;letter-spacing:-.3px;">FIKOM Certification Center</p>
                        <span style="display:inline-block;padding:2px 8px;background:#FFC81A;color:#131218;font-size:9px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;border-radius:4px;margin-top:3px;">
                            Universitas Muslim Indonesia
                        </span>
                    </div>
                </div>
                <p style="color:rgba(255,255,255,0.75);font-size:13.5px;line-height:1.8;max-width:300px;margin:0 0 24px;">
                    Platform resmi sertifikasi dan pelatihan profesional FIKOM UMI Makassar. Bimbing langkah Anda menuju keahlian IT berstandar industri.
                </p>

                {{-- Social Media Links with Hover Glow --}}
                <div style="display:flex;gap:10px;">
                    @foreach([
                        ['M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z','Instagram'],
                        ['M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z','Facebook'],
                        ['M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814z M9.545 15.568L15.818 12 9.545 8.432v7.136z','YouTube'],
                    ] as [$path, $name])
                    <a href="#" title="{{ $name }}" style="width:38px;height:38px;border-radius:12px;background:#1E1D26;border:1.5px solid rgba(255,200,26,0.25);display:flex;align-items:center;justify-content:center;transition:all .25s ease;text-decoration:none;"
                       onmouseover="this.style.background='#FFC81A';this.style.borderColor='#FFC81A';this.style.transform='translateY(-3px)';this.querySelector('svg').style.fill='#131218';"
                       onmouseout="this.style.background='#1E1D26';this.style.borderColor='rgba(255,200,26,0.25)';this.style.transform='translateY(0)';this.querySelector('svg').style.fill='#FFC81A';">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="#FFC81A" style="transition:fill .25s ease;"><path fill-rule="evenodd" clip-rule="evenodd" d="{{ $path }}"/></svg>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Navigasi Column --}}
            <div>
                <span style="display:inline-block;padding:4px 12px;background:#1E1D26;color:#FFC81A;border:1px solid rgba(255,200,26,0.3);font-size:10px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;border-radius:100px;margin-bottom:18px;">
                    Navigasi
                </span>
                @foreach([['Home','landing.index'],['Kegiatan','landing.kegiatan'],['Profil','landing.profil'],['Arsip','landing.arsip']] as [$l,$r])
                <a href="{{ route($r) }}"
                   style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.7);font-size:13.5px;font-weight:600;text-decoration:none;margin-bottom:12px;transition:all .2s ease;"
                   onmouseover="this.style.color='#FFC81A';this.style.paddingLeft='6px';"
                   onmouseout="this.style.color='rgba(255,255,255,0.7)';this.style.paddingLeft='0';">
                    <span style="width:5px;height:5px;border-radius:50%;background:#FFC81A;flex-shrink:0;"></span>
                    {{ $l }}
                </a>
                @endforeach
            </div>

            {{-- Layanan Column --}}
            <div>
                <span style="display:inline-block;padding:4px 12px;background:#1E1D26;color:#FFC81A;border:1px solid rgba(255,200,26,0.3);font-size:10px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;border-radius:100px;margin-bottom:18px;">
                    Layanan
                </span>
                @foreach([['Pelatihan IT','landing.kegiatan'],['Sertifikasi BNSP','landing.kegiatan'],['Tata Cara Daftar','landing.pendaftaran'],['Hubungi Kami','landing.kontak']] as [$l,$r])
                <a href="{{ route($r) }}"
                   style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.7);font-size:13.5px;font-weight:600;text-decoration:none;margin-bottom:12px;transition:all .2s ease;"
                   onmouseover="this.style.color='#FFC81A';this.style.paddingLeft='6px';"
                   onmouseout="this.style.color='rgba(255,255,255,0.7)';this.style.paddingLeft='0';">
                    <span style="width:5px;height:5px;border-radius:50%;background:#FFC81A;flex-shrink:0;"></span>
                    {{ $l }}
                </a>
                @endforeach
            </div>

            {{-- Kontak Column --}}
            <div>
                <span style="display:inline-block;padding:4px 12px;background:#1E1D26;color:#FFC81A;border:1px solid rgba(255,200,26,0.3);font-size:10px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;border-radius:100px;margin-bottom:18px;">
                    Hubungi Kami
                </span>

                @php
                    $fKontak = \App\Models\Kontak::aktif();
                    $fAlamat = $fKontak->alamat ?? 'Jl. Urip Sumoharjo No.225, Makassar 90232';
                    $fTelp   = $fKontak?->telepon_dengan_nama ?? ($fKontak->telepon ?? '(0411) 455 855');
                    $fEmail  = $fKontak->email ?? 'fcc@fikom.umi.ac.id';
                    $fWaUrl  = $fKontak?->wa_url ?? 'https://wa.me/6281234567890';
                    $fMailUrl= $fKontak?->mailto_url ?? 'mailto:fcc@fikom.umi.ac.id';
                @endphp

                @foreach([
                    ['M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0-6 0','Alamat', $fAlamat, null, false],
                    ['M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z','Telepon & WhatsApp', $fTelp, $fWaUrl, true],
                    ['M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z M22 6l-10 7L2 6','Email Resmi', $fEmail, $fMailUrl, false],
                ] as [$path,$label,$val,$url,$isNewTab])
                @if($url)
                    <a href="{{ $url }}" {{ $isNewTab ? 'target="_blank" rel="noopener noreferrer"' : '' }} 
                       style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;background:#1E1D26;padding:10px 14px;border-radius:12px;border:1px solid rgba(255,200,26,0.2);text-decoration:none;transition:all 0.2s ease;"
                       onmouseover="this.style.borderColor='#FFC81A'; this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.borderColor='rgba(255,200,26,0.2)'; this.style.transform='none';">
                        <div style="width:30px;height:30px;border-radius:8px;background:#FFC81A;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#131218;margin-top:1px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $path }}"/></svg>
                        </div>
                        <div>
                            <p style="color:#FFC81A;font-size:9.5px;font-weight:900;margin:0 0 2px;text-transform:uppercase;letter-spacing:1px;display:flex;align-items:center;gap:4px;">
                                {{ $label }}
                                @if($isNewTab) <span style="font-size:9px;color:#25D366;">(WA) &nearr;</span> @else <span style="font-size:9px;color:#0284C7;">&nearr;</span> @endif
                            </p>
                            <p style="color:#FFFFFF;font-size:12.5px;font-weight:600;margin:0;line-height:1.4;">{{ $val }}</p>
                        </div>
                    </a>
                @else
                    <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;background:#1E1D26;padding:10px 14px;border-radius:12px;border:1px solid rgba(255,200,26,0.15);">
                        <div style="width:30px;height:30px;border-radius:8px;background:#FFC81A;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#131218;margin-top:1px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $path }}"/></svg>
                        </div>
                        <div>
                            <p style="color:#FFC81A;font-size:9.5px;font-weight:900;margin:0 0 2px;text-transform:uppercase;letter-spacing:1px;">{{ $label }}</p>
                            <p style="color:#FFFFFF;font-size:12.5px;font-weight:600;margin:0;line-height:1.4;">{{ $val }}</p>
                        </div>
                    </div>
                @endif
                @endforeach
            </div>
        </div>

        {{-- Bottom Copyright Bar --}}
        <div class="footer-bottom" style="border-top:1.5px solid rgba(255,200,26,0.2);padding:22px 0 30px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;">
            <p style="color:rgba(255,255,255,0.6);font-size:12.5px;font-weight:600;margin:0;line-height:1.5;">
                &copy; {{ date('Y') }} FIKOM Certification Center &middot; Universitas Muslim Indonesia
            </p>
            <div style="display:flex;align-items:center;flex-wrap:wrap;gap:10px 18px;">
                @foreach(['Kebijakan Privasi','Syarat & Ketentuan'] as $l)
                <span style="color:rgba(255,255,255,0.6);font-size:12.5px;font-weight:600;cursor:pointer;transition:color .2s;"
                      onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                    {{ $l }}
                </span>
                @endforeach
                <span style="color:rgba(255,200,26,0.4);font-size:11px;">|</span>
                <span style="color:rgba(255,255,255,0.6);font-size:12px;font-weight:600;">Dikelola oleh <span style="color:#FFC81A;font-weight:800;">FCC FIKOM UMI</span></span>
            </div>
        </div>
    </div>
</footer>

{{-- ═══ MODAL LOGIN & REGISTER ════════════════════════════════════ --}}
<div id="fcc-auth-modal" style="position:fixed;inset:0;background:rgba(14,13,20,0.8);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);z-index:9999;display:none;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:all 0.3s cubic-bezier(0.16,1,0.3,1);">
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
        <div id="fcc-auth-alert" style="{{ $errors->any() ? 'display:block;' : 'display:none;' }}padding:12px 14px;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);border-radius:10px;color:#EF4444;font-size:13px;font-weight:600;margin-bottom:20px;line-height:1.45;">
            @if($errors->any())
                {!! implode('<br>', $errors->all()) !!}
            @endif
        </div>

        {{-- FORM LOGIN --}}
        <div id="fcc-login-container">
            <h2 style="color:#FFF;font-size:22px;font-weight:900;margin:0 0 6px;">Masuk</h2>
            <p style="color:rgba(255,255,255,.5);font-size:13.5px;margin:0 0 24px;">Belum punya akun? <a href="javascript:void(0)" onclick="switchAuthTab('register')" style="color:#FFC81A;font-weight:700;text-decoration:none;">Daftar gratis</a></p>

            <form id="fcc-login-form" action="{{ route('auth.login.post') }}" method="POST" onsubmit="submitAuthForm(event, '{{ route('auth.login.post') }}')">
                @csrf
                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Email *</label>
                    <div style="position:relative;">
                        @include('components.icon',['name'=>'mail','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                        <input type="email" name="email" required placeholder="email@example.com" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div style="margin-bottom:18px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                        <label style="font-size:11px;font-weight:700;color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:.7px;">Password *</label>
                        <a href="javascript:void(0)" onclick="switchAuthTab('forgot')" style="font-size:12px;color:#FFC81A;font-weight:600;text-decoration:none;">Lupa Password?</a>
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

            <form id="fcc-register-form" action="{{ route('auth.register.post') }}" method="POST" onsubmit="submitAuthForm(event, '{{ route('auth.register.post') }}')">
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
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                    <div>
                        <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">No. HP *</label>
                        <input type="text" name="no_hp" required placeholder="08xxxxxxxxxx" class="fcc-input-dark" style="width:100%;box-sizing:border-box;padding-left:14px;">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Jenis Kelamin *</label>
                        <div style="display:flex;gap:8px;">
                            <label style="flex:1;cursor:pointer;position:relative;">
                                <input type="radio" name="kelamin" value="L" required style="position:absolute;opacity:0;" class="fcc-radio-pill">
                                <div class="radio-pill-bg" style="padding:10px;text-align:center;border-radius:10px;background:rgba(255,255,255,.04);border:1.5px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5);font-size:12.5px;font-weight:600;transition:all .2s;box-sizing:border-box;">Laki-laki</div>
                            </label>
                            <label style="flex:1;cursor:pointer;position:relative;">
                                <input type="radio" name="kelamin" value="P" required style="position:absolute;opacity:0;" class="fcc-radio-pill">
                                <div class="radio-pill-bg" style="padding:10px;text-align:center;border-radius:10px;background:rgba(255,255,255,.04);border:1.5px solid rgba(255,255,255,.1);color:rgba(255,255,255,.5);font-size:12.5px;font-weight:600;transition:all .2s;box-sizing:border-box;">Perempuan</div>
                            </label>
                        </div>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:22px;">
                    <div>
                        <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Password *</label>
                        <div style="position:relative;">
                            @include('components.icon',['name'=>'lock','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                            <input type="password" name="password" required placeholder="Min. 8 karakter" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                        </div>
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Ulangi Password *</label>
                        <div style="position:relative;">
                            @include('components.icon',['name'=>'lock','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                            <input type="password" name="password_confirmation" required placeholder="Ulangi password" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                        </div>
                    </div>
                </div>
                <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:22px;background:rgba(255,255,255,.05);border-radius:10px;padding:12px 14px;">
                    <input type="checkbox" name="agree" required style="width:16px;height:16px;accent-color:#FFC81A;cursor:pointer;flex-shrink:0;margin-top:2px;">
                    <label style="font-size:12px;color:rgba(255,255,255,.6);cursor:pointer;line-height:1.5;">
                        Saya menyetujui
                        <a href="javascript:void(0)" onclick="openTnCModal()" style="color:#FFC81A;font-weight:700;text-decoration:none;">syarat & ketentuan</a>
                        serta kebijakan privasi FCC UMI.
                    </label>
                </div>
                <button type="submit" class="fcc-btn-gold btn-shine" style="width:100%;justify-content:center;padding:12px;font-size:14.5px;border-radius:12px;font-weight:800;">
                    Daftar Sekarang
                </button>
            </form>
        </div>

        {{-- FORM FORGOT PASSWORD --}}
        <div id="fcc-forgot-container" style="display:none;">
            <h2 style="color:#FFF;font-size:22px;font-weight:900;margin:0 0 6px;">Lupa Password</h2>
            <p style="color:rgba(255,255,255,.5);font-size:13.5px;margin:0 0 24px;">Kembali ke <a href="javascript:void(0)" onclick="switchAuthTab('login')" style="color:#FFC81A;font-weight:700;text-decoration:none;">Masuk</a></p>

            <form id="fcc-forgot-form" action="{{ route('auth.forgot.post') }}" method="POST" onsubmit="submitAuthForm(event, '{{ route('auth.forgot.post') }}')">
                @csrf
                <div style="margin-bottom:22px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Email Akun Anda *</label>
                    <div style="position:relative;">
                        @include('components.icon',['name'=>'mail','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                        <input type="email" name="email" required placeholder="email@example.com" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <button type="submit" class="fcc-btn-gold btn-shine" style="width:100%;justify-content:center;padding:12px;font-size:14.5px;border-radius:12px;font-weight:800;">
                    Kirim Kode OTP
                </button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL OTP --}}
<div id="otpModal" style="display:none;position:fixed;inset:0;background:rgba(14,13,20,.85);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);z-index:99999;align-items:center;justify-content:center;padding:20px;">
    <div style="background:#131218;width:100%;max-width:400px;border-radius:24px;padding:40px;box-shadow:0 24px 64px rgba(0,0,0,.6);border:1.5px solid rgba(255,200,26,.2);text-align:center;position:relative;">
        <button type="button" onclick="closeOtpModal()" style="position:absolute;top:20px;right:20px;background:none;border:none;color:rgba(255,255,255,.4);cursor:pointer;padding:6px;border-radius:50%;display:flex;align-items:center;justify-content:center;" onmouseover="this.style.color='#FFF';this.style.background='rgba(255,255,255,.05)'" onmouseout="this.style.color='rgba(255,255,255,.4)';this.style.background='none'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div style="width:64px;height:64px;border-radius:18px;background:rgba(255,200,26,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <h3 style="color:#FFF;font-size:20px;font-weight:900;margin:0 0 8px;">Verifikasi Email</h3>
        <p style="color:rgba(255,255,255,.5);font-size:13px;line-height:1.6;margin:0 0 24px;">
            Kami telah mengirimkan 4 digit kode OTP ke <br>
            <strong id="otpEmailDisplay" style="color:#FFC81A;"></strong>
        </p>
        
        <form id="otpForm" action="/daftar/verify" method="POST">
            @csrf
            <input type="hidden" name="email" id="otpEmailInput">
            <div style="display:flex;gap:12px;justify-content:center;margin-bottom:24px;" id="otpInputs">
                <input type="text" maxlength="1" class="otp-box-pub" required autofocus>
                <input type="text" maxlength="1" class="otp-box-pub" required>
                <input type="text" maxlength="1" class="otp-box-pub" required>
                <input type="text" maxlength="1" class="otp-box-pub" required>
            </div>
            <input type="hidden" name="otp" id="finalOtp">
            <div id="otpError" style="color:#EF4444;font-size:12px;margin-bottom:16px;display:none;font-weight:600;"></div>
            
            <button id="btnVerify" type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:12px;font-size:14px;border-radius:10px;font-weight:800;">
                Verifikasi & Masuk
            </button>
        </form>
    </div>
</div>

{{-- MODAL RESET PASSWORD OTP --}}
<div id="otpResetModal" style="display:none;position:fixed;inset:0;background:rgba(14,13,20,.8);backdrop-filter:blur(5px);z-index:99999;align-items:center;justify-content:center;padding:20px;overflow-y:auto;">
    <div style="background:#131218;width:100%;max-width:440px;border-radius:24px;padding:36px;box-shadow:0 24px 64px rgba(0,0,0,.4);border:1px solid rgba(255,200,26,.2);position:relative;margin:auto;">
        <button onclick="document.getElementById('otpResetModal').style.display='none'" style="position:absolute;top:20px;right:20px;background:none;border:none;color:rgba(255,255,255,.4);cursor:pointer;padding:6px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div style="text-align:center;">
            <div style="width:56px;height:56px;border-radius:16px;background:rgba(255,200,26,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h3 style="color:#FFF;font-size:20px;font-weight:900;margin:0 0 8px;">Reset Password</h3>
            <p style="color:rgba(255,255,255,.5);font-size:13px;line-height:1.6;margin:0 0 24px;">
                Masukkan 4 digit kode OTP dari email <br>
                <strong id="otpResetEmailDisplay" style="color:#FFC81A;"></strong>
            </p>
        </div>
        
        <form id="otpResetForm" action="/lupa-password/verify" method="POST">
            @csrf
            <input type="hidden" name="email" id="otpResetEmailInput">
            <div style="display:flex;gap:12px;justify-content:center;margin-bottom:20px;" id="otpResetInputs">
                <input type="text" maxlength="1" class="otp-box-reset" required autofocus>
                <input type="text" maxlength="1" class="otp-box-reset" required>
                <input type="text" maxlength="1" class="otp-box-reset" required>
                <input type="text" maxlength="1" class="otp-box-reset" required>
            </div>
            <input type="hidden" name="otp" id="finalResetOtp">
            
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Password Baru *</label>
                <div style="position:relative;">
                    @include('components.icon',['name'=>'lock','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                    <input type="password" name="password" required placeholder="Min. 8 karakter" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                </div>
            </div>
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.6);margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Konfirmasi Password Baru *</label>
                <div style="position:relative;">
                    @include('components.icon',['name'=>'lock','size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;'])
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password baru" class="fcc-input-dark" style="padding-left:38px;width:100%;box-sizing:border-box;">
                </div>
            </div>

            <div id="otpResetError" style="color:#EF4444;font-size:12px;margin-bottom:16px;display:none;font-weight:600;text-align:center;"></div>
            
            <button id="btnResetVerify" type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:12px;font-size:14px;border-radius:10px;">
                Simpan Password Baru
            </button>
        </form>
    </div>
</div>

{{-- MODAL SYARAT & KETENTUAN --}}
<div id="tncModal" style="display:none;position:fixed;inset:0;background:rgba(14,13,20,.8);backdrop-filter:blur(5px);z-index:99999;align-items:center;justify-content:center;padding:20px;overflow-y:auto;">
    <div style="background:#131218;width:100%;max-width:550px;border-radius:24px;padding:36px;box-shadow:0 24px 64px rgba(0,0,0,.4);border:1px solid rgba(255,200,26,.2);position:relative;margin:auto;">
        <button onclick="closeTnCModal()" style="position:absolute;top:20px;right:20px;background:none;border:none;color:rgba(255,255,255,.4);cursor:pointer;padding:6px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
            <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,200,26,.1);display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
            <div>
                <h3 style="color:#FFF;font-size:20px;font-weight:900;margin:0 0 4px;">Syarat & Ketentuan</h3>
                <p style="color:rgba(255,255,255,.5);font-size:13px;margin:0;">Fikom Certification Center UMI</p>
            </div>
        </div>
        
        <div style="color:rgba(255,255,255,.75);font-size:13.5px;line-height:1.7;max-height:400px;overflow-y:auto;padding-right:10px;margin-bottom:24px;" class="fcc-custom-scroll">
            <ol style="padding-left:16px;margin:0;display:flex;flex-direction:column;gap:12px;">
                <li><strong style="color:#FFF;">Kebenaran Data:</strong> Peserta wajib mengisi seluruh data diri pendaftaran (Nama, NIM, Email, dll) dengan benar, akurat, dan dapat dipertanggungjawabkan.</li>
                <li><strong style="color:#FFF;">Kerahasiaan Akun:</strong> Akun yang telah didaftarkan bersifat pribadi. Peserta dilarang keras memindahtangankan akun, memberikan password, atau menyuruh orang lain mengikuti ujian atas namanya.</li>
                <li><strong style="color:#FFF;">Pelaksanaan Ujian:</strong> Peserta wajib mengikuti seluruh tahapan sertifikasi sesuai dengan jadwal yang telah ditentukan oleh Fikom Certification Center UMI.</li>
                <li><strong style="color:#FFF;">Larangan Kecurangan:</strong> Segala bentuk kecurangan, perjokian, pencurian soal, maupun pelanggaran etika akademik selama ujian berlangsung akan mengakibatkan sanksi <strong>Diskualifikasi</strong> secara sepihak tanpa pengembalian biaya.</li>
                <li><strong style="color:#FFF;">Keputusan Mutlak:</strong> Keputusan kelulusan dari tim penguji atau instruktur sertifikasi bersifat mutlak dan tidak dapat diganggu gugat.</li>
                <li><strong style="color:#FFF;">Kebijakan Privasi:</strong> Data yang dimasukkan akan digunakan semata-mata untuk keperluan sertifikasi dan laporan akademik di lingkungan FIKOM UMI. Sistem ini tidak akan menyebarluaskan data Anda kepada pihak ketiga di luar kepentingan kampus.</li>
            </ol>
        </div>
        
        <button onclick="closeTnCModal()" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:14px;font-size:14.5px;border-radius:12px;font-weight:800;">
            Saya Mengerti
        </button>
    </div>
</div>

<style>
.fcc-custom-scroll::-webkit-scrollbar { width:6px; }
.fcc-custom-scroll::-webkit-scrollbar-track { background:rgba(255,255,255,.02); border-radius:10px; }
.fcc-custom-scroll::-webkit-scrollbar-thumb { background:rgba(255,255,255,.1); border-radius:10px; }
.fcc-custom-scroll::-webkit-scrollbar-thumb:hover { background:rgba(255,200,26,.3); }

.otp-box-pub, .otp-box-reset {
    width:50px;height:56px;background:rgba(255,255,255,.04);border:1.5px solid rgba(255,255,255,.1);
    border-radius:12px;text-align:center;font-size:24px;font-weight:900;color:#FFF;
    transition:all .2s;outline:none;
}
.otp-box-pub:focus, .otp-box-reset:focus { border-color:#FFC81A;background:rgba(255,200,26,.05);box-shadow:0 0 0 4px rgba(255,200,26,.1); }
.fcc-radio-pill:checked + .radio-pill-bg {
    background: rgba(255,200,26,.1) !important;
    border-color: #FFC81A !important;
    color: #FFC81A !important;
}
.fcc-radio-pill:focus-visible + .radio-pill-bg {
    box-shadow: 0 0 0 3px rgba(255,200,26,.2);
}
</style>

<script>
(function() {
    const modal = document.getElementById('fcc-auth-modal');
    const dialog = document.getElementById('fcc-auth-dialog');
    const alertBox = document.getElementById('fcc-auth-alert');

    window.openAuthModal = function(tab = 'login', keepAlert = false) {
        window.switchAuthTab(tab);
        const ab = document.getElementById('fcc-auth-alert');
        if (!keepAlert && ab) ab.style.display = 'none';
        const m = document.getElementById('fcc-auth-modal');
        const d = document.getElementById('fcc-auth-dialog');
        if (m) {
            m.style.opacity = '1';
            m.style.pointerEvents = 'auto';
        }
        if (d) d.style.transform = 'scale(1)';
        document.body.style.overflow = 'hidden';
    };

    window.closeAuthModal = function() {
        const m = document.getElementById('fcc-auth-modal');
        const d = document.getElementById('fcc-auth-dialog');
        if (m) {
            m.style.opacity = '0';
            m.style.pointerEvents = 'none';
            m.style.display = 'none';
        }
        if (d) d.style.transform = 'scale(0.92)';
        document.body.style.overflow = '';
    };

    function onDOMReady(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    window.openOtpModal = function(email) {
        window.closeAuthModal();
        const disp = document.getElementById('otpEmailDisplay');
        const inp = document.getElementById('otpEmailInput');
        const m = document.getElementById('otpModal');
        if (disp) disp.innerText = email || '';
        if (inp) inp.value = email || '';
        if (m) {
            m.style.setProperty('display', 'flex', 'important');
            m.style.setProperty('opacity', '1', 'important');
            m.style.setProperty('visibility', 'visible', 'important');
            m.style.setProperty('pointer-events', 'auto', 'important');
            m.style.setProperty('z-index', '999999', 'important');
        }
        document.body.style.overflow = 'hidden';
        setTimeout(function() {
            const boxes = document.querySelectorAll('.otp-box-pub');
            if (boxes.length) {
                boxes.forEach(b => b.value = '');
                boxes[0].focus();
            }
        }, 100);
    };

    window.closeOtpModal = function() {
        const m = document.getElementById('otpModal');
        if (m) {
            m.style.setProperty('display', 'none', 'important');
        }
        document.body.style.overflow = '';
    };

    window.openTnCModal = function() {
        const tnc = document.getElementById('tncModal');
        if (tnc) tnc.style.display = 'flex';
    };

    window.closeTnCModal = function() {
        const tnc = document.getElementById('tncModal');
        if (tnc) tnc.style.display = 'none';
    };

    window.switchAuthTab = function(tab) {
        const ab = document.getElementById('fcc-auth-alert');
        if (ab) ab.style.display = 'none';

        const loginC = document.getElementById('fcc-login-container');
        const regC = document.getElementById('fcc-register-container');
        const forgC = document.getElementById('fcc-forgot-container');

        if (loginC) loginC.style.display = 'none';
        if (regC) regC.style.display = 'none';
        if (forgC) forgC.style.display = 'none';

        if (tab === 'login') {
            if (loginC) loginC.style.display = 'block';
        } else if (tab === 'forgot') {
            if (forgC) forgC.style.display = 'block';
        } else {
            if (regC) regC.style.display = 'block';
        }
    };

    @if(session('require_otp'))
    onDOMReady(function() {
        const email = "{{ session('email') }}";
        if (email) {
            window.openOtpModal(email);
        }
    });
    @elseif(session('open_auth_modal'))
    onDOMReady(function() {
        window.openAuthModal("{{ session('open_auth_modal') }}");
    });
    @endif

    @if($errors->any())
    onDOMReady(function() {
        window.openAuthModal('login', true);
    });
    @endif



    // Submit Auth Form via AJAX
    window.submitAuthForm = function(e, url) {
        e.preventDefault();
        const ab = document.getElementById('fcc-auth-alert');
        if (ab) ab.style.display = 'none';
        
        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn ? submitBtn.innerText : '';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || form.querySelector('input[name="_token"]')?.value;
        
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerText = 'Memproses...';
        }

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken || ''
            }
        })
        .then(async response => {
            let data = {};
            try {
                data = await response.json();
            } catch(e) {}
            if (!response.ok) {
                throw { status: response.status, data: data };
            }
            return data;
        })
        .then(data => {
            if (data.require_otp) {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerText = originalText;
                }
                
                if (url.includes('/lupa-password')) {
                    const disp = document.getElementById('otpResetEmailDisplay');
                    const inp = document.getElementById('otpResetEmailInput');
                    const m = document.getElementById('otpResetModal');
                    if (disp) disp.innerText = data.email;
                    if (inp) inp.value = data.email;
                    if (m) m.style.display = 'flex';
                    const box = document.querySelector('.otp-box-reset');
                    if (box) box.focus();
                } else {
                    window.openOtpModal(data.email);
                }
            } else if (data.success) {
                window.location.href = data.redirect || '/';
            }
        })
        .catch(err => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = originalText;
            }

            if (err && err.data && err.data.require_otp) {
                window.openOtpModal(err.data.email);
                return;
            }
            
            let errMsg = 'Terjadi kesalahan sistem. Silakan coba lagi.';
            if (err && err.status === 429) {
                errMsg = '⚠️ Terlalu banyak percobaan. Silakan tunggu 1 menit sebelum mencoba lagi.';
            } else if (err && err.data && err.data.errors) {
                errMsg = Object.values(err.data.errors).flat().join('<br>');
            } else if (err && err.data && err.data.message) {
                errMsg = err.data.message;
            } else if (err && err.message) {
                errMsg = err.message;
            }
            
            if (ab) {
                ab.innerHTML = errMsg;
                ab.style.display = 'block';
            }
        });
    };
})();

    // Dynamic Premium File Alert Modal
    window.fccShowFileAlert = function(title, message) {
        let alertModal = document.getElementById('fcc-global-file-alert');
        if (!alertModal) {
            alertModal = document.createElement('div');
            alertModal.id = 'fcc-global-file-alert';
            alertModal.style = 'display:none;position:fixed;inset:0;z-index:100000;background:rgba(0,0,0,0.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;font-family:sans-serif;';
            alertModal.innerHTML = `
                <div style="background:#131218;border:1.5px solid rgba(255,200,26,.15);border-radius:20px;padding:32px;max-width:400px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.6);text-align:center;animation:fccModalIn .25s ease;">
                    <div style="width:56px;height:56px;border-radius:16px;background:rgba(239,68,68,.15);border:1.5px solid rgba(239,68,68,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <h3 id="fcc-file-alert-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 8px;font-family:inherit;">Format Tidak Sesuai</h3>
                    <p id="fcc-file-alert-msg" style="color:rgba(255,255,255,.55);font-size:14px;margin:0 0 24px;line-height:1.6;font-family:inherit;"></p>
                    <button onclick="document.getElementById('fcc-global-file-alert').style.display='none'" style="padding:11px 28px;border-radius:12px;border:none;background:linear-gradient(135deg,#FFC81A,#FFD84D);color:#111;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 15px rgba(255,200,26,.3);transition:all .2s;font-family:inherit;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">Mengerti</button>
                </div>
                <style>
                    @keyframes fccModalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
                </style>
            `;
            document.body.appendChild(alertModal);
            
            alertModal.addEventListener('click', function(evt) {
                if (evt.target === this) this.style.display = 'none';
            });
        }
        document.getElementById('fcc-file-alert-title').innerText = title;
        document.getElementById('fcc-file-alert-msg').innerText = message;
        alertModal.style.display = 'flex';
    };

    // Global File Input Change Listener
    document.addEventListener('change', function(e) {
        if (e.target && e.target.type === 'file') {
            const input = e.target;
            if (!input.files || input.files.length === 0) return;
            const file = input.files[0];
            
            // 1. Extension Validation
            const accept = input.getAttribute('accept');
            if (accept) {
                const fileName = file.name.toLowerCase();
                const fileExt = '.' + fileName.split('.').pop();
                let allowed = false;
                const acceptTypes = accept.split(',').map(t => t.trim());
                
                for (let type of acceptTypes) {
                    if (type === 'image/*') {
                        if (['.jpg', '.jpeg', '.png', '.webp', '.gif', '.svg'].includes(fileExt)) {
                            allowed = true;
                            break;
                        }
                    } else if (type.startsWith('.')) {
                        if (type === fileExt) {
                            allowed = true;
                            break;
                        }
                    } else if (type === 'application/pdf') {
                        if (fileExt === '.pdf') {
                            allowed = true;
                            break;
                        }
                    }
                }
                
                if (!allowed) {
                    window.fccShowFileAlert('Ekstensi File Salah', `Format file "${file.name}" tidak didukung. Tipe file yang diperbolehkan: ${accept}`);
                    input.value = '';
                    return;
                }
            }
            
            // 2. Size Validation
            let maxBytes = 2 * 1024 * 1024; // Default 2MB
            let sizeText = '2 MB';
            
            if (input.name === 'file_materi') {
                maxBytes = 20 * 1024 * 1024; // 20MB
                sizeText = '20 MB';
            } else if (input.name === 'bukti_bayar') {
                maxBytes = 5 * 1024 * 1024; // 5MB
                sizeText = '5 MB';
            } else if (input.name === 'berita_acara') {
                maxBytes = 10 * 1024 * 1024; // 10MB
                sizeText = '10 MB';
            }
            
            if (file.size > maxBytes) {
                window.fccShowFileAlert('Ukuran File Terlalu Besar', `Ukuran file "${file.name}" melebihi batas maksimal yang diperbolehkan (${sizeText}).`);
                input.value = '';
                return;
            }
        }
    });
    // OTP Input Logic
    const otpBoxesPub = document.querySelectorAll('.otp-box-pub');
    otpBoxesPub.forEach((box, i) => {
        box.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value && i < otpBoxesPub.length - 1) otpBoxesPub[i + 1].focus();
        });
        box.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && i > 0) {
                otpBoxesPub[i - 1].focus();
            }
        });
    });

    const otpFormEl = document.getElementById('otpForm');
    if(otpFormEl) {
        otpFormEl.addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnVerify');
            const oriText = btn.innerHTML;
            
            let otp = '';
            otpBoxesPub.forEach(b => otp += b.value);
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
                    window.location.href = data.redirect || '/';
                } else if (data.errors) {
                    document.getElementById('otpError').innerText = data.errors.otp ? data.errors.otp[0] : 'Kode tidak valid.';
                    document.getElementById('otpError').style.display = 'block';
                    otpBoxesPub.forEach(b => b.value = '');
                    otpBoxesPub[0].focus();
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
    // OTP Reset Password Logic
    const otpBoxesReset = document.querySelectorAll('.otp-box-reset');
    otpBoxesReset.forEach((box, i) => {
        box.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value && i < otpBoxesReset.length - 1) otpBoxesReset[i + 1].focus();
        });
        box.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && i > 0) {
                otpBoxesReset[i - 1].focus();
            }
        });
    });

    const otpResetFormEl = document.getElementById('otpResetForm');
    if(otpResetFormEl) {
        otpResetFormEl.addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnResetVerify');
            const oriText = btn.innerHTML;
            
            let otp = '';
            otpBoxesReset.forEach(b => otp += b.value);
            document.getElementById('finalResetOtp').value = otp;
            
            if (otp.length < 4) return;

            btn.innerHTML = 'Menyimpan...';
            btn.disabled = true;
            document.getElementById('otpResetError').style.display = 'none';

            try {
                const formData = new FormData(this);
                const res = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                const data = await res.json();
                
                if (data.success) {
                    window.location.href = data.redirect || '/';
                } else if (data.errors) {
                    document.getElementById('otpResetError').innerText = data.errors.otp ? data.errors.otp[0] : (data.errors.password ? data.errors.password[0] : 'Data tidak valid.');
                    document.getElementById('otpResetError').style.display = 'block';
                    if (data.errors.otp) {
                        otpBoxesReset.forEach(b => b.value = '');
                        otpBoxesReset[0].focus();
                    }
                }
            } catch (err) {
                document.getElementById('otpResetError').innerText = 'Terjadi kesalahan jaringan.';
                document.getElementById('otpResetError').style.display = 'block';
            } finally {
                btn.innerHTML = oriText;
                btn.disabled = false;
            }
        });
    }
});
</script>

{{-- ══ Top Gold Progress Bar Indicator & Instant Prefetcher ══ --}}
<div id="fcc-top-bar" style="position:fixed; top:0; left:0; width:0%; height:3px; background:#FFC81A; z-index:99999; transition:width 0.25s ease, opacity 0.3s ease; opacity:0; pointer-events:none; box-shadow:0 0 10px #FFC81A, 0 0 5px #FFC81A;"></div>

<script>
(window.requestIdleCallback||setTimeout)(function(){
(function() {
    'use strict';
    
    // 1. Instant Hover Prefetching
    const prefetched = new Set();
    function prefetchUrl(url) {
        if (!url || prefetched.has(url)) return;
        if (url.startsWith('#') || url.startsWith('javascript:')) return;
        try {
            const parsed = new URL(url, window.location.origin);
            if (parsed.origin !== window.location.origin) return;
            prefetched.add(url);
            const link = document.createElement('link');
            link.rel = 'prefetch';
            link.href = url;
            document.head.appendChild(link);
        } catch(e) {}
    }

    document.addEventListener('mouseover', function(e) {
        const anchor = e.target.closest('a');
        if (anchor && anchor.href && !anchor.target && !anchor.hasAttribute('download') && !anchor.href.includes('/download') && !anchor.href.includes('/unduh')) {
            prefetchUrl(anchor.href);
        }
    }, { passive: true });

    document.addEventListener('touchstart', function(e) {
        const anchor = e.target.closest('a');
        if (anchor && anchor.href && !anchor.target && !anchor.hasAttribute('download') && !anchor.href.includes('/download') && !anchor.href.includes('/unduh')) {
            prefetchUrl(anchor.href);
        }
    }, { passive: true });

    // 2. Top Progress Loading Bar Trigger
    const bar = document.getElementById('fcc-top-bar');
    function startTopBar() {
        if (!bar) return;
        bar.style.opacity = '1';
        bar.style.width = '30%';
        setTimeout(() => { if (bar.style.opacity === '1') bar.style.width = '70%'; }, 150);
        setTimeout(() => { if (bar.style.opacity === '1') bar.style.width = '90%'; }, 400);
    }

    document.addEventListener('click', function(e) {
        const anchor = e.target.closest('a');
        if (anchor && anchor.href && !anchor.target && !anchor.href.includes('#') && !anchor.hasAttribute('download') && !anchor.href.includes('/download') && !anchor.href.includes('/unduh') && anchor.origin === window.location.origin) {
            startTopBar();
        }
    });

    window.addEventListener('pageshow', function() {
        if (!bar) return;
        bar.style.width = '100%';
        setTimeout(() => {
            bar.style.opacity = '0';
            setTimeout(() => { bar.style.width = '0%'; }, 300);
        }, 150);
    });
});
});
</script>

@include('components.fcc-modal')
@endsection

{{-- JS Navbar dimuat via resources/js/components/navbar.js (diimport app.js) --}}


