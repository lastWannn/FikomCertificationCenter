@extends('layouts.public')
@section('title', $arsip->judul ?? 'Arsip Kegiatan')
@section('page-content')
<div class="page-content-wrap" style="padding-top:68px; background:linear-gradient(180deg, #131218 0%, #0e0d14 120px, #0e0d14 100%); min-height:100vh;">
  
  {{-- Header --}}
  <div style="background:#131218;padding:52px 24px 40px;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;opacity:.04;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:64px 64px;"></div>
    <div style="max-width:880px;margin:0 auto;position:relative;z-index:1;">
      <a href="{{ route('landing.arsip') }}" style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.5);font-size:13px;text-decoration:none;margin-bottom:16px;transition:color .18s;"
         onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='rgba(255,255,255,.5)'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Arsip Kegiatan
      </a>
      <div style="display:inline-block;background:rgba(255,200,26,.14);border:1px solid rgba(255,200,26,.28);border-radius:100px;padding:4px 14px;margin-bottom:14px;">
        <span style="color:#FFC81A;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;">{{ ucfirst($arsip->kegiatan?->jenis_kegiatan ?? 'kegiatan') }}</span>
      </div>
      <h1 class="fcc-gold-text" style="font-size:clamp(22px,4vw,38px);font-weight:900;margin:0 0 10px;line-height:1.15;">
        {{ $arsip->judul ?? $arsip->kegiatan?->judul ?? 'Arsip Kegiatan' }}
      </h1>
      <p style="color:rgba(255,255,255,.5);font-size:13px;margin:0;">
        {{ $arsip->created_at->format('d M Y') }} &bull; {{ $arsip->kegiatan?->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? '' }}
      </p>
    </div>
  </div>

  {{-- Konten --}}
  <div style="max-width:880px;margin:0 auto;padding:44px 24px;">
    
    @if($arsip->ringkasan)
    <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:14px;padding:22px 24px;margin-bottom:28px;">
      <p style="color:rgba(255,255,255,.7);font-size:15px;line-height:1.88;margin:0;font-weight:500;">{{ $arsip->ringkasan }}</p>
    </div>
    @endif

    {{-- Info kegiatan --}}
    @if($arsip->kegiatan)
    <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:14px;padding:22px 24px;margin-bottom:28px;">
      <p style="font-size:14px;font-weight:800;color:#FFF;margin:0 0 14px;">Informasi Kegiatan</p>
      @foreach([
        ['Program', $arsip->kegiatan->judul],
        ['Jenis', ucfirst($arsip->kegiatan->jenis_kegiatan)],
        ['Tanggal Pelaksanaan', $arsip->kegiatan->jadwal?->tgl_pelaksanaan?->format('d F Y') ?? '—'],
        ['Total Peserta', $arsip->kegiatan->pendaftaran->where('status_pendaftaran','terdaftar')->count().' peserta'],
      ] as [$l,$v])
      <div style="display:flex;gap:16px;padding:9px 0;border-top:1px solid rgba(255,255,255,.08);">
        <span style="min-width:160px;font-size:12px;font-weight:700;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;">{{ $l }}</span>
        <span style="font-size:14px;color:#FFF;font-weight:500;">{{ $v }}</span>
      </div>
      @endforeach
    </div>
    @endif

    {{-- GALERI DOKUMENTASI FOTO KEGIATAN (SLIDER SHOWCASE + HORIZONTAL STRIP) --}}
    @if(!empty($arsip->dokumentasi))
    @php
        $fotoList = array_values($arsip->dokumentasi);
        $totalFoto = count($fotoList);
    @endphp
    <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:18px;padding:24px;margin-bottom:28px;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
        <h3 style="font-size:16px;font-weight:900;color:#FFF;margin:0;display:flex;align-items:center;gap:8px;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
          Galeri Dokumentasi Kegiatan
        </h3>
        <span style="font-size:12px;color:#FFC81A;font-weight:800;background:rgba(255,200,26,.12);padding:4px 14px;border-radius:20px;border:1px solid rgba(255,200,26,0.3);">
          {{ $totalFoto }} Foto Dokumentasi
        </span>
      </div>

      {{-- Featured Main Image Preview --}}
      <div style="position:relative; width:100%; height:400px; border-radius:14px; overflow:hidden; border:1px solid rgba(255,255,255,0.12); background:#131218; margin-bottom:14px; cursor:pointer;"
           onclick="openLightBox(currentFotoIndex)">
        <img id="featured-gallery-img" src="{{ asset('storage/'.$fotoList[0]) }}" alt="Foto Utama Dokumentasi"
             style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s ease;"
             onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
        
        {{-- Prev / Next Controls over Main Showcase --}}
        <button type="button" onclick="event.stopPropagation(); changeFeaturedFoto(-1);" title="Foto Sebelumnya"
                style="position:absolute; left:12px; top:50%; transform:translateY(-50%); width:40px; height:40px; border-radius:50%; background:rgba(19,18,24,0.75); border:1px solid rgba(255,255,255,0.2); color:#FFFFFF; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s;"
                onmouseover="this.style.background='#FFC81A';this.style.color='#131218'" onmouseout="this.style.background='rgba(19,18,24,0.75)';this.style.color='#FFFFFF'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button type="button" onclick="event.stopPropagation(); changeFeaturedFoto(1);" title="Foto Selanjutnya"
                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); width:40px; height:40px; border-radius:50%; background:rgba(19,18,24,0.75); border:1px solid rgba(255,255,255,0.2); color:#FFFFFF; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s;"
                onmouseover="this.style.background='#FFC81A';this.style.color='#131218'" onmouseout="this.style.background='rgba(19,18,24,0.75)';this.style.color='#FFFFFF'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </button>

        {{-- Counter Overlay & Zoom Hint --}}
        <div style="position:absolute; bottom:12px; left:12px; background:rgba(19,18,24,0.85); border:1px solid rgba(255,255,255,0.2); padding:5px 14px; border-radius:20px; font-size:12px; color:#FFFFFF; font-weight:800; display:flex; align-items:center; gap:6px; box-shadow:0 4px 12px rgba(0,0,0,0.3);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
            <span id="featured-counter-text">Foto 1 dari {{ $totalFoto }} (Klik untuk Perbesar)</span>
        </div>
      </div>

      {{-- Horizontal Thumbnail Strip (Scroll Samping) --}}
      <div style="display:flex; gap:10px; overflow-x:auto; padding-bottom:6px; scrollbar-width:thin;" id="thumb-strip">
        @foreach($fotoList as $idx => $img)
        <div id="thumb-item-{{ $idx }}"
             style="width:90px; height:65px; border-radius:10px; overflow:hidden; flex-shrink:0; border:{{ $idx===0 ? '2px solid #FFC81A' : '1.5px solid rgba(255,255,255,0.15)' }}; cursor:pointer; transition:all 0.2s; opacity:{{ $idx===0 ? '1' : '0.6' }};"
             onclick="selectFeaturedFoto({{ $idx }})"
             onmouseover="this.style.opacity='1'" onmouseout="if(currentFotoIndex!=={{ $idx }}) this.style.opacity='0.6'">
          <img src="{{ asset('storage/'.$img) }}" alt="Foto Thumb" style="width:100%; height:100%; object-fit:cover;">
        </div>
        @endforeach
      </div>
    </div>

    {{-- Fullscreen Lightbox Modal --}}
    <div id="lightbox-modal" style="display:none; position:fixed; inset:0; background:rgba(10,10,14,0.95); z-index:99999; align-items:center; justify-content:center; flex-direction:column; padding:24px;" onclick="closeLightBox()">
      
      {{-- Top Header Toolbar --}}
      <div style="position:absolute; top:20px; left:24px; right:24px; display:flex; justify-content:space-between; align-items:center; z-index:10;" onclick="event.stopPropagation();">
        <span id="lightbox-counter" style="color:#FFC81A; font-size:13px; font-weight:900; background:rgba(255,200,26,0.15); padding:6px 16px; border-radius:20px; border:1px solid rgba(255,200,26,0.3);">
          Foto 1 dari {{ $totalFoto }}
        </span>
        <button type="button" onclick="closeLightBox()" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); color:#FFFFFF; width:38px; height:38px; border-radius:50%; cursor:pointer; font-size:16px; font-weight:900; display:flex; align-items:center; justify-content:center; transition:all 0.2s;" onmouseover="this.style.background='#EF4444'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
          ✕
        </button>
      </div>

      {{-- Prev Button --}}
      <button type="button" onclick="event.stopPropagation(); changeLightBoxFoto(-1);" title="Foto Sebelumnya (Panah Kiri)"
              style="position:absolute; left:20px; top:50%; transform:translateY(-50%); width:46px; height:46px; border-radius:50%; background:rgba(255,200,26,0.2); border:1.5px solid #FFC81A; color:#FFC81A; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:10; transition:all 0.2s;"
              onmouseover="this.style.background='#FFC81A';this.style.color='#131218'" onmouseout="this.style.background='rgba(255,200,26,0.2)';this.style.color='#FFC81A'">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="15 18 9 12 15 6"/></svg>
      </button>

      {{-- Main Lightbox Image --}}
      <img id="lightbox-img" style="max-width:88vw; max-height:80vh; border-radius:12px; object-fit:contain; box-shadow:0 16px 50px rgba(0,0,0,0.9); border:1px solid rgba(255,255,255,0.15);" onclick="event.stopPropagation();">

      {{-- Next Button --}}
      <button type="button" onclick="event.stopPropagation(); changeLightBoxFoto(1);" title="Foto Selanjutnya (Panah Kanan)"
              style="position:absolute; right:20px; top:50%; transform:translateY(-50%); width:46px; height:46px; border-radius:50%; background:rgba(255,200,26,0.2); border:1.5px solid #FFC81A; color:#FFC81A; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:10; transition:all 0.2s;"
              onmouseover="this.style.background='#FFC81A';this.style.color='#131218'" onmouseout="this.style.background='rgba(255,200,26,0.2)';this.style.color='#FFC81A'">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"/></svg>
      </button>

    </div>

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
                item.style.borderWidth = i === idx ? '2px' : '1.5px';
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

    {{-- Berita acara --}}
    @if($arsip->berita_acara)
    <div style="background:rgba(255,255,255,.03);border:1.5px solid rgba(255,200,26,.3);border-radius:14px;padding:20px 22px;display:flex;align-items:center;gap:14px;margin-bottom:28px;">
      <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,200,26,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2"><path d="M14 2H6a2 2 0 0 1-2 2v16a2 2 0 0 1 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      </div>
      <div style="flex:1;">
        <p style="font-size:14px;font-weight:800;color:#FFF;margin:0 0 3px;">Berita Acara Kegiatan</p>
        <p style="font-size:12px;color:rgba(255,255,255,.5);margin:0;">Dokumen resmi pelaksanaan kegiatan</p>
      </div>
      <a href="{{ asset('storage/'.$arsip->berita_acara) }}" target="_blank" class="fcc-btn-gold btn-shine" style="padding:9px 18px;font-size:13px;text-decoration:none;border-radius:10px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Unduh PDF
      </a>
    </div>
    @endif

    <a href="{{ route('landing.arsip') }}" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,200,26,0.3);color:rgba(255,255,255,.8);padding:10px 22px;font-size:14px;display:inline-flex;align-items:center;gap:6px;text-decoration:none;border-radius:12px;transition:all .2s ease;font-weight:700;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218'" onmouseout="this.style.background='rgba(255,200,26,0.04)';this.style.color='rgba(255,255,255,.8)'">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali ke Arsip
    </a>
  </div>
</div>
@endsection
