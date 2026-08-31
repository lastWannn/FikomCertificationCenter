@extends('layouts.public')
@section('title','Program Pelatihan & Sertifikasi')
@section('meta-description', 'Jelajahi program pelatihan dan sertifikasi kompetensi teknologi informasi berstandar BNSP dan industri di FIKOM Certification Center UMI Makassar.')
@section('page-content')
<div class="page-content-wrap" style="background:#131218; min-height: calc(100vh - 100px);">
    {{-- Page Header --}}
    <div class="fcc-kegiatan-hero">
        <!-- Ambient Glow -->
        <div style="position: absolute; top: -50%; left: -20%; width: 400px; height: 400px; max-width: 100vw; border-radius: 50%; background: radial-gradient(circle, rgba(255, 200, 26, 0.08), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; bottom: -50%; right: -20%; width: 450px; height: 450px; max-width: 100vw; border-radius: 50%; background: radial-gradient(circle, rgba(255, 200, 26, 0.05), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; inset: 0; opacity: .03; background-image: linear-gradient(rgba(255, 200, 26, 1) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 200, 26, 1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <div style="position: relative; z-index: 1; max-width: 740px; margin: 0 auto; width: 100%; box-sizing: border-box;">
            <span style="display:inline-block; padding:5px 16px; background:#FFC81A; color:#131218; font-size:10.5px; font-weight:900; text-transform:uppercase; letter-spacing:1.5px; margin-bottom:12px; border-radius:100px; border:1.5px solid #131218; box-shadow:0 4px 12px rgba(255, 200, 26, 0.25);">
                Program Unggulan
            </span>
            <h1 style="color: #FFFFFF; font-size: clamp(24px, 4.5vw, 40px); font-weight: 900; margin: 0 0 10px; letter-spacing: -0.6px; line-height: 1.15;">
                Kegiatan <span style="color: #FFC81A;">FCC UMI</span>
            </h1>
            <p style="color: rgba(255, 255, 255, 0.8); font-size: clamp(13.5px, 1.4vw, 15px); margin: 0 auto; line-height: 1.55; font-weight: 500; max-width: 500px;">
                Daftar lengkap program pelatihan kompetensi &amp; sertifikasi profesi FIKOM UMI.
            </p>
        </div>
    </div>

    {{-- Livewire Search & Filter Component --}}
    @livewire('landing.search-kegiatan')
</div>

<style>
.fcc-kegiatan-hero {
    background: #131218;
    padding: 44px 24px 38px;
    text-align: center;
    position: relative;
    overflow: hidden;
    border-bottom: 1px solid #1E1D26;
    box-sizing: border-box;
    width: 100%;
}
@media (max-width: 767px) {
    .fcc-kegiatan-hero {
        padding: 30px 16px 28px !important;
    }
}
.fcc-pagination-light nav { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 6px; }
.fcc-pagination-light nav svg { width: 18px; height: 18px; }
.fcc-pagination-light nav a, .fcc-pagination-light nav span.relative { background: #FFFFFF !important; border: 1.5px solid #CBD5E1 !important; color: #131218 !important; margin: 0 2px; border-radius: 8px !important; box-shadow: none !important; font-weight: 700 !important; }
.fcc-pagination-light nav span[aria-current="page"] span { background: #FFC81A !important; color: #131218 !important; border-color: #131218 !important; font-weight: 900 !important; }
.fcc-pagination-light nav a:hover { background: #FFC81A !important; color: #131218 !important; border-color: #131218 !important; }
</style>
@endsection
