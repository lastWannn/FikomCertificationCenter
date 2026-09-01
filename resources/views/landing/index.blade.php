@extends('layouts.public')
@section('title','Beranda')
@section('meta-description','FIKOM Certification Center UMI Makassar — Platform resmi pelatihan dan sertifikasi kompetensi teknologi terpercaya. Sertifikasi BNSP & Pelatihan IT Profesional.')
@section('og-title','Beranda — FIKOM Certification Center UMI')
@section('og-description','Platform resmi pelatihan dan sertifikasi kompetensi teknologi terpercaya di Fakultas Ilmu Komputer Universitas Muslim Indonesia.')
@section('og-image', asset('images/og-preview.webp'))

@push('preloads')
<link rel="preload" as="image" href="{{ asset('images/herosection.webp') }}" type="image/webp"/>
<link rel="preload" as="image" href="{{ asset('images/hero-model.webp') }}" type="image/webp"/>
@endpush

@push('styles')
<style>
    @keyframes floatBadge {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-6px); }
    }
    @keyframes shimmerBar {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(200%); }
    }

    .hero-gradient-text {
        background: linear-gradient(135deg, #FFFFFF 25%, #FFC81A 70%, #FFA800 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endpush

@section('page-content')

{{-- ══════════════════════════════════════════════════════════════
     HERO SECTION — High-Impact Portal Layout with Background Image
  ══════════════════════════════════════════════════════════════════ --}}
<section data-hero style="position:relative;overflow:hidden;display:flex;align-items:center;border-bottom:1px solid #1E1D26;background:#131218;">
    {{-- Hero Background Image (LCP element — loaded as <img> for fastest discovery) --}}
    <img src="{{ asset('images/herosection.webp') }}" alt="" fetchpriority="high" decoding="async" width="1920" height="1080" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;"/>
    {{-- Gradient Overlay --}}
    <div style="position:absolute;inset:0;background:linear-gradient(180deg, rgba(19,18,24,0.84) 0%, rgba(15,14,21,0.92) 70%, #131218 100%);z-index:1;"></div>
    {{-- Particle Canvas --}}
    <canvas id="hero-particles" style="position:absolute;inset:0;pointer-events:none;z-index:2;opacity:.6;"></canvas>
    
    {{-- Main Content Container --}}
    <div style="position:relative;z-index:3;max-width:1240px;margin:0 auto;padding:0 24px;width:100%;">

        <div class="hero-grid-layout">
            
            {{-- Left Column: Clean Typography & CTAs --}}
            <div style="max-width:660px;">

                {{-- Headline --}}
                <h1 style="color:#FFFFFF;font-weight:900;line-height:1.15;letter-spacing:-1px;">
                    Dapatkan <span style="color:#FFC81A;">Sertifikasi Resmi</span> &amp; Gelar Kompetensi Berstandar Industri
                </h1>

                {{-- Subtitle --}}
                <p style="color:rgba(255,255,255,0.85);max-width:600px;font-size:15px;line-height:1.65;margin-top:14px;">
                    Platform pelatihan dan sertifikasi kompetensi terpercaya di Fakultas Ilmu Komputer UMI. Raih gelar profesi serta sertifikat resmi berstandar industri yang <strong style="color:#FFF;">berlaku seumur hidup</strong> untuk menunjang karir Anda.
                </p>

                {{-- Action Buttons --}}
                <div class="hero-cta-buttons">
                    <span class="btn-magnetic">
                        <a href="{{ route('landing.kegiatan') }}" style="border-radius:30px;font-weight:800;display:inline-flex;align-items:center;gap:10px;background:#FFC81A;color:#131218;border:2px solid #FFC81A;box-shadow:0 6px 20px rgba(255,200,26,0.35);text-decoration:none;transition:all .25s ease;">
                            Jelajahi Program Sekarang
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    </span>
                    <span class="btn-magnetic">
                        <a href="{{ route('landing.pendaftaran') }}" style="border-radius:30px;font-weight:800;display:inline-flex;align-items:center;gap:8px;background:#FFFFFF;color:#131218;border:2px solid #FFFFFF;text-decoration:none;box-shadow:0 6px 20px rgba(255,255,255,0.15);transition:all .25s ease;">
                            Cara Mendaftar
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </span>
                </div>

            </div>

            {{-- Right Column: Modern Asymmetric Layered Showcase --}}
            <div class="hero-model-section">
                
                <div class="hero-showcase-box">
                    
                    {{-- Solid Yellow Angled Backdrop Card --}}
                    <div class="hero-backdrop-card"></div>

                    {{-- Main Asymmetric Model Container --}}
                    <div class="hero-model-wrapper">
                        
                        {{-- Inner Image Arch Container --}}
                        <div class="hero-image-arch">
                            <img src="{{ asset('images/hero-model.webp') }}" alt="Peserta Sertifikasi FIKOM UMI" width="520" height="620" fetchpriority="high" decoding="async" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                        </div>

                        {{-- Floating Badge 1: Top Right Trust Tag --}}
                        <div class="hero-badge-top">
                            <span style="font-size:14px;">⭐</span>
                            <span>Standar BNSP &amp; Industri</span>
                        </div>

                        {{-- Floating Badge 2: Bottom Left Verification Badge --}}
                        <div class="floating-badge-bottom">
                            <div class="floating-badge-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            </div>
                            <div>
                                <p>Akreditasi A &amp; Terverifikasi</p>
                                <p>Resmi FIKOM UMI</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     KEGIATAN — Clean White Surface & Premium Solid Cards (Spacious Layout)
  ══════════════════════════════════════════════════════════════════ --}}
<section style="min-height:86vh;display:flex;align-items:center;justify-content:center;padding:70px 24px;background:#F8F9FA;position:relative;overflow:hidden;box-sizing:border-box;">
    <div style="max-width:1180px;margin:0 auto;width:100%;position:relative;z-index:1;">
        
        {{-- Section Header --}}
        <div class="reveal" style="text-align:center;margin-bottom:34px;">
            <span style="display:inline-block;padding:6px 16px;background:#FFC81A;color:#131218;font-size:11px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;border-radius:100px;border:1.5px solid #131218;margin-bottom:10px;">
                Jadwal Terbaru
            </span>
            <h2 style="color:#131218;font-size:clamp(26px,3.5vw,38px);font-weight:900;margin:0;line-height:1.2;">
                Kegiatan yang Akan <span style="color:#FFC81A;background:#131218;padding:2px 10px;border-radius:6px;">Datang</span>
            </h2>
        </div>

        @php
            $kegiatanList = $kegiatanTerbaru->take(3);
            $kCount = $kegiatanList->count();
        @endphp

        {{-- Cards Grid (Balanced Centered Layout) --}}
        <div id="kegiatan-grid" style="display:flex; flex-wrap:wrap; justify-content:center; gap:24px; max-width:{{ $kCount == 1 ? '480px' : ($kCount == 2 ? '860px' : '100%') }}; margin:0 auto;">
            @forelse($kegiatanList as $k)
            @php
                $isPel       = $k->jenis_kegiatan === 'pelatihan';
                $posterUrl   = $k->detail?->gambar_url;
            @endphp
            <div class="kegiatan-card" data-jenis="{{ $k->jenis_kegiatan }}"
                 style="flex:1 1 310px; max-width:{{ $kCount == 1 ? '480px' : ($kCount == 2 ? '410px' : '370px') }}; width:100%; border-radius:18px; border:2px solid #E5E7EB; background:#FFFFFF; overflow:hidden; display:flex; flex-direction:column; justify-content:space-between; transition:all 0.28s ease; box-shadow:0 4px 16px rgba(0,0,0,0.04);"
                 onmouseover="this.style.transform='translateY(-6px)'; this.style.borderColor='#FFC81A'; this.style.boxShadow='0 16px 32px rgba(0,0,0,0.08)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E5E7EB'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">

                <div>
                    {{-- Poster Container (Height 185px) --}}
                    <div style="position:relative; width:100%; height:185px; overflow:hidden; background:#131218;">
                        @if($posterUrl)
                        <img src="{{ $posterUrl }}" alt="{{ $k->judul }}" width="400" height="185" loading="lazy" decoding="async" style="width:100%; height:100%; object-fit:cover; object-position:center top; display:block; transition:transform 0.4s ease;"
                             onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        @else
                        <div style="width:100%; height:100%; background:#131218; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px;">
                            @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>36,'style'=>'color:#FFC81A'])
                            <span style="font-size:11px; font-weight:800; color:#FFC81A; text-transform:uppercase; letter-spacing:1.5px;">{{ ucfirst($k->jenis_kegiatan) }}</span>
                        </div>
                        @endif

                        {{-- Floating Badges over Poster --}}
                        <div style="position:absolute;top:12px;left:12px;display:flex;gap:6px;">
                            <span style="font-size:10.5px; font-weight:900; padding:4px 10px; border-radius:6px; background:#FFC81A; color:#131218; border:1px solid #131218; text-transform:uppercase; letter-spacing:0.5px;">
                                {{ ucfirst($k->jenis_kegiatan) }}
                            </span>
                        </div>
                        <div style="position:absolute;top:12px;right:12px;">
                            <span style="font-size:10.5px; font-weight:800; color:{{ $k->isComingSoon() ? '#D97706' : ($k->isRegistrationClosed() ? '#EF4444' : ($k->isFull() ? '#EF4444' : '#131218')) }}; background:#FFFFFF; padding:4px 10px; border-radius:6px; border:1px solid #131218; box-shadow:0 2px 8px rgba(0,0,0,0.15);">
                                {{ $k->isComingSoon() ? 'Segera Hadir' : ($k->isRegistrationClosed() ? 'Pendaftaran Ditutup' : ($k->isFull() ? 'Kuota Penuh' : ($k->biaya->isNotEmpty() ? 'Berbayar' : 'Gratis'))) }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div style="padding:16px 18px 12px;">
                        
                        {{-- Title --}}
                        <h4 style="margin:0 0 10px; color:#131218; font-size:15px; font-weight:800; line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; height:42px;">
                            <a href="{{ route('landing.show', $k) }}" style="color:#131218; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#F59E0B'" onmouseout="this.style.color='#131218'">
                                {{ $k->judul }}
                            </a>
                        </h4>

                        {{-- Date & Kuota Bar --}}
                        <div style="display:flex; align-items:center; justify-content:space-between; font-size:12.5px; color:#4B5563; font-weight:700; margin-bottom:10px;">
                            <div style="display:flex; align-items:center; gap:6px;">
                                @include('components.icon',['name'=>'calendar','size'=>15,'style'=>'color:#6B7280'])
                                <span>{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Jadwal Menyusul' }}</span>
                            </div>
                            <span style="color:#131218;font-weight:800;font-size:12px;">{{ $k->terisi }}/{{ $k->kuota }}</span>
                        </div>

                        {{-- Kuota Progress Bar --}}
                        <div style="background:#F8F9FA; border-radius:8px; padding:7px 9px; border:1px solid #E5E7EB; margin-bottom:12px;">
                            <div style="display:flex; justify-content:space-between; font-size:11px; color:#4B5563; margin-bottom:4px; font-weight:700;">
                                <span>Peserta Terdaftar</span>
                                <span style="color:#131218;font-weight:800;">{{ $k->terisi }} / {{ $k->kuota }}</span>
                            </div>
                            <div style="height:5px; background:#E5E7EB; border-radius:3px; overflow:hidden;">
                                <div style="height:5px; border-radius:3px; transition:width 0.3s;
                                            background:{{ $k->isComingSoon() ? '#F59E0B' : ($k->isRegistrationClosed() || $k->isFull() ? '#EF4444' : '#FFC81A') }};
                                            width:{{ $k->kuota>0 ? min(100, round($k->terisi/$k->kuota*100)) : 0 }}%;"></div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Action Button --}}
                <div style="padding:0 18px 16px;">
                    @if($k->isRegistrationClosed())
                    <button disabled
                       style="display:inline-flex; align-items:center; justify-content:center; padding:10.5px 14px; border-radius:10px; font-size:13px; font-weight:800; width:100%; box-sizing:border-box; background:#F3F4F6; border:1px solid #E5E7EB; color:#9CA3AF; cursor:not-allowed;">
                        Tutup
                    </button>
                    @elseif($k->isComingSoon())
                    <a href="{{ route('landing.show', $k) }}"
                       style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; padding:10.5px 14px; border-radius:10px; font-size:13px; font-weight:800; transition:all 0.2s ease; width:100%; box-sizing:border-box; background:#FFFBEB; border:1.5px solid #F59E0B; color:#D97706;">
                        Segera Hadir →
                    </a>
                    @elseif($k->isFull())
                    <button disabled
                       style="display:inline-flex; align-items:center; justify-content:center; padding:10.5px 14px; border-radius:10px; font-size:13px; font-weight:800; width:100%; box-sizing:border-box; background:#F3F4F6; border:1px solid #E5E7EB; color:#9CA3AF; cursor:not-allowed;">
                        Kuota Penuh
                    </button>
                    @else
                    <a href="{{ route('landing.show', $k) }}"
                       style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; padding:10.5px 14px; border-radius:10px; font-size:13px; font-weight:800; transition:all 0.2s ease; width:100%; box-sizing:border-box; background:#FFC81A; color:#131218; border:1.5px solid #131218; box-shadow:0 4px 12px rgba(255,200,26,0.3);">
                        Detail &amp; Daftar →
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div style="grid-column:1 / -1; padding:45px 24px; text-align:center; color:#6B7280; font-size:14.5px; background:#FFFFFF; border:2px solid #E5E7EB; border-radius:16px;">
                Belum ada kegiatan yang dipublikasikan.
            </div>
            @endforelse
        </div>

        {{-- Bottom View All Button --}}
        <div class="reveal" style="text-align:center;margin-top:36px;">
            <span class="btn-magnetic">
                <a href="{{ route('landing.kegiatan') }}" style="padding:11.5px 30px;font-size:13.5px;font-weight:800;background:#131218;color:#FFC81A;border:2px solid #131218;border-radius:30px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 4px 14px rgba(0,0,0,0.12);">
                    Lihat Semua Kegiatan
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </span>
        </div>
    </div>
</section>
        </div>
    </div>
</section>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     TENTANG — High-Contrast Dark Section (Kuning + Putih + Hitam)
  ══════════════════════════════════════════════════════════════════ --}}
<section class="section-stack" style="z-index:3;padding:90px 24px;background:#131218;position:sticky;overflow:hidden;">
    <div class="tentang-grid" style="max-width:1100px;margin:0 auto;align-items:center;position:relative;z-index:1;">
        
        {{-- Left Content --}}
        <div class="rl">
            <span style="display:inline-block;padding:6px 16px;background:#FFC81A;color:#131218;font-size:11px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;border-radius:100px;margin-bottom:14px;">
                Tentang Kami
            </span>
            <h2 style="color:#FFFFFF;font-size:clamp(26px,3.5vw,38px);font-weight:900;margin:0 0 18px;line-height:1.2;">
                Pusat Sertifikasi dan Pelatihan <span style="color:#FFC81A;">Profesional</span>
            </h2>
            <p style="color:rgba(255,255,255,0.8);font-size:15px;line-height:1.8;margin:0 0 24px;">
                FIKOM Certification Center (FCC) adalah unit pelaksana di bawah Fakultas Ilmu Komputer Universitas Muslim Indonesia yang menyelenggarakan program pelatihan dan sertifikasi kompetensi bagi mahasiswa dan masyarakat umum.
            </p>
            @foreach([
                'Terakreditasi oleh lembaga sertifikasi nasional (BNSP)',
                'Kurikulum diperbarui bersama mitra industri setiap semester',
                'Sertifikat diakui oleh perusahaan dan institusi mitra FCC',
            ] as $item)
            <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:12px;">
                <div style="width:22px;height:22px;border-radius:6px;flex-shrink:0;margin-top:1px;background:#FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <span style="color:#FFFFFF;font-size:14px;line-height:1.6;font-weight:600;">{{ $item }}</span>
            </div>
            @endforeach
            <div style="margin-top:30px;">
                <a href="{{ route('landing.profil') }}" style="padding:12px 28px;font-size:14px;font-weight:800;background:#FFC81A;color:#131218;border-radius:30px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 6px 20px rgba(255,200,26,0.3);">
                    Selengkapnya
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Right Feature Cards --}}
        <div class="rr" style="display:flex;flex-direction:column;gap:16px;">
            @foreach([
                ['award',    'Sertifikasi Berstandar BNSP',  'Program sertifikasi yang diakui secara nasional sesuai standar BNSP dan mitra resmi.'],
                ['book-open','Kurikulum Berbasis Industri',   'Materi dirancang bersama praktisi dan diselaraskan kebutuhan industri digital terkini.'],
                ['users',    'Instruktur Berpengalaman',      'Diasuh dosen berpengalaman dan profesional bidang teknologi informasi.'],
            ] as [$ic,$t,$d])
            <div style="padding:22px;display:flex;gap:16px;align-items:flex-start;background:#1E1D26;border:1.5px solid rgba(255,200,26,0.25);border-radius:16px;transition:all .25s ease;"
                 onmouseover="this.style.borderColor='#FFC81A';this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.borderColor='rgba(255,200,26,0.25)';this.style.transform='translateY(0)'">
                <div style="width:48px;height:48px;border-radius:12px;background:#FFC81A;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    @include('components.icon',['name'=>$ic,'size'=>22,'style'=>'color:#131218'])
                </div>
                <div>
                    <p style="margin:0 0 6px;color:#FFFFFF;font-size:15px;font-weight:800;">{{ $t }}</p>
                    <p style="margin:0;color:rgba(255,255,255,0.7);font-size:13px;line-height:1.65;">{{ $d }}</p>
                </div>
            </div>
            @endforeach

            {{-- Visi Misi Mini Cards --}}
            <div class="visi-misi-grid">
                @foreach([
                    ['star','Visi','Menjadi unit pelatihan dan sertifikasi profesional pencetak tenaga kerja berkualitas, terampil, dan mandiri berstandar nasional dan internasional.'],
                    ['zap', 'Misi','Memberikan pelatihan & sertifikasi IT, membentuk SDM profesional, serta berkontribusi dalam peningkatan keterampilan anak bangsa.'],
                ] as [$ic,$t,$txt])
                <div style="padding:18px 16px;background:#1E1D26;border:1px solid rgba(255,255,255,0.12);border-radius:14px;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                        <div style="width:28px;height:28px;border-radius:8px;background:#FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;">
                            @include('components.icon',['name'=>$ic,'size'=>15,'style'=>'color:#131218'])
                        </div>
                        <span style="font-weight:900;font-size:14px;color:#FFFFFF;">{{ $t }}</span>
                    </div>
                    <p style="margin:0;color:rgba(255,255,255,0.65);font-size:12px;line-height:1.65;">{{ $txt }}</p>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>



{{-- ══════════════════════════════════════════════════════════════
     MITRA STRATEGIS — Clean Official Partners Showcase
  ══════════════════════════════════════════════════════════════════ --}}
<section class="section-stack" style="z-index:5;min-height:75vh;display:flex;align-items:center;justify-content:center;padding:90px 24px;background:#F8F9FA;position:sticky;overflow:hidden;box-sizing:border-box;">
    <div style="max-width:1100px;margin:0 auto;width:100%;position:relative;z-index:1;">
        
        {{-- Section Header --}}
        <div class="reveal" style="text-align:center;margin-bottom:52px;">
            <span style="display:inline-block;padding:6px 18px;background:#FFC81A;color:#131218;font-size:11px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;border-radius:100px;border:1.5px solid #131218;margin-bottom:12px;box-shadow:0 4px 12px rgba(255,200,26,0.25);">
                Dipercaya Bersama
            </span>
            <h2 style="color:#131218;font-size:clamp(26px,3.8vw,38px);font-weight:900;margin:0 0 12px;line-height:1.2;">
                Mitra <span style="color:#FFC81A;background:#131218;padding:2px 10px;border-radius:6px;">Strategis</span> Kami
            </h2>
            <p style="color:#4B5563;font-size:15px;margin:0 auto;max-width:500px;line-height:1.7;">
                Kolaborasi resmi FIKOM Certification Center dengan penyedia sertifikasi teknologi global terkemuka.
            </p>
        </div>
        
        {{-- Database Partners Grid --}}
        <div class="mitra-grid">
            @foreach($mitras as $m)
            @php
                $mLogo    = is_array($m) ? ($m['logo'] ?? null) : ($m->logo ?? null);
                $mNama    = is_array($m) ? ($m['nama_mitra'] ?? '') : ($m->nama_mitra ?? '');
                $mInisial = is_array($m) ? ($m['inisial'] ?? '') : ($m->inisial ?? '');
                $mLink    = is_array($m) ? ($m['link_website'] ?? null) : ($m->link_website ?? null);
            @endphp
            <div class="spring-up stagger-{{ ($loop->index % 3) + 1 }}" 
                 style="background:#FFFFFF;border:2px solid #E5E7EB;border-radius:24px;padding:36px 30px;display:flex;flex-direction:column;align-items:center;text-align:center;transition:all .3s ease;box-shadow:0 6px 20px rgba(0,0,0,0.03);"
                 onmouseover="this.style.borderColor='#FFC81A';this.style.transform='translateY(-6px)';this.style.boxShadow='0 16px 36px rgba(0,0,0,0.08)';"
                 onmouseout="this.style.borderColor='#E5E7EB';this.style.transform='translateY(0)';this.style.boxShadow='0 6px 20px rgba(0,0,0,0.03)';">
                
                {{-- Logo Box --}}
                <div style="width:76px;height:76px;border-radius:20px;background:#131218;border:2.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;margin-bottom:22px;box-shadow:0 8px 20px rgba(19,18,24,0.25);">
                    @if($mLogo)
                    <img src="{{ asset('storage/'.$mLogo) }}" alt="{{ $mNama }}" width="52" height="52" loading="lazy" decoding="async" style="width:52px;height:52px;object-fit:contain;filter:brightness(0) invert(1);">
                    @else
                    <span style="color:#FFC81A;font-size:18px;font-weight:900;letter-spacing:.5px;font-family:monospace;">{{ Str::upper(Str::substr($mInisial ?: $mNama, 0, 4)) }}</span>
                    @endif
                </div>

                {{-- Partner Name --}}
                <h3 style="color:#131218;font-size:20px;font-weight:900;margin:0 0 8px;line-height:1.3;">
                    {{ $mNama }}
                </h3>

                {{-- Sub-label --}}
                <p style="color:#6B7280;font-size:13px;font-weight:700;margin:0 0 24px;text-transform:uppercase;letter-spacing:.5px;">
                    Mitra Resmi FIKOM UMI
                </p>

                {{-- Button Link --}}
                @if($mLink)
                <a href="{{ $mLink }}" target="_blank" rel="noopener noreferrer" 
                   style="padding:10px 24px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border-radius:30px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .2s;"
                   onmouseover="this.style.background='#FFC81A';this.style.color='#131218';"
                   onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                    Kunjungi Website
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                </a>
                @else
                <span style="padding:8px 18px;font-size:12px;font-weight:800;background:#F3F4F6;color:#6B7280;border-radius:30px;border:1px solid #E5E7EB;">
                    Mitra Terverifikasi
                </span>
                @endif

            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     TESTIMONI — Solid Dark Accent Section with Participant Stories
  ══════════════════════════════════════════════════════════════════ --}}
@php
    $displayTestimonis = ($testimonis && $testimonis->isNotEmpty()) ? $testimonis : collect([
        (object)[
            'nama' => 'Ahmad Raziq, S.Kom.',
            'keterangan' => 'Alumni Sertifikasi Network Engineer (BNSP)',
            'kata' => 'Pelatihan dan sertifikasi di FIKOM Certification Center sangat terstruktur. Instrukturnya profesional dan materi yang diajarkan sangat relevan dengan kebutuhan dunia kerja saat ini.',
            'foto' => null,
            'rating' => 5
        ],
        (object)[
            'nama' => 'Nurfadhilah, S.Kom.',
            'keterangan' => 'Peserta Pelatihan Web Development Batch 2',
            'kata' => 'Materi pelatihan praktikal sekali dan fasilitator sangat membantu hingga paham. Sertifikat resmi dari FIKOM UMI menjadi nilai tambah besar saat melamar kerja.',
            'foto' => null,
            'rating' => 5
        ],
        (object)[
            'nama' => 'Muhammad Fikri',
            'keterangan' => 'Mahasiswa FIKOM UMI · Sertifikasi Cyber Security',
            'kata' => 'Fasilitas lab komputer yang memadai dan bimbingan simulasi ujian yang intensif membuat saya lulus ujian sertifikasi BNSP dalam sekali percobaan.',
            'foto' => null,
            'rating' => 5
        ],
        (object)[
            'nama' => 'Siti Nurhaliza, S.T.',
            'keterangan' => 'Peserta Sertifikasi Data Analyst',
            'kata' => 'Sangat merekomendasikan FCC UMI bagi siapa saja yang ingin meningkatkan kompetensi digital. Proses pendaftaran mudah dan pelayanan timnya sangat ramah.',
            'foto' => null,
            'rating' => 5
        ],
    ]);
@endphp

<section class="section-stack" style="z-index:6;padding:90px 0;background:#131218;position:sticky;overflow:hidden;">
    <div style="max-width:1100px;margin:0 auto;padding:0 24px;position:relative;z-index:1;">
        <div class="reveal" style="text-align:center;margin-bottom:48px;">
            <span style="display:inline-block;padding:6px 16px;background:#FFC81A;color:#131218;font-size:11px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;border-radius:100px;margin-bottom:12px;">
                Testimoni Peserta
            </span>
            <h2 style="color:#FFFFFF;font-size:clamp(26px,4vw,38px);font-weight:900;margin:0 0 12px;">
                Kata <span style="color:#FFC81A;">Alumni &amp; Peserta</span> Kami
            </h2>
            <p style="color:rgba(255,255,255,0.7);font-size:15px;margin:0 auto;max-width:480px;line-height:1.6;">
                Pengalaman nyata dari mahasiswa dan profesional yang telah mengikuti program pelatihan &amp; sertifikasi di FCC UMI.
            </p>
        </div>
    </div>

    {{-- Full-Width Carousel Testimoni with Soft Gradient Fade Edges --}}
    <div class="reveal testimoni-wrapper" style="width:100%;position:relative;z-index:1;display:flex;overflow:hidden;padding:20px 0 60px;gap:24px;mask-image:linear-gradient(90deg,transparent 0%,#000 5%,#000 95%,transparent 100%);-webkit-mask-image:linear-gradient(90deg,transparent 0%,#000 5%,#000 95%,transparent 100%);">
        @php
            $multiplier = max(1, ceil(6 / max(1, $displayTestimonis->count())));
            $trackItems = collect();
            for($i=0; $i<$multiplier; $i++) { $trackItems = $trackItems->concat($displayTestimonis); }
        @endphp
        
        {{-- Track 1 --}}
        <div class="testimoni-track" style="display:flex;gap:24px;flex-shrink:0;">
            @foreach($trackItems as $t)
            <div class="testimoni-card" style="width:360px;background:#1E1D26;border:1.5px solid rgba(255,200,26,0.25);border-radius:20px;padding:30px 26px;position:relative;display:flex;flex-direction:column;transition:all .3s ease;white-space:normal;" 
                 onmouseover="this.style.borderColor='#FFC81A';this.style.transform='translateY(-4px)'"
                 onmouseout="this.style.borderColor='rgba(255,200,26,0.25)';this.style.transform='translateY(0)'">
                
                {{-- Rating Stars --}}
                <div style="display:flex;gap:4px;margin-bottom:18px;">
                    @for($i=0;$i<5;$i++)
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="{{ $i < ($t->rating ?? 5) ? '#FFC81A' : 'rgba(255,255,255,.2)' }}" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    @endfor
                </div>

                {{-- Quote Text --}}
                <p style="color:#FFFFFF;font-size:14.5px;line-height:1.7;margin:0 0 28px;flex-grow:1;font-style:italic;">
                    "{!! nl2br(e($t->kata)) !!}"
                </p>

                {{-- Profile --}}
                <div style="display:flex;align-items:center;gap:14px;margin-top:auto;">
                    <div style="width:46px;height:46px;border-radius:50%;background:#FFC81A;border:2px solid #FFFFFF;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;color:#131218;">
                        @if(!empty($t->foto))
                        <img src="{{ asset('storage/'.$t->foto) }}" alt="{{ $t->nama }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                        <span style="font-size:18px;font-weight:900;line-height:1;">{{ Str::upper(Str::substr($t->nama,0,1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <h4 style="color:#FFFFFF;font-size:14.5px;font-weight:800;margin:0 0 3px;">{{ $t->nama }}</h4>
                        <p style="color:#FFC81A;font-size:11.5px;margin:0;font-weight:700;letter-spacing:.3px;">{{ $t->keterangan }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Track 2 (Duplicate for seamless loop) --}}
        <div class="testimoni-track" style="display:flex;gap:24px;flex-shrink:0;">
            @foreach($trackItems as $t)
            <div class="testimoni-card" style="width:360px;background:#1E1D26;border:1.5px solid rgba(255,200,26,0.25);border-radius:20px;padding:30px 26px;position:relative;display:flex;flex-direction:column;transition:all .3s ease;white-space:normal;" 
                 onmouseover="this.style.borderColor='#FFC81A';this.style.transform='translateY(-4px)'"
                 onmouseout="this.style.borderColor='rgba(255,200,26,0.25)';this.style.transform='translateY(0)'">
                
                {{-- Rating Stars --}}
                <div style="display:flex;gap:4px;margin-bottom:18px;">
                    @for($i=0;$i<5;$i++)
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="{{ $i < ($t->rating ?? 5) ? '#FFC81A' : 'rgba(255,255,255,.2)' }}" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    @endfor
                </div>

                {{-- Quote Text --}}
                <p style="color:#FFFFFF;font-size:14.5px;line-height:1.7;margin:0 0 28px;flex-grow:1;font-style:italic;">
                    "{!! nl2br(e($t->kata)) !!}"
                </p>

                {{-- Profile --}}
                <div style="display:flex;align-items:center;gap:14px;margin-top:auto;">
                    <div style="width:46px;height:46px;border-radius:50%;background:#FFC81A;border:2px solid #FFFFFF;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;color:#131218;">
                        @if(!empty($t->foto))
                        <img src="{{ asset('storage/'.$t->foto) }}" alt="{{ $t->nama }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                        <span style="font-size:18px;font-weight:900;line-height:1;">{{ Str::upper(Str::substr($t->nama,0,1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <h4 style="color:#FFFFFF;font-size:14.5px;font-weight:800;margin:0 0 3px;">{{ $t->nama }}</h4>
                        <p style="color:#FFC81A;font-size:11.5px;margin:0;font-weight:700;letter-spacing:.3px;">{{ $t->keterangan }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <style>
        .testimoni-track {
            animation: scroll-testimoni {{ max(15, $trackItems->count() * 5) }}s linear infinite;
        }
        .testimoni-wrapper:hover .testimoni-track {
            animation-play-state: paused;
        }
        @keyframes scroll-testimoni {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-100% - 24px)); }
        }
        </style>
    </div>
</section>



{{-- ══════════════════════════════════════════════════════════════
     FAQ — Clean Off-White Accordion Section
  ══════════════════════════════════════════════════════════════════ --}}
@if($faqs->isNotEmpty())
<section style="padding:90px 24px;background:#F8F9FA;position:relative;overflow:hidden;">
    <div style="max-width:780px;margin:0 auto;position:relative;z-index:1;">
        
        {{-- Header --}}
        <div class="reveal" style="text-align:center;margin-bottom:52px;">
            <span style="display:inline-block;padding:6px 16px;background:#FFC81A;color:#131218;font-size:11px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;border-radius:100px;border:1px solid #131218;margin-bottom:12px;">
                Pusat Informasi
            </span>
            <h2 style="color:#131218;font-size:clamp(26px,4vw,40px);font-weight:900;margin:0 0 12px;line-height:1.2;">
                Pertanyaan yang Sering <span style="color:#FFC81A;background:#131218;padding:2px 10px;border-radius:6px;">Ditanyakan</span>
            </h2>
            <p style="color:#4B5563;font-size:15px;margin:0 auto;max-width:500px;line-height:1.7;">
                Temukan jawaban atas pertanyaan umum seputar program sertifikasi dan pelatihan FCC.
            </p>
        </div>

        {{-- FAQ Accordion --}}
        <div class="reveal" style="display:flex;flex-direction:column;gap:14px;" id="faq-list">
            @foreach($faqs as $i => $faq)
            <div class="faq-item" style="background:#FFFFFF;border:2px solid #E5E7EB;border-radius:16px;overflow:hidden;transition:all .3s ease;box-shadow:0 4px 12px rgba(0,0,0,0.03);">
                <button onclick="toggleFaq(this)"
                    style="width:100%;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:20px 24px;background:none;border:none;cursor:pointer;text-align:left;">
                    <div style="display:flex;align-items:flex-start;gap:14px;flex:1;">
                        <div style="width:30px;height:30px;border-radius:9px;background:#FFC81A;border:1px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                            <span style="color:#131218;font-size:11px;font-weight:900;">{{ str_pad($i+1,'2','0',STR_PAD_LEFT) }}</span>
                        </div>
                        <span style="color:#131218;font-size:15px;font-weight:800;line-height:1.5;">{{ $faq->judul }}</span>
                    </div>
                    <div class="faq-chevron" style="flex-shrink:0;width:32px;height:32px;border-radius:10px;background:#F3F4F6;border:1.5px solid #E5E7EB;display:flex;align-items:center;justify-content:center;transition:all .35s ease;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </button>
                <div class="faq-body" style="max-height:0;overflow:hidden;transition:max-height .45s cubic-bezier(0.16,1,0.3,1);">
                    <div style="padding:0 24px 22px 68px;border-top:1px solid #E5E7EB;">
                        <p style="color:#374151;font-size:14px;line-height:1.8;margin:16px 0 0;">{!! nl2br(e($faq->isi)) !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- CTA Bottom --}}
        <div class="reveal" style="text-align:center;margin-top:48px;">
            <p style="color:#6B7280;font-size:14px;margin:0 0 16px;font-weight:600;">Masih ada pertanyaan lain?</p>
            <a href="{{ route('landing.kontak') }}" style="padding:13px 30px;font-size:14px;font-weight:800;background:#131218;color:#FFC81A;border:2px solid #131218;border-radius:30px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 6px 20px rgba(0,0,0,0.12);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Hubungi Tim Kami
            </a>
        </div>
    </div>
</section>

<style>
    .faq-item.faq-open {
        border-color: #FFC81A !important;
        background: #FFFFFF !important;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06) !important;
    }
    .faq-item.faq-open .faq-chevron {
        background: #FFC81A !important;
        border-color: #131218 !important;
        transform: rotate(180deg);
    }
</style>
<script>
    function toggleFaq(btn) {
        const item  = btn.closest('.faq-item');
        const body  = item.querySelector('.faq-body');
        const inner = body.querySelector('div');
        const isOpen = item.classList.contains('faq-open');

        document.querySelectorAll('.faq-item.faq-open').forEach(el => {
            el.classList.remove('faq-open');
            el.querySelector('.faq-body').style.maxHeight = '0';
        });

        if (!isOpen) {
            item.classList.add('faq-open');
            body.style.maxHeight = inner.scrollHeight + 32 + 'px';
        }
    }
</script>
@endif


@endsection


{{-- ── DATA DARI PHP: dilewatkan ke JS via window.PAGE_DATA ──────── --}}
@push('page-data')
<script>
window.PAGE_DATA = {!! json_encode([
    'arsips'      => $arsips->values()->map(fn($a) => [
        'judul'      => $a->kegiatan->judul ?? ($a->judul ?? ''),
        'ringkasan'  => $a->ringkasan ?? '',
        'created_at' => $a->created_at?->toISOString() ?? '',
        'url'        => route('landing.arsip.show', $a),
    ]),
    'searchRoute' => route('landing.search'),
]) !!};
</script>
@endpush

{{-- ── EXTERNAL JS: dimuat setelah page-data ─────────────────────── --}}
@push('scripts')
@vite('resources/js/pages/landing-index.js')
@endpush
