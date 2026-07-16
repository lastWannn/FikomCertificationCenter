@extends('layouts.peserta')
@section('title','Preview Sertifikat')
@section('page-title','Preview Sertifikat')
@section('page-content')
<div style="padding:24px;max-width:780px;margin:0 auto;">

    <div style="margin-bottom:20px;">
        <a href="{{ route('peserta.sertifikat') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Daftar Sertifikat
        </a>
    </div>

    <div class="fcc-card" style="padding:28px;margin-bottom:18px;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:14px;margin-bottom:24px;">
            <div>
                <h2 style="font-size:18px;font-weight:900;color:#131218;margin:0 0 4px;">
                    {{ $sertifikat->pendaftaran->kegiatan->judul }}
                </h2>
                <p style="color:#9CA3B0;font-size:13px;margin:0;">
                    Diterbitkan: {{ optional($sertifikat->tgl_terbit)->format('d M Y') ?? '-' }}
                </p>
            </div>
            <a href="{{ route('peserta.sertifikat.download', $sertifikat) }}"
               class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;text-decoration:none;">
                @include('components.icon',['name'=>'download','size'=>14])
                Unduh Sertifikat
            </a>
        </div>

        @if($sertifikat->file_sertifikat)
        <div style="border:1px solid #E2E4EB;border-radius:12px;overflow:hidden;background:#F7F8FA;">
            <iframe src="{{ asset('storage/'.$sertifikat->file_sertifikat) }}"
                    style="width:100%;height:640px;border:none;"
                    title="Preview Sertifikat">
            </iframe>
        </div>
        @else
        <div style="background:#F7F8FA;border:1px dashed #E2E4EB;border-radius:12px;padding:48px;text-align:center;">
            @include('components.icon',['name'=>'file-text','size'=>40,'style'=>'color:#C0C4CF;margin:0 auto 14px;display:block;'])
            <p style="font-size:15px;font-weight:700;color:#6B7280;margin:0 0 6px;">File sertifikat belum tersedia</p>
            <p style="font-size:13px;color:#9CA3B0;margin:0;">Silakan hubungi Admin FCC jika Anda sudah seharusnya menerima sertifikat.</p>
        </div>
        @endif
    </div>

    <div class="fcc-card" style="padding:22px;">
        <h3 style="font-size:14px;font-weight:800;color:#131218;margin:0 0 14px;">Info Sertifikat</h3>
        @foreach([
            ['No. Sertifikat', $sertifikat->no_sertifikat ?? '-'],
            ['Kegiatan',       $sertifikat->pendaftaran->kegiatan->judul],
            ['Peserta',        $sertifikat->pendaftaran->peserta->nama],
            ['Tgl. Terbit',    optional($sertifikat->tgl_terbit)->format('d M Y') ?? '-'],
        ] as [$label, $value])
        <div style="display:flex;gap:14px;padding:9px 0;border-top:1px solid #F0F1F5;">
            <span style="min-width:130px;color:#9CA3B0;font-size:11px;font-weight:700;
                         text-transform:uppercase;letter-spacing:.5px;flex-shrink:0;">{{ $label }}</span>
            <span style="color:#131218;font-size:13px;font-weight:600;">{{ $value }}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection
