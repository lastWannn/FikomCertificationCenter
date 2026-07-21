@extends('layouts.public')
@section('title','Tata Cara Pendaftaran')
@section('page-content')
<div style="padding-top:68px; background:linear-gradient(180deg, #131218 0%, #0e0d14 120px, #0e0d14 100%); min-height: 100vh;">
    <div style="background:#131218;padding:52px 24px 44px;text-align:center;position:relative;overflow:hidden;">
        <div style="position:absolute;inset:0;opacity:.04;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div style="position:relative;z-index:1;">
            <h1 class="fcc-gold-text" style="font-size:clamp(28px,5vw,50px);font-weight:900;margin:0 0 10px;">Tata Cara Pendaftaran</h1>
            <p style="color:rgba(255,255,255,.55);font-size:16px;margin:0;">Panduan lengkap mendaftar kegiatan FCC dalam 4 langkah mudah</p>
        </div>
    </div>
    <div style="padding:64px 24px;max-width:1000px;margin:0 auto;">
        {{-- Steps --}}
        <div style="position:relative;margin-bottom:52px;">
            {{-- Garis Latar --}}
            <div style="position:absolute;top:35px;left:12.5%;right:12.5%;height:2px;background:rgba(255,255,255,.08);border-radius:2px;"></div>
            {{-- Garis Progres --}}
            <div style="position:absolute;top:35px;left:12.5%;right:12.5%;height:2px;z-index:1;">
                <div id="step-fill-pend" style="position:absolute;top:0;left:0;height:100%;width:0%;background:linear-gradient(90deg,#FFC81A,#FFD84D);border-radius:2px;transition:width .5s ease;"></div>
            </div>
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;position:relative;z-index:1;">
                @foreach([
                    ['search','Pilih Kegiatan','Jelajahi program pelatihan atau sertifikasi, cek jadwal, harga, dan kuota tersedia.'],
                    ['user-plus','Daftar & Isi Data','Buat akun peserta, isi data diri lengkap, pilih jenis biaya, dan konfirmasi pendaftaran.'],
                    ['credit-card','Bayar & Upload','Aktifkan kode unik, transfer ke rekening FCC, lalu upload bukti transfer di portal.'],
                    ['check','Ikuti Kegiatan','Setelah Admin memverifikasi, kamu resmi terdaftar dan siap mengikuti kegiatan.'],
                ] as $i=>[$ic,$t,$d])
                <div id="step-wrapper-{{ $i }}" style="text-align:center;cursor:pointer;padding:4px;" onclick="setStepInline({{ $i }})" onmouseenter="clearInterval(stepTimer); setStepInline({{ $i }})" onmouseleave="startTimer()">
                    <div id="step-box-{{ $i }}" style="width:70px;height:70px;border-radius:20px;margin:0 auto 16px;position:relative;transition:all .3s ease;
                        background:{{ $i===0 ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : '#16151c' }};
                        border:{{ $i===0 ? '2px solid transparent' : '2px solid rgba(255,255,255,.08)' }};
                        box-shadow:{{ $i===0 ? '0 8px 28px rgba(255,200,26,.45)' : '0 2px 8px rgba(0,0,0,.2)' }};
                        display:flex;align-items:center;justify-content:center;">
                        @include('components.icon',['name'=>$ic,'size'=>26,'style'=>"color:".($i===0?'#111':'rgba(255,255,255,.4)').";transition:color .3s;"])
                        <div style="position:absolute;top:-8px;right:-8px;width:24px;height:24px;border-radius:50%;" class="step-num-badge" style="
                            background:{{ $i===0 ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : 'rgba(255,255,255,.08)' }};
                            display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(255,200,26,.4);transition:all .3s;">
                            <span style="font-size:11px;font-weight:900;color:{{ $i===0?'#111':'rgba(255,255,255,.6)' }};transition:color .3s;">{{ $i+1 }}</span>
                        </div>
                    </div>
                    <p id="step-title-{{ $i }}" style="color:{{ $i===0?'#FFF':'rgba(255,255,255,.6)' }};font-size:14px;font-weight:{{ $i===0?'800':'600' }};margin:0 0 8px;transition:all .3s;">{{ $t }}</p>
                    <p style="color:rgba(255,255,255,.4);font-size:12.5px;line-height:1.7;margin:0;">{{ $d }}</p>
                </div>
                @endforeach
            </div>
            </div>
        </div>
        {{-- Progress dots --}}
        <div style="display:flex;justify-content:center;gap:8px;margin-bottom:36px;" id="step-dots">
            @for($i=0;$i<4;$i++)
            <div onclick="setStepInline({{ $i }})" style="width:{{ $i===0?'20':'8' }}px;height:8px;border-radius:4px;cursor:pointer;transition:all .3s;background:{{ $i===0?'#FFC81A':'rgba(255,255,255,.1)' }};"></div>
            @endfor
        </div>
        {{-- CTA --}}
        <div style="text-align:center;">
            <a href="{{ route('auth.register') }}" class="fcc-btn-gold btn-shine" style="padding:13px 30px;font-size:15px;text-decoration:none;border-radius:12px;">
                @include('components.icon',['name'=>'user-plus','size'=>16]) Mulai Pendaftaran Sekarang
            </a>
        </div>
    </div>
</div>
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

        // Garis progres presisi
        const fill = document.getElementById('step-fill-pend');
        if (fill) fill.style.width = ['0%', '33.33%', '66.66%', '100%'][s];

        // Titik indikator
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
@endpush
