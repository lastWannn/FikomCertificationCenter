@extends('layouts.public')
@section('title',$arsip->judul??'Arsip Kegiatan')
@section('page-content')
<div class="page-content-wrap" style="padding-top:68px;">
  {{-- Header gelap = bagian dari branding, kuning aksesnya --}}
  <div style="background:#131218;padding:52px 24px 40px;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;opacity:.04;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:64px 64px;"></div>
    <div style="max-width:880px;margin:0 auto;position:relative;z-index:1;">
      <a href="{{ route('landing.arsip') }}" style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.5);font-size:13px;text-decoration:none;margin-bottom:16px;transition:color .18s;"
         onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='rgba(255,255,255,.5)'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Arsip Kegiatan
      </a>
      <div style="display:inline-block;background:rgba(255,200,26,.14);border:1px solid rgba(255,200,26,.28);border-radius:100px;padding:4px 14px;margin-bottom:14px;">
        <span style="color:#FFC81A;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;">{{ ucfirst($arsip->kegiatan?->jenis_kegiatan??'kegiatan') }}</span>
      </div>
      <h1 class="fcc-gold-text" style="font-size:clamp(22px,4vw,38px);font-weight:900;margin:0 0 10px;line-height:1.15;">
        {{ $arsip->judul ?? $arsip->kegiatan?->judul ?? 'Arsip Kegiatan' }}
      </h1>
      <p style="color:rgba(255,255,255,.5);font-size:13px;margin:0;">
        {{ $arsip->created_at->format('d M Y') }} &bull; {{ $arsip->kegiatan?->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? '' }}
      </p>
    </div>
  </div>

  {{-- Konten: putih, bersih --}}
  <div style="max-width:880px;margin:0 auto;padding:44px 24px;">
    @if($arsip->ringkasan)
    <div style="background:#F7F8FA;border:1px solid #E2E4EB;border-radius:14px;padding:22px 24px;margin-bottom:28px;">
      <p style="color:#131218;font-size:15px;line-height:1.88;margin:0;font-weight:500;">{{ $arsip->ringkasan }}</p>
    </div>
    @endif

    {{-- Info kegiatan --}}
    @if($arsip->kegiatan)
    <div style="background:#FFF;border:1px solid #E2E4EB;border-radius:14px;padding:22px 24px;margin-bottom:28px;">
      <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 14px;">Informasi Kegiatan</p>
      @foreach([
        ['Program', $arsip->kegiatan->judul],
        ['Jenis', ucfirst($arsip->kegiatan->jenis_kegiatan)],
        ['Tanggal Pelaksanaan', $arsip->kegiatan->jadwal?->tgl_pelaksanaan?->format('d F Y') ?? '—'],
        ['Total Peserta', $arsip->kegiatan->pendaftaran->where('status_pendaftaran','terdaftar')->count().' peserta'],
      ] as [$l,$v])
      <div style="display:flex;gap:16px;padding:9px 0;border-top:1px solid #F0F1F5;">
        <span style="min-width:160px;font-size:12px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.5px;">{{ $l }}</span>
        <span style="font-size:14px;color:#131218;font-weight:500;">{{ $v }}</span>
      </div>
      @endforeach
    </div>
    @endif

    {{-- Berita acara --}}
    @if($arsip->berita_acara)
    <div style="background:#FFF;border:1.5px solid rgba(255,200,26,.3);border-radius:14px;padding:20px 22px;display:flex;align-items:center;gap:14px;margin-bottom:28px;">
      <div style="width:44px;height:44px;border-radius:12px;background:#131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      </div>
      <div style="flex:1;">
        <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 3px;">Berita Acara Kegiatan</p>
        <p style="font-size:12px;color:#9CA3B0;margin:0;">Dokumen resmi pelaksanaan kegiatan</p>
      </div>
      <a href="{{ asset('storage/'.$arsip->berita_acara) }}" target="_blank" class="fcc-btn-dark" style="padding:9px 18px;font-size:13px;text-decoration:none;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Unduh PDF
      </a>
    </div>
    @endif

    <a href="{{ route('landing.arsip') }}" class="fcc-btn-outline-dark" style="padding:10px 22px;font-size:14px;display:inline-flex;">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali ke Arsip
    </a>
  </div>
</div>
@endsection
