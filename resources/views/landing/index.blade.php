@extends('layouts.public')
@section('title','Beranda')
@section('page-content')

{{-- ══════════════════════════════════════════════════════════════
     HERO — #131218 (satu-satunya bagian gelap di atas)
     Kuning #FFC81A pop sempurna di latar hitam
 ══════════════════════════════════════════════════════════════════ --}}
<section style="min-height:100vh;background:#131218;position:relative;overflow:hidden;
    display:flex;align-items:center;justify-content:center;">
    {{-- Grid pattern --}}
    <div style="position:absolute;inset:0;opacity:.04;
        background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),
                         linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);
        background-size:64px 64px;"></div>
    {{-- Animasi ornamen --}}
    <div style="position:absolute;top:8%;right:5%;width:300px;height:300px;animation:spin 22s linear infinite;">
        <svg width="300" height="300" viewBox="0 0 300 300">
            <circle cx="150" cy="150" r="138" fill="none" stroke="rgba(255,200,26,.10)" stroke-width="1" stroke-dasharray="8 7"/>
            <circle cx="150" cy="150" r="104" fill="none" stroke="rgba(255,200,26,.06)" stroke-width="1" stroke-dasharray="4 11"/>
        </svg>
    </div>
    <div style="position:absolute;top:12%;right:9%;width:150px;height:150px;animation:rspin 14s linear infinite;">
        <svg width="150" height="150" viewBox="0 0 150 150">
            <circle cx="75" cy="75" r="68" fill="none" stroke="rgba(255,200,26,.18)" stroke-width="1.5" stroke-dasharray="11 5"/>
        </svg>
    </div>
    <div class="hex" style="position:absolute;top:18%;right:13%;width:44px;height:44px;
        background:rgba(255,200,26,.18);animation:float1 6s ease-in-out infinite;"></div>
    <div class="hex" style="position:absolute;top:62%;right:4%;width:26px;height:26px;
        background:rgba(255,200,26,.12);animation:float2 8s ease-in-out infinite 1.4s;"></div>
    <div class="dia" style="position:absolute;top:40%;right:1.5%;width:20px;height:20px;
        background:rgba(255,200,26,.22);animation:float3 5.5s ease-in-out infinite .7s;"></div>
    <div class="dia" style="position:absolute;top:72%;right:16%;width:14px;height:14px;
        background:rgba(255,200,26,.25);animation:float1 7s ease-in-out infinite 2s;"></div>
    {{-- Dot grid kiri bawah --}}
    <div style="position:absolute;bottom:7%;left:3%;opacity:.28;">
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
            <div style="width:6px;height:6px;border-radius:50%;background:#FFC81A;animation:blink 2s ease-in-out infinite;"></div>
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
            <a href="{{ route('landing.kegiatan') }}" class="fcc-btn-gold" style="padding:13px 28px;font-size:15px;">
                Lihat Kegiatan
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
            <a href="{{ route('landing.pendaftaran') }}" class="fcc-btn-outline-light" style="padding:13px 28px;font-size:15px;">
                Cara Mendaftar
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     STATS — PUTIH — angka besar #131218, ikon kuning
 ══════════════════════════════════════════════════════════════════ --}}
<section style="background:#FFFFFF;padding:64px 24px;border-bottom:1px solid #E2E4EB;">
    <div style="max-width:1100px;margin:0 auto;
        display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        @foreach([
            [$stats['pelatihan'],'+','Program Pelatihan','book-open'],
            [$stats['sertifikasi'],'+','Jenis Sertifikasi','award'],
            [$stats['peserta'],'+','Peserta Terdaftar','users'],
            [$stats['mitra'],'','Mitra Institusi','building'],
        ] as $i=>[$val,$suf,$lbl,$ic])
        <div class="reveal stat-card-light" style="transition-delay:{{ $i*100 }}ms;">
            <div class="icon-box-dark" style="width:48px;height:48px;border-radius:14px;margin:0 auto 16px;">
                @include('components.icon',['name'=>$ic,'size'=>22,'style'=>'color:#FFC81A'])
            </div>
            <p style="margin:0 0 4px;color:#131218;font-size:clamp(30px,4vw,46px);
                font-weight:900;letter-spacing:-1px;line-height:1;">{{ $val }}{{ $suf }}</p>
            <p style="margin:0;color:#9CA3B0;font-size:13px;">{{ $lbl }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     KEGIATAN — Surface #F7F8FA (abu sangat terang)
 ══════════════════════════════════════════════════════════════════ --}}
<section style="padding:88px 24px;background:#F7F8FA;">
    <div style="max-width:1100px;margin:0 auto;">
        <div class="reveal" style="text-align:center;margin-bottom:44px;">
            <span class="section-label-yellow">Jadwal Terbaru</span>
            <h2 style="color:#131218;font-size:clamp(24px,4vw,40px);font-weight:900;
                margin:0 0 12px;line-height:1.15;">Kegiatan yang Akan Datang</h2>
            <p style="color:#5A6275;font-size:15px;max-width:460px;margin:0 auto 24px;">
                Temukan pelatihan dan sertifikasi yang sesuai kebutuhanmu
            </p>
            {{-- Filter tabs --}}
            <div style="display:inline-flex;gap:4px;background:#FFF;padding:4px;
                border-radius:12px;border:1px solid #E2E4EB;box-shadow:0 1px 3px rgba(0,0,0,.04);">
                @foreach([['all','Semua'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
                <button onclick="filterKegiatan('{{ $v }}')" data-filter="{{ $v }}"
                    style="padding:7px 18px;border-radius:9px;border:none;font-size:13px;
                           font-weight:700;cursor:pointer;transition:all .2s;
                           background:{{ $v==='all'?'#131218':'transparent' }};
                           color:{{ $v==='all'?'#FFC81A':'#9CA3B0' }};">
                    {{ $l }}
                </button>
                @endforeach
            </div>
        </div>
        <div id="kegiatan-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:18px;">
            @forelse($kegiatanTerbaru as $k)
            @php $isPel = $k->jenis_kegiatan==='pelatihan'; @endphp
            <div class="reveal ch fcc-card kegiatan-card" data-jenis="{{ $k->jenis_kegiatan }}"
                 style="overflow:hidden;transitiondelay:{{ $loop->index*80 }}ms;">
                {{-- Poster placeholder: #131218 bg + kuning icon --}}
                <div style="height:148px;position:relative;overflow:hidden;background:#131218;">
                    {{-- Pattern overlay --}}
                    <div style="position:absolute;inset:0;opacity:.08;
                        background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),
                                         linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);
                        background-size:24px 24px;"></div>
                    {{-- Dekor lingkaran --}}
                    <div style="position:absolute;top:-40px;right:-40px;width:160px;height:160px;
                        border-radius:50%;background:rgba(255,200,26,.06);border:1px solid rgba(255,200,26,.12);"></div>
                    {{-- Icon center --}}
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;
                        align-items:center;justify-content:center;gap:6px;">
                        <div style="width:50px;height:50px;border-radius:14px;
                            background:rgba(255,200,26,.15);border:1.5px solid rgba(255,200,26,.3);
                            display:flex;align-items:center;justify-content:center;">
                            @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>24,'style'=>'color:#FFC81A'])
                        </div>
                        <span style="color:rgba(255,200,26,.5);font-size:9px;letter-spacing:2px;
                            text-transform:uppercase;font-weight:700;">Poster Kegiatan</span>
                    </div>
                    {{-- Badges --}}
                    <div style="position:absolute;top:10px;left:10px;">
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:5px;
                            background:{{ $isPel?'#FFC81A':'#FFF' }};
                            color:{{ $isPel?'#131218':'#131218' }};">
                            {{ ucfirst($k->jenis_kegiatan) }}
                        </span>
                    </div>
                    @if($k->isFull())
                    <div style="position:absolute;top:10px;right:10px;">
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:5px;
                            background:#EF4444;color:#FFF;">Penuh</span>
                    </div>
                    @elseif($k->kuota>0 && ($k->kuota-$k->terisi)<=3 && $k->terisi>0)
                    <div style="position:absolute;top:10px;right:10px;">
                        <span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:5px;
                            background:rgba(245,158,11,.9);color:#FFF;">Sisa {{ $k->kuota-$k->terisi }}</span>
                    </div>
                    @endif
                </div>
                {{-- Content --}}
                <div style="padding:18px 20px;">
                    <p style="color:#131218;font-size:14px;font-weight:800;margin:0 0 4px;line-height:1.35;">
                        {{ Str::limit($k->judul,42) }}
                    </p>
                    <p style="color:#9CA3B0;font-size:12px;margin:0 0 12px;">
                        {{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}
                    </p>
                    {{-- Biaya --}}
                    <div style="background:#F7F8FA;border-radius:8px;padding:9px 12px;
                        display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                        <span style="color:#9CA3B0;font-size:11px;">Mulai dari</span>
                        <span style="color:#131218;font-weight:900;font-size:14px;">
                            {{ $k->biaya->isNotEmpty() ? 'Rp '.number_format($k->biaya->min('nominal'),0,',','.') : 'Gratis' }}
                        </span>
                    </div>
                    <a href="{{ route('landing.show', $k) }}"
                       class="{{ $k->isFull() ? '' : 'fcc-btn-gold' }}"
                       style="display:block;text-align:center;text-decoration:none;padding:9px;border-radius:9px;font-size:14px;font-weight:700;
                              {{ $k->isFull() ? 'background:#F0F1F5;color:#C0C4CF;border:1px solid #E2E4EB;cursor:not-allowed;' : '' }}">
                        {{ $k->isFull() ? 'Kuota Penuh' : 'Lihat &amp; Daftar' }}
                    </a>
                </div>
            </div>
            @empty
            <div style="grid-column:span 3;text-align:center;padding:48px;color:#9CA3B0;font-size:15px;">
                Belum ada kegiatan yang dipublikasikan.
            </div>
            @endforelse
        </div>
        <div class="reveal" style="text-align:center;margin-top:28px;">
            <a href="{{ route('landing.kegiatan') }}" class="fcc-btn-outline-dark" style="padding:10px 24px;font-size:14px;">
                Lihat Semua Kegiatan
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     TENTANG — PUTIH — #131218 icon bg, kuning highlight
 ══════════════════════════════════════════════════════════════════ --}}
<section style="padding:88px 24px;background:#FFFFFF;">
    <div style="max-width:1100px;margin:0 auto;
        display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center;">
        {{-- Teks kiri --}}
        <div class="rl">
            <span class="section-label-yellow">Tentang Kami</span>
            <div class="divider-yellow"></div>
            <h2 style="color:#131218;font-size:clamp(24px,3.5vw,38px);font-weight:900;
                margin:0 0 18px;line-height:1.2;">
                Pusat Sertifikasi dan Pelatihan <span class="fcc-gold-text">Profesional</span>
            </h2>
            <p style="color:#5A6275;font-size:15px;line-height:1.88;margin:0 0 20px;">
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
                    background:#131218;display:flex;align-items:center;justify-content:center;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <span style="color:#5A6275;font-size:14px;line-height:1.6;">{{ $item }}</span>
            </div>
            @endforeach
            <div style="margin-top:28px;">
                <a href="{{ route('landing.profil') }}" class="fcc-btn-dark" style="padding:11px 24px;font-size:14px;">
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
            <div class="fcc-card" style="padding:20px 22px;display:flex;gap:14px;align-items:flex-start;
                transition:all .22s ease;" onmouseover="this.style.borderColor='rgba(255,200,26,.4)';this.style.boxShadow='0 4px 20px rgba(0,0,0,.08)'"
                 onmouseout="this.style.borderColor='#E2E4EB';this.style.boxShadow='0 1px 4px rgba(0,0,0,.05)'">
                <div class="icon-box-dark" style="width:46px;height:46px;border-radius:12px;">
                    @include('components.icon',['name'=>$ic,'size'=>21,'style'=>'color:#FFC81A'])
                </div>
                <div>
                    <p style="margin:0 0 5px;color:#131218;font-size:14px;font-weight:800;">{{ $t }}</p>
                    <p style="margin:0;color:#5A6275;font-size:13px;line-height:1.65;">{{ $d }}</p>
                </div>
            </div>
            @endforeach
            {{-- Visi Misi mini --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:2px;">
                @foreach([
                    ['star','Visi','#FFC81A','Pusat sertifikasi TI terkemuka di Indonesia Timur, menghasilkan SDM digital berdaya saing global.'],
                    ['zap', 'Misi','#10B981','Pelatihan berkualitas, sertifikasi terstandar, kemitraan industri, dan kontribusi SDM nasional.'],
                ] as [$ic,$t,$c,$txt])
                <div class="fcc-card" style="padding:16px 14px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                        <div style="width:30px;height:30px;border-radius:8px;
                            background:{{ $c=='#FFC81A'?'#131218':'rgba(16,185,129,.12)' }};
                            display:flex;align-items:center;justify-content:center;">
                            @include('components.icon',['name'=>$ic,'size'=>14,'style'=>"color:{$c}"])
                        </div>
                        <span style="font-weight:800;font-size:13px;color:#131218;">{{ $t }}</span>
                    </div>
                    <p style="margin:0;color:#5A6275;font-size:12px;line-height:1.65;">{{ $txt }}</p>
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
<section style="padding:88px 24px;background:#131218;position:relative;overflow:hidden;">
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
            <div class="step-line-base" style="background:rgba(255,255,255,.08);"></div>
            <div class="step-line-fill" id="step-fill" style="width:0%;"></div>
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;position:relative;z-index:1;">
                @foreach([
                    ['search',      'Pilih Kegiatan',   'Jelajahi pelatihan atau sertifikasi, cek jadwal, harga, dan kuota yang tersedia.'],
                    ['user-plus',   'Daftar & Isi Data', 'Buat akun, isi data diri, pilih jenis biaya, dan konfirmasi pendaftaran.'],
                    ['credit-card', 'Bayar & Upload',    'Aktifkan kode unik, transfer ke rekening FCC, lalu upload bukti transfer.'],
                    ['check',       'Ikuti Kegiatan',    'Setelah Admin memverifikasi, kamu resmi terdaftar dan siap mengikuti kegiatan.'],
                ] as $si=>[$ic,$t,$d])
                <div id="step-{{ $si }}" class="reveal" style="text-align:center;transition-delay:{{ $si*100 }}ms;cursor:pointer;"
                     onclick="setStep({{ $si }})"
                     onmouseenter="hovStep({{ $si }})" onmouseleave="unhovStep({{ $si }})">
                    <div id="step-box-{{ $si }}"
                         style="width:70px;height:70px;border-radius:20px;margin:0 auto 16px;position:relative;
                                transition:all .3s ease;display:flex;align-items:center;justify-content:center;
                                background:{{ $si===0?'linear-gradient(135deg,#FFC81A,#FFD84D)':'rgba(255,255,255,.08)' }};
                                border:{{ $si===0?'none':'1.5px solid rgba(255,255,255,.12)' }};
                                box-shadow:{{ $si===0?'0 8px 28px rgba(255,200,26,.4)':'none' }};">
                        @include('components.icon',['name'=>$ic,'size'=>26,'style'=>($si===0?'color:#131218':'color:rgba(255,255,255,.4)').';transition:color .3s;'])
                        <div id="step-num-{{ $si }}" style="position:absolute;top:-9px;right:-9px;
                            width:24px;height:24px;border-radius:50%;
                            background:{{ $si===0?'linear-gradient(135deg,#FFC81A,#FFD84D)':'rgba(255,255,255,.12)' }};
                            display:flex;align-items:center;justify-content:center;
                            font-size:11px;font-weight:900;
                            color:{{ $si===0?'#131218':'rgba(255,255,255,.4)' }};transition:all .3s;">
                            {{ $si+1 }}
                        </div>
                    </div>
                    <p id="step-title-{{ $si }}" style="font-size:14px;font-weight:{{ $si===0?800:600 }};
                        margin:0 0 8px;color:{{ $si===0?'#FFF':'rgba(255,255,255,.45)' }};transition:all .3s;">
                        {{ $t }}
                    </p>
                    <p style="color:rgba(255,255,255,.35);font-size:12.5px;line-height:1.7;margin:0;">{{ $d }}</p>
                </div>
                @endforeach
            </div>
        </div>
        {{-- Dots --}}
        <div style="display:flex;justify-content:center;gap:8px;margin-bottom:36px;" id="step-dots">
            @for($i=0;$i<4;$i++)
            <div onclick="setStep({{ $i }})"
                 style="width:{{ $i===0?20:8 }}px;height:8px;border-radius:4px;cursor:pointer;transition:all .3s;
                        background:{{ $i===0?'#FFC81A':'rgba(255,255,255,.15)' }};"></div>
            @endfor
        </div>
        <div style="text-align:center;">
            <a href="{{ route('auth.register') }}" class="fcc-btn-gold" style="padding:13px 30px;font-size:15px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
                Mulai Pendaftaran Sekarang
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     MITRA — PUTIH — logo #131218 bg + kuning teks inisial
 ══════════════════════════════════════════════════════════════════ --}}
<section style="padding:76px 0;background:#FFFFFF;border-top:1px solid #E2E4EB;">
    <div style="max-width:1100px;margin:0 auto;padding:0 24px 0;">
        <div class="reveal" style="text-align:center;margin-bottom:36px;">
            <span class="section-label-yellow">Dipercaya Bersama</span>
            <h2 style="color:#131218;font-size:clamp(22px,3.5vw,34px);font-weight:900;margin:0;">
                Mitra <span class="fcc-gold-text">Kami</span>
            </h2>
        </div>
    </div>
    <div class="marquee-wrap" style="padding:6px 0;">
        <div class="marquee-track">
            @php $allMitras = $mitras->merge($mitras->all()); @endphp
            @foreach($allMitras as $m)
            {{-- Mitra card: logo di atas (gambar/inisial), nama di bawah --}}
            <div style="display:inline-flex;flex-direction:column;align-items:center;gap:10px;
                margin:0 8px;padding:20px 18px 16px;background:#FFF;border:1.5px solid #E2E4EB;
                border-radius:16px;flex-shrink:0;min-width:120px;max-width:140px;
                text-align:center;cursor:default;vertical-align:top;
                transition:all .25s;box-shadow:0 1px 3px rgba(0,0,0,.04);"
                 onmouseover="this.style.borderColor='#FFC81A';this.style.boxShadow='0 4px 20px rgba(255,200,26,.18)';this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.borderColor='#E2E4EB';this.style.boxShadow='0 1px 3px rgba(0,0,0,.04)';this.style.transform=''">
                {{-- Logo gambar / fallback inisial --}}
                <div style="width:64px;height:64px;border-radius:16px;background:#131218;
                    display:flex;align-items:center;justify-content:center;
                    border:2px solid rgba(255,200,26,.2);overflow:hidden;flex-shrink:0;">
                    @if($m->logo)
                    <img src="{{ asset('storage/'.$m->logo) }}" alt="{{ $m->nama_mitra }}"
                         style="width:56px;height:56px;object-fit:contain;border-radius:10px;">
                    @else
                    <span style="color:#FFC81A;font-size:16px;font-weight:900;letter-spacing:.5px;
                        font-family:monospace;">{{ Str::upper(Str::substr($m->inisial ?? $m->nama_mitra,0,3)) }}</span>
                    @endif
                </div>
                {{-- Nama di bawah logo --}}
                <div>
                    <p style="margin:0;color:#131218;font-size:12px;font-weight:800;line-height:1.35;
                        word-break:break-word;">{{ $m->nama_mitra }}</p>
                    <p style="margin:4px 0 0;color:#9CA3B0;font-size:9px;font-weight:700;
                        text-transform:uppercase;letter-spacing:.5px;">Mitra Resmi FCC</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════════════════
     BERITA & KEGIATAN TERBARU — Carousel horizontal
     Data dari arsip_kegiatan; hover: pause + preview konten
 ══════════════════════════════════════════════════════════════════ --}}
@if($arsips->isNotEmpty())
<section style="padding:76px 0;background:#FFFFFF;border-top:1px solid #E2E4EB;overflow:hidden;">
    <div style="max-width:1100px;margin:0 auto;padding:0 24px 28px;">
        <div class="reveal" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:12px;margin-bottom:24px;">
            <div>
                <span class="section-label-yellow">Rekam Jejak</span>
                <h2 style="color:#131218;font-size:clamp(22px,3.5vw,36px);font-weight:900;margin:0 0 4px;">
                    Berita & <span class="fcc-gold-text">Kegiatan</span>
                </h2>
                <p style="color:#9CA3B0;font-size:13px;margin:0;">Arahkan cursor ke kartu untuk melihat pratinjau konten</p>
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
     ARSIP — Surface #F7F8FA
 ══════════════════════════════════════════════════════════════════ --}}
@if($arsips->isNotEmpty())
<section style="padding:88px 24px;background:#F7F8FA;border-top:1px solid #E2E4EB;">
    <div style="max-width:1100px;margin:0 auto;">
        <div class="reveal" style="display:flex;justify-content:space-between;align-items:flex-end;
            margin-bottom:32px;flex-wrap:wrap;gap:14px;">
            <div>
                <span class="section-label-yellow">Rekam Jejak</span>
                <h2 style="color:#131218;font-size:clamp(22px,3.5vw,36px);font-weight:900;margin:0 0 4px;">
                    Arsip <span class="fcc-gold-text">Kegiatan</span>
                </h2>
                <p style="color:#9CA3B0;font-size:14px;margin:0;">Dokumentasi kegiatan yang telah selesai</p>
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
                border:1.5px solid #E2E4EB;background:#FFF;color:#5A6275;cursor:pointer;
                display:flex;align-items:center;justify-content:center;transition:all .2s;"
                onmouseover="this.style.borderColor='#FFC81A';this.style.color='#131218'"
                onmouseout="this.style.borderColor='#E2E4EB';this.style.color='#5A6275'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div id="arsip-dots" style="display:flex;gap:6px;"></div>
            <button onclick="arsipNext()" style="width:38px;height:38px;border-radius:10px;
                border:1.5px solid #E2E4EB;background:#FFF;color:#5A6275;cursor:pointer;
                display:flex;align-items:center;justify-content:center;transition:all .2s;"
                onmouseover="this.style.borderColor='#FFC81A';this.style.color='#131218'"
                onmouseout="this.style.borderColor='#E2E4EB';this.style.color='#5A6275'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════════
     KONTAK — PUTIH — ikon di #131218 bg
 ══════════════════════════════════════════════════════════════════ --}}
<section style="padding:88px 24px;background:#FFFFFF;border-top:1px solid #E2E4EB;">
    <div style="max-width:1000px;margin:0 auto;">
        <div class="reveal" style="text-align:center;margin-bottom:52px;">
            <span class="section-label-yellow">Hubungi Kami</span>
            <h2 style="color:#131218;font-size:clamp(24px,4vw,40px);font-weight:900;margin:0 0 12px;line-height:1.2;">
                Ada Pertanyaan? <span class="fcc-gold-text">Kami Siap</span> Membantu
            </h2>
            <p style="color:#5A6275;font-size:15px;margin:0;max-width:420px;margin:0 auto;">
                Tim FCC siap menjawab seputar pendaftaran dan program kami
            </p>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;">
            {{-- Form --}}
            <div class="rl">
                @if(session('success'))
                <div style="padding:14px 18px;background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);
                    border-radius:10px;color:#10B981;font-size:14px;font-weight:600;margin-bottom:20px;">
                    &#10003; {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('landing.kontak.post') }}" method="POST">
                    @csrf
                    @foreach([['nama','Nama Lengkap','text','Nama kamu','user'],['email','Email','email','email@example.com','mail']] as [$n,$l,$t,$p,$ic])
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">{{ $l }} *</label>
                        <div style="position:relative;">
                            @include('components.icon',['name'=>$ic,'size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#C0C4CF;pointer-events:none;'])
                            <input type="{{ $t }}" name="{{ $n }}" value="{{ old($n) }}" placeholder="{{ $p }}" required
                                   class="fcc-input" style="padding-left:38px;"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>
                    </div>
                    @endforeach
                    <div style="margin-bottom:20px;">
                        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Pesan *</label>
                        <textarea name="pesan" rows="5" required placeholder="Tuliskan pertanyaan atau pesanmu…"
                                  class="fcc-input" style="resize:vertical;">{{ old('pesan') }}</textarea>
                    </div>
                    <button type="submit" class="fcc-btn-dark" style="width:100%;justify-content:center;padding:12px;font-size:15px;">
                        Kirim Pesan
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>
                </form>
            </div>
            {{-- Info kontak --}}
            <div class="rr" style="display:flex;flex-direction:column;gap:20px;">
                @foreach([
                    ['map-pin','Alamat',   $konten['tentang_kami']?->alamat??'Jl. Urip Sumoharjo No.225, Makassar 90232'],
                    ['phone',  'Telepon',  '(0411) 455 855'],
                    ['mail',   'Email',    'fcc@fikom.umi.ac.id'],
                    ['globe',  'Website',  'www.fcc.fikom.umi.ac.id'],
                ] as [$ic,$lbl,$val])
                <div style="display:flex;gap:14px;align-items:flex-start;">
                    <div class="icon-box-dark" style="width:44px;height:44px;border-radius:13px;">
                        @include('components.icon',['name'=>$ic,'size'=>18,'style'=>'color:#FFC81A'])
                    </div>
                    <div>
                        <p style="margin:0 0 2px;color:#9CA3B0;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">{{ $lbl }}</p>
                        <p style="margin:0;color:#131218;font-size:14px;font-weight:500;">{{ $val }}</p>
                    </div>
                </div>
                @endforeach
                {{-- CTA Langsung --}}
                <div style="background:#F7F8FA;border:1.5px solid #E2E4EB;border-radius:14px;padding:22px;margin-top:4px;">
                    <p style="color:#131218;font-size:14px;font-weight:800;margin:0 0 6px;">Jam Operasional</p>
                    <p style="color:#5A6275;font-size:13px;margin:0 0 14px;line-height:1.7;">
                        Senin – Jumat: 08.00 – 16.00 WITA<br/>
                        Sabtu: 09.00 – 13.00 WITA
                    </p>
                    <a href="{{ route('auth.register') }}" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:10px;font-size:14px;">
                        Daftar Sekarang — Gratis
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

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
