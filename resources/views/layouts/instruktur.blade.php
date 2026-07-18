@extends('layouts.app')
@section('content')
<div style="display:flex;height:100vh;overflow:hidden;background:#F7F8FA;font-family:'Inter',sans-serif;">
    {{-- SIDEBAR --}}
    <div id="sidebar" style="width:260px;min-width:260px;height:100vh;overflow:hidden;
        background:#131218;border-right:1px solid rgba(255,200,26,.14);
        display:flex;flex-direction:column;
        transition:width .26s cubic-bezier(.4,0,.2,1),min-width .26s cubic-bezier(.4,0,.2,1);
        z-index:100;flex-shrink:0;">
        {{-- Logo --}}
        <div style="padding:20px 18px;border-bottom:1px solid rgba(255,200,26,.14);
            display:flex;align-items:center;gap:12px;flex-shrink:0;">
            <div style="width:38px;height:38px;border-radius:11px;flex-shrink:0;
                background:linear-gradient(135deg,#FFC81A,#FFD84D);
                display:flex;align-items:center;justify-content:center;
                box-shadow:0 0 16px rgba(255,200,26,.25);">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div id="sb-title">
                <p style="margin:0;color:#FFF;font-weight:900;font-size:13px;">Portal Instruktur</p>
                <p style="margin:0;color:#FFC81A;font-size:9px;letter-spacing:2px;text-transform:uppercase;">Certification Center</p>
            </div>
        </div>
        {{-- Profile mini --}}
        <div id="sb-profile" style="padding:14px 18px;border-bottom:1px solid rgba(255,200,26,.1);display:flex;align-items:center;gap:10px;">
            <div style="width:34px;height:34px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <p style="margin:0;color:#FFF;font-size:13px;font-weight:700;">{{ auth('instruktur')->user()->nama ?? 'Instruktur' }}</p>
                <p style="margin:0;color:#888;font-size:10px;">{{ auth('instruktur')->user()->email ?? '' }}</p>
            </div>
        </div>
        {{-- Nav --}}
        <nav style="flex:1;padding:10px 0;overflow-y:auto;overflow-x:hidden;">
            @php
            $instrukturMenu = [
                ['route'=>'instruktur.dashboard', 'icon'=>'layout-dashboard', 'label'=>'Dashboard'],
            ];
            @endphp
            @foreach($instrukturMenu as $item)
            @php $isActive = request()->routeIs($item['route'].'*'); @endphp
            <a href="{{ route($item['route']) }}"
               class="sidebar-link {{ $isActive ? 'active' : '' }}"
               style="text-decoration:none;">
                @include('components.icon', ['name'=>$item['icon'], 'size'=>18, 'class'=>'sidebar-icon'])
                <span style="font-size:14px;font-weight:{{ $isActive ? '700' : '500' }};">{{ $item['label'] }}</span>
            </a>
            @endforeach
        </nav>
        {{-- Bottom --}}
        <div style="border-top:1px solid rgba(255,200,26,.14);padding:10px 0;flex-shrink:0;">
            <a href="{{ route('landing.index') }}" class="sidebar-link" style="text-decoration:none;">
                @include('components.icon', ['name'=>'home', 'size'=>17, 'class'=>'sidebar-icon'])
                <span style="font-size:14px;font-weight:500;">Beranda</span>
            </a>
            <form action="{{ route('auth.logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="sidebar-link" style="width:100%;border:none;background:none;cursor:pointer;text-align:left;"
                    onmouseover="this.style.background='rgba(239,68,68,.1)'" onmouseout="this.style.background='transparent'">
                    @include('components.icon', ['name'=>'log-out', 'size'=>17, 'class'=>'', 'style'=>'color:#EF4444'])
                    <span style="font-size:14px;font-weight:500;color:#EF4444;">Keluar</span>
                </button>
            </form>
        </div>
    </div>
    {{-- MAIN --}}
    <div style="flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0;">
        {{-- HEADER --}}
        <header style="height:62px;background:#FFF;border-bottom:1px solid #E0E2E8;
            display:flex;align-items:center;padding:0 22px;gap:14px;flex-shrink:0;box-shadow:0 1px 0 #E0E2E8;">
            <p style="margin:0;color:#0F0F14;font-size:15px;font-weight:700;">@yield('page-title', 'Dashboard')</p>
        </header>
        {{-- Content --}}
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
@endsection
