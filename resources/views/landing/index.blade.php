@extends('layouts.public')
@section('title','Beranda')

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

    @media (min-width: 992px) {
        .hero-grid-layout {
            grid-template-columns: 1.15fr 0.85fr !important;
            gap: 56px !important;
        }
    }
    @media (max-width: 991px) {
        .hero-model-section {
            margin-top: 32px;
        }
        .hero-model-wrapper {
            max-width: 360px !important;
            height: 430px !important;
        }
        .floating-badge-bottom {
            bottom: 12px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            width: calc(100% - 32px) !important;
        }
    }
    @media (max-width: 576px) {
        .hero-model-wrapper {
            max-width: 290px !important;
            height: 350px !important;
        }
        .trust-item-divider {
            display: none !important;
        }
    }
</style>
@endpush

@section('page-content')

{{-- ══════════════════════════════════════════════════════════════
     HERO SECTION — High-Impact Portal Layout with Background Image
  ══════════════════════════════════════════════════════════════════ --}}
<section data-hero style="min-height:86vh;background:linear-gradient(180deg, rgba(19,18,24,0.84) 0%, rgba(15,14,21,0.92) 70%, #131218 100%), url('{{ asset("images/herosection.webp") }}?v={{ filemtime(public_path("images/herosection.webp")) }}');background-size:cover;background-position:center;position:relative;overflow:hidden;display:flex;align-items:center;padding:110px 0 75px;border-bottom:1px solid #1E1D26;">
    
    {{-- Main Content Container --}}
    <div style="position:relative;z-index:3;max-width:1240px;margin:0 auto;padding:0 24px;width:100%;">
        <div class="hero-grid-layout" style="display:grid;grid-template-columns:1fr;gap:44px;align-items:center;">
            
            {{-- Left Column: Clean Typography & CTAs --}}
            <div style="max-width:660px;">
                
                {{-- Clean Solid Tag Pill --}}
                <div style="display:inline-flex;align-items:center;gap:10px;margin-bottom:22px;background:#FFC81A;border:1.5px solid #131218;border-radius:100px;padding:6px 18px;box-shadow:0 4px 12px rgba(255,200,26,0.25);">
                    <div style="width:7px;height:7px;border-radius:50%;background:#131218;"></div>
                    <span style="color:#131218;font-size:11px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;">
                        FIKOM CERTIFICATION CENTER &middot; UMI MAKASSAR
                    </span>
                </div>

                {{-- Headline --}}
                <h1 style="color:#FFFFFF;font-size:clamp(34px,4.3vw,56px);font-weight:900;line-height:1.15;margin:0 0 20px;letter-spacing:-1px;">
                    Bimbing Langkah Anda Menuju <span style="color:#FFC81A;">Keahlian Profesional</span> &amp; Sertifikasi Resmi
                </h1>

                {{-- Subtitle --}}
                <p style="color:rgba(255,255,255,0.8);font-size:clamp(15px,1.4vw,17px);margin:0 0 34px;line-height:1.75;max-width:600px;">
                    Platform pelatihan dan sertifikasi kompetensi teknologi terpercaya di Fakultas Ilmu Komputer Universitas Muslim Indonesia. Dapatkan pengakuan karir resmi berstandar industri.
                </p>

                {{-- Action Buttons --}}
                <div style="display:flex;gap:14px;align-items:center;flex-wrap:wrap;margin-bottom:0;">
                    <span class="btn-magnetic">
                        <a href="{{ route('landing.kegiatan') }}" style="padding:14px 32px;font-size:14.5px;border-radius:30px;font-weight:800;display:inline-flex;align-items:center;gap:10px;background:#FFC81A;color:#131218;border:2px solid #FFC81A;box-shadow:0 6px 20px rgba(255,200,26,0.35);text-decoration:none;transition:all .25s ease;">
                            Jelajahi Program Sekarang
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    </span>
                    <span class="btn-magnetic">
                        <a href="{{ route('landing.pendaftaran') }}" style="padding:14px 28px;font-size:14.5px;border-radius:30px;font-weight:800;display:inline-flex;align-items:center;gap:8px;background:#FFFFFF;color:#131218;border:2px solid #FFFFFF;text-decoration:none;box-shadow:0 6px 20px rgba(255,255,255,0.15);transition:all .25s ease;">
                            Cara Mendaftar
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </span>
                </div>

            </div>

            {{-- Right Column: Modern Asymmetric Layered Showcase --}}
            <div class="hero-model-section" style="position:relative;display:flex;justify-content:center;align-items:center;">
                
                <div style="position:relative;width:100%;max-width:430px;height:500px;">
                    
                    {{-- Solid Yellow Angled Backdrop Card --}}
                    <div style="position:absolute;inset:-6px 6px 6px -6px;background:#FFC81A;border-radius:120px 44px 120px 44px;transform:rotate(-3.5deg);z-index:1;box-shadow:0 15px 40px rgba(255,200,26,0.35);"></div>

                    {{-- Main Asymmetric Model Container --}}
                    <div class="hero-model-wrapper" style="position:relative;z-index:2;width:100%;height:100%;border-radius:115px 36px 115px 36px;padding:8px;background:#1E1D26;border:3px solid #131218;box-shadow:0 24px 60px rgba(0,0,0,0.6);overflow:visible;">
                        
                        {{-- Inner Image Arch Container --}}
                        <div style="width:100%;height:100%;border-radius:108px 30px 108px 30px;overflow:hidden;position:relative;background:#131218;">
                            <img src="{{ asset('images/hero-model.png') }}?v={{ filemtime(public_path('images/hero-model.png')) }}" alt="Peserta Sertifikasi FIKOM UMI" style="width:100%;height:100%;object-fit:cover;object-position:top center;transition:transform 0.5s ease;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                        </div>

                        {{-- Floating Badge 1: Top Right Trust Tag --}}
                        <div style="position:absolute;top:-16px;right:-20px;z-index:6;background:#FFC81A;border:2px solid #131218;border-radius:30px;padding:8px 18px;display:flex;align-items:center;gap:8px;box-shadow:0 10px 25px rgba(0,0,0,0.35);">
                            <span style="font-size:14px;">⭐</span>
                            <span style="color:#131218;font-size:12px;font-weight:900;letter-spacing:0.3px;white-space:nowrap;">Standar BNSP &amp; Industri</span>
                        </div>

                        {{-- Floating Badge 2: Bottom Left Verification Badge --}}
                        <div class="floating-badge-bottom" style="position:absolute;bottom:-20px;left:-24px;z-index:6;background:#131218;border:2.5px solid #FFC81A;border-radius:18px;padding:12px 18px;display:flex;align-items:center;gap:12px;box-shadow:0 16px 36px rgba(0,0,0,0.5);">
                            <div style="width:40px;height:40px;border-radius:10px;background:#FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;font-weight:900;flex-shrink:0;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            </div>
                            <div>
                                <p style="margin:0;color:#FFFFFF;font-size:13.5px;font-weight:800;line-height:1.2;">Akreditasi A &amp; Terverifikasi</p>
                                <p style="margin:2px 0 0;color:#FFC81A;font-size:11px;font-weight:800;">Resmi FIKOM UMI</p>
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
        
        {{-- Split Header: Title Left & Filter Right --}}
        <div class="reveal" style="display:flex;align-items:flex-end;justify-content:space-between;gap:24px;margin-bottom:34px;flex-wrap:wrap;">
            <div>
                <span style="display:inline-block;padding:6px 16px;background:#FFC81A;color:#131218;font-size:11px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;border-radius:100px;border:1.5px solid #131218;margin-bottom:10px;">
                    Jadwal Terbaru
                </span>
                <h2 style="color:#131218;font-size:clamp(26px,3.5vw,38px);font-weight:900;margin:0;line-height:1.2;">
                    Kegiatan yang Akan <span style="color:#FFC81A;background:#131218;padding:2px 10px;border-radius:6px;">Datang</span>
                </h2>
            </div>
            
            {{-- Filter Tabs (Right Aligned) --}}
            <div style="display:inline-flex;gap:6px;background:#FFFFFF;padding:5px;border-radius:14px;border:1.5px solid #E5E7EB;box-shadow:0 3px 10px rgba(0,0,0,0.04);">
                @foreach([['all','Semua'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
                <button data-filter="{{ $v }}"
                    style="padding:8px 22px;border-radius:9px;border:none;font-size:13px;font-weight:800;cursor:pointer;transition:all .2s ease;
                           background:{{ $v==='all'?'#FFC81A':'transparent' }};
                           color:{{ $v==='all'?'#131218':'#6B7280' }};
                           {{ $v==='all'?'border:1.5px solid #131218;':'' }}">
                    {{ $l }}
                </button>
                @endforeach
            </div>
        </div>

        {{-- Cards Grid (3 Columns) --}}
        <div id="kegiatan-grid" style="display:grid; grid-template-columns:repeat(3, 1fr); gap:24px;">
            @forelse($kegiatanTerbaru->take(3) as $k)
            @php
                $isPel       = $k->jenis_kegiatan === 'pelatihan';
                $posterUrl   = $k->detail?->gambar_url;
            @endphp
            <div class="kegiatan-card" data-jenis="{{ $k->jenis_kegiatan }}"
                 style="border-radius:18px; border:2px solid #E5E7EB; background:#FFFFFF; overflow:hidden; display:flex; flex-direction:column; justify-content:space-between; transition:all 0.28s ease; box-shadow:0 4px 16px rgba(0,0,0,0.04);"
                 onmouseover="this.style.transform='translateY(-6px)'; this.style.borderColor='#FFC81A'; this.style.boxShadow='0 16px 32px rgba(0,0,0,0.08)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E5E7EB'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">

                <div>
                    {{-- Poster Container (Height 185px) --}}
                    <div style="position:relative; width:100%; height:185px; overflow:hidden; background:#131218;">
                        @if($posterUrl)
                        <img src="{{ $posterUrl }}" alt="{{ $k->judul }}" style="width:100%; height:100%; object-fit:cover; object-position:center top; display:block; transition:transform 0.4s ease;"
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
                            <span style="font-size:10.5px; font-weight:800; color:{{ $k->isFull() ? '#EF4444' : '#131218' }}; background:#FFFFFF; padding:4px 10px; border-radius:6px; border:1px solid #131218; box-shadow:0 2px 8px rgba(0,0,0,0.15);">
                                {{ $k->isFull() ? 'Kuota Penuh' : ($k->biaya->isNotEmpty() ? 'Berbayar' : 'Gratis') }}
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
                                            background:{{ $k->isFull() ? '#EF4444' : '#FFC81A' }};
                                            width:{{ $k->kuota>0 ? min(100, round($k->terisi/$k->kuota*100)) : 0 }}%;"></div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Action Button --}}
                <div style="padding:0 18px 16px;">
                    <a href="{{ route('landing.show', $k) }}"
                       style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; padding:10.5px 14px; border-radius:10px; font-size:13px; font-weight:800; transition:all 0.2s ease; width:100%; box-sizing:border-box;
                              {{ $k->isFull() ? 'background:#F3F4F6; border:1px solid #E5E7EB; color:#9CA3AF; cursor:not-allowed;' : 'background:#FFC81A; color:#131218; border:1.5px solid #131218; box-shadow:0 4px 12px rgba(255,200,26,0.3);' }}">
                        {{ $k->isFull() ? 'Kuota Penuh' : 'Detail & Daftar →' }}
                    </a>
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
    <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;position:relative;z-index:1;">
        
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
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:4px;">
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
     TATA CARA PENDAFTARAN — Clean White Section
  ══════════════════════════════════════════════════════════════════ --}}
<section style="padding:90px 24px;background:#FFFFFF; position:relative; overflow:hidden; border-bottom:1px solid #E5E7EB;">
    <div style="max-width:1100px;margin:0 auto;position:relative;z-index:1;">
        <div class="reveal" style="text-align:center;margin-bottom:54px;">
            <span style="display:inline-block;padding:6px 16px;background:#131218;color:#FFC81A;font-size:11px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;border-radius:100px;margin-bottom:12px;">
                Mudah &amp; Cepat
            </span>
            <h2 style="color:#131218;font-size:clamp(26px,4vw,40px);font-weight:900;margin:0 0 12px;">
                Tata Cara <span style="color:#FFC81A;background:#131218;padding:2px 10px;border-radius:6px;">Pendaftaran</span>
            </h2>
            <p style="color:#4B5563;font-size:15px;margin:0 auto;max-width:440px;">
                Selesaikan proses pendaftaran Anda dalam 4 langkah mudah.
            </p>
        </div>

        {{-- Steps Grid --}}
        <div style="position:relative;margin-bottom:44px;">
            {{-- Connector line --}}
            <div style="position:absolute;top:35px;left:12.5%;right:12.5%;height:3px;background:#E5E7EB;border-radius:2px;"></div>
            {{-- Progress fill line --}}
            <div style="position:absolute;top:35px;left:12.5%;right:12.5%;height:3px;z-index:1;">
                <div id="step-fill-pend" style="position:absolute;top:0;left:0;height:100%;width:0%;background:#FFC81A;border-radius:2px;transition:width .5s ease;"></div>
            </div>
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;position:relative;z-index:1;">
                @foreach([
                    ['search','Pilih Kegiatan','Jelajahi program pelatihan atau sertifikasi, cek jadwal, harga, dan kuota tersedia.'],
                    ['user-plus','Daftar & Isi Data','Buat akun peserta, isi data diri lengkap, pilih jenis biaya, dan konfirmasi pendaftaran.'],
                    ['credit-card','Bayar & Upload','Aktifkan kode unik, transfer ke rekening FCC, lalu upload bukti transfer di portal.'],
                    ['check','Ikuti Kegiatan','Setelah Admin memverifikasi, kamu resmi terdaftar dan siap mengikuti kegiatan.'],
                ] as $si=>[$ic,$t,$d])
                <div id="step-wrapper-{{ $si }}" class="reveal" style="text-align:center;cursor:pointer;padding:6px;transition-delay:{{ $si*100 }}ms;" onclick="setStepInline({{ $si }})" onmouseenter="clearInterval(stepTimer); setStepInline({{ $si }})" onmouseleave="startTimer()">
                    <div id="step-box-{{ $si }}" style="width:68px;height:68px;border-radius:18px;margin:0 auto 16px;position:relative;transition:all .3s ease;
                        background:{{ $si===0 ? '#FFC81A' : '#F3F4F6' }};
                        border:{{ $si===0 ? '2px solid #131218' : '2px solid #E5E7EB' }};
                        box-shadow:{{ $si===0 ? '0 6px 18px rgba(0,0,0,0.12)' : 'none' }};
                        display:flex;align-items:center;justify-content:center;">
                        @include('components.icon',['name'=>$ic,'size'=>24,'style'=>"color:".($si===0?'#131218':'#6B7280').";transition:color .3s;"])
                        <div class="step-num-badge" style="position:absolute;top:-8px;right:-8px;width:24px;height:24px;border-radius:50%;
                            background:{{ $si===0 ? '#131218' : '#E5E7EB' }};
                            display:flex;align-items:center;justify-content:center;transition:all .3s;">
                            <span style="font-size:11px;font-weight:900;color:{{ $si===0?'#FFC81A':'#6B7280' }};transition:color .3s;">{{ $si+1 }}</span>
                        </div>
                    </div>
                    <p id="step-title-{{ $si }}" style="color:{{ $si===0?'#131218':'#4B5563' }};font-size:14.5px;font-weight:{{ $si===0?'800':'600' }};margin:0 0 8px;transition:all .3s;">{{ $t }}</p>
                    <p style="color:#6B7280;font-size:12.5px;line-height:1.65;margin:0;">{{ $d }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Progress Dots --}}
        <div style="display:flex;justify-content:center;gap:8px;margin-bottom:36px;" id="step-dots">
            @for($i=0;$i<4;$i++)
            <div onclick="setStepInline({{ $i }})" style="width:{{ $i===0?'22':'8' }}px;height:8px;border-radius:4px;cursor:pointer;transition:all .3s;background:{{ $i===0?'#FFC81A':'#E5E7EB' }};"></div>
            @endfor
        </div>

        <div style="text-align:center;">
            <span class="btn-magnetic">
                <a href="{{ route('auth.register') }}" style="padding:14px 32px;font-size:15px;font-weight:800;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:30px;text-decoration:none;display:inline-flex;align-items:center;gap:10px;box-shadow:0 6px 20px rgba(255,200,26,0.35);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    Mulai Pendaftaran Sekarang
                </a>
            </span>
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
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:28px;">
            @foreach($mitras as $index => $m)
            <div class="spring-up stagger-{{ ($index % 3) + 1 }}" 
                 style="background:#FFFFFF;border:2px solid #E5E7EB;border-radius:24px;padding:36px 30px;display:flex;flex-direction:column;align-items:center;text-align:center;transition:all .3s ease;box-shadow:0 6px 20px rgba(0,0,0,0.03);"
                 onmouseover="this.style.borderColor='#FFC81A';this.style.transform='translateY(-6px)';this.style.boxShadow='0 16px 36px rgba(0,0,0,0.08)';"
                 onmouseout="this.style.borderColor='#E5E7EB';this.style.transform='translateY(0)';this.style.boxShadow='0 6px 20px rgba(0,0,0,0.03)';">
                
                {{-- Logo Box --}}
                <div style="width:76px;height:76px;border-radius:20px;background:#131218;border:2.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;margin-bottom:22px;box-shadow:0 8px 20px rgba(19,18,24,0.25);">
                    @if($m->logo)
                    <img src="{{ asset('storage/'.$m->logo) }}" alt="{{ $m->nama_mitra }}" style="width:52px;height:52px;object-fit:contain;filter:brightness(0) invert(1);">
                    @else
                    <span style="color:#FFC81A;font-size:18px;font-weight:900;letter-spacing:.5px;font-family:monospace;">{{ Str::upper(Str::substr($m->inisial ?? $m->nama_mitra,0,4)) }}</span>
                    @endif
                </div>

                {{-- Partner Name --}}
                <h3 style="color:#131218;font-size:20px;font-weight:900;margin:0 0 8px;line-height:1.3;">
                    {{ $m->nama_mitra }}
                </h3>

                {{-- Sub-label --}}
                <p style="color:#6B7280;font-size:13px;font-weight:700;margin:0 0 24px;text-transform:uppercase;letter-spacing:.5px;">
                    Mitra Resmi FIKOM UMI
                </p>

                {{-- Button Link --}}
                @if($m->link_website)
                <a href="{{ $m->link_website }}" target="_blank" rel="noopener noreferrer" 
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
<script>
    const STEP_COUNT = 4;
    let curStep = 0, stepTimer;

    function setStepInline(s) {
        curStep = s;
        for (let i = 0; i < STEP_COUNT; i++) {
            const wrapper = document.getElementById(`step-wrapper-${i}`);
            if (!wrapper) continue;
            
            const box   = document.getElementById(`step-box-${i}`);
            const ic    = box ? box.querySelector('svg') : null;
            const num   = wrapper.querySelector('.step-num-badge');
            const numText = num ? num.querySelector('span') : null;
            const title = document.getElementById(`step-title-${i}`);
            
            const isActive = i === s;
            const isPast   = i < s;

            if (box) {
                box.style.background = isActive ? '#FFC81A' : (isPast ? '#131218' : '#F3F4F6');
                box.style.border = isActive ? '2px solid #131218' : (isPast ? '2px solid #FFC81A' : '2px solid #E5E7EB');
                box.style.boxShadow = isActive ? '0 6px 18px rgba(0,0,0,0.12)' : 'none';
            }
            if (ic) ic.style.color = isActive ? '#131218' : (isPast ? '#FFC81A' : '#6B7280');
            
            if (num) {
                num.style.background = i <= s ? '#131218' : '#E5E7EB';
            }
            if (numText) {
                numText.style.color = i <= s ? '#FFC81A' : '#6B7280';
            }
            if (title) {
                title.style.color = isActive ? '#131218' : '#4B5563';
            }
        }

        const fill = document.getElementById('step-fill-pend');
        if (fill) fill.style.width = ['0%', '33.33%', '66.66%', '100%'][s];

        document.querySelectorAll('#step-dots div').forEach((d, i) => {
            d.style.width      = i === s ? '22px' : '8px';
            d.style.background = i === s ? '#FFC81A' : '#E5E7EB';
        });
    }

    function startTimer() {
        stepTimer = setInterval(() => setStepInline((curStep + 1) % STEP_COUNT), 2400);
    }

    document.addEventListener('DOMContentLoaded', () => {
        setStepInline(0);
        startTimer();
    });
</script>
@vite('resources/js/pages/landing-index.js')
@endpusharch'),
]) !!};
</script>
@endpush

{{-- ── EXTERNAL JS: dimuat setelah page-data ─────────────────────── --}}
@push('scripts')
<script>
    const STEP_COUNT = 4;
    let curStep = 0, stepTimer;

    function setStepInline(s) {
        curStep = s;
        for (let i = 0; i < STEP_COUNT; i++) {
            const wrapper = document.getElementById(`step-wrapper-${i}`);
            if (!wrapper) continue;
            
            const box   = document.getElementById(`step-box-${i}`);
            const ic    = box ? box.querySelector('svg') : null;
            const num   = wrapper.querySelector('.step-num-badge');
            const numText = num ? num.querySelector('span') : null;
            const title = document.getElementById(`step-title-${i}`);
            
            const isActive = i === s;
            const isPast   = i < s;

            if (box) {
                box.style.background = isActive
                    ? 'linear-gradient(135deg,#FFC81A,#FFD84D)'
                    : isPast ? '#1a1921' : '#16151c';
                box.style.border = isActive ? '2px solid transparent'
                    : isPast ? '2px solid rgba(255,200,26,.3)' : '2px solid rgba(255,255,255,.08)';
                box.style.boxShadow = isActive ? '0 8px 28px rgba(255,200,26,.45)' : '0 2px 8px rgba(0,0,0,.2)';
            }
            if (ic) ic.style.color = isActive ? '#111' : (isPast ? '#FFC81A' : 'rgba(255,255,255,.4)');
            
            if (num) {
                num.style.background = i <= s ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : 'rgba(255,255,255,.08)';
                num.style.boxShadow  = i <= s ? '0 2px 8px rgba(255,200,26,.4)' : 'none';
            }
            if (numText) {
                numText.style.color = i <= s ? '#111' : 'rgba(255,255,255,.6)';
            }
            if (title) {
                title.style.color = isActive ? '#FFF' : 'rgba(255,255,255,.6)';
            }
        }

        const fill = document.getElementById('step-fill-pend');
        if (fill) fill.style.width = ['0%', '33.33%', '66.66%', '100%'][s];

        document.querySelectorAll('#step-dots div').forEach((d, i) => {
            d.style.width      = i === s ? '20px' : '8px';
            d.style.background = i === s ? '#FFC81A' : 'rgba(255,255,255,.1)';
        });
    }

    function startTimer() {
        stepTimer = setInterval(() => setStepInline((curStep + 1) % STEP_COUNT), 2400);
    }

    document.addEventListener('DOMContentLoaded', () => {
        setStepInline(0);
        startTimer();
    });
</script>
@vite('resources/js/pages/landing-index.js')
@endpush
