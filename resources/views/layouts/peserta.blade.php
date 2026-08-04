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
            <img src="{{ asset('images/logo.png') }}" alt="Logo FCC UMI" style="height:38px;width:auto;object-fit:contain;flex-shrink:0;">
            <div id="sb-title">
                <p style="margin:0;color:#FFF;font-weight:900;font-size:13px;">Portal Peserta</p>
                <p style="margin:0;color:#FFC81A;font-size:9px;letter-spacing:2px;text-transform:uppercase;">Certification Center</p>
            </div>
        </div>
        {{-- Profile mini --}}
        <div id="sb-profile" style="padding:14px 18px;border-bottom:1px solid rgba(255,200,26,.1);display:flex;align-items:center;gap:10px;">
            <div style="width:34px;height:34px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
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
                ['route'=>'peserta.sertifikat',   'icon'=>'file-text',        'label'=>'Sertifikat Saya'],
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
                <span id="sb-badge-bayar" style="background:#EF4444;color:#FFF;font-size:10px;font-weight:700;padding:1px 7px;border-radius:10px;margin-left:auto;">{{ $unpaidCount }}</span>
                @endif
            </a>
            @endforeach
        </nav>
        {{-- Bottom --}}
        <div style="border-top:1px solid rgba(255,200,26,.14);padding:10px 0;flex-shrink:0;">
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
    {{-- MAIN --}}
    <div style="flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0;">
        {{-- HEADER --}}
        <header style="height:62px;background:#FFF;border-bottom:1px solid #E0E2E8;
            display:flex;align-items:center;padding:0 22px;gap:14px;flex-shrink:0;box-shadow:0 1px 0 #E0E2E8;">
            <button id="sb-toggle" onclick="toggleSidebar()"
                style="background:none;border:1px solid #E2E4EB;color:#6B7280;padding:7px 9px;border-radius:8px;display:flex;cursor:pointer;transition:all .18s;"
                onmouseover="this.style.borderColor='#FFC81A';this.style.color='#FFC81A'"
                onmouseout="this.style.borderColor='#E0E2E8';this.style.color='#6B7280'">
                <svg id="sb-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <p style="margin:0;color:#0F0F14;font-size:15px;font-weight:700;">@yield('page-title', 'Dashboard')</p>
            <div style="flex:1;"></div>
            <a href="{{ route('peserta.profile') }}"
               style="display:flex;align-items:center;gap:10px;background:#F7F8FA;border:1px solid #E2E4EB;
                    border-radius:10px;padding:5px 12px 5px 5px;text-decoration:none;transition:border-color .18s;"
               onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E0E2E8'">
                <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <p style="margin:0;font-size:13px;font-weight:700;color:#0F0F14;">{{ auth('peserta')->user()->nama ?? 'Peserta' }}</p>
                    <p style="margin:0;font-size:10px;color:#FFC81A;">Peserta</p>
                </div>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#A0A3AD" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </a>
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
@include('components.fcc-modal')
@endsection

@push('scripts')
<script>
let collapsed = false;
function toggleSidebar() {
    collapsed = !collapsed;
    const sb = document.getElementById('sidebar');
    const title = document.getElementById('sb-title');
    const profile = document.getElementById('sb-profile');
    sb.style.width = collapsed ? '64px' : '260px';
    sb.style.minWidth = collapsed ? '64px' : '260px';
    title.style.display = collapsed ? 'none' : 'block';
    profile.style.display = collapsed ? 'none' : 'flex';
    document.querySelectorAll('[id^="sb-lbl-"]').forEach(el => el.style.display = collapsed ? 'none' : 'block');
    document.querySelectorAll('[id^="sb-badge-"]').forEach(el => el.style.display = collapsed ? 'none' : 'inline-block');
}
</script>
@endpush
