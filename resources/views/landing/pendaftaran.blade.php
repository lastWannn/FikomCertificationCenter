@extends('layouts.public')
@section('title','Tata Cara Pendaftaran')
@section('page-content')
<div style="padding-top:68px;">
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
            <div style="position:absolute;top:35px;left:calc(12.5% + 20px);right:calc(12.5% + 20px);height:2px;background:#E2E4EB;border-radius:2px;"></div>
            <div id="step-fill-pend" style="position:absolute;top:35px;left:calc(12.5% + 20px);height:2px;width:0%;background:linear-gradient(90deg,#FFC81A,#FFD84D);border-radius:2px;transition:width .5s ease;z-index:1;"></div>
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;position:relative;z-index:1;">
                @foreach([
                    ['search','Pilih Kegiatan','Jelajahi program pelatihan atau sertifikasi, cek jadwal, harga, dan kuota tersedia.'],
                    ['user-plus','Daftar & Isi Data','Buat akun peserta, isi data diri lengkap, pilih jenis biaya, dan konfirmasi pendaftaran.'],
                    ['credit-card','Bayar & Upload','Aktifkan kode unik, transfer ke rekening FCC, lalu upload bukti transfer di portal.'],
                    ['check','Ikuti Kegiatan','Setelah Admin memverifikasi, kamu resmi terdaftar dan siap mengikuti kegiatan.'],
                ] as $i=>[$ic,$t,$d])
                <div id="step-{{ $i }}" style="text-align:center;cursor:pointer;padding:4px;" onclick="setStep({{ $i }})">
                    <div style="width:70px;height:70px;border-radius:20px;margin:0 auto 16px;position:relative;transition:all .3s ease;
                        background:{{ $i===0 ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : '#FFF' }};
                        border:{{ $i===0 ? 'none' : '2px solid #E2E4EB' }};
                        box-shadow:{{ $i===0 ? '0 8px 28px rgba(255,200,26,.45)' : '0 2px 8px rgba(0,0,0,.06)' }};
                        display:flex;align-items:center;justify-content:center;">
                        @include('components.icon',['name'=>$ic,'size'=>26,'style'=>"color:".($i===0?'#111':'#A0A3AD').";transition:color .3s;"])
                        <div style="position:absolute;top:-8px;right:-8px;width:24px;height:24px;border-radius:50%;" class="step-num-badge" style="
                            background:{{ $i===0 ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : '#E2E4EB' }};
                            display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(255,200,26,.4);transition:all .3s;">
                            <span style="font-size:11px;font-weight:900;color:{{ $i===0?'#111':'#A0A3AD' }};transition:color .3s;">{{ $i+1 }}</span>
                        </div>
                    </div>
                    <p style="color:{{ $i===0?'#0F0F14':'#6B7280' }};font-size:14px;font-weight:{{ $i===0?'800':'600' }};margin:0 0 8px;transition:all .3s;">{{ $t }}</p>
                    <p style="color:#A0A3AD;font-size:12.5px;line-height:1.7;margin:0;">{{ $d }}</p>
                </div>
                @endforeach
            </div>
            {{-- Connector fill --}}
            <div id="connector-fill" style="position:absolute;top:35px;left:calc(12.5% + 20px);height:2px;background:linear-gradient(90deg,#FFC81A,#FFD84D);border-radius:2px;width:0%;transition:width .5s ease;"></div>
        </div>
        {{-- Progress dots --}}
        <div style="display:flex;justify-content:center;gap:8px;margin-bottom:36px;" id="step-dots">
            @for($i=0;$i<4;$i++)
            <div onclick="setStep({{ $i }})" style="width:{{ $i===0?'20':'8' }}px;height:8px;border-radius:4px;cursor:pointer;transition:all .3s;background:{{ $i===0?'#FFC81A':'#E2E4EB' }};"></div>
            @endfor
        </div>
        {{-- CTA --}}
        <div style="text-align:center;">
            <a href="{{ route('auth.register') }}" class="fcc-btn-gold" style="padding:13px 30px;font-size:15px;text-decoration:none;">
                @include('components.icon',['name'=>'user-plus','size'=>16]) Mulai Pendaftaran Sekarang
            </a>
        </div>

        {{-- Persyaratan --}}
        <div style="background:#F7F8FA;border-radius:16px;padding:32px;margin-top:44px;">
            <h3 style="color:#0F0F14;font-weight:900;font-size:18px;margin:0 0 18px;">&#128073; Persyaratan Pendaftaran</h3>
            @foreach(['Memiliki akun peserta di portal FCC (daftar gratis)','Mengisi data diri secara lengkap dan benar','Melakukan pembayaran sesuai jenis biaya yang dipilih (Umum/Mahasiswa)','Mengunggah bukti transfer melalui portal peserta','Menunggu konfirmasi verifikasi dari Admin FCC (maksimal 1×24 jam)'] as $i=>$r)
            <div style="display:flex;gap:12px;align-items:flex-start;margin-bottom:12px;">
                <div style="width:22px;height:22px;border-radius:6px;flex-shrink:0;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center;">
                    <span style="color:#111;font-size:11px;font-weight:900;">{{ $i+1 }}</span>
                </div>
                <span style="color:#6B7280;font-size:14px;line-height:1.6;">{{ $r }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('page-data')
<script>window.PAGE_DATA = { pendaftaranPage: true };</script>
@endpush

@push('scripts')
@vite('resources/js/pages/landing-pendaftaran.js')
@endpush
