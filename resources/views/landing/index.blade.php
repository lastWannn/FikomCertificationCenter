@extends('layouts.public')
@section('title','Beranda')
@section('page-content')

{{-- ══════════════════════════════════════════════════════════════
     HERO — #131218 (satu-satunya bagian gelap di atas)
     Kuning #FFC81A pop sempurna di latar hitam
 ══════════════════════════════════════════════════════════════════ --}}
<section data-hero style="min-height:100vh;background:#131218;position:relative;overflow:hidden;
    display:flex;align-items:center;justify-content:center;">
    {{-- Particle Canvas --}}
    <canvas id="hero-particles"></canvas>
    {{-- Grid pattern --}}
    <div style="position:absolute;inset:0;opacity:.04;
        background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),
                         linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);
        background-size:64px 64px;z-index:0;"></div>
    {{-- Animasi ornamen — Parallax Layers --}}
    <div class="parallax-layer" data-parallax="20" style="position:absolute;top:8%;right:5%;width:300px;height:300px;animation:spin 22s linear infinite;">
        <svg width="300" height="300" viewBox="0 0 300 300">
            <circle cx="150" cy="150" r="138" fill="none" stroke="rgba(255,200,26,.10)" stroke-width="1" stroke-dasharray="8 7"/>
            <circle cx="150" cy="150" r="104" fill="none" stroke="rgba(255,200,26,.06)" stroke-width="1" stroke-dasharray="4 11"/>
        </svg>
    </div>
    <div class="parallax-layer" data-parallax="12" style="position:absolute;top:12%;right:9%;width:150px;height:150px;animation:rspin 14s linear infinite;">
        <svg width="150" height="150" viewBox="0 0 150 150">
            <circle cx="75" cy="75" r="68" fill="none" stroke="rgba(255,200,26,.18)" stroke-width="1.5" stroke-dasharray="11 5"/>
        </svg>
    </div>
    <div class="parallax-layer hex" data-parallax="8" style="position:absolute;top:18%;right:13%;width:44px;height:44px;
        background:rgba(255,200,26,.18);animation:float1 6s ease-in-out infinite;"></div>
    <div class="parallax-layer hex" data-parallax="18" style="position:absolute;top:62%;right:4%;width:26px;height:26px;
        background:rgba(255,200,26,.12);animation:float2 8s ease-in-out infinite 1.4s;"></div>
    <div class="parallax-layer dia" data-parallax="25" style="position:absolute;top:40%;right:1.5%;width:20px;height:20px;
        background:rgba(255,200,26,.22);animation:float3 5.5s ease-in-out infinite .7s;"></div>
    <div class="parallax-layer dia" data-parallax="10" style="position:absolute;top:72%;right:16%;width:14px;height:14px;
        background:rgba(255,200,26,.25);animation:float1 7s ease-in-out infinite 2s;"></div>
    {{-- Extra left ornaments --}}
    <div class="parallax-layer" data-parallax="14" style="position:absolute;top:25%;left:4%;width:80px;height:80px;border-radius:50%;border:1.5px solid rgba(255,200,26,.12);animation:rspin 18s linear infinite;"></div>
    <div class="parallax-layer hex" data-parallax="20" style="position:absolute;top:55%;left:8%;width:18px;height:18px;background:rgba(255,200,26,.2);animation:float2 7s ease-in-out infinite 1s;"></div>
    {{-- Dot grid kiri bawah --}}
    <div style="position:absolute;bottom:7%;left:3%;opacity:.28;z-index:2;">
        <svg width="108" height="108" viewBox="0 0 108 108">
            @foreach([0,22,44,66,88] as $x)@foreach([0,22,44,66,88] as $y)
            <circle cx="{{ $x+6 }}" cy="{{ $y+6 }}" r="1.8" fill="#FFC81A"/>
            @endforeach@endforeach
        </svg>
    </div>
    {{-- Gradient overlay bawah --}}
    <div style="position:absolute;bottom:0;left:0;right:0;height:30%;
        background:linear-gradient(to top,rgba(19,18,24,.8),transparent);z-index:2;"></div>

    {{-- Content --}}
    <div style="position:relative;z-index:3;text-align:center;max-width:820px;padding:110px 24px 60px;">
        {{-- Label --}}
        <div style="display:inline-flex;align-items:center;gap:8px;margin-bottom:28px;
            background:rgba(255,200,26,.1);border:1px solid rgba(255,200,26,.28);
            border-radius:100px;padding:6px 18px;animation:fadeUp .7s ease .1s both;">
            <div class="hero-badge-live" style="width:6px;height:6px;border-radius:50%;background:#FFC81A;"></div>
            <span style="color:#FFC81A;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;">
                Fakultas Ilmu Komputer &middot; Universitas Muslim Indonesia
            </span>
        </div>
        {{-- Headline --}}
        <h1 style="color:#FFF;font-size:clamp(38px,6.5vw,68px);font-weight:900;
            line-height:1.07;margin:0 0 20px;letter-spacing:-1.5px;
            animation:fadeUp .7s ease .25s both;">
            <span class="fcc-gold-text">FIKOM</span> Certification<br/>Center
        </h1>
        {{-- Tagline --}}
        <p style="color:rgba(255,255,255,.6);font-size:clamp(15px,2vw,18px);
            margin:0 auto 42px;line-height:1.8;max-width:560px;
            animation:fadeUp .7s ease .4s both;">
            Platform sertifikasi dan pelatihan profesional untuk mahasiswa dan masyarakat umum.
            <br/><strong style="color:rgba(255,255,255,.88);">Tingkatkan kompetensi. Raih pengakuan resmi.</strong>
        </p>
        {{-- CTA --}}
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;animation:fadeUp .7s ease .55s both;">
            <span class="btn-magnetic">
                <a href="{{ route('landing.kegiatan') }}" class="fcc-btn-gold btn-shine" style="padding:13px 28px;font-size:15px;">
                    Lihat Kegiatan
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </span>
            <span class="btn-magnetic">
                <a href="{{ route('landing.pendaftaran') }}" class="fcc-btn-outline-light" style="padding:13px 28px;font-size:15px;">
                    Cara Mendaftar
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </span>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     STATS — Premium gradient cards berwarna + animasi counter
 ══════════════════════════════════════════════════════════════════ --}}
<section style="background:linear-gradient(180deg, #131218 0%, #0e0d14 120px, #0e0d14 100%); padding:80px 24px 72px; border-bottom: none; position:relative; overflow:hidden;">
    <div style="position:absolute;inset:0;opacity:.02;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:600px;height:200px;background:radial-gradient(ellipse,rgba(255,200,26,0.05),transparent 70%);pointer-events:none;"></div>
    
    <div style="max-width:1100px;margin:0 auto;
        display:grid;grid-template-columns:repeat(4,1fr);gap:22px;position:relative;z-index:1;">
        @php
            $statItems = [
                [$stats['pelatihan'],'+','Program Pelatihan','book-open','#FFC81A','rgba(255,200,26,.15)','linear-gradient(135deg,#FFC81A,#FFD84D)','rgba(255,200,26,.3)'],
                [$stats['sertifikasi'],'+','Jenis Sertifikasi','award','#8B5CF6','rgba(139,92,246,.15)','linear-gradient(135deg,#8B5CF6,#A78BFA)','rgba(139,92,246,.3)'],
                [$stats['peserta'],'+','Peserta Terdaftar','users','#10B981','rgba(16,185,129,.15)','linear-gradient(135deg,#10B981,#34D399)','rgba(16,185,129,.3)'],
                [$stats['mitra'],'','Mitra Institusi','building','#3B82F6','rgba(59,130,246,.15)','linear-gradient(135deg,#3B82F6,#60A5FA)','rgba(59,130,246,.3)'],
            ];
        @endphp
        @foreach($statItems as $i=>[$val,$suf,$lbl,$ic,$color,$icBg,$grad,$glow])
        <div class="reveal tilt-card" style="transition-delay:{{ $i*110 }}ms;
            background:rgba(255,255,255,.03);
            border:1px solid rgba(255,255,255,.08);
            border-radius:24px;
            padding:32px 24px;
            text-align:center;
            position:relative;
            overflow:hidden;
            box-shadow:0 4px 12px rgba(0,0,0,.2);
            transition:all .35s cubic-bezier(.4,0,.2,1);"
             onmouseover="this.style.borderColor='{{ $color }}60';this.style.boxShadow='0 20px 48px {{ $glow }}, 0 8px 24px rgba(0,0,0,.3)';this.style.transform='translateY(-6px)'"
             onmouseout="this.style.borderColor='rgba(255,255,255,.08)';this.style.boxShadow='0 4px 12px rgba(0,0,0,.2)';this.style.transform='translateY(0)'">
            {{-- Glow accent top --}}
            <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);
                width:60%;height:3px;background:linear-gradient(90deg,transparent,{{ $color }}80,transparent);opacity:0;transition:opacity .3s;"
                onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'"></div>
            {{-- Icon --}}
            <div style="width:56px;height:56px;border-radius:18px;margin:0 auto 20px;
                background:{{ $icBg }};border:1px solid {{ $color }}30;
                display:flex;align-items:center;justify-content:center;">
                @include('components.icon',['name'=>$ic,'size'=>24,'style'=>"color:{$color}"])
            </div>
            {{-- Number --}}
            <p class="stat-number" data-count="{{ $val }}" data-suffix="{{ $suf }}"
               style="margin:0 0 8px;
                font-size:clamp(32px,3.5vw,46px);font-weight:900;letter-spacing:-2px;line-height:1;
                background:{{ $grad }};-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $val }}{{ $suf }}</p>
            {{-- Label --}}
            <p style="margin:0;color:rgba(255,255,255,.6);font-size:12.5px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;">{{ $lbl }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     KEGIATAN — Surface #F7F8FA (abu sangat terang)
 ══════════════════════════════════════════════════════════════════ --}}
<section style="padding:96px 24px;background:linear-gradient(180deg, #0e0d14 0%, #131218 120px, #131218 100%); position:relative; overflow:hidden;">
    <div style="position:absolute;top:-100px;right:-60px;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(255,200,26,0.06),transparent 70%);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-100px;left:-60px;width:340px;height:340px;border-radius:50%;background:radial-gradient(circle,rgba(139,92,246,0.05),transparent 70%);pointer-events:none;"></div>
    <div style="max-width:1100px;margin:0 auto;position:relative;z-index:1;">
        <div class="reveal" style="text-align:center;margin-bottom:52px;">
            <span class="section-label-yellow-inv">Jadwal Terbaru</span>
            <div style="width:48px;height:3px;background:linear-gradient(90deg,#FFC81A,#FFD84D);border-radius:2px;margin:10px auto 18px;"></div>
            <h2 style="color:#FFF;font-size:clamp(24px,4vw,42px);font-weight:900;
                margin:0 0 14px;line-height:1.1;">Kegiatan yang Akan <span style="background:linear-gradient(135deg,#FFC81A,#FFD84D);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Datang</span></h2>
            <p style="color:rgba(255,255,255,.6);font-size:15.5px;max-width:480px;margin:0 auto 32px;line-height:1.7;">
                Temukan pelatihan dan sertifikasi yang sesuai kebutuhanmu
            </p>
            {{-- Filter tabs — more premium --}}
            <div style="display:inline-flex;gap:4px;background:rgba(255,255,255,.03);padding:5px;
                border-radius:14px;border:1px solid rgba(255,255,255,.08);box-shadow:0 4px 16px rgba(0,0,0,.15);">
                @foreach([['all','Semua'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
                <button data-filter="{{ $v }}"
                    style="padding:9px 22px;border-radius:10px;border:none;font-size:13px;
                           font-weight:800;cursor:pointer;transition:all .25s cubic-bezier(.4,0,.2,1);
                           background:{{ $v==='all'?'#FFC81A':'transparent' }};
                           color:{{ $v==='all'?'#131218':'rgba(255,255,255,.6)' }};
                           {{ $v==='all'?'box-shadow:0 4px 12px rgba(255,200,26,.3);':'' }}">
                    {{ $l }}
                </button>
                @endforeach
            </div>
        </div>
        <div id="kegiatan-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:26px;">
            @forelse($kegiatanTerbaru as $k)
            @php
                $isPel       = $k->jenis_kegiatan === 'pelatihan';
                $accentColor = $isPel ? '#FFC81A' : '#8B5CF6';
                $accentGlow  = $isPel ? 'rgba(255,200,26,.2)' : 'rgba(139,92,246,.2)';
                $accentBg    = $isPel ? 'rgba(255,200,26,0.10)' : 'rgba(139,92,246,0.08)';
            @endphp
            <div class="reveal kegiatan-card tilt-card"
                 data-jenis="{{ $k->jenis_kegiatan }}"
                 style="background:rgba(255,255,255,.03);border-radius:24px;border:1.5px solid rgba(255,255,255,.08);
                        overflow:hidden;display:flex;flex-direction:column;
                        transition:all .35s cubic-bezier(.4,0,.2,1);
                        box-shadow:0 2px 12px rgba(0,0,0,.1);
                        transition-delay:{{ $loop->index*90 }}ms;"
                 onmouseover="this.style.transform='translateY(-8px)';this.style.boxShadow='0 20px 48px {{ $accentGlow }}, 0 0 0 1px {{ $accentColor }}30';this.style.borderColor='{{ $accentColor }}44'"
                 onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 12px rgba(0,0,0,.1)';this.style.borderColor='rgba(255,255,255,.08)'">
                {{-- Card Banner (tinggi lebih, lebih dramatis) --}}
                <div style="height:168px;position:relative;overflow:hidden;background:linear-gradient(135deg,#0e0d14,#1e1b29);">
                    @if($k->detail?->gambar)
                        <img src="{{ asset('storage/' . $k->detail->gambar) }}" style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0;" alt="Poster" />
                        <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(14,13,20,.5),transparent);"></div>
                    @else
                        {{-- Animated grid bg --}}
                        <div style="position:absolute;inset:0;opacity:.05;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:24px 24px;"></div>
                        {{-- Glow blob --}}
                        <div style="position:absolute;top:-20px;right:-20px;width:160px;height:160px;border-radius:50%;background:{{ $accentBg }};filter:blur(30px);"></div>
                        <div style="position:absolute;bottom:-30px;left:-20px;width:120px;height:120px;border-radius:50%;background:{{ $accentBg }};filter:blur(20px);opacity:.5;"></div>
                        {{-- Icon center --}}
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                            <div style="width:68px;height:68px;border-radius:22px;
                                background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);
                                display:flex;align-items:center;justify-content:center;
                                box-shadow:0 0 30px {{ $accentGlow }};">
                                @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>30,'style'=>"color:{$accentColor}"])
                            </div>
                        </div>
                    @endif
                    {{-- Type badge --}}
                    <div style="position:absolute;top:14px;left:14px;">
                        <span style="font-size:10px;font-weight:900;padding:4px 12px;border-radius:100px;
                            background:{{ $accentBg }};color:{{ $accentColor }};
                            border:1px solid {{ $accentColor }}35;text-transform:uppercase;letter-spacing:1px;
                            backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);">
                            {{ $k->jenis_kegiatan }}
                        </span>
                    </div>
                    {{-- Status badge --}}
                    @if($k->isFull())
                    <div style="position:absolute;top:14px;right:14px;">
                        <span style="font-size:10px;font-weight:900;padding:4px 12px;border-radius:100px;background:rgba(239,68,68,0.15);color:#EF4444;border:1px solid rgba(239,68,68,0.3);backdrop-filter:blur(8px);">Penuh</span>
                    </div>
                    @elseif($k->kuota>0 && ($k->kuota-$k->terisi)<=5 && $k->terisi>0)
                    <div style="position:absolute;top:14px;right:14px;">
                        <span style="font-size:10px;font-weight:900;padding:4px 12px;border-radius:100px;background:rgba(245,158,11,.15);color:#F59E0B;border:1px solid rgba(245,158,11,.3);backdrop-filter:blur(8px);">Sisa {{ $k->kuota-$k->terisi }}</span>
                    </div>
                    @endif
                </div>
                {{-- Content --}}
                <div style="padding:22px 22px;display:flex;flex-direction:column;flex-grow:1;justify-content:space-between;">
                    <div>
                        <h4 style="color:#FFF;font-size:15.5px;font-weight:900;margin:0 0 12px;line-height:1.4;
                            display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:44px;">
                            {{ $k->judul }}
                        </h4>
                        <div style="display:flex;gap:14px;margin-bottom:16px;">
                            <span style="color:rgba(255,255,255,.6);font-size:12px;display:flex;align-items:center;gap:5px;font-weight:600;">
                                @include('components.icon',['name'=>'calendar','size'=>12,'style'=>"color:{$accentColor}"])
                                {{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}
                            </span>
                            <span style="color:rgba(255,255,255,.6);font-size:12px;display:flex;align-items:center;gap:5px;font-weight:600;">
                                @include('components.icon',['name'=>'users','size'=>12,'style'=>"color:{$accentColor}"])
                                {{ $k->terisi }}/{{ $k->kuota }} peserta
                            </span>
                        </div>
                    </div>
                    <div>
                        {{-- Price row --}}
                        <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:10px 16px;
                            display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                            <span style="color:rgba(255,255,255,.5);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;">Biaya</span>
                            <span style="color:{{ $isPel?'#FFC81A':'#A78BFA' }};font-weight:900;font-size:15px;">
                                {{ $k->biaya->isNotEmpty() ? 'Rp '.number_format($k->biaya->min('nominal'),0,',','.') : 'Gratis' }}
                            </span>
                        </div>
                        {{-- CTA button --}}
                        <a href="{{ route('landing.show', $k) }}"
                           class="{{ $k->isFull() ? '' : 'fcc-btn-gold btn-shine' }}"
                           style="display:block;text-align:center;text-decoration:none;padding:11px;border-radius:14px;font-size:13.5px;font-weight:800;
                                  {{ $k->isFull() ? 'background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.05);color:rgba(255,255,255,.4);cursor:not-allowed;' : 'box-shadow:0 6px 20px rgba(255,200,26,.25);' }}">
                            {{ $k->isFull() ? 'Kuota Penuh' : 'Detail & Daftar →' }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column:span 3;text-align:center;padding:80px 40px;background:rgba(255,255,255,.03);border-radius:24px;border:1.5px dashed rgba(255,255,255,.1);">
                <div style="width:64px;height:64px;border-radius:20px;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.05);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                    @include('components.icon',['name'=>'calendar','size'=>28,'style'=>'color:rgba(255,255,255,.4)'])
                </div>
                <p style="color:rgba(255,255,255,.5);font-size:15px;margin:0;font-weight:600;">Belum ada kegiatan yang dipublikasikan.</p>
            </div>
            @endforelse
        </div>
        <div class="reveal" style="text-align:center;margin-top:44px;">
            <span class="btn-magnetic">
                <a href="{{ route('landing.kegiatan') }}" class="fcc-btn-outline-light btn-shine" style="padding:12px 32px;font-size:14px;font-weight:800;">
                    Lihat Semua Kegiatan
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </span>
        </div>
    </div>
</section>

    <!-- Decorative background accent -->



{{-- ══════════════════════════════════════════════════════════════
     TENTANG — PUTIH — #131218 icon bg, kuning highlight
 ══════════════════════════════════════════════════════════════════ --}}
<section style="padding:88px 24px;background:linear-gradient(180deg, #131218 0%, #0e0d14 120px, #0e0d14 100%); position:relative; overflow:hidden;">
    <!-- Animated Glowing Ornaments -->
    <div style="position:absolute;top:15%;right:5%;width:120px;height:120px;border-radius:50%;background:radial-gradient(circle, rgba(255,200,26,0.05) 0%, transparent 70%);border:1px solid rgba(255,200,26,0.1);animation:float1 8s ease-in-out infinite;pointer-events:none;"></div>
    <div style="position:absolute;bottom:10%;left:8%;width:180px;height:180px;border-radius:50%;background:radial-gradient(circle, rgba(139,92,246,0.03) 0%, transparent 70%);border:1px dashed rgba(139,92,246,0.1);animation:spin 25s linear infinite;pointer-events:none;"></div>
    <div style="position:absolute;top:60%;right:10%;width:30px;height:30px;background:rgba(255,200,26,0.1);border-radius:8px;animation:float2 6s ease-in-out infinite 2s;pointer-events:none;transform:rotate(45deg);"></div>
    <div style="position:absolute;top:20%;left:5%;width:15px;height:15px;background:rgba(139,92,246,0.15);border-radius:4px;animation:float1 5s ease-in-out infinite 1s;pointer-events:none;transform:rotate(45deg);"></div>
    <div style="max-width:1100px;margin:0 auto;
        display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center;position:relative;z-index:1;">
        {{-- Teks kiri --}}
        <div class="rl">
            <span class="section-label-yellow-inv">Tentang Kami</span>
            <div class="divider-yellow"></div>
            <h2 style="color:#FFF;font-size:clamp(24px,3.5vw,38px);font-weight:900;
                margin:0 0 18px;line-height:1.2;">
                Pusat Sertifikasi dan Pelatihan <span class="fcc-gold-text">Profesional</span>
            </h2>
            <p style="color:rgba(255,255,255,.65);font-size:15px;line-height:1.88;margin:0 0 20px;">
                FIKOM Certification Center (FCC) adalah unit pelaksana di bawah Fakultas Ilmu Komputer
                Universitas Muslim Indonesia yang menyelenggarakan program pelatihan dan sertifikasi
                kompetensi bagi mahasiswa dan masyarakat umum.
            </p>
            @foreach([
                'Terakreditasi oleh lembaga sertifikasi nasional (BNSP)',
                'Kurikulum diperbarui bersama mitra industri setiap semester',
                'Sertifikat diakui oleh perusahaan dan institusi mitra FCC',
            ] as $item)
            <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px;">
                <div style="width:20px;height:20px;border-radius:6px;flex-shrink:0;margin-top:1px;
                    background:rgba(255,200,26,.15);display:flex;align-items:center;justify-content:center;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <span style="color:rgba(255,255,255,.7);font-size:14px;line-height:1.6;">{{ $item }}</span>
            </div>
            @endforeach
            <div style="margin-top:28px;">
                <a href="{{ route('landing.profil') }}" class="fcc-btn-gold btn-shine" style="padding:11px 24px;font-size:14px;">
                    Selengkapnya
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>
        </div>
        {{-- Feature cards kanan --}}
        <div class="rr" style="display:flex;flex-direction:column;gap:14px;">
            @foreach([
                ['award',    'Sertifikasi Berstandar BNSP',  'Program sertifikasi yang diakui secara nasional sesuai standar BNSP dan mitra resmi.'],
                ['book-open','Kurikulum Berbasis Industri',   'Materi dirancang bersama praktisi dan diselaraskan kebutuhan industri digital terkini.'],
                ['users',    'Instruktur Berpengalaman',      'Diasuh dosen berpengalaman dan profesional bidang teknologi informasi.'],
            ] as $i=>[$ic,$t,$d])
            <div class="fcc-card-dark" style="padding:20px 22px;display:flex;gap:14px;align-items:flex-start;
                transition:all .22s ease;" onmouseover="this.style.borderColor='rgba(255,200,26,.4)';this.style.boxShadow='0 8px 32px rgba(255,200,26,.15)';this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.borderColor='rgba(255,200,26,.14)';this.style.boxShadow='none';this.style.transform='translateY(0)'">
                <div class="icon-box-inv" style="width:46px;height:46px;border-radius:12px;">
                    @include('components.icon',['name'=>$ic,'size'=>21,'style'=>'color:#FFC81A'])
                </div>
                <div>
                    <p style="margin:0 0 5px;color:#FFF;font-size:14px;font-weight:800;">{{ $t }}</p>
                    <p style="margin:0;color:rgba(255,255,255,.6);font-size:13px;line-height:1.65;">{{ $d }}</p>
                </div>
            </div>
            @endforeach
            {{-- Visi Misi mini --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:2px;">
                @foreach([
                    ['star','Visi','#FFC81A','Menjadi unit pelatihan dan sertifikasi profesional pencetak tenaga kerja berkualitas, terampil, dan mandiri berstandar nasional dan internasional.'],
                    ['zap', 'Misi','#10B981','Memberikan pelatihan & sertifikasi IT, membentuk SDM profesional, serta berkontribusi dalam peningkatan keterampilan anak bangsa.'],
                ] as [$ic,$t,$c,$txt])
                <div class="fcc-card-dark" style="padding:16px 14px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                        <div style="width:30px;height:30px;border-radius:8px;
                            background:{{ $c=='#FFC81A'?'rgba(255,200,26,.15)':'rgba(16,185,129,.15)' }};
                            display:flex;align-items:center;justify-content:center;">
                            @include('components.icon',['name'=>$ic,'size'=>14,'style'=>"color:{$c}"])
                        </div>
                        <span style="font-weight:800;font-size:13px;color:#FFF;">{{ $t }}</span>
                    </div>
                    <p style="margin:0;color:rgba(255,255,255,.5);font-size:12px;line-height:1.65;">{{ $txt }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     TATA CARA — #131218 BG — kuning aktif, putih teks
     Kuning di atas hitam: kontras terbaik
 ══════════════════════════════════════════════════════════════════ --}}
<section style="padding:88px 24px;background:linear-gradient(180deg, #0e0d14 0%, #131218 120px, #131218 100%); position:relative; overflow:hidden;">
    <div style="position:absolute;inset:0;opacity:.04;
        background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),
                         linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);
        background-size:64px 64px;"></div>
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
        width:600px;height:600px;border-radius:50%;
        background:radial-gradient(circle,rgba(255,200,26,.04),transparent 65%);pointer-events:none;"></div>
    <div style="max-width:1100px;margin:0 auto;position:relative;z-index:1;">
        <div class="reveal" style="text-align:center;margin-bottom:58px;">
            <span class="section-label-yellow-inv">Mudah &amp; Cepat</span>
            <div style="width:48px;height:3px;background:linear-gradient(90deg,#FFC81A,#FFD84D);border-radius:2px;margin:10px auto 16px;"></div>
            <h2 style="color:#FFF;font-size:clamp(24px,4vw,40px);font-weight:900;margin:0 0 12px;">
                Tata Cara <span class="fcc-gold-text">Pendaftaran</span>
            </h2>
            <p style="color:rgba(255,255,255,.5);font-size:15px;margin:0;max-width:420px;margin:0 auto;">
                Selesaikan pendaftaran dalam 4 langkah mudah
            </p>
        </div>
        {{-- Steps --}}
        <div style="position:relative;margin-bottom:40px;">
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
                ] as $si=>[$ic,$t,$d])
                <div id="step-wrapper-{{ $si }}" class="reveal" style="text-align:center;cursor:pointer;padding:4px;transition-delay:{{ $si*100 }}ms;" onclick="setStepInline({{ $si }})" onmouseenter="clearInterval(stepTimer); setStepInline({{ $si }})" onmouseleave="startTimer()">
                    <div id="step-box-{{ $si }}" style="width:70px;height:70px;border-radius:20px;margin:0 auto 16px;position:relative;transition:all .3s ease;
                        background:{{ $si===0 ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : 'rgba(255,255,255,.03)' }};
                        border:{{ $si===0 ? '2px solid transparent' : '2px solid rgba(255,255,255,.08)' }};
                        box-shadow:{{ $si===0 ? '0 8px 28px rgba(255,200,26,.45)' : '0 2px 8px rgba(0,0,0,.2)' }};
                        display:flex;align-items:center;justify-content:center;">
                        @include('components.icon',['name'=>$ic,'size'=>26,'style'=>"color:".($si===0?'#111':'rgba(255,255,255,.4)').";transition:color .3s;"])
                        <div style="position:absolute;top:-8px;right:-8px;width:24px;height:24px;border-radius:50%;" class="step-num-badge" style="
                            background:{{ $si===0 ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : 'rgba(255,255,255,.08)' }};
                            display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(255,200,26,.4);transition:all .3s;">
                            <span style="font-size:11px;font-weight:900;color:{{ $si===0?'#111':'rgba(255,255,255,.6)' }};transition:color .3s;">{{ $si+1 }}</span>
                        </div>
                    </div>
                    <p id="step-title-{{ $si }}" style="color:{{ $si===0?'#FFF':'rgba(255,255,255,.6)' }};font-size:14px;font-weight:{{ $si===0?'800':'600' }};margin:0 0 8px;transition:all .3s;">{{ $t }}</p>
                    <p style="color:rgba(255,255,255,.4);font-size:12.5px;line-height:1.7;margin:0;">{{ $d }}</p>
                </div>
                @endforeach
            </div>
        </div>
        {{-- Progress dots --}}
        <div style="display:flex;justify-content:center;gap:8px;margin-bottom:36px;" id="step-dots">
            @for($i=0;$i<4;$i++)
            <div onclick="setStepInline({{ $i }})" style="width:{{ $i===0?'20':'8' }}px;height:8px;border-radius:4px;cursor:pointer;transition:all .3s;background:{{ $i===0?'#FFC81A':'rgba(255,255,255,.1)' }};"></div>
            @endfor
        </div>
        <div style="text-align:center;">
            <span class="btn-magnetic">
                <a href="{{ route('auth.register') }}" class="fcc-btn-gold btn-shine" style="padding:13px 30px;font-size:15px;">
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
     MITRA — background gelap dengan logo yang tampil menonjol
 ══════════════════════════════════════════════════════════════════ --}}
<section style="padding:80px 0;background:linear-gradient(180deg, #131218 0%, #0e0d14 120px, #0e0d14 100%); position:relative; overflow:hidden;">
    <div style="position:absolute;inset:0;opacity:.02;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div style="max-width:1100px;margin:0 auto;padding:0 24px;position:relative;z-index:1;">
        <div class="reveal" style="text-align:center;margin-bottom:44px;">
            <span class="section-label-yellow-inv">Dipercaya Bersama</span>
            <div style="width:48px;height:3px;background:linear-gradient(90deg,#FFC81A,#FFD84D);border-radius:2px;margin:10px auto 16px;"></div>
            <h2 style="color:#FFF;font-size:clamp(22px,3.5vw,34px);font-weight:900;margin:0 0 10px;">
                Mitra <span class="fcc-gold-text">Strategis</span> Kami
            </h2>
            <p style="color:rgba(255,255,255,.6);font-size:14px;margin:0;">Kolaborasi kami dengan penyedia sertifikasi global terkemuka</p>
        </div>
    </div>
    <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:24px;padding:12px 24px;max-width:1000px;margin:0 auto;">
        @foreach($mitras as $index => $m)
        <div class="spring-up stagger-{{ ($index % 4) + 1 }}">
            <div class="fcc-mitra-card tilt-card" style="padding:16px;background:rgba(255,255,255,.04);border-radius:18px;display:flex;align-items:center;gap:14px;border:1px solid rgba(255,255,255,.08);transition:all .2s;cursor:default;"
                 onmouseover="this.style.borderColor='rgba(255,200,26,.3)';this.style.background='rgba(255,255,255,.06)'"
                 onmouseout="this.style.borderColor='rgba(255,255,255,.08)';this.style.background='rgba(255,255,255,.04)'">
                <div style="width:70px;height:70px;border-radius:14px;background:rgba(255,255,255,.05);
                    display:flex;align-items:center;justify-content:center;
                    border:1px solid rgba(255,255,255,.05);overflow:hidden;flex-shrink:0;">
                    @if($m->logo)
                    <img src="{{ asset('storage/'.$m->logo) }}" alt="{{ $m->nama_mitra }}"
                         style="width:52px;height:52px;object-fit:contain;filter:brightness(0) invert(1);opacity:.85;">
                    @else
                    <span style="color:#FFF;font-size:16px;font-weight:900;letter-spacing:.5px;
                        font-family:monospace;">{{ Str::upper(Str::substr($m->inisial ?? $m->nama_mitra,0,3)) }}</span>
                    @endif
                </div>
                <div style="padding-right:10px;">
                    <p style="margin:0;color:#FFF;font-size:13px;font-weight:900;line-height:1.35;
                        word-break:break-word;">{{ $m->nama_mitra }}</p>
                    <p style="margin:4px 0 0;color:rgba(255,255,255,.5);font-size:10px;font-weight:700;
                        text-transform:uppercase;letter-spacing:.5px;">Mitra Resmi</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>


{{-- ══════════════════════════════════════════════════════════════
     BERITA & KEGIATAN TERBARU — Carousel horizontal
     Data dari arsip_kegiatan; hover: pause + preview konten
 ══════════════════════════════════════════════════════════════════ --}}
@if($arsips->isNotEmpty())
<section style="padding:76px 0;background:linear-gradient(180deg, #0e0d14 0%, #131218 120px, #131218 100%); border-top:none; overflow:hidden;">
    <div style="max-width:1100px;margin:0 auto;padding:0 24px 28px;">
        <div class="reveal" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:12px;margin-bottom:24px;">
            <div>
                <span class="section-label-yellow-inv">Rekam Jejak</span>
                <h2 style="color:#FFF;font-size:clamp(22px,3.5vw,36px);font-weight:900;margin:0 0 4px;">
                    Berita & <span class="fcc-gold-text">Kegiatan</span>
                </h2>
                <p style="color:rgba(255,255,255,.5);font-size:13px;margin:0;">Arahkan cursor ke kartu untuk melihat pratinjau konten</p>
            </div>
            <a href="{{ route('landing.arsip') }}" style="color:#FFC81A;font-size:13px;font-weight:700;text-decoration:none;display:flex;align-items:center;gap:4px;">
                Lihat semua
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>

    {{-- Carousel: infinite scroll, pause on hover (via CSS) --}}
    <div class="berita-carousel-wrap">
        <div class="berita-track" id="berita-track">
            @php
                // Duplikasi untuk infinite loop visual
                $beritaItems = $arsips->concat($arsips->all());
            @endphp
            @foreach($beritaItems as $ar)
            <a href="{{ route('landing.arsip.show', $ar) }}" class="berita-card" style="text-decoration:none;">
                {{-- Thumbnail --}}
                <div class="berita-thumb">
                    <div class="berita-thumb-grid"></div>
                    @if($ar->foto_dokumentasi)
                    <img class="berita-thumb-img"
                         src="{{ asset('storage/'.$ar->foto_dokumentasi) }}"
                         alt="{{ $ar->judul ?? 'Arsip' }}">
                    @else
                    <div class="berita-thumb-placeholder">
                        <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,200,26,.14);border:1.5px solid rgba(255,200,26,.28);display:flex;align-items:center;justify-content:center;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>
                        <span style="color:rgba(255,200,26,.45);font-size:9px;letter-spacing:2px;text-transform:uppercase;font-weight:700;">Dokumentasi</span>
                    </div>
                    @endif
                    <div class="berita-overlay"></div>
                    <span class="berita-badge">Kegiatan</span>
                </div>

                {{-- Body --}}
                <div class="berita-body">
                    <p class="berita-title">{{ Str::limit($ar->judul ?? $ar->kegiatan?->judul ?? 'Arsip Kegiatan', 46) }}</p>
                    <p class="berita-date">{{ optional($ar->created_at)->format('d M Y') ?? '' }}</p>
                </div>

                {{-- Preview konten — muncul saat hover (CSS transition) --}}
                <div class="berita-preview">
                    {{ Str::limit(strip_tags($ar->ringkasan ?? 'Kegiatan telah selesai dilaksanakan.'), 120) }}
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════════
     ARSIP — Surface dengan accent visual yang kaya
 ══════════════════════════════════════════════════════════════════ --}}
@if($arsips->isNotEmpty())
<section style="padding:88px 24px;background:linear-gradient(180deg, #131218 0%, #0e0d14 120px, #0e0d14 100%); border-top:none; position:relative; overflow:hidden;">
    <div style="position:absolute;top:-50px;right:-50px;width:250px;height:250px;border-radius:50%;background:radial-gradient(circle,rgba(255,200,26,0.06),transparent 70%);pointer-events:none;"></div>
    <div style="max-width:1100px;margin:0 auto;">
        <div class="reveal" style="display:flex;justify-content:space-between;align-items:flex-end;
            margin-bottom:32px;flex-wrap:wrap;gap:14px;">
            <div>
                <span class="section-label-yellow-inv">Rekam Jejak</span>
                <h2 style="color:#FFF;font-size:clamp(22px,3.5vw,36px);font-weight:900;margin:0 0 4px;">
                    Arsip <span class="fcc-gold-text">Kegiatan</span>
                </h2>
                <p style="color:rgba(255,255,255,.5);font-size:14px;margin:0;">Dokumentasi kegiatan yang telah selesai</p>
            </div>
            <a href="{{ route('landing.arsip') }}" style="color:#FFC81A;font-size:13px;font-weight:700;
                text-decoration:none;display:flex;align-items:center;gap:4px;">
                Lihat semua
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
        {{-- Carousel --}}
        <div id="arsip-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:18px;"></div>
        {{-- Arrow + dots controls --}}
        <div style="display:flex;justify-content:center;align-items:center;gap:12px;margin-top:24px;">
            <button onclick="arsipPrev()" style="width:38px;height:38px;border-radius:10px;
                border:1.5px solid rgba(255,255,255,.1);background:rgba(255,255,255,.05);color:rgba(255,255,255,.6);cursor:pointer;
                display:flex;align-items:center;justify-content:center;transition:all .2s;"
                onmouseover="this.style.borderColor='#FFC81A';this.style.color='#FFF';this.style.boxShadow='0 0 16px rgba(255,200,26,.2)'"
                onmouseout="this.style.borderColor='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.6)';this.style.boxShadow='none'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div id="arsip-dots" style="display:flex;gap:6px;"></div>
            <button onclick="arsipNext()" style="width:38px;height:38px;border-radius:10px;
                border:1.5px solid rgba(255,255,255,.1);background:rgba(255,255,255,.05);color:rgba(255,255,255,.6);cursor:pointer;
                display:flex;align-items:center;justify-content:center;transition:all .2s;"
                onmouseover="this.style.borderColor='#FFC81A';this.style.color='#FFF';this.style.boxShadow='0 0 16px rgba(255,200,26,.2)'"
                onmouseout="this.style.borderColor='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.6)';this.style.boxShadow='none'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════════
     FAQ — 1 kolom, gradasi soft, desain premium
 ══════════════════════════════════════════════════════════════════ --}}
@if($faqs->isNotEmpty())
{{-- Gradasi soft penghubung dari section sebelumnya --}}
<div style="height:80px;background:linear-gradient(180deg,#131218,#0c0b12);pointer-events:none;"></div>

<section style="padding:0 24px 100px;background:linear-gradient(180deg,#0c0b12 0%,#0f0e18 40%,#0c0b12 100%);position:relative;overflow:hidden;">
    {{-- Ornamen latar --}}
    <div style="position:absolute;inset:0;opacity:.025;background-image:linear-gradient(rgba(139,92,246,1) 1px,transparent 1px),linear-gradient(90deg,rgba(139,92,246,1) 1px,transparent 1px);background-size:72px 72px;"></div>
    <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:700px;height:200px;background:radial-gradient(ellipse,rgba(139,92,246,.06),transparent 70%);pointer-events:none;"></div>
    <div style="position:absolute;bottom:0;right:0;width:400px;height:300px;background:radial-gradient(ellipse at bottom right,rgba(255,200,26,.03),transparent 70%);pointer-events:none;"></div>

    <div style="max-width:760px;margin:0 auto;position:relative;z-index:1;">
        {{-- Header --}}
        <div class="reveal" style="text-align:center;margin-bottom:52px;">
            <span class="section-label-yellow-inv">Pusat Informasi</span>
            <div style="width:48px;height:3px;background:linear-gradient(90deg,#8B5CF6,#FFC81A);border-radius:2px;margin:10px auto 16px;"></div>
            <h2 style="color:#FFF;font-size:clamp(24px,4vw,40px);font-weight:900;margin:0 0 12px;line-height:1.2;">
                Pertanyaan yang Sering <span class="fcc-gold-text">Ditanyakan</span>
            </h2>
            <p style="color:rgba(255,255,255,.55);font-size:15px;margin:0 auto;max-width:500px;line-height:1.7;">
                Temukan jawaban atas pertanyaan umum seputar program sertifikasi dan pelatihan FCC
            </p>
        </div>

        {{-- FAQ Accordion — 1 kolom penuh --}}
        <div class="reveal" style="display:flex;flex-direction:column;gap:12px;" id="faq-list">
            @foreach($faqs as $i => $faq)
            <div class="faq-item" style="background:rgba(255,255,255,.025);border:1.5px solid rgba(255,255,255,.07);border-radius:16px;overflow:hidden;transition:all .3s ease;">
                <button onclick="toggleFaq(this)"
                    style="width:100%;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:20px 24px;background:none;border:none;cursor:pointer;text-align:left;">
                    <div style="display:flex;align-items:flex-start;gap:14px;flex:1;">
                        <div style="width:30px;height:30px;border-radius:9px;background:rgba(139,92,246,.1);border:1px solid rgba(139,92,246,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                            <span style="color:#8B5CF6;font-size:11px;font-weight:900;">{{ str_pad($i+1,'2','0',STR_PAD_LEFT) }}</span>
                        </div>
                        <span style="color:#FFF;font-size:14.5px;font-weight:700;line-height:1.5;">{{ $faq->judul }}</span>
                    </div>
                    <div class="faq-chevron" style="flex-shrink:0;width:32px;height:32px;border-radius:10px;background:rgba(139,92,246,.08);border:1.5px solid rgba(139,92,246,.18);display:flex;align-items:center;justify-content:center;transition:all .35s cubic-bezier(0.34,1.56,0.64,1);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </button>
                <div class="faq-body" style="max-height:0;overflow:hidden;transition:max-height .45s cubic-bezier(0.16,1,0.3,1);">
                    <div style="padding:0 24px 22px 68px;border-top:1px solid rgba(139,92,246,.08);">
                        <p style="color:rgba(255,255,255,.62);font-size:14px;line-height:1.8;margin:16px 0 0;">{!! nl2br(e($faq->isi)) !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- CTA bawah --}}
        <div class="reveal" style="text-align:center;margin-top:44px;">
            <p style="color:rgba(255,255,255,.4);font-size:14px;margin:0 0 16px;">Masih ada pertanyaan lain?</p>
            <a href="{{ route('landing.kontak') }}" class="fcc-btn-gold btn-shine" style="padding:12px 28px;font-size:14px;display:inline-flex;align-items:center;gap:8px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Hubungi Tim Kami
            </a>
        </div>
    </div>
</section>

{{-- Gradasi soft ke bawah / footer --}}
<div style="height:60px;background:linear-gradient(180deg,#0c0b12,#0e0d14);pointer-events:none;"></div>

<style>
    .faq-item.faq-open {
        border-color: rgba(139,92,246,.35) !important;
        background: rgba(139,92,246,.04) !important;
        box-shadow: 0 0 30px rgba(139,92,246,.06);
    }
    .faq-item.faq-open .faq-chevron {
        background: rgba(139,92,246,.2) !important;
        border-color: rgba(139,92,246,.4) !important;
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
                box.style.background = isActive
                    ? 'linear-gradient(135deg,#FFC81A,#FFD84D)'
                    : isPast ? 'rgba(255,255,255,.05)' : 'rgba(255,255,255,.03)';
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
