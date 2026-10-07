@extends('layouts.admin')
@section('title','Detail Presensi Peserta')
@section('page-title','Detail Presensi Peserta')

@section('page-content')
<style>
  /* ── FCC PRESENSI DETAIL RESPONSIVE CONTAINER & HEADER ── */
  .fcc-presensi-detail-container {
    padding: 24px;
    box-sizing: border-box;
    max-width: 100%;
    position: relative;
  }
  @media (max-width: 1023px) {
    .fcc-presensi-detail-container {
      padding: 18px 16px;
    }
  }
  @media (max-width: 639px) {
    .fcc-presensi-detail-container {
      padding: 14px 12px;
    }
  }
  @media (max-width: 420px) {
    .fcc-presensi-detail-container {
      padding: 12px 8px;
    }
  }

  .fcc-pdetail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    flex-wrap: wrap;
    gap: 16px;
  }
  @media (max-width: 1239px) {
    .fcc-pdetail-header {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 12px !important;
    }
    .fcc-pdetail-title-block {
      flex: none !important;
      width: 100% !important;
    }
  }

  .fcc-pdetail-title-block {
    flex: 1 1 auto;
    min-width: 0;
  }
  .fcc-pdetail-title {
    font-size: 22px;
    font-weight: 900;
    color: #131218;
    margin: 0;
    letter-spacing: -0.02em;
    word-break: break-word;
    overflow-wrap: anywhere;
    line-height: 1.3;
  }
  @media (max-width: 639px) {
    .fcc-pdetail-title {
      font-size: 18px;
    }
  }

  .fcc-pdetail-actions {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
  }
  @media (max-width: 1239px) {
    .fcc-pdetail-actions {
      width: 100%;
      justify-content: flex-start;
    }
  }
  @media (max-width: 639px) {
    .fcc-pdetail-actions {
      width: 100%;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
    }
    .fcc-pdetail-actions a {
      width: 100% !important;
      justify-content: center !important;
      padding: 9px 12px !important;
      font-size: 12px !important;
      box-sizing: border-box;
      white-space: nowrap !important;
    }
  }
</style>

<div class="fcc-presensi-detail-container">

    {{-- Navigasi Kembali --}}
    <div style="margin-bottom:16px;">
        <a href="{{ route('admin.presensi.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#131218;background:#FFFFFF;border:1.5px solid #131218;padding:6px 14px;border-radius:20px;font-size:12.5px;text-decoration:none;font-weight:800;transition:all 0.18s;box-shadow:0 2px 8px rgba(0,0,0,0.03);"
           onmouseover="this.style.background='#FFC81A';this.style.transform='translateX(-2px)'" onmouseout="this.style.background='#FFFFFF';this.style.transform='translateX(0)'">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) &larr; Kembali ke Daftar Kegiatan Presensi
        </a>
    </div>

    {{-- Header & Title --}}
    <div class="fcc-pdetail-header">
        <div class="fcc-pdetail-title-block">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Presensi Real-Time</span>
            </div>
            <h1 class="fcc-pdetail-title">{{ $kegiatan->judul }}</h1>
            <p style="color:#64748B;font-size:13px;margin:4px 0 0;font-weight:500;">Kelola daftar hadir dan verifikasi presensi peserta secara live real-time.</p>
        </div>

        {{-- Action Buttons --}}
        <div class="fcc-pdetail-actions">
            <a href="{{ route('admin.cetak.presensi', $kegiatan) }}" target="_blank"
               style="padding:10px 18px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.1);text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
               onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';"
               title="Cetak Lembar Presensi Kertas PDF">
                @include('components.icon',['name'=>'printer','size'=>15]) Cetak PDF
            </a>
            <a href="{{ route('admin.presensi.export', $kegiatan) }}"
               style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.04);text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
               onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'"
               title="Export Data CSV">
                @include('components.icon',['name'=>'download','size'=>15]) Export CSV
            </a>
        </div>
    </div>

    {{-- Livewire Presensi Detail Component --}}
    @livewire('admin.presensi-detail-manager', ['kegiatan' => $kegiatan])

</div>
@endsection
