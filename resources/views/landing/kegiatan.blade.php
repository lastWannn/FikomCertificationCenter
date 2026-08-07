@extends('layouts.public')
@section('title','Kegiatan')
@section('page-content')
<div style="padding-top:64px; background:#131218; min-height: calc(100vh - 64px);">
    {{-- Page Header --}}
    <div style="background: #131218; padding: 48px 24px 38px; text-align: center; position: relative; overflow: hidden; border-bottom: 1px solid #1E1D26;">
        <!-- Ambient Glow -->
        <div style="position: absolute; top: -50%; left: -20%; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(255, 200, 26, 0.08), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; bottom: -50%; right: -20%; width: 450px; height: 450px; border-radius: 50%; background: radial-gradient(circle, rgba(255, 200, 26, 0.05), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; inset: 0; opacity: .03; background-image: linear-gradient(rgba(255, 200, 26, 1) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 200, 26, 1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <div style="position: relative; z-index: 1; max-width: 740px; margin: 0 auto;">
            <h1 style="color: #FFFFFF; font-size: clamp(26px, 4.5vw, 40px); font-weight: 900; margin: 0 0 10px; letter-spacing: -0.8px; line-height: 1.15;">
                Kegiatan <span style="color: #FFC81A;">FCC UMI</span>
            </h1>
            <p style="color: rgba(255, 255, 255, 0.8); font-size: 14.5px; margin: 0 auto; line-height: 1.55; font-weight: 500; max-width: 500px;">
                Daftar lengkap program pelatihan kompetensi &amp; sertifikasi profesi FIKOM UMI.
            </p>
        </div>
    </div>

    {{-- Livewire Search & Filter Component --}}
    @livewire('landing.search-kegiatan')
</div>

<style>
.fcc-pagination-dark nav { display: flex; align-items: center; justify-content: center; }
.fcc-pagination-dark nav svg { width: 18px; height: 18px; }
.fcc-pagination-dark nav a, .fcc-pagination-dark nav span.relative { background: #1E1D26 !important; border: 1.5px solid rgba(255,200,26,0.25) !important; color: #FFF !important; margin: 0 4px; border-radius: 8px !important; box-shadow: none !important; }
.fcc-pagination-dark nav span[aria-current="page"] span { background: #FFC81A !important; color: #131218 !important; border-color: #FFC81A !important; font-weight: 900 !important; }
.fcc-pagination-dark nav a:hover { background: #FFC81A !important; color: #131218 !important; border-color: #FFC81A !important; }
</style>
@endsection
