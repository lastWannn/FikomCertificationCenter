@extends('layouts.public')
@section('title', $arsip->judul ?? 'Arsip Kegiatan')
@section('page-content')
<div style="padding-top:84px; background:#131218; min-height: calc(100vh - 84px);">

    {{-- ═══ TOP HERO CARD ════════════════════════════════════════════════════════ --}}
    <div style="background:#131218; border-bottom:1.5px solid rgba(255,200,26,0.2); padding:40px 24px 44px; position:relative; overflow:hidden;">
        <!-- Subtle Glow -->
        <div style="position:absolute; top:-40%; right:-10%; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle, rgba(255,200,26,0.07), transparent 70%); pointer-events:none;"></div>

        <div style="max-width:1180px; margin:0 auto; position:relative; z-index:1;">
            
            {{-- Top Breadcrumb & Status --}}
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
                <a href="{{ route('landing.arsip') }}" style="display:inline-flex;align-items:center;gap:6px;color:#FFC81A;font-size:12.5px;font-weight:800;text-decoration:none;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    @include('components.icon',['name'=>'chevron-left','size'=>15]) Kembali ke Daftar Arsip
                </a>

                <div style="display:flex; align-items:center; gap:8px;">
                    <span style="font-size:10.5px; font-weight:900; padding:4px 12px; border-radius:100px; text-transform:uppercase; letter-spacing:1px; background:#FFC81A; color:#131218;">
                        {{ ucfirst($arsip->kegiatan?->jenis_kegiatan ?? 'arsip') }}
                    </span>
                </div>
            </div>

            {{-- Main Title & Date Metadata --}}
            <h1 style="font-size:clamp(22px, 3.5vw, 34px); font-weight:900; color:#FFFFFF; margin:0 0 12px; line-height:1.25; letter-spacing:-0.5px;">
                {{ $arsip->judul ?? $arsip->kegiatan?->judul ?? 'Arsip Kegiatan' }}
            </h1>

            <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap; color:rgba(255,255,255,0.65); font-size:13px; font-weight:600;">
                <span style="display:inline-flex; align-items:center; gap:6px; color:#FFC81A; font-weight:700;">
                    @include('components.icon',['name'=>'calendar','size'=>14,'style'=>'color:#FFC81A'])
                    Diarsipkan {{ $arsip->created_at->translatedFormat('d M Y') }}
                </span>
                @if($arsip->kegiatan?->jadwal?->tgl_pelaksanaan)
                <span style="color:rgba(255,255,255,0.3);">&bull;</span>
                <span style="display:inline-flex; align-items:center; gap:6px;">
                    @include('components.icon',['name'=>'clock','size'=>14,'style'=>'color:rgba(255,255,255,0.5)'])
                    Pelaksanaan {{ $arsip->kegiatan->jadwal->tgl_pelaksanaan->translatedFormat('d M Y') }}
                </span>
                @endif
            </div>

        </div>
    </div>

    {{-- ═══ MAIN CONTENT BODY ═════════════════════════════════════════════════════ --}}
    <div class="fcc-arsip-main-body" style="max-width:1180px; margin:0 auto; padding:40px 24px 60px;">
        
        {{-- Ringkasan Laporan --}}
        @if($arsip->ringkasan)
        <div style="background:#1E1D26; border:1.5px solid rgba(255,200,26,0.25); border-radius:18px; padding:28px; margin-bottom:28px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <h3 style="font-size:15px; font-weight:900; color:#FFC81A; margin:0 0 12px; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                @include('components.icon',['name'=>'file-text','size'=>16,'style'=>'color:#FFC81A']) Ringkasan Laporan Kegiatan
            </h3>
            <p style="color:rgba(255,255,255,0.85); font-size:14.5px; line-height:1.8; margin:0; font-weight:500;">
                {{ $arsip->ringkasan }}
            </p>
        </div>
        @endif

        {{-- Detail Spesifikasi Informasi Kegiatan --}}
        @if($arsip->kegiatan)
        <div style="background:#1E1D26; border:1.5px solid rgba(255,200,26,0.25); border-radius:18px; padding:28px; margin-bottom:28px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <h3 style="font-size:16px; font-weight:900; color:#FFFFFF; margin:0 0 20px; display:flex; align-items:center; gap:10px;">
                @include('components.icon',['name'=>'info','size'=>18,'style'=>'color:#FFC81A']) Spesifikasi Informasi Kegiatan
            </h3>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                @foreach([
                    ['Program Kegiatan', $arsip->kegiatan->judul, 'book-open'],
                    ['Jenis Kegiatan', ucfirst($arsip->kegiatan->jenis_kegiatan), 'layers'],
                    ['Tanggal Pelaksanaan', $arsip->kegiatan->jadwal?->tgl_pelaksanaan?->translatedFormat('d F Y') ?? '—', 'calendar'],
                    ['Total Peserta Terdaftar', $arsip->kegiatan->pendaftaran->where('status_pendaftaran','terdaftar')->count().' Peserta', 'users'],
                ] as [$label, $val, $ico])
                <div style="background:#131218; border:1px solid rgba(255,200,26,0.2); border-radius:14px; padding:16px 20px;">
                    <p style="color:#FFC81A; font-size:11px; font-weight:900; margin:0 0 6px; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:6px;">
                        @include('components.icon',['name'=>$ico,'size'=>13,'style'=>'color:#FFC81A']) {{ $label }}
                    </p>
                    <p style="color:#FFFFFF; font-size:14px; font-weight:800; margin:0;">
                        {{ $val }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- GALERI DOKUMENTASI FOTO KEGIATAN --}}
        @if(!empty($arsip->dokumentasi))
        @php
            $fotoList = array_values($arsip->dokumentasi);
            $totalFoto = count($fotoList);
        @endphp
        <div class="fcc-arsip-photo-card" style="background:#1E1D26; border:1.5px solid rgba(255,200,26,0.25); border-radius:18px; padding:28px; margin-bottom:28px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:10px;">
                <h3 style="font-size:clamp(14px, 3vw, 16px); font-weight:900; color:#FFFFFF; margin:0; display:flex; align-items:center; gap:10px;">
                    @include('components.icon',['name'=>'camera','size'=>18,'style'=>'color:#FFC81A'])
                    Galeri Dokumentasi Foto Kegiatan
                </h3>
                <span style="font-size:11.5px; color:#FFC81A; font-weight:800; background:rgba(255,200,26,0.12); padding:4px 14px; border-radius:100px; border:1px solid rgba(255,200,26,0.3);">
                    {{ $totalFoto }} Foto Dokumentasi
                </span>
            </div>

            {{-- Featured Main Image Preview Container --}}
            <div class="fcc-arsip-featured-box" onclick="openLightBox(currentFotoIndex)">
                <img id="featured-gallery-img" src="{{ asset('storage/'.$fotoList[0]) }}" alt="Foto Utama Dokumentasi"
                     style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s ease;"
                     onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">

                {{-- Prev / Next Controls over Main Showcase --}}
                <button type="button" onclick="event.stopPropagation(); changeFeaturedFoto(-1);" title="Foto Sebelumnya"
                        class="fcc-arsip-nav-btn fcc-arsip-nav-prev"
                        onmouseover="this.style.background='#FFC81A';this.style.color='#131218'" onmouseout="this.style.background='rgba(19,18,24,0.85)';this.style.color='#FFC81A'">
                    @include('components.icon',['name'=>'chevron-left','size'=>18])
                </button>
                <button type="button" onclick="event.stopPropagation(); changeFeaturedFoto(1);" title="Foto Selanjutnya"
                        class="fcc-arsip-nav-btn fcc-arsip-nav-next"
                        onmouseover="this.style.background='#FFC81A';this.style.color='#131218'" onmouseout="this.style.background='rgba(19,18,24,0.85)';this.style.color='#FFC81A'">
                    @include('components.icon',['name'=>'chevron-right','size'=>18])
                </button>

                {{-- Counter Overlay & Zoom Hint --}}
                <div class="fcc-arsip-counter-badge">
                    @include('components.icon',['name'=>'zoom-in','size'=>14,'style'=>'color:#FFC81A'])
                    <span id="featured-counter-text">Foto 1 dari {{ $totalFoto }} (Klik Perbesar)</span>
                </div>
            </div>

            {{-- Horizontal Thumbnail Strip (Scroll Samping) --}}
            <div style="display:flex; gap:10px; overflow-x:auto; padding-bottom:6px; scrollbar-width:thin;" id="thumb-strip">
                @foreach($fotoList as $idx => $img)
                <div id="thumb-item-{{ $idx }}"
                     class="fcc-arsip-thumb-item"
                     style="border:{{ $idx===0 ? '2.5px solid #FFC81A' : '1.5px solid rgba(255,255,255,0.15)' }}; opacity:{{ $idx===0 ? '1' : '0.6' }};"
                     onclick="selectFeaturedFoto({{ $idx }})"
                     onmouseover="this.style.opacity='1'" onmouseout="if(currentFotoIndex!=={{ $idx }}) this.style.opacity='0.6'">
                    <img src="{{ asset('storage/'.$img) }}" alt="Foto Thumb" style="width:100%; height:100%; object-fit:cover;">
                </div>
                @endforeach
            </div>
        </div>

        {{-- Fullscreen Lightbox Modal --}}
        <div id="lightbox-modal" style="display:none; position:fixed; inset:0; background:rgba(14,13,20,0.95); z-index:99999; align-items:center; justify-content:center; flex-direction:column; padding:24px;" onclick="closeLightBox()">
            
            {{-- Top Header Toolbar --}}
            <div style="position:absolute; top:16px; left:16px; right:16px; display:flex; justify-content:space-between; align-items:center; z-index:10;" onclick="event.stopPropagation();">
                <span id="lightbox-counter" style="color:#FFC81A; font-size:12px; font-weight:900; background:rgba(255,200,26,0.15); padding:5px 14px; border-radius:100px; border:1px solid rgba(255,200,26,0.3);">
                    Foto 1 dari {{ $totalFoto }}
                </span>
                <button type="button" onclick="closeLightBox()" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); color:#FFFFFF; width:36px; height:36px; border-radius:50%; cursor:pointer; font-size:18px; font-weight:900; display:flex; align-items:center; justify-content:center; transition:all 0.2s;" onmouseover="this.style.background='#EF4444';this.style.borderColor='#EF4444'" onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(255,255,255,0.2)'">
                    &times;
                </button>
            </div>

            {{-- Prev Button --}}
            <button type="button" onclick="event.stopPropagation(); changeLightBoxFoto(-1);" title="Foto Sebelumnya"
                    class="fcc-lightbox-arrow fcc-lightbox-arrow-left"
                    onmouseover="this.style.background='#FFC81A';this.style.color='#131218'" onmouseout="this.style.background='#131218';this.style.color='#FFC81A'">
                @include('components.icon',['name'=>'chevron-left','size'=>20])
            </button>

            {{-- Main Lightbox Image --}}
            <img id="lightbox-img" class="fcc-lightbox-img" onclick="event.stopPropagation();">

            {{-- Next Button --}}
            <button type="button" onclick="event.stopPropagation(); changeLightBoxFoto(1);" title="Foto Selanjutnya"
                    class="fcc-lightbox-arrow fcc-lightbox-arrow-right"
                    onmouseover="this.style.background='#FFC81A';this.style.color='#131218'" onmouseout="this.style.background='#131218';this.style.color='#FFC81A'">
                @include('components.icon',['name'=>'chevron-right','size'=>20])
            </button>

        </div>

        <style>
        .fcc-arsip-photo-card { padding: 28px; }
        .fcc-arsip-featured-box {
            position: relative; width: 100%; height: 420px; border-radius: 16px; overflow: hidden;
            border: 2px solid #FFC81A; background: #131218; margin-bottom: 16px; cursor: pointer;
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
        }
        .fcc-arsip-nav-btn {
            width: 42px; height: 42px; border-radius: 50%; background: rgba(19,18,24,0.85); backdrop-filter: blur(4px);
            border: 1.5px solid rgba(255,200,26,0.5); color: #FFC81A; cursor: pointer; display: flex;
            align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 4px 14px rgba(0,0,0,0.5);
            z-index: 5;
        }
        .fcc-arsip-nav-prev { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); }
        .fcc-arsip-nav-next { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); }
        .fcc-arsip-counter-badge {
            position: absolute; bottom: 14px; left: 14px; background: rgba(19,18,24,0.85); backdrop-filter: blur(6px);
            border: 1px solid rgba(255,200,26,0.3); padding: 6px 16px; border-radius: 100px; font-size: 12px;
            color: #FFFFFF; font-weight: 800; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(0,0,0,0.4);
        }
        .fcc-arsip-thumb-item {
            width: 96px; height: 68px; border-radius: 12px; overflow: hidden; flex-shrink: 0; cursor: pointer; transition: all 0.2s;
        }
        .fcc-lightbox-img {
            max-width: 88vw; max-height: 80vh; border-radius: 16px; object-fit: contain; box-shadow: 0 20px 60px rgba(0,0,0,0.9); border: 2px solid rgba(255,200,26,0.3);
        }
        .fcc-lightbox-arrow {
            position: absolute; top: 50%; transform: translateY(-50%); width: 48px; height: 48px; border-radius: 50%;
            background: #131218; border: 1.5px solid #FFC81A; color: #FFC81A; cursor: pointer; display: flex;
            align-items: center; justify-content: center; z-index: 10; transition: all 0.2s; box-shadow: 0 6px 20px rgba(0,0,0,0.6);
        }
        .fcc-lightbox-arrow-left { left: 24px; }
        .fcc-lightbox-arrow-right { right: 24px; }

        @media (max-width: 767px) {
            .fcc-arsip-photo-card { padding: 16px 14px !important; border-radius: 14px !important; margin-bottom: 20px !important; }
            .fcc-arsip-featured-box { height: clamp(210px, 56vw, 300px) !important; border-radius: 12px !important; margin-bottom: 12px !important; }
            .fcc-arsip-nav-btn { width: 34px !important; height: 34px !important; }
            .fcc-arsip-nav-prev { left: 8px !important; }
            .fcc-arsip-nav-next { right: 8px !important; }
            .fcc-arsip-counter-badge { bottom: 8px !important; left: 8px !important; padding: 4px 10px !important; font-size: 10.5px !important; }
            .fcc-arsip-thumb-item { width: 72px !important; height: 50px !important; border-radius: 8px !important; }
            #lightbox-modal { padding: 12px !important; }
            .fcc-lightbox-img { max-width: 96vw !important; max-height: 75vh !important; border-radius: 10px !important; }
            .fcc-lightbox-arrow { width: 36px !important; height: 36px !important; }
            .fcc-lightbox-arrow-left { left: 8px !important; }
            .fcc-lightbox-arrow-right { right: 8px !important; }
        }
        </style>

        <script>
        const allFotos = {!! json_encode(array_map(fn($f) => asset('storage/'.$f), $fotoList)) !!};
        let currentFotoIndex = 0;

        function selectFeaturedFoto(idx) {
            if (idx < 0 || idx >= allFotos.length) return;
            currentFotoIndex = idx;

            const featuredImg = document.getElementById('featured-gallery-img');
            const counterText = document.getElementById('featured-counter-text');

            if (featuredImg) featuredImg.src = allFotos[idx];
            if (counterText) counterText.innerText = `Foto ${idx + 1} dari ${allFotos.length} (Klik untuk Perbesar)`;

            for (let i = 0; i < allFotos.length; i++) {
                const item = document.getElementById(`thumb-item-${i}`);
                if (item) {
                    item.style.borderColor = i === idx ? '#FFC81A' : 'rgba(255,255,255,0.15)';
                    item.style.borderWidth = i === idx ? '2.5px' : '1.5px';
                    item.style.opacity = i === idx ? '1' : '0.6';
                }
            }

            const activeThumb = document.getElementById(`thumb-item-${idx}`);
            if (activeThumb) {
                activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }

        function changeFeaturedFoto(direction) {
            let newIdx = currentFotoIndex + direction;
            if (newIdx < 0) newIdx = allFotos.length - 1;
            if (newIdx >= allFotos.length) newIdx = 0;
            selectFeaturedFoto(newIdx);
        }

        function openLightBox(idx) {
            currentFotoIndex = idx;
            updateLightBoxUI();
            document.getElementById('lightbox-modal').style.display = 'flex';
        }

        function changeLightBoxFoto(direction) {
            currentFotoIndex += direction;
            if (currentFotoIndex < 0) currentFotoIndex = allFotos.length - 1;
            if (currentFotoIndex >= allFotos.length) currentFotoIndex = 0;
            updateLightBoxUI();
            selectFeaturedFoto(currentFotoIndex);
        }

        function updateLightBoxUI() {
            const lbImg = document.getElementById('lightbox-img');
            const lbCounter = document.getElementById('lightbox-counter');
            if (lbImg) lbImg.src = allFotos[currentFotoIndex];
            if (lbCounter) lbCounter.innerText = `Foto ${currentFotoIndex + 1} dari ${allFotos.length}`;
        }

        function closeLightBox() {
            document.getElementById('lightbox-modal').style.display = 'none';
        }

        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('lightbox-modal');
            if (modal && modal.style.display === 'flex') {
                if (e.key === 'ArrowLeft') changeLightBoxFoto(-1);
                if (e.key === 'ArrowRight') changeLightBoxFoto(1);
                if (e.key === 'Escape') closeLightBox();
            }
        });
        </script>
        @endif

        {{-- Berita Acara Document Action Box --}}
        @if(!empty($beritaAcaraFile) && file_exists($beritaAcaraFile))
        <div style="background:#1E1D26; border:1.5px solid rgba(255,200,26,0.25); border-radius:18px; padding:28px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:20px; margin-bottom:28px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <div style="display:flex; align-items:center; gap:16px;">
                <div style="width:52px; height:52px; border-radius:16px; background:rgba(255,200,26,0.12); border:1.5px solid rgba(255,200,26,0.3); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    @include('components.icon',['name'=>'file-text','size'=>24,'style'=>'color:#FFC81A'])
                </div>
                <div>
                    <h4 style="font-size:16px; font-weight:900; color:#FFFFFF; margin:0 0 4px;">Dokumen Berita Acara Resmi</h4>
                    <p style="font-size:12.5px; color:rgba(255,255,255,0.65); margin:0; font-weight:500;">Dokumen Laporan &amp; Berita Acara Hasil Pelaksanaan Kegiatan</p>
                </div>
            </div>
            
            <a href="{{ route('landing.arsip.pdf', $arsip, false) }}" target="_blank" style="padding:11px 22px; font-size:13.5px; font-weight:900; border-radius:12px; display:inline-flex; align-items:center; gap:8px; background:#FFC81A; color:#131218; text-decoration:none; box-shadow:0 4px 14px rgba(255,200,26,0.35); transition:all 0.2s;" onmouseover="this.style.background='#FFFFFF'" onmouseout="this.style.background='#FFC81A'">
                @include('components.icon',['name'=>'eye','size'=>16]) Lihat PDF Berita Acara &rarr;
            </a>
        </div>
        @endif

        {{-- Bottom Back Button --}}
        <div style="text-align:center; margin-top:20px;">
            <a href="{{ route('landing.arsip') }}" style="background:#1E1D26; border:1.5px solid rgba(255,200,26,0.25); color:#FFFFFF; padding:12px 28px; font-size:13.5px; display:inline-flex; align-items:center; gap:8px; text-decoration:none; border-radius:100px; transition:all 0.2s ease; font-weight:800; box-shadow:0 4px 16px rgba(0,0,0,0.3);" onmouseover="this.style.background='#FFC81A';this.style.color='#131218'" onmouseout="this.style.background='#1E1D26';this.style.color='#FFFFFF'">
                @include('components.icon',['name'=>'chevron-left','size'=>16]) Kembali ke Daftar Arsip
            </a>
        </div>

    </div>
</div>
@endsection
