@extends('layouts.public')
@section('title', 'Hubungi Kami')
@section('page-content')
<div style="padding-top:84px; background:#131218; min-height: calc(100vh - 84px);">
    
    {{-- ═══ HERO HEADER ═════════════════════════════════════════════════════════════ --}}
    <div style="background:#131218; border-bottom:1.5px solid rgba(255,200,26,0.2); padding:40px 24px 44px; position:relative; overflow:hidden; text-align:center;">
        <!-- Subtle Glow -->
        <div style="position:absolute; top:-50%; left:50%; transform:translateX(-50%); width:600px; height:600px; border-radius:50%; background:radial-gradient(circle, rgba(255,200,26,0.07), transparent 70%); pointer-events:none;"></div>
        
        <div style="max-width:800px; margin:0 auto; position:relative; z-index:1;">
            <div style="display:inline-block; font-size:10.5px; font-weight:900; padding:5px 16px; border-radius:100px; text-transform:uppercase; letter-spacing:1.5px; background:#FFC81A; color:#131218; margin-bottom:14px; box-shadow:0 4px 12px rgba(255,200,26,0.25);">
                HUBUNGI KAMI
            </div>
            
            <h1 style="font-size:clamp(26px, 4vw, 40px); font-weight:900; color:#FFFFFF; margin:0 0 12px; line-height:1.2; letter-spacing:-0.5px;">
                Layanan Informasi &amp; Bantuan
            </h1>
            
            <p style="color:rgba(255,255,255,0.75); font-size:15px; margin:0; line-height:1.6; font-weight:500;">
                Ada pertanyaan seputar jadwal pelatihan, ujian sertifikasi, atau kendala pendaftaran? Tim sekretariat FCC FIKOM UMI siap membantu Anda.
            </p>
        </div>
    </div>

    {{-- ═══ MAIN CONTENT GRID ══════════════════════════════════════════════════════ --}}
    <div style="background:#F8F9FA; padding:48px 24px 72px;">
        <div style="max-width:1180px; margin:0 auto;">
            
            @if(session('success'))
            <div style="padding:16px 20px; background:rgba(16,185,129,0.12); border:1.5px solid #10B981; border-radius:16px; color:#065F46; font-size:14.5px; font-weight:800; margin-bottom:32px; display:flex; align-items:center; gap:10px;">
                @include('components.icon',['name'=>'check-circle','size'=>18,'style'=>'color:#10B981'])
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <div style="display:grid; grid-template-columns: 1.2fr 1fr; gap:36px; align-items:start;" class="fcc-kontak-grid">
                
                {{-- LEFT COLUMN: Contact Form Card --}}
                <div style="background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:22px; padding:36px; box-shadow:0 8px 24px rgba(0,0,0,0.04);">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:28px;">
                        <div style="width:4px; height:24px; background:#FFC81A; border-radius:2px;"></div>
                        <h2 style="font-size:19px; font-weight:900; color:#0F172A; margin:0; letter-spacing:-0.4px;">
                            Kirim Pesan Langsung
                        </h2>
                    </div>

                    <form action="{{ route('landing.kontak.post') }}" method="POST">
                        @csrf
                        
                        {{-- Nama Lengkap --}}
                        <div style="margin-bottom:20px;">
                            <label style="display:block; font-size:11.5px; font-weight:900; color:#1E293B; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.8px;">
                                Nama Lengkap *
                            </label>
                            <div style="position:relative;">
                                @include('components.icon',['name'=>'user','size'=>16,'style'=>'position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#64748B; pointer-events:none;'])
                                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap Anda" required 
                                       style="width:100%; box-sizing:border-box; background:#FFFFFF; border:1.5px solid #CBD5E1; border-radius:12px; padding:12px 14px 12px 42px; color:#0F172A; font-size:14px; outline:none; transition:all 0.2s;"
                                       onfocus="this.style.borderColor='#FFC81A'; this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)'" onblur="this.style.borderColor='#CBD5E1'; this.style.boxShadow='none'">
                            </div>
                            @error('nama')<p style="color:#EF4444; font-size:12px; margin:6px 0 0; font-weight:600;">{{ $message }}</p>@enderror
                        </div>

                        {{-- Email --}}
                        <div style="margin-bottom:20px;">
                            <label style="display:block; font-size:11.5px; font-weight:900; color:#1E293B; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.8px;">
                                Alamat Email *
                            </label>
                            <div style="position:relative;">
                                @include('components.icon',['name'=>'mail','size'=>16,'style'=>'position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#64748B; pointer-events:none;'])
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required 
                                       style="width:100%; box-sizing:border-box; background:#FFFFFF; border:1.5px solid #CBD5E1; border-radius:12px; padding:12px 14px 12px 42px; color:#0F172A; font-size:14px; outline:none; transition:all 0.2s;"
                                       onfocus="this.style.borderColor='#FFC81A'; this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)'" onblur="this.style.borderColor='#CBD5E1'; this.style.boxShadow='none'">
                            </div>
                            @error('email')<p style="color:#EF4444; font-size:12px; margin:6px 0 0; font-weight:600;">{{ $message }}</p>@enderror
                        </div>

                        {{-- Pesan --}}
                        <div style="margin-bottom:28px;">
                            <label style="display:block; font-size:11.5px; font-weight:900; color:#1E293B; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.8px;">
                                Pesan / Pertanyaan *
                            </label>
                            <textarea name="pesan" rows="5" required placeholder="Tuliskan pertanyaan atau kendala yang ingin Anda sampaikan..." 
                                      style="width:100%; box-sizing:border-box; background:#FFFFFF; border:1.5px solid #CBD5E1; border-radius:12px; padding:14px; color:#0F172A; font-size:14px; outline:none; resize:vertical; line-height:1.6; font-family:inherit; transition:all 0.2s;"
                                      onfocus="this.style.borderColor='#FFC81A'; this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)'" onblur="this.style.borderColor='#CBD5E1'; this.style.boxShadow='none'">{{ old('pesan') }}</textarea>
                            @error('pesan')<p style="color:#EF4444; font-size:12px; margin:6px 0 0; font-weight:600;">{{ $message }}</p>@enderror
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" 
                                style="width:100%; padding:14px; border-radius:30px; font-size:14.5px; font-weight:900; background:#FFC81A; color:#131218; border:1.5px solid #131218; cursor:pointer; box-shadow:0 6px 20px rgba(255,200,26,0.35); display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s ease;"
                                onmouseover="this.style.background='#131218'; this.style.color='#FFC81A';" onmouseout="this.style.background='#FFC81A'; this.style.color='#131218';">
                            @include('components.icon',['name'=>'send','size'=>16]) Kirim Pesan Sekarang
                        </button>
                    </form>
                </div>

                {{-- RIGHT COLUMN: Contact Info & Maps --}}
                <div style="display:flex; flex-direction:column; gap:28px;">
                    
                    {{-- Sekretariat Info Card --}}
                    <div style="background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:22px; padding:32px; box-shadow:0 8px 24px rgba(0,0,0,0.04);">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:24px;">
                            <div style="width:4px; height:22px; background:#FFC81A; border-radius:2px;"></div>
                            <h2 style="font-size:18px; font-weight:900; color:#0F172A; margin:0;">
                                Informasi Sekretariat
                            </h2>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:20px;">
                            {{-- Alamat --}}
                            <div style="display:flex; gap:14px; align-items:flex-start;">
                                <div style="width:42px; height:42px; border-radius:12px; background:#FFC81A; border:1.5px solid #131218; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#131218; box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                                    @include('components.icon',['name'=>'map-pin','size'=>18,'style'=>'color:#131218'])
                                </div>
                                <div>
                                    <p style="margin:0 0 2px; color:#D97706; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.8px;">Alamat Sekretariat</p>
                                    <p style="margin:0; color:#0F172A; font-size:14px; font-weight:700; line-height:1.5;">
                                        {{ $kontak->alamat ?? 'Gedung FIKOM UMI, Jl. Urip Sumoharjo No.225, Makassar 90232' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Telepon / WA --}}
                            <div style="display:flex; gap:14px; align-items:flex-start;">
                                <div style="width:42px; height:42px; border-radius:12px; background:#FFC81A; border:1.5px solid #131218; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#131218; box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                                    @include('components.icon',['name'=>'phone','size'=>18,'style'=>'color:#131218'])
                                </div>
                                <div>
                                    <p style="margin:0 0 2px; color:#D97706; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.8px;">Telepon &amp; WhatsApp</p>
                                    <p style="margin:0; color:#0F172A; font-size:14px; font-weight:700;">
                                        {{ $kontak->telepon ?? '(0411) 455 855 / WhatsApp: +62 812-3456-7890' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div style="display:flex; gap:14px; align-items:flex-start;">
                                <div style="width:42px; height:42px; border-radius:12px; background:#FFC81A; border:1.5px solid #131218; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#131218; box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                                    @include('components.icon',['name'=>'mail','size'=>18,'style'=>'color:#131218'])
                                </div>
                                <div>
                                    <p style="margin:0 0 2px; color:#D97706; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.8px;">Email Resmi</p>
                                    <p style="margin:0; color:#0F172A; font-size:14px; font-weight:700;">
                                        {{ $kontak->email ?? 'fcc@fikom.umi.ac.id' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Jam Operasional --}}
                            <div style="display:flex; gap:14px; align-items:flex-start;">
                                <div style="width:42px; height:42px; border-radius:12px; background:#FFC81A; border:1.5px solid #131218; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#131218; box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                                    @include('components.icon',['name'=>'clock','size'=>18,'style'=>'color:#131218'])
                                </div>
                                <div>
                                    <p style="margin:0 0 2px; color:#D97706; font-size:11px; font-weight:900; text-transform:uppercase; letter-spacing:0.8px;">Jam Layanan Sekretariat</p>
                                    <p style="margin:0; color:#0F172A; font-size:14px; font-weight:700;">
                                        Senin – Jumat: 08:00 – 16:00 WITA
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Map Box Card --}}
                    <div style="background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:22px; padding:20px; box-shadow:0 8px 24px rgba(0,0,0,0.04);">
                        @if($kontak?->maps_embed)
                            <div style="border-radius:14px; overflow:hidden; height:220px;">
                                {!! $kontak->maps_embed !!}
                            </div>
                        @else
                            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:14px; padding:28px 20px; text-align:center; height:180px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px;">
                                <div style="width:48px; height:48px; border-radius:14px; background:#FFC81A; border:1.5px solid #131218; color:#131218; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                                    @include('components.icon',['name'=>'map-pin','size'=>24,'style'=>'color:#131218'])
                                </div>
                                <p style="color:#0F172A; font-size:14px; font-weight:800; margin:0;">Kampus UMI Makassar</p>
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
@media (max-width: 900px) {
    .fcc-kontak-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
