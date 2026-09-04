@extends('layouts.app')
@section('content')
<style>
    .fcc-peserta-layout {
        display: flex;
        height: 100vh;
        overflow: hidden;
        background: #F7F8FA;
        font-family: 'Inter', sans-serif;
        position: relative;
    }
    .fcc-peserta-sidebar {
        width: 260px;
        min-width: 260px;
        height: 100vh;
        overflow: hidden;
        background: #131218;
        border-right: 1px solid rgba(255,200,26,.14);
        display: flex;
        flex-direction: column;
        transition: width .26s cubic-bezier(.4,0,.2,1), min-width .26s cubic-bezier(.4,0,.2,1), transform .26s cubic-bezier(.4,0,.2,1);
        z-index: 1000;
        flex-shrink: 0;
    }
    /* Desktop Collapsed Sidebar */
    .fcc-peserta-sidebar.collapsed {
        width: 68px !important;
        min-width: 68px !important;
    }
    .fcc-peserta-sidebar.collapsed #sb-title,
    .fcc-peserta-sidebar.collapsed #sb-profile,
    .fcc-peserta-sidebar.collapsed .sidebar-link span:not(.fcc-badge) {
        display: none !important;
    }
    .fcc-peserta-sidebar.collapsed .sidebar-link {
        justify-content: center !important;
        padding: 12px 0 !important;
    }

    .fcc-peserta-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        min-width: 0;
        width: 100%;
    }
    .fcc-peserta-header {
        height: 62px;
        background: #FFF;
        border-bottom: 1px solid #E0E2E8;
        display: flex;
        align-items: center;
        padding: 0 22px;
        gap: 14px;
        flex-shrink: 0;
        box-shadow: 0 1px 0 #E0E2E8;
    }
    .fcc-peserta-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(19, 18, 24, 0.65);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 999;
        transition: opacity 0.25s ease;
    }
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 18px;
        color: #94A3B8;
        transition: all .2s;
    }
    .sidebar-link:hover, .sidebar-link.active {
        background: rgba(255,200,26,.12);
        color: #FFC81A;
        border-left: 3px solid #FFC81A;
    }
    .sidebar-link.active span {
        color: #FFF;
    }

    /* Mobile & Tablet (< 1024px) */
    /* sm:show helper */
    .fcc-sm-show { display: none !important; }
    .fcc-sidebar-mobile-close { display: none !important; }

    @media (max-width: 1023px) {
        .fcc-sidebar-mobile-close { display: flex !important; }
        .fcc-peserta-sidebar {
            position: fixed !important;
            top: 0;
            bottom: 0;
            left: 0;
            height: 100dvh !important;
            max-height: 100vh !important;
            width: 260px !important;
            min-width: 260px !important;
            transform: translateX(-100%) !important;
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
        }
        .fcc-peserta-sidebar .sb-header-block {
            padding: 12px 14px !important;
        }
        .fcc-peserta-sidebar #sb-profile {
            padding: 10px 14px !important;
        }
        .fcc-peserta-sidebar .sidebar-link {
            padding: 8px 14px !important;
        }
        .fcc-peserta-sidebar .sb-bottom-block {
            padding: 6px 0 !important;
        }
        .fcc-peserta-sidebar.mobile-open {
            transform: translateX(0) !important;
        }
        .fcc-peserta-backdrop.mobile-open {
            display: block !important;
        }
        .fcc-peserta-header {
            padding: 0 14px !important;
            gap: 10px !important;
        }
    }

    @media (min-width: 600px) {
        .fcc-sm-show { display: block !important; }
    }
    @media (max-width: 599px) {
        .fcc-topbar-profile-btn {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            box-shadow: none !important;
        }
        .fcc-topbar-profile-icon {
            width: 36px !important;
            height: 36px !important;
            border-radius: 10px !important;
        }
    }
</style>

<div class="fcc-peserta-layout">
    {{-- MOBILE BACKDROP OVERLAY --}}
    <div id="sidebar-backdrop" class="fcc-peserta-backdrop" onclick="closeSidebarMobile()"></div>

    {{-- SIDEBAR --}}
    <div id="sidebar" class="fcc-peserta-sidebar">
        {{-- Logo --}}
        <div class="sb-header-block" style="padding:16px 18px;border-bottom:1px solid rgba(255,200,26,.14);
            display:flex;align-items:center;gap:12px;flex-shrink:0;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo FCC UMI" style="height:38px;width:auto;object-fit:contain;flex-shrink:0;">
            <div id="sb-title">
                <p style="margin:0;color:#FFF;font-weight:900;font-size:13px;">Portal Peserta</p>
                <p style="margin:0;color:#FFC81A;font-size:9px;letter-spacing:2px;text-transform:uppercase;">Certification Center</p>
            </div>
            {{-- Mobile Close Button (Hanya tampil di mobile/tablet < 1024px) --}}
            <button type="button" data-close-sidebar class="fcc-sidebar-mobile-close" style="margin-left:auto;background:none;border:none;color:#FFF;cursor:pointer;padding:6px;align-items:center;border-radius:8px;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='none'" title="Tutup Sidebar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        {{-- Profile mini --}}
        <div id="sb-profile" style="padding:14px 18px;border-bottom:1px solid rgba(255,200,26,.1);display:flex;align-items:center;gap:10px;">
            <div style="width:34px;height:34px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center;overflow:hidden;border:1px solid #FFC81A;">
                @if(auth('peserta')->user()?->foto)
                <img src="{{ asset('storage/'.auth('peserta')->user()->foto) }}" alt="Foto" style="width:100%;height:100%;object-fit:cover;">
                @else
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                @endif
            </div>
            <div>
                <p style="margin:0;color:#FFF;font-size:13px;font-weight:700;">{{ auth('peserta')->user()->nama ?? 'Peserta' }}</p>
                <p style="margin:0;color:#888;font-size:10px;">{{ auth('peserta')->user()->email ?? '' }}</p>
            </div>
        </div>
        {{-- Nav --}}
        <nav style="flex:1;padding:10px 0;overflow-y:auto;overflow-x:hidden;">
            @php
            $pesertaMenu = [
                ['route'=>'peserta.dashboard',    'icon'=>'layout-dashboard', 'label'=>'Dashboard'],
                ['route'=>'peserta.jelajahi',     'icon'=>'search',           'label'=>'Jelajahi Kegiatan'],
                ['route'=>'peserta.pendaftaran',  'icon'=>'clipboard-list',   'label'=>'Pendaftaran Saya'],
                ['route'=>'peserta.pembayaran',   'icon'=>'credit-card',      'label'=>'Pembayaran'],
                ['route'=>'peserta.sertifikat',   'icon'=>'award',            'label'=>'Sertifikat Saya'],
                ['route'=>'peserta.testimoni',    'icon'=>'message-square',   'label'=>'Beri Testimoni'],
            ];
            $unpaidCount = auth('peserta')->check()
                ? \App\Models\Pembayaran::whereHas('pendaftaran', function($q) {
                    $q->where('peserta_id', auth('peserta')->id());
                })->where('status_pembayaran', 'menunggu_pembayaran')->count()
                : 0;
            @endphp
            @foreach($pesertaMenu as $item)
            @php $isActive = request()->routeIs($item['route'].'*'); @endphp
            <a href="{{ route($item['route']) }}"
               class="sidebar-link {{ $isActive ? 'active' : '' }}"
               style="text-decoration:none;">
                @include('components.icon', ['name'=>$item['icon'], 'size'=>18, 'class'=>'sidebar-icon'])
                <span id="sb-lbl-{{ $loop->index }}" style="font-size:14px;font-weight:{{ $isActive ? '700' : '500' }};">{{ $item['label'] }}</span>
                @if($item['route'] === 'peserta.pembayaran' && $unpaidCount > 0)
                <span id="sb-badge-bayar" class="fcc-badge" style="background:#EF4444;color:#FFF;font-size:10px;font-weight:700;padding:1px 7px;border-radius:10px;margin-left:auto;">{{ $unpaidCount }}</span>
                @endif
            </a>
            @endforeach
        </nav>
        {{-- Bottom --}}
        <div class="sb-bottom-block" style="border-top:1px solid rgba(255,200,26,.14);padding:8px 0;flex-shrink:0;">
            <a href="{{ route('landing.index') }}" class="sidebar-link" style="text-decoration:none;">
                @include('components.icon', ['name'=>'home', 'size'=>17, 'class'=>'sidebar-icon'])
                <span id="sb-lbl-home" style="font-size:14px;font-weight:500;">Beranda</span>
            </a>
            <form action="{{ route('auth.logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="sidebar-link" style="width:100%;border:none;background:none;cursor:pointer;text-align:left;"
                    onmouseover="this.style.background='rgba(239,68,68,.1)'" onmouseout="this.style.background='transparent'">
                    @include('components.icon', ['name'=>'log-out', 'size'=>17, 'class'=>'', 'style'=>'color:#EF4444'])
                    <span id="sb-lbl-logout" style="font-size:14px;font-weight:500;color:#EF4444;">Keluar</span>
                </button>
            </form>
        </div>
    </div>

    {{-- MAIN CONTENT WRAPPER --}}
    <div class="fcc-peserta-main">
        {{-- HEADER --}}
        <header class="fcc-peserta-header">
            <button id="sb-toggle" type="button" onclick="toggleSidebar()"
                style="background:none;border:1px solid #E2E4EB;color:#6B7280;padding:7px 9px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .18s;"
                onmouseover="this.style.borderColor='#FFC81A';this.style.color='#FFC81A'"
                onmouseout="this.style.borderColor='#E0E2E8';this.style.color='#6B7280'">
                <svg id="sb-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <p style="margin:0;color:#0F0F14;font-size:15px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">@yield('page-title', 'Dashboard')</p>
            <div style="flex:1;"></div>
            <a href="{{ route('peserta.profile') }}" class="fcc-topbar-profile-btn"
               style="display:flex;align-items:center;gap:8px;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:12px;padding:4px 10px 4px 4px;text-decoration:none;transition:all .18s;flex-shrink:0;"
               onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
                <div class="fcc-topbar-profile-icon" style="width:32px;height:32px;border-radius:9px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 6px rgba(19,18,24,0.15);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" class="fcc-sm-show">
                    <p style="margin:0;font-size:12px;font-weight:800;color:#131218;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ auth('peserta')->user()->nama ?? 'Peserta' }}</p>
                    <p style="margin:0;font-size:9.5px;color:#64748B;font-weight:700;">Peserta</p>
                </div>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="2.5" class="fcc-sm-show"><polyline points="6 9 12 15 18 9"/></svg>
            </a>
        </header>

        {{-- Content Area --}}
        <main style="flex:1;overflow:auto;background:#F7F8FA;">
            @if(session('success'))
            <div style="margin:16px 24px 0;padding:12px 16px;background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);border-radius:10px;color:#10B981;font-size:13px;font-weight:600;">
                {{ session('success') }}
            </div>
            @endif
            @yield('page-content')
        </main>
    </div>
</div>
@include('components.fcc-modal')
@stack('modals')
@endsection

@push('scripts')
<script>
(function () {
    var sidebar  = document.getElementById('sidebar');
    var backdrop = document.getElementById('sidebar-backdrop');
    var toggle   = document.getElementById('sb-toggle');

    function isMobile() { return window.innerWidth < 1024; }

    function openDrawer() {
        if (sidebar)  sidebar.classList.add('mobile-open');
        if (backdrop) backdrop.classList.add('mobile-open');
    }
    function closeDrawer() {
        if (sidebar)  sidebar.classList.remove('mobile-open');
        if (backdrop) backdrop.classList.remove('mobile-open');
    }

    if (toggle) {
        toggle.addEventListener('click', function () {
            if (isMobile()) {
                sidebar && sidebar.classList.contains('mobile-open') ? closeDrawer() : openDrawer();
            } else {
                if (sidebar) sidebar.classList.toggle('collapsed');
            }
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeDrawer);
    }

    document.querySelectorAll('[data-close-sidebar]').forEach(function (btn) {
        btn.addEventListener('click', closeDrawer);
    });

    window.addEventListener('resize', function () {
        if (!isMobile()) closeDrawer();
    });

    // Expose for any remaining inline onclick attributes
    window.toggleSidebar      = function () { toggle && toggle.click(); };
    window.closeSidebarMobile = closeDrawer;
})();
</script>
@endpush

