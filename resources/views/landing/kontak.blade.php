@extends('layouts.public')
@section('title', 'Hubungi Kami')
@section('meta-description', 'Hubungi FIKOM Certification Center UMI Makassar. Informasi kontak sekretariat, telepon, WhatsApp, email resmi, dan formulir pesan langsung.')
@section('page-content')
<div class="page-content-wrap" style="background:#131218; min-height: calc(100vh - 100px);">
    
    {{-- ═══ HERO HEADER ═════════════════════════════════════════════════════════════ --}}
    <div class="fcc-kontak-hero">
        <!-- Subtle Glow -->
        <div style="position:absolute; top:-50%; left:50%; transform:translateX(-50%); width:600px; height:600px; max-width:100vw; border-radius:50%; background:radial-gradient(circle, rgba(255,200,26,0.07), transparent 70%); pointer-events:none;"></div>
        
        <div style="max-width:800px; margin:0 auto; position:relative; z-index:1;">
            <div style="display:inline-block; font-size:10.5px; font-weight:900; padding:5px 16px; border-radius:100px; text-transform:uppercase; letter-spacing:1.5px; background:#FFC81A; color:#131218; margin-bottom:14px; box-shadow:0 4px 12px rgba(255,200,26,0.25);">
                HUBUNGI KAMI
            </div>
            
            <h1 style="font-size:clamp(24px, 4.5vw, 40px); font-weight:900; color:#FFFFFF; margin:0 0 12px; line-height:1.2; letter-spacing:-0.5px;">
                Layanan Informasi &amp; Bantuan
            </h1>
            
            <p style="color:rgba(255,255,255,0.75); font-size:clamp(13.5px, 1.4vw, 15px); margin:0 auto; max-width:640px; line-height:1.6; font-weight:500;">
                Ada pertanyaan seputar jadwal pelatihan, ujian sertifikasi, atau kendala pendaftaran? Tim sekretariat FCC FIKOM UMI siap membantu Anda.
            </p>
        </div>
    </div>

    {{-- ═══ MAIN CONTENT GRID ══════════════════════════════════════════════════════ --}}
    <div class="fcc-kontak-section">
        <div style="max-width:1180px; margin:0 auto; width:100%;">
            
            @if(session('success'))
            <div style="padding:14px 18px; background:rgba(16,185,129,0.12); border:1.5px solid #10B981; border-radius:14px; color:#065F46; font-size:14px; font-weight:800; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
                @include('components.icon',['name'=>'check-circle','size'=>18,'style'=>'color:#10B981;flex-shrink:0;'])
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <div class="fcc-kontak-grid">
                
                {{-- LEFT COLUMN: Contact Form Card --}}
                <div class="fcc-kontak-card">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:24px;">
                        <div style="width:4px; height:22px; background:#FFC81A; border-radius:2px; flex-shrink:0;"></div>
                        <h2 style="font-size:18px; font-weight:900; color:#0F172A; margin:0; letter-spacing:-0.4px;">
                            Kirim Pesan Langsung
                        </h2>
                    </div>

                    <form action="{{ route('landing.kontak.post') }}" method="POST">
                        @csrf
                        
                        {{-- Nama Lengkap --}}
                        <div style="margin-bottom:18px;">
                            <label style="display:block; font-size:11.5px; font-weight:900; color:#1E293B; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.8px;">
                                Nama Lengkap *
                            </label>
                            <div style="position:relative;">
                                @include('components.icon',['name'=>'user','size'=>16,'style'=>'position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#64748B; pointer-events:none;'])
                                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap Anda" required 
                                       style="width:100%; box-sizing:border-box; background:#FFFFFF; border:1.5px solid #CBD5E1; border-radius:12px; padding:11px 14px 11px 40px; color:#0F172A; font-size:13.5px; outline:none; transition:all 0.2s;"
                                       onfocus="this.style.borderColor='#FFC81A'; this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)'" onblur="this.style.borderColor='#CBD5E1'; this.style.boxShadow='none'">
                            </div>
                            @error('nama')<p style="color:#EF4444; font-size:12px; margin:6px 0 0; font-weight:600;">{{ $message }}</p>@enderror
                        </div>

                        {{-- Email --}}
                        <div style="margin-bottom:18px;">
                            <label style="display:block; font-size:11.5px; font-weight:900; color:#1E293B; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.8px;">
                                Alamat Email *
                            </label>
                            <div style="position:relative;">
                                @include('components.icon',['name'=>'mail','size'=>16,'style'=>'position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#64748B; pointer-events:none;'])
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required 
                                       style="width:100%; box-sizing:border-box; background:#FFFFFF; border:1.5px solid #CBD5E1; border-radius:12px; padding:11px 14px 11px 40px; color:#0F172A; font-size:13.5px; outline:none; transition:all 0.2s;"
                                       onfocus="this.style.borderColor='#FFC81A'; this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)'" onblur="this.style.borderColor='#CBD5E1'; this.style.boxShadow='none'">
                            </div>
                            @error('email')<p style="color:#EF4444; font-size:12px; margin:6px 0 0; font-weight:600;">{{ $message }}</p>@enderror
                        </div>

                        {{-- Pesan --}}
                        <div style="margin-bottom:24px;">
                            <label style="display:block; font-size:11.5px; font-weight:900; color:#1E293B; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.8px;">
                                Pesan / Pertanyaan *
                            </label>
                            <textarea name="pesan" rows="4" required placeholder="Tuliskan pertanyaan atau kendala yang ingin Anda sampaikan..." 
                                      style="width:100%; box-sizing:border-box; background:#FFFFFF; border:1.5px solid #CBD5E1; border-radius:12px; padding:12px; color:#0F172A; font-size:13.5px; outline:none; resize:vertical; line-height:1.6; font-family:inherit; transition:all 0.2s;"
                                      onfocus="this.style.borderColor='#FFC81A'; this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)'" onblur="this.style.borderColor='#CBD5E1'; this.style.boxShadow='none'">{{ old('pesan') }}</textarea>
                            @error('pesan')<p style="color:#EF4444; font-size:12px; margin:6px 0 0; font-weight:600;">{{ $message }}</p>@enderror
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" 
                                style="width:100%; padding:13px 20px; border-radius:30px; font-size:14px; font-weight:900; background:#FFC81A; color:#131218; border:1.5px solid #131218; cursor:pointer; box-shadow:0 6px 20px rgba(255,200,26,0.35); display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s ease;"
                                onmouseover="this.style.background='#131218'; this.style.color='#FFC81A';" onmouseout="this.style.background='#FFC81A'; this.style.color='#131218';">
                            @include('components.icon',['name'=>'send','size'=>16]) Kirim Pesan Sekarang
                        </button>
                    </form>
                </div>

                {{-- RIGHT COLUMN: Contact Info & Maps --}}
                <div style="display:flex; flex-direction:column; gap:24px;">
                    
                    {{-- Sekretariat Info Card --}}
                    <div class="fcc-kontak-card">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                            <div style="width:4px; height:22px; background:#FFC81A; border-radius:2px; flex-shrink:0;"></div>
                            <h2 style="font-size:18px; font-weight:900; color:#0F172A; margin:0;">
                                Informasi Sekretariat
                            </h2>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:18px;">
                            {{-- Alamat --}}
                            <div class="fcc-contact-item">
                                <div class="fcc-contact-icon" style="background:#FFC81A; color:#131218;">
                                    @include('components.icon',['name'=>'map-pin','size'=>17,'style'=>'color:#131218'])
                                </div>
                                <div style="flex:1; min-width:0;">
                                    <p style="margin:0 0 2px; color:#D97706; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.8px;">Alamat Sekretariat</p>
                                    <p style="margin:0; color:#0F172A; font-size:13.5px; font-weight:700; line-height:1.5; word-break:break-word;">
                                        {{ $kontak->alamat ?? 'Gedung FIKOM UMI, Jl. Urip Sumoharjo No.225, Makassar 90232' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Telepon / WA --}}
                            <a href="{{ $kontak?->wa_url ?? 'https://wa.me/6281234567890' }}" target="_blank" rel="noopener noreferrer" 
                               class="fcc-contact-item" style="text-decoration:none; color:inherit; transition:transform 0.2s;"
                               onmouseover="this.querySelector('.fcc-tel-title').style.color='#25D366'; this.querySelector('.fcc-tel-num').style.color='#25D366'; this.querySelector('.fcc-tel-num').style.textDecoration='underline';"
                               onmouseout="this.querySelector('.fcc-tel-title').style.color='#D97706'; this.querySelector('.fcc-tel-num').style.color='#0F172A'; this.querySelector('.fcc-tel-num').style.textDecoration='none';">
                                <div class="fcc-contact-icon" style="background:#25D366; color:#FFFFFF; box-shadow:0 4px 10px rgba(37,211,102,0.35);">
                                    @include('components.icon',['name'=>'phone','size'=>17,'style'=>'color:#FFFFFF'])
                                </div>
                                <div style="flex:1; min-width:0;">
                                    <div class="fcc-tel-title" style="margin:0 0 3px; color:#D97706; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.8px; transition:color 0.2s; display:flex; flex-wrap:wrap; align-items:center; gap:6px;">
                                        <span>Telepon &amp; WhatsApp</span>
                                        <span style="font-size:9.5px; background:#25D366; color:#FFF; padding:2px 6px; border-radius:4px; font-weight:800; text-transform:none;">Chat WhatsApp &nearr;</span>
                                    </div>
                                    <p class="fcc-tel-num" style="margin:0; color:#0F172A; font-size:13.5px; font-weight:700; transition:color 0.2s; word-break:break-word;">
                                        {{ $kontak->telepon ?? '(0411) 455 855 / WhatsApp: +62 812-3456-7890' }}
                                    </p>
                                </div>
                            </a>

                            {{-- Email --}}
                            <a href="{{ $kontak?->mailto_url ?? 'mailto:fcc@fikom.umi.ac.id' }}" 
                               class="fcc-contact-item" style="text-decoration:none; color:inherit; transition:transform 0.2s;"
                               onmouseover="this.querySelector('.fcc-mail-title').style.color='#0284C7'; this.querySelector('.fcc-mail-val').style.color='#0284C7'; this.querySelector('.fcc-mail-val').style.textDecoration='underline';"
                               onmouseout="this.querySelector('.fcc-mail-title').style.color='#D97706'; this.querySelector('.fcc-mail-val').style.color='#0F172A'; this.querySelector('.fcc-mail-val').style.textDecoration='none';">
                                <div class="fcc-contact-icon" style="background:#0284C7; color:#FFFFFF; box-shadow:0 4px 10px rgba(2,132,199,0.35);">
                                    @include('components.icon',['name'=>'mail','size'=>17,'style'=>'color:#FFFFFF'])
                                </div>
                                <div style="flex:1; min-width:0;">
                                    <div class="fcc-mail-title" style="margin:0 0 3px; color:#D97706; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.8px; transition:color 0.2s; display:flex; flex-wrap:wrap; align-items:center; gap:6px;">
                                        <span>Email Resmi</span>
                                        <span style="font-size:9.5px; background:#0284C7; color:#FFF; padding:2px 6px; border-radius:4px; font-weight:800; text-transform:none;">Kirim Email &nearr;</span>
                                    </div>
                                    <p class="fcc-mail-val" style="margin:0; color:#0F172A; font-size:13.5px; font-weight:700; transition:color 0.2s; word-break:break-word;">
                                        {{ $kontak->email ?? 'fcc@fikom.umi.ac.id' }}
                                    </p>
                                </div>
                            </a>

                            {{-- Jam Operasional --}}
                            <div class="fcc-contact-item">
                                <div class="fcc-contact-icon" style="background:#FFC81A; color:#131218;">
                                    @include('components.icon',['name'=>'clock','size'=>17,'style'=>'color:#131218'])
                                </div>
                                <div style="flex:1; min-width:0;">
                                    <p style="margin:0 0 2px; color:#D97706; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.8px;">Jam Layanan Sekretariat</p>
                                    <p style="margin:0; color:#0F172A; font-size:13.5px; font-weight:700; word-break:break-word;">
                                        Senin – Jumat: 08:00 – 16:00 WITA
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Map Box Card --}}
                    <div class="fcc-kontak-card" style="padding:16px;">
                        @if($kontak?->maps_embed)
                            <div class="fcc-map-container">
                                {!! $kontak->maps_embed !!}
                            </div>
                        @else
                            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:12px; padding:24px 16px; text-align:center; height:180px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px;">
                                <div style="width:44px; height:44px; border-radius:12px; background:#FFC81A; border:1.5px solid #131218; color:#131218; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                                    @include('components.icon',['name'=>'map-pin','size'=>22,'style'=>'color:#131218'])
                                </div>
                                <p style="color:#0F172A; font-size:13.5px; font-weight:800; margin:0;">Kampus UMI Makassar</p>
                                <p style="color:#64748B; font-size:12px; margin:0;">Fakultas Ilmu Komputer Universitas Muslim Indonesia</p>
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* Base / Desktop Layout */
.fcc-kontak-hero {
    background: #131218;
    border-bottom: 1.5px solid rgba(255,200,26,0.2);
    padding: 44px 24px 48px;
    position: relative;
    overflow: hidden;
    text-align: center;
    box-sizing: border-box;
    width: 100%;
}
.fcc-kontak-section {
    background: #F8F9FA;
    padding: 48px 24px 72px;
    box-sizing: border-box;
    width: 100%;
}
.fcc-kontak-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 32px;
    align-items: start;
    width: 100%;
    box-sizing: border-box;
}
.fcc-kontak-card {
    background: #FFFFFF;
    border: 1.5px solid #E2E8F0;
    border-radius: 22px;
    padding: 32px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.04);
    box-sizing: border-box;
    width: 100%;
}
.fcc-contact-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    box-sizing: border-box;
    width: 100%;
}
.fcc-contact-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1.5px solid #131218;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 3px 8px rgba(255,200,26,0.2);
}
.fcc-map-container {
    border-radius: 12px;
    overflow: hidden;
    height: 230px;
    width: 100%;
    position: relative;
    box-sizing: border-box;
}
.fcc-map-container iframe {
    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    border: 0 !important;
}

/* Tablet & Mobile (< 1024px) */
@media (max-width: 1023px) {
    .fcc-kontak-grid {
        display: flex !important;
        flex-direction: column !important;
        gap: 24px !important;
        width: 100% !important;
    }
    .fcc-kontak-section {
        padding: 28px 16px 56px !important;
    }
    .fcc-kontak-hero {
        padding: 32px 16px 36px !important;
    }
    .fcc-kontak-card {
        padding: 22px 16px !important;
        border-radius: 18px !important;
        width: 100% !important;
    }
}

/* Small Mobile (< 480px) */
@media (max-width: 479px) {
    .fcc-kontak-section {
        padding: 20px 12px 48px !important;
    }
    .fcc-kontak-card {
        padding: 20px 14px !important;
        border-radius: 16px !important;
    }
    .fcc-map-container {
        height: 200px !important;
    }
}
</style>
@endsection
