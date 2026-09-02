@extends('layouts.admin')
@section('title','Terbitkan Sertifikat Peserta')
@section('page-title','Terbitkan Sertifikat Peserta')

@section('page-content')
<div style="padding:24px;position:relative;">

    {{-- ═══ SKELETON LOADING OVERLAY ═════════════════════════════════ --}}
    <style>
      @keyframes skeletonShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
      }
      .fcc-skeleton-box {
        background: linear-gradient(90deg, #E2E8F0 25%, #F1F5F9 50%, #E2E8F0 75%);
        background-size: 200% 100%;
        animation: skeletonShimmer 1.4s infinite ease-in-out;
        border-radius: 12px;
      }
      #sertifikat-peserta-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="sertifikat-peserta-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
      {{-- Back Button & Header Skeleton --}}
      <div class="fcc-skeleton-box" style="width:180px;height:32px;border-radius:20px;margin-bottom:16px;"></div>
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:120px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
        </div>
        <div class="fcc-skeleton-box" style="width:180px;height:40px;border-radius:30px;"></div>
      </div>
      {{-- Table Skeleton --}}
      <div style="padding:28px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('sertifikat-peserta-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

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
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">
                  {{ $kegiatan->jadwal?->nama_kegiatan ?: ('Jadwal ' . ($kegiatan->jadwal?->tgl_pelaksanaan?->translatedFormat('d M Y') ?? 'Reguler')) }}
                </span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">{{ $kegiatan->judul }}</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">
              Penerbitan sertifikat khusus peserta yang terdaftar pada <strong>{{ $kegiatan->jadwal?->nama_kegiatan ?: ('Jadwal ' . ($kegiatan->jadwal?->tgl_pelaksanaan?->translatedFormat('d F Y') ?? 'Reguler')) }}</strong>.
            </p>
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

    {{-- Background Status Banner --}}
    @if($kegiatan->has_latar)
    <div style="background:#ECFDF5;border:1.5px solid #10B981;border-radius:16px;padding:14px 20px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;box-shadow:0 2px 10px rgba(16,185,129,0.08);">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="position:relative;width:68px;height:46px;border-radius:8px;overflow:hidden;border:1.5px solid #059669;flex-shrink:0;box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                <img src="{{ $kegiatan->latar_url }}" alt="Preview Latar" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <div>
                <span style="font-size:10px;font-weight:900;color:#047857;background:#D1FAE5;padding:2px 8px;border-radius:12px;border:1px solid #10B981;text-transform:uppercase;letter-spacing:0.5px;display:inline-block;margin-bottom:2px;">
                    ✅ Template Latar Ready
                </span>
                <p style="margin:0;font-size:13px;font-weight:800;color:#064E3B;">Template latar sertifikat kegiatan ini sudah terupload &amp; siap diterbitkan.</p>
            </div>
        </div>
        <div style="display:flex;gap:8px;align-items:center;">
            <a href="{{ route('admin.sertifikat.layout-editor', $kegiatan) }}" style="font-size:12px;font-weight:900;color:#FFFFFF;background:#F59E0B;border:1.5px solid #D97706;padding:6px 14px;border-radius:10px;text-decoration:none;box-shadow:0 2px 8px rgba(245,158,11,0.25);">
                🎨 Atur Koordinat Teks
            </a>
            <a href="{{ route('admin.sertifikat.index') }}" style="font-size:12px;font-weight:800;color:#047857;background:#FFFFFF;border:1.5px solid #10B981;padding:6px 14px;border-radius:10px;text-decoration:none;transition:all .15s;" onmouseover="this.style.background='#10B981';this.style.color='#FFF';" onmouseout="this.style.background='#FFF';this.style.color='#047857';">
                Ganti Template Latar &rarr;
            </a>
        </div>
    </div>
    @else
    <div style="background:#FFFBEB;border:1.5px solid #F59E0B;border-radius:16px;padding:14px 20px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;box-shadow:0 2px 10px rgba(245,158,11,0.08);">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:42px;height:42px;border-radius:12px;background:#FEF3C7;border:1.5px solid #F59E0B;display:flex;align-items:center;justify-content:center;color:#D97706;flex-shrink:0;">
                @include('components.icon',['name'=>'alert-triangle','size'=>20])
            </div>
            <div>
                <span style="font-size:10px;font-weight:900;color:#B45309;background:#FEF3C7;padding:2px 8px;border-radius:12px;border:1px solid #F59E0B;text-transform:uppercase;letter-spacing:0.5px;display:inline-block;margin-bottom:2px;">
                    ⚠️ Perhatian: Belum Ada Latar
                </span>
                <p style="margin:0;font-size:13px;font-weight:800;color:#78350F;">Kegiatan ini belum memiliki template latar sertifikat!</p>
            </div>
        </div>
        <a href="{{ route('admin.sertifikat.index') }}" style="font-size:12.5px;font-weight:900;color:#131218;background:#FFC81A;border:1.5px solid #131218;padding:8px 16px;border-radius:10px;text-decoration:none;box-shadow:0 3px 10px rgba(0,0,0,0.08);display:inline-flex;align-items:center;gap:6px;transition:all .15s;" onmouseover="this.style.transform='translateY(-1px)';" onmouseout="this.style.transform='translateY(0)';">
            @include('components.icon',['name'=>'upload','size'=>14]) Upload Latar Sekarang &rarr;
        </a>
    </div>
    @endif

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
