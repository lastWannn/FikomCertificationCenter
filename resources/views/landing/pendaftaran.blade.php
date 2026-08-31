@extends('layouts.public')
@section('title','Tata Cara Pendaftaran')
@section('meta-description', 'Panduan praktis dan alur pendaftaran pelatihan dan sertifikasi kompetensi di FIKOM Certification Center UMI Makassar.')
@section('page-content')
<div class="page-content-wrap" style="background:#131218; min-height: calc(100vh - 100px);">
    {{-- Hero Header --}}
    <div class="fcc-pend-hero">
        <!-- Ambient Glow -->
        <div style="position:absolute; top:-50%; left:50%; transform:translateX(-50%); width:600px; height:600px; max-width:100vw; border-radius:50%; background:radial-gradient(circle, rgba(255,200,26,0.08), transparent 70%); pointer-events:none;"></div>
        <div style="position:absolute; inset:0; opacity:.03; background-image:linear-gradient(rgba(255,200,26,1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,200,26,1) 1px, transparent 1px); background-size:50px 50px;"></div>
        
        <div style="position:relative; z-index:1; max-width:800px; margin:0 auto; width:100%; box-sizing:border-box;">
            <span style="display:inline-block; padding:5px 16px; background:#FFC81A; color:#131218; font-size:10.5px; font-weight:900; text-transform:uppercase; letter-spacing:1.5px; margin-bottom:12px; border-radius:100px; border:1.5px solid #131218; box-shadow:0 4px 12px rgba(255, 200, 26, 0.25);">
                Mudah &amp; Cepat
            </span>
            <h1 style="color:#FFFFFF; font-size:clamp(24px,4.5vw,42px); font-weight:900; margin:0 0 12px; letter-spacing:-0.6px; line-height:1.15;">
                Tata Cara <span style="color:#FFC81A; background:#131218; padding:2px 10px; border-radius:6px;">Pendaftaran</span>
            </h1>
            <p style="color:rgba(255,255,255,0.8); font-size:clamp(13.5px, 1.4vw, 15px); margin:0 auto; max-width:480px; line-height:1.6; font-weight:500;">
                Panduan praktis mendaftar kegiatan pelatihan &amp; sertifikasi FCC FIKOM UMI dalam 4 langkah mudah.
            </p>
        </div>
    </div>

    {{-- Main Section — Clean White Section --}}
    <div class="fcc-pend-section">
        <div style="max-width:1100px; margin:0 auto; width:100%; position:relative; z-index:1; box-sizing:border-box;">
            
            {{-- Steps Grid / List --}}
            <div style="position:relative; margin-bottom:36px;">
                {{-- Connector line (Desktop only) --}}
                <div class="fcc-step-line" style="position:absolute; top:35px; left:12.5%; right:12.5%; height:3px; background:#E5E7EB; border-radius:2px;"></div>
                {{-- Progress fill line (Desktop only) --}}
                <div class="fcc-step-line" style="position:absolute; top:35px; left:12.5%; right:12.5%; height:3px; z-index:1;">
                    <div id="step-fill-pend" style="position:absolute; top:0; left:0; height:100%; width:0%; background:#FFC81A; border-radius:2px; transition:width .5s ease;"></div>
                </div>
                
                <div class="fcc-steps-container">
                    @foreach([
                        ['search','Pilih Kegiatan','Jelajahi program pelatihan atau sertifikasi, cek jadwal, harga, dan kuota tersedia.'],
                        ['user-plus','Daftar & Isi Data','Buat akun peserta, isi data diri lengkap, pilih jenis biaya, dan konfirmasi pendaftaran.'],
                        ['credit-card','Bayar & Upload','Aktifkan kode unik, transfer ke rekening FCC, lalu upload bukti transfer di portal.'],
                        ['check','Ikuti Kegiatan','Setelah Admin memverifikasi, kamu resmi terdaftar dan siap mengikuti kegiatan.'],
                    ] as $si=>[$ic,$t,$d])
                    <div id="step-wrapper-{{ $si }}" class="fcc-step-item fcc-step-mobile-card" onclick="setStepInline({{ $si }})" onmouseenter="clearInterval(stepTimer); setStepInline({{ $si }})" onmouseleave="startTimer()">
                        <div id="step-box-{{ $si }}" class="fcc-step-box" style="background:{{ $si===0 ? '#FFC81A' : '#F3F4F6' }}; border:{{ $si===0 ? '2px solid #131218' : '2px solid #E5E7EB' }}; box-shadow:{{ $si===0 ? '0 6px 18px rgba(0,0,0,0.12)' : 'none' }};">
                            @include('components.icon',['name'=>$ic,'size'=>22,'style'=>"color:".($si===0?'#131218':'#6B7280').";transition:color .3s;"])
                            <div class="step-num-badge" style="position:absolute; top:-7px; right:-7px; width:22px; height:22px; border-radius:50%; background:{{ $si===0 ? '#131218' : '#E5E7EB' }}; display:flex; align-items:center; justify-content:center; transition:all .3s;">
                                <span style="font-size:10.5px; font-weight:900; color:{{ $si===0?'#FFC81A':'#6B7280' }}; transition:color .3s;">{{ $si+1 }}</span>
                            </div>
                        </div>
                        <div class="fcc-step-text-wrap">
                            <p id="step-title-{{ $si }}" style="color:{{ $si===0?'#131218':'#4B5563' }}; font-size:14.5px; font-weight:{{ $si===0?'800':'600' }}; margin:0 0 4px; transition:all .3s;">{{ $t }}</p>
                            <p style="color:#6B7280; font-size:12.5px; line-height:1.55; margin:0;">{{ $d }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Progress Dots (Desktop) --}}
            <div class="fcc-step-dots-wrap" style="display:flex; justify-content:center; gap:8px; margin-bottom:32px;" id="step-dots">
                @for($i=0;$i<4;$i++)
                <div onclick="setStepInline({{ $i }})" style="width:{{ $i===0?'22':'8' }}px; height:8px; border-radius:4px; cursor:pointer; transition:all .3s; background:{{ $i===0?'#FFC81A':'#E5E7EB' }};"></div>
                @endfor
            </div>

            {{-- CTA Button --}}
            <div style="text-align:center;">
                <a href="{{ route('auth.register') }}" class="fcc-pend-cta"
                   onmouseover="this.style.background='#131218'; this.style.color='#FFC81A';" onmouseout="this.style.background='#FFC81A'; this.style.color='#131218';">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    <span>Mulai Pendaftaran Sekarang</span>
                </a>
            </div>

        </div>
    </div>
</div>

<style>
/* Base / Desktop Layout */
.fcc-pend-hero {
    background: #131218;
    padding: 48px 24px 44px;
    text-align: center;
    position: relative;
    overflow: hidden;
    border-bottom: 1px solid #1E1D26;
    box-sizing: border-box;
    width: 100%;
}
.fcc-pend-section {
    background: #FFFFFF;
    padding: 64px 24px 80px;
    border-bottom: 1px solid #E5E7EB;
    box-sizing: border-box;
    width: 100%;
}
.fcc-steps-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    position: relative;
    z-index: 1;
    box-sizing: border-box;
    width: 100%;
}
.fcc-step-item {
    text-align: center;
    cursor: pointer;
    padding: 8px 6px;
    box-sizing: border-box;
    transition: all 0.25s ease;
}
.fcc-step-box {
    width: 64px;
    height: 64px;
    border-radius: 18px;
    margin: 0 auto 14px;
    position: relative;
    transition: all .3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.fcc-pend-cta {
    padding: 14px 32px;
    font-size: 14.5px;
    font-weight: 800;
    background: #FFC81A;
    color: #131218;
    border: 1.5px solid #131218;
    border-radius: 30px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 6px 20px rgba(255,200,26,0.35);
    transition: all 0.2s ease;
    box-sizing: border-box;
}

/* Mobile & Tablet Layout (< 768px) */
@media (max-width: 767px) {
    .fcc-pend-hero {
        padding: 32px 16px 36px !important;
    }
    .fcc-pend-section {
        padding: 32px 14px 48px !important;
    }
    .fcc-step-line {
        display: none !important;
    }
    .fcc-steps-container {
        display: flex !important;
        flex-direction: column !important;
        gap: 12px !important;
    }
    .fcc-step-item.fcc-step-mobile-card {
        display: flex !important;
        align-items: flex-start !important;
        gap: 14px !important;
        text-align: left !important;
        background: #F9FAFB;
        border: 1.5px solid #E5E7EB;
        border-radius: 16px;
        padding: 14px 14px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    .fcc-step-box {
        width: 46px !important;
        height: 46px !important;
        min-width: 46px !important;
        border-radius: 12px !important;
        margin: 0 !important;
    }
    .fcc-step-box svg {
        width: 18px !important;
        height: 18px !important;
    }
    .fcc-step-text-wrap {
        flex: 1;
        min-width: 0;
    }
    .fcc-step-dots-wrap {
        display: none !important;
    }
    .fcc-pend-cta {
        width: 100% !important;
        max-width: 320px !important;
        padding: 13px 20px !important;
        font-size: 14px !important;
    }
}
</style>
@endsection

@push('page-data')
<script>window.PAGE_DATA = { pendaftaranPage: true };</script>
@endpush

@push('scripts')
<script>
    const STEP_COUNT = 4;
    let curStep = 0, stepTimer;

    function setStepInline(s) {
        curStep = s;
        for (let i = 0; i < STEP_COUNT; i++) {
            const wrapper = document.getElementById(`step-wrapper-${i}`);
            if (!wrapper) continue;
            
            const box     = document.getElementById(`step-box-${i}`);
            const ic      = box ? box.querySelector('svg') : null;
            const num     = wrapper.querySelector('.step-num-badge');
            const numText = num ? num.querySelector('span') : null;
            const title   = document.getElementById(`step-title-${i}`);
            
            const isActive = i === s;
            const isPast   = i < s;

            // Mobile card border and background highlight
            if (window.innerWidth < 768) {
                wrapper.style.borderColor = isActive ? '#FFC81A' : '#E5E7EB';
                wrapper.style.background  = isActive ? '#FFFDF5' : '#F9FAFB';
                wrapper.style.boxShadow   = isActive ? '0 4px 14px rgba(255,200,26,0.15)' : 'none';
            }

            if (box) {
                box.style.background = isActive
                    ? '#FFC81A'
                    : isPast ? '#FFEBA0' : '#F3F4F6';
                box.style.border = isActive ? '2px solid #131218'
                    : isPast ? '2px solid #FFC81A' : '2px solid #E5E7EB';
                box.style.boxShadow = isActive ? '0 6px 18px rgba(0,0,0,0.12)' : 'none';
            }
            if (ic) ic.style.color = (isActive || isPast) ? '#131218' : '#6B7280';
            
            if (num) {
                num.style.background = i <= s ? '#131218' : '#E5E7EB';
                num.style.boxShadow  = i <= s ? '0 2px 8px rgba(0,0,0,0.15)' : 'none';
            }
            if (numText) {
                numText.style.color = i <= s ? '#FFC81A' : '#6B7280';
            }
            if (title) {
                title.style.color = isActive ? '#131218' : '#374151';
            }
        }

        // Garis progres presisi (desktop)
        const fill = document.getElementById('step-fill-pend');
        if (fill) fill.style.width = ['0%', '33.33%', '66.66%', '100%'][s];

        // Titik indikator
        document.querySelectorAll('#step-dots div').forEach((d, i) => {
            d.style.width      = i === s ? '22px' : '8px';
            d.style.background = i === s ? '#FFC81A' : '#E5E7EB';
        });
    }

    function startTimer() {
        stepTimer = setInterval(() => setStepInline((curStep + 1) % STEP_COUNT), 2600);
    }

    document.addEventListener('DOMContentLoaded', () => {
        setStepInline(0);
        startTimer();
    });
</script>
@endpush
