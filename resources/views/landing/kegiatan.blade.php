@extends('layouts.public')
@section('title','Kegiatan')
@section('page-content')
<div style="padding-top:68px; background:linear-gradient(180deg, #131218 0%, #0e0d14 120px, #0e0d14 100%); min-height: calc(100vh - 68px);">
    {{-- Page Header --}}
    <div style="background: #131218; padding: 76px 24px 64px; text-align: center; position: relative; overflow: hidden; border-bottom: none;">
        <!-- Glow effects -->
        <div style="position: absolute; top: -50%; left: -20%; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(255, 200, 26, 0.06), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; bottom: -50%; right: -20%; width: 450px; height: 450px; border-radius: 50%; background: radial-gradient(circle, rgba(59, 130, 246, 0.04), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; inset: 0; opacity: .03; background-image: linear-gradient(rgba(255, 200, 26, 1) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 200, 26, 1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <div style="position: relative; z-index: 1; max-width: 800px; margin: 0 auto;">
            <a href="{{ route('landing.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.5);font-size:13px;text-decoration:none;margin-bottom:20px;transition:all 0.2s;" onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='rgba(255,255,255,.5)'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg> Kembali ke Beranda
            </a>
            <h1 style="color: #FFF; font-size: clamp(30px, 5.5vw, 48px); font-weight: 900; margin: 0 0 16px; letter-spacing: -1.2px; line-height: 1.15;">
                Kegiatan <span class="fcc-gold-text">FCC UMI</span>
            </h1>
            <p style="color: rgba(255, 255, 255, 0.55); font-size: 16px; margin: 0; line-height: 1.6; font-weight: 500; max-width: 520px; margin: 0 auto;">
                Seluruh daftar program pelatihan kompetensi & sertifikasi profesi FIKOM UMI yang tersedia.
            </p>
        </div>
    </div>

    {{-- Livewire Search & Filter Component --}}
    @livewire('landing.search-kegiatan')
</div>

<style>
/* Temporary style override for pagination to look good on dark background */
.fcc-pagination-dark nav { display: flex; align-items: center; justify-content: center; }
.fcc-pagination-dark nav svg { width: 20px; height: 20px; }
.fcc-pagination-dark nav a, .fcc-pagination-dark nav span.relative { background: rgba(255,255,255,.03) !important; border: 1px solid rgba(255,255,255,.08) !important; color: #FFF !important; margin: 0 4px; border-radius: 8px !important; box-shadow: none !important; }
.fcc-pagination-dark nav span[aria-current="page"] span { background: #FFC81A !important; color: #131218 !important; border-color: #FFC81A !important; }
.fcc-pagination-dark nav a:hover { background: rgba(255,255,255,.1) !important; border-color: rgba(255,255,255,.15) !important; }
</style>
@endsection
