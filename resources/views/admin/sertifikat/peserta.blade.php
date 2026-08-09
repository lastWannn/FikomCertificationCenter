@extends('layouts.admin')
@section('title','Terbitkan Sertifikat Peserta')
@section('page-title','Terbitkan Sertifikat Peserta')

@section('page-content')
<div style="padding:24px;">

    {{-- Navigasi Kembali --}}
    <div style="margin-bottom:16px;">
        <a href="{{ route('admin.sertifikat.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#131218;background:#FFFFFF;border:1.5px solid #131218;padding:6px 14px;border-radius:20px;font-size:12.5px;text-decoration:none;font-weight:800;transition:all 0.18s;box-shadow:0 2px 8px rgba(0,0,0,0.03);"
           onmouseover="this.style.background='#FFC81A';this.style.transform='translateX(-2px)'" onmouseout="this.style.background='#FFFFFF';this.style.transform='translateX(0)'">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) &larr; Kembali ke Manajemen Sertifikat
        </a>
    </div>

    {{-- Header & Terbitkan Semua Form --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Sertifikat Digital</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">{{ $kegiatan->judul }}</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola penerbitan sertifikat digital per peserta kegiatan ini.</p>
        </div>

        {{-- Form Terbitkan Semua --}}
        <form action="{{ route('admin.sertifikat.terbitkan-semua', $kegiatan) }}" method="POST">
            @csrf
            <div style="display:flex;gap:10px;align-items:center;">
                <input type="date" name="tgl_terbit" value="{{ date('Y-m-d') }}" required class="fcc-input" style="width:auto;font-size:12.5px;height:40px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;">
                <button type="submit" style="padding:10px 18px;font-size:13px;height:40px;display:inline-flex;align-items:center;gap:8px;border-radius:10px;font-weight:800;cursor:pointer;border:1.5px solid #131218;background:#131218;color:#FFC81A;transition:all .18s;"
                        onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';"
                        onclick="return fccConfirmAction(this, 'Terbitkan Sertifikat', 'Apakah Anda yakin ingin menerbitkan sertifikat untuk semua peserta yang terdaftar?', 'Ya, Terbitkan', false)">
                    @include('components.icon',['name'=>'award','size'=>16]) Terbitkan Semua
                </button>
            </div>
        </form>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Peserta &amp; Status Penerbitan</h3>
            <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $pendaftaran->count() }} Peserta</span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Peserta</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Status Pendaftaran</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">No. Sertifikat</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;">Tgl Terbit</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:240px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $pd)
                    @php $sert = $pd->sertifikat; @endphp
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        
                        {{-- Peserta --}}
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;">{{ $pd->peserta->nama }}</p>
                            <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;">{{ $pd->peserta->email }}</p>
                        </td>

                        {{-- Status Pendaftaran --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            @php
                            $sc = match($pd->status_pendaftaran) {
                                'terdaftar' => ['#059669', '#ECFDF5', '#A7F3D0', 'Terdaftar'],
                                'menunggu_verifikasi' => ['#D97706', '#FEF3C7', '#FCD34D', 'Menunggu'],
                                default => ['#64748B', '#F1F5F9', '#CBD5E1', 'Lainnya']
                            };
                            @endphp
                            <span style="font-size:11px;font-weight:800;padding:3px 10px;border-radius:12px;background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[2] }};display:inline-block;">
                                {{ $sc[3] }}
                            </span>
                        </td>

                        {{-- No. Sertifikat --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            @if($sert)
                            <span style="font-size:12px;font-weight:900;color:#FFC81A;background:#131218;padding:4px 10px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;display:inline-block;">
                                {{ $sert->nomor_sertifikat }}
                            </span>
                            @else
                            <span style="font-size:12px;color:#94A3B8;font-weight:600;">—</span>
                            @endif
                        </td>

                        {{-- Tgl Terbit --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;font-size:13px;color:#64748B;font-weight:700;">
                            {{ $sert?->tgl_terbit?->format('d M Y') ?? '—' }}
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            @if($pd->status_pendaftaran === 'terdaftar' && !$sert)
                            <form action="{{ route('admin.sertifikat.terbitkan', $pd) }}" method="POST" style="display:inline-flex;gap:6px;align-items:center;justify-content:center;">
                                @csrf
                                <input type="date" name="tgl_terbit" value="{{ date('Y-m-d') }}" required class="fcc-input" style="width:auto;font-size:12px;padding:4px 8px;height:34px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;font-weight:600;">
                                <button type="submit" style="padding:6px 14px;font-size:12px;font-weight:800;background:#131218;color:#FFC81A;border-radius:8px;border:1px solid #131218;cursor:pointer;white-space:nowrap;transition:all .18s;"
                                        onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                                    Terbitkan
                                </button>
                            </form>
                            @elseif($sert)
                            <a href="{{ route('admin.cetak.sertifikat', $sert) }}" target="_blank"
                               style="padding:6px 14px;font-size:12px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:8px;border:1.5px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .18s;"
                               onmouseover="this.style.background='#131218';this.style.color='#FFFFFF';" onmouseout="this.style.background='#FFFFFF';this.style.color='#131218';">
                                @include('components.icon',['name'=>'printer','size'=>13]) Lihat PDF
                            </a>
                            @else
                            <span style="font-size:11.5px;color:#94A3B8;font-weight:600;">Belum terdaftar</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'users','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Peserta Terdaftar</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Peserta yang terdaftar pada kegiatan ini akan muncul di sini untuk diterbitkan sertifikatnya.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
