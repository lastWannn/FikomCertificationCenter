@extends('layouts.admin')
@section('title', 'Evaluasi Nilai — ' . ($jadwal->sertifikasi->judul ?? 'Sertifikasi'))

@section('page-content')
<div class="fcc-point-show-container" style="padding:24px;">

    <style>
      /* Desktop Table (>= 1024px) */
      .fcc-peserta-desktop-table {
        display: block;
      }
      /* Card Grid (< 1024px) */
      .fcc-peserta-cards {
        display: none;
      }
      .fcc-peserta-header-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
      }
      .fcc-stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
      }
      .fcc-modal-dialog {
        background: #FFFFFF;
        border: 2px solid #131218;
        border-radius: 24px;
        padding: 26px 28px;
        max-width: 1040px;
        width: 94%;
        position: relative;
        box-shadow: 0 24px 60px rgba(0,0,0,0.35);
        max-height: 92vh;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
      }
      .fcc-modal-grid {
        display: grid;
        grid-template-columns: 1.05fr 1fr;
        gap: 22px;
        align-items: start;
      }
      .fcc-transkrip-box {
        height: 460px;
      }
      .fcc-modal-materi-scroll {
        max-height: 390px;
        overflow-y: auto;
        padding-right: 4px;
        margin-bottom: 18px;
      }

      /* Tablet & Small Laptop (768px - 1023px) */
      @media (max-width: 1023px) {
        .fcc-peserta-desktop-table {
          display: none !important;
        }
        .fcc-peserta-cards {
          display: grid !important;
          grid-template-columns: repeat(2, 1fr) !important;
          gap: 16px !important;
          padding: 16px !important;
        }
        .fcc-point-show-container {
          padding: 20px 18px !important;
        }
        .fcc-stat-grid {
          grid-template-columns: repeat(3, 1fr) !important;
          gap: 14px !important;
        }
        .fcc-modal-dialog {
          padding: 22px 20px !important;
          width: 96% !important;
          max-height: 92vh !important;
        }
        .fcc-modal-grid {
          grid-template-columns: 1fr 1fr !important;
          gap: 18px !important;
        }
        .fcc-transkrip-box {
          height: 380px !important;
        }
        .fcc-modal-materi-scroll {
          max-height: 310px !important;
        }
      }

      /* Small Tablet & Phablet (640px - 767px) */
      @media (max-width: 767px) {
        .fcc-point-show-container {
          padding: 16px 14px !important;
        }
        .fcc-point-show-title {
          font-size: 19px !important;
        }
        .fcc-back-btn {
          width: 100% !important;
          justify-content: center !important;
        }
        .fcc-stat-grid {
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) !important;
          gap: 12px !important;
          margin-bottom: 18px !important;
        }
        .fcc-modal-dialog {
          padding: 18px 16px !important;
          border-radius: 18px !important;
          width: 96% !important;
          max-height: 94vh !important;
        }
        .fcc-modal-grid {
          grid-template-columns: 1fr !important;
          gap: 16px !important;
        }
        .fcc-transkrip-box {
          height: 300px !important;
        }
        .fcc-modal-materi-scroll {
          max-height: 270px !important;
        }
        .fcc-modal-footer {
          flex-direction: column-reverse !important;
        }
        .fcc-modal-footer button {
          width: 100% !important;
          justify-content: center !important;
        }
      }

      /* Mobile Standard (< 640px) */
      @media (max-width: 639px) {
        .fcc-peserta-cards {
          grid-template-columns: 1fr !important;
          gap: 12px !important;
          padding: 12px !important;
        }
        .fcc-stat-grid {
          grid-template-columns: 1fr !important;
          gap: 10px !important;
        }
      }

      /* Small Mobile (< 420px) */
      @media (max-width: 419px) {
        .fcc-point-show-container {
          padding: 12px 10px !important;
        }
        .fcc-peserta-cards {
          padding: 10px !important;
          gap: 10px !important;
        }
        .fcc-point-show-title {
          font-size: 17.5px !important;
        }
        .fcc-modal-dialog {
          padding: 16px 12px !important;
          border-radius: 16px !important;
        }
        .fcc-transkrip-box {
          height: 240px !important;
        }
        .fcc-modal-materi-scroll {
          max-height: 240px !important;
        }
      }
    </style>

    {{-- HEADER BAR --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div style="flex:1;min-width:280px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;flex-shrink:0;">EVALUASI NILAI</span>
                <h1 class="fcc-point-show-title" style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Point Peserta Sertifikasi</h1>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <p style="margin:0;font-size:13.5px;font-weight:800;color:#334155;">
                    Judul: <span style="color:#131218;">{{ $jadwal->sertifikasi->judul ?? '-' }}</span>
                </p>
                <span style="color:#CBD5E1;">&bull;</span>
                <div style="display:inline-flex;align-items:center;gap:6px;background:#F8FAFC;border:1px solid #CBD5E1;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:800;color:#334155;white-space:nowrap;">
                    @include('components.icon',['name'=>'calendar','size'=>13,'style'=>'color:#131218;flex-shrink:0;'])
                    <span>{{ \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.sertifikasi.point.index') }}" class="fcc-back-btn"
           style="display:inline-flex;align-items:center;gap:6px;padding:9.5px 18px;border-radius:30px;border:1.5px solid #CBD5E1;background:#F1F5F9;font-size:13px;font-weight:800;color:#64748B;text-decoration:none;transition:all .18s;white-space:nowrap;"
           onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Daftar Batch
        </a>
    </div>

    @if(session('success'))
    <div style="background:#ECFDF5;border:1.5px solid #10B981;padding:14px 18px;border-radius:14px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
        @include('components.icon',['name'=>'check-circle','size'=>20,'style'=>'color:#10B981'])
        <p style="margin:0;color:#065F46;font-size:13.5px;font-weight:800;">{{ session('success') }}</p>
    </div>
    @endif

    {{-- STAT SUMMARY CARDS GRID --}}
    @php
        $totalPeserta = $pendaftaran->count();
        $sudahDinilai = $pendaftaran->filter(fn($p) => $p->nilai->count() > 0)->count();
        $allAvg = $sudahDinilai > 0 ? number_format($pendaftaran->map(fn($p) => $p->nilai->avg('nilai'))->filter()->avg(), 0) : 0;
    @endphp
    <div class="fcc-stat-grid">
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'users','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Peserta Terdaftar</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $totalPeserta }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Orang</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;">
                @include('components.icon',['name'=>'check-circle','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Sudah Dinilai</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $sudahDinilai }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'award','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Rata-Rata Point Batch</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $allAvg }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Point</span></p>
            </div>
        </div>
    </div>

    @php $belumDimulai = $jadwal->tgl_pelaksanaan && \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->gt(now()->startOfDay()); @endphp
    @if($belumDimulai)
    <div style="margin-bottom:18px;padding:16px 20px;background:#FFFDF5;border:1.5px solid #FCD34D;border-radius:16px;display:flex;align-items:center;gap:14px;box-shadow:0 2px 10px rgba(245,158,11,0.08);">
        @include('components.icon',['name'=>'alert-circle','size'=>22,'style'=>'color:#D97706;flex-shrink:0;'])
        <div>
            <h4 style="margin:0 0 2px;font-size:14px;font-weight:900;color:#92400E;">Pelaksanaan Sertifikasi Belum Dimulai</h4>
            <p style="margin:0;font-size:12px;color:#B45309;font-weight:600;">Tanggal pelaksanaan sertifikasi ini ditetapkan pada <strong>{{ \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d F Y') }}</strong>. Penginputan nilai peserta baru dapat dilakukan pada saat atau setelah tanggal pelaksanaan.</p>
        </div>
    </div>
    @endif

    {{-- LIST PESERTA TABEL --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div class="fcc-peserta-header-wrap" style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Peserta &amp; Penilaian</h3>
            <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;white-space:nowrap;flex-shrink:0;">{{ $totalPeserta }} Peserta</span>
        </div>

        {{-- Desktop Table View (>= 1024px) --}}
        <div class="fcc-peserta-desktop-table" style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:50px;">No</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;">No. Telepon / HP</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;min-width:150px;">Nama Peserta</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:130px;">Rata-Rata Point</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:220px;">Aksi Evaluasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $index => $item)
                    @php
                        $avgPoint = $item->nilai->count() > 0 ? $item->nilai->avg('nilai') : null;
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;color:#64748B;font-weight:800;font-size:13px;">
                            <span style="display:inline-flex;width:28px;height:28px;border-radius:8px;background:#F1F5F9;border:1px solid #CBD5E1;align-items:center;justify-content:center;color:#131218;font-weight:900;">{{ $index + 1 }}</span>
                        </td>
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <div style="display:inline-flex;align-items:center;gap:6px;background:#F8FAFC;border:1px solid #CBD5E1;padding:3px 10px;border-radius:12px;font-family:monospace;font-size:12.5px;font-weight:700;color:#334155;">
                                @include('components.icon',['name'=>'phone','size'=>13,'style'=>'color:#131218;flex-shrink:0;'])
                                <span>{{ $item->peserta->no_hp ?? '-' }}</span>
                            </div>
                        </td>
                        <td style="padding:14px 16px;vertical-align:middle;font-weight:900;color:#131218;font-size:14px;">
                            {{ $item->peserta->nama ?? 'Peserta Tidak Ditemukan' }}
                        </td>
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            @if($avgPoint !== null)
                                <span style="font-weight:900;font-size:12px;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;display:inline-block;white-space:nowrap;">
                                    🏆 {{ number_format($avgPoint, 0) }} Point
                                </span>
                            @else
                                <span style="font-weight:800;color:#94A3B8;font-size:11.5px;background:#F1F5F9;padding:3px 10px;border-radius:14px;white-space:nowrap;">Belum Dinilai</span>
                            @endif
                        </td>
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:inline-flex;align-items:center;justify-content:center;gap:6px;flex-wrap:nowrap;">
                                <button type="button" onclick="openNilaiModal('{{ $item->id }}', '{{ addslashes($item->peserta->nama ?? '') }}', {{ $item->nilai->toJson() }}, '{{ $item->transkrip_url }}')"
                                        style="padding:6px 13px;font-size:12px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:20px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;transition:all .18s;"
                                        onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                    @include('components.icon',['name'=>'edit-3','size'=>13]) Input Nilai
                                </button>

                                @if($item->sertifikat)
                                    <a href="{{ route('admin.cetak.sertifikat', $item->sertifikat->hashid) }}" target="_blank"
                                       style="padding:6px 13px;font-size:12px;font-weight:800;background:#ECFDF5;color:#10B981;border:1.5px solid #10B981;border-radius:20px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;text-decoration:none;white-space:nowrap;transition:all .18s;"
                                       onmouseover="this.style.background='#10B981';this.style.color='#FFF';" onmouseout="this.style.background='#ECFDF5';this.style.color='#10B981';">
                                        @include('components.icon',['name'=>'award','size'=>13]) Sertifikat
                                    </a>
                                @else
                                    <button type="button" onclick="alert('Sertifikat belum diterbitkan! Silakan terbitkan sertifikat melalui menu Kelola Sertifikat terlebih dahulu.')"
                                            style="padding:6px 13px;font-size:12px;font-weight:800;background:#F8FAFC;color:#94A3B8;border:1.5px solid #E2E8F0;border-radius:20px;cursor:not-allowed;opacity:0.7;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;" title="Sertifikat Belum Diterbitkan">
                                        @include('components.icon',['name'=>'award','size'=>13]) Sertifikat
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:48px 24px;color:#94A3B8;">
                            <div style="width:52px;height:52px;background:#F7F8FA;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'users','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-weight:900;color:#131218;margin:0 0 4px;font-size:14px;">Belum Ada Peserta</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Tidak ada peserta yang terdaftar pada jadwal sertifikasi ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Responsive Multi-Tier Card Grid (< 1024px: 2 columns on Tablet, 1 column on Mobile) --}}
        <div class="fcc-peserta-cards">
            @forelse($pendaftaran as $index => $item)
            @php
                $avgPoint = $item->nilai->count() > 0 ? $item->nilai->avg('nilai') : null;
            @endphp
            <div class="fcc-peserta-card" style="background:#FFFFFF;border:2px solid #E5E7EB;border-radius:16px;padding:16px;box-shadow:0 2px 10px rgba(0,0,0,0.03);display:flex;flex-direction:column;justify-content:space-between;gap:12px;">
                <div>
                    {{-- Top: Number, Participant Name & Point Badge --}}
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;margin-bottom:8px;">
                        <div style="display:flex;align-items:center;gap:10px;min-width:0;flex:1;">
                            <span style="display:inline-flex;width:28px;height:28px;border-radius:8px;background:#F1F5F9;border:1px solid #CBD5E1;align-items:center;justify-content:center;color:#131218;font-weight:900;font-size:12px;flex-shrink:0;">
                                {{ $index + 1 }}
                            </span>
                            <h4 style="margin:0;font-size:14.5px;font-weight:900;color:#131218;line-height:1.35;word-break:break-word;">
                                {{ $item->peserta->nama ?? 'Peserta Tidak Ditemukan' }}
                            </h4>
                        </div>

                        @if($avgPoint !== null)
                            <span style="font-weight:900;font-size:11.5px;color:#131218;background:#FFC81A;padding:4px 10px;border-radius:16px;border:1px solid #131218;white-space:nowrap;flex-shrink:0;">
                                🏆 {{ number_format($avgPoint, 0) }} Pt
                            </span>
                        @else
                            <span style="font-weight:800;color:#94A3B8;font-size:11px;background:#F1F5F9;padding:3px 8px;border-radius:12px;white-space:nowrap;flex-shrink:0;">
                                Belum Dinilai
                            </span>
                        @endif
                    </div>

                    {{-- Phone Badge --}}
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="display:inline-flex;align-items:center;gap:6px;background:#F8FAFC;border:1px solid #CBD5E1;padding:3px 10px;border-radius:12px;font-family:monospace;font-size:12px;font-weight:700;color:#334155;">
                            @include('components.icon',['name'=>'phone','size'=>12,'style'=>'color:#131218;flex-shrink:0;'])
                            <span>{{ $item->peserta->no_hp ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons Row on Mobile & Tablet --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;padding-top:10px;border-top:1px dashed #E2E8F0;">
                    <button type="button" onclick="openNilaiModal('{{ $item->id }}', '{{ addslashes($item->peserta->nama ?? '') }}', {{ $item->nilai->toJson() }}, '{{ $item->transkrip_url }}')"
                            style="padding:8px 10px;font-size:12px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:12px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:5px;white-space:nowrap;transition:all .18s;box-shadow:0 2px 6px rgba(255,200,26,0.25);"
                            onmouseover="this.style.background='#F5B700';" onmouseout="this.style.background='#FFC81A';">
                        @include('components.icon',['name'=>'edit-3','size'=>13]) Input Nilai
                    </button>

                    @if($item->sertifikat)
                        <a href="{{ route('admin.cetak.sertifikat', $item->sertifikat->hashid) }}" target="_blank"
                           style="padding:8px 10px;font-size:12px;font-weight:800;background:#ECFDF5;color:#10B981;border:1.5px solid #10B981;border-radius:12px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:5px;text-decoration:none;white-space:nowrap;transition:all .18s;"
                           onmouseover="this.style.background='#10B981';this.style.color='#FFF';" onmouseout="this.style.background='#ECFDF5';this.style.color='#10B981';">
                            @include('components.icon',['name'=>'award','size'=>13]) Sertifikat
                        </a>
                    @else
                        <button type="button" onclick="alert('Sertifikat belum diterbitkan! Silakan terbitkan sertifikat melalui menu Kelola Sertifikat terlebih dahulu.')"
                                style="padding:8px 10px;font-size:12px;font-weight:800;background:#F8FAFC;color:#94A3B8;border:1.5px solid #E2E8F0;border-radius:12px;cursor:not-allowed;opacity:0.7;display:inline-flex;align-items:center;justify-content:center;gap:5px;white-space:nowrap;" title="Sertifikat Belum Diterbitkan">
                            @include('components.icon',['name'=>'award','size'=>13]) Sertifikat
                        </button>
                    @endif
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:36px 16px;color:#94A3B8;">
                <div style="width:48px;height:48px;background:#F7F8FA;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    @include('components.icon',['name'=>'users','size'=>22,'style'=>'color:#9CA3B0'])
                </div>
                <p style="font-weight:900;color:#131218;margin:0 0 4px;font-size:14px;">Belum Ada Peserta</p>
                <p style="font-size:12px;color:#64748B;margin:0;">Tidak ada peserta yang terdaftar pada jadwal sertifikasi ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL INPUT NILAI DENGAN PRATINJAU TRANSKRIP NILAI (Split 2-Column Neo-Brutalist) --}}
<div id="nilai-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.7);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:16px;">
    <div class="fcc-modal-dialog">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('nilai-modal').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:18px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;z-index:10;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        {{-- Modal Header --}}
        <div style="margin-bottom:18px;border-bottom:2px solid #E5E7EB;padding-bottom:12px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:3px;flex-wrap:wrap;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;letter-spacing:0.5px;white-space:nowrap;flex-shrink:0;">EVALUASI NILAI</span>
                <h2 style="font-size:18px;font-weight:900;color:#131218;margin:0;">Input Nilai &amp; Transkrip Peserta</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Peserta: <strong id="peserta-name" style="color:#131218;font-size:13.5px;">-</strong></p>
        </div>

        {{-- 2-COLUMN LAYOUT: TRANSCRIPT PREVIEW (LEFT) + MODULE SCORE FORM (RIGHT) --}}
        <div class="fcc-modal-grid">
            
            {{-- KOLOM KIRI: PRATINJAU TRANSKRIP NILAI USER --}}
            <div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;flex-wrap:wrap;gap:6px;">
                    <span style="font-size:13px;font-weight:900;color:#131218;display:inline-flex;align-items:center;gap:6px;white-space:nowrap;">
                        📄 Lembar Transkrip Nilai
                    </span>
                    <a id="transkrip-open-tab" href="#" target="_blank" style="display:none;font-size:11.5px;font-weight:800;color:#2563EB;text-decoration:underline;white-space:nowrap;">
                        Buka di Tab Baru ↗
                    </a>
                </div>

                {{-- Box Iframe / Preview --}}
                <div id="transkrip-frame-wrap" class="fcc-transkrip-box" style="border-radius:16px;border:1.5px solid #CBD5E1;background:#F8FAFC;overflow:hidden;position:relative;display:flex;align-items:center;justify-content:center;">
                    <iframe id="preview-transkrip-pdf" src="" style="display:none;width:100%;height:100%;border:none;"></iframe>
                    <img id="preview-transkrip-img" src="" style="display:none;max-width:100%;max-height:100%;object-fit:contain;padding:8px;">
                    
                    <div id="preview-transkrip-empty" style="display:none;text-align:center;padding:24px;">
                        <div style="width:48px;height:48px;border-radius:12px;background:#FEF3C7;color:#D97706;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            @include('components.icon',['name'=>'alert-circle','size'=>24])
                        </div>
                        <p style="margin:0 0 4px;font-size:14px;font-weight:900;color:#131218;">Belum Ada Transkrip</p>
                        <p style="margin:0;font-size:12px;color:#64748B;max-width:240px;line-height:1.4;">Peserta belum mengunggah dokumen transkrip nilai.</p>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: FORM INPUT NILAI PER MODUL --}}
            <div style="display:flex;flex-direction:column;">
                <div style="margin-bottom:10px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                    <span style="font-size:13px;font-weight:900;color:#131218;display:inline-flex;align-items:center;gap:6px;">
                        ✏️ Input Nilai Modul / Materi
                    </span>
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                        <span id="badge-auto-extract" style="display:none;font-size:11px;font-weight:800;color:#15803D;background:#DCFCE7;border:1px solid #86EFAC;padding:3px 10px;border-radius:12px;white-space:nowrap;">
                            ✨ Terisi Otomatis dari Transkrip
                        </span>
                        <button type="button" id="btn-rescan-transkrip" onclick="triggerRescanTranskrip()"
                                style="display:none;align-items:center;gap:6px;font-size:11px;font-weight:900;color:#131218;background:#FFC81A;border:1.5px solid #131218;border-radius:12px;padding:3.5px 11px;cursor:pointer;transition:all .18s;box-shadow:0 2px 6px rgba(0,0,0,0.06);white-space:nowrap;"
                                onmouseover="this.style.background='#F5B700';this.style.transform='translateY(-1px)';" 
                                onmouseout="this.style.background='#FFC81A';this.style.transform='translateY(0)';"
                                title="Pindai ulang transkrip untuk memperbarui nilai materi secara otomatis">
                            <span id="rescan-spinner" style="display:none;animation:fcc-spin 1s linear infinite;">🔄</span>
                            <span id="rescan-icon">⚡</span>
                            <span id="rescan-text">Scan Ulang Transkrip</span>
                        </button>
                    </div>
                </div>

                {{-- Alert Banner Feedback --}}
                <div id="rescan-alert-banner" style="display:none;margin-bottom:12px;padding:10px 14px;border-radius:12px;font-size:12px;font-weight:700;line-height:1.4;"></div>
                
                <form id="nilai-form" method="POST" action="" style="display:flex;flex-direction:column;">
                    @csrf
                    
                    <div class="fcc-modal-materi-scroll" style="overflow-y:auto;padding-right:4px;margin-bottom:18px;">
                        @if($jadwal->sertifikasi && $jadwal->sertifikasi->materi && $jadwal->sertifikasi->materi->count() > 0)
                            <div style="background:#F8FAFC;border:1.5px solid #CBD5E1;padding:14px 18px;border-radius:16px;">
                                @foreach($jadwal->sertifikasi->materi as $index => $mat)
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:{{ $loop->last ? '0' : '12px' }};padding-bottom:{{ $loop->last ? '0' : '12px' }};border-bottom:{{ $loop->last ? 'none' : '1px solid #E2E8F0' }};gap:10px;">
                                    <div style="flex:1;min-width:0;padding-right:8px;">
                                        <p style="margin:0 0 2px;font-size:13px;font-weight:900;color:#131218;line-height:1.35;">{{ $mat->judul_materi }}</p>
                                        <span style="font-size:10.5px;color:#64748B;font-weight:600;">Modul {{ $loop->iteration }}</span>
                                    </div>
                                    <div style="width:85px;flex-shrink:0;">
                                        <input type="number" name="nilai[{{ $mat->id }}]" id="nilai-input-{{ $mat->id }}" min="0" max="100" placeholder="0 - 100" class="fcc-input" style="padding:8px 10px;font-size:14px;font-weight:900;text-align:center;width:100%;border-radius:10px;border:1.5px solid #131218;background:#FFF;transition:all 0.3s ease;">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div style="background:#FEF2F2;border:1.5px solid #FCA5A5;padding:16px;border-radius:14px;text-align:center;">
                                <p style="margin:0;color:#EF4444;font-size:13px;font-weight:800;">Sertifikasi ini belum memiliki materi.</p>
                            </div>
                        @endif
                    </div>

                    <div class="fcc-modal-footer" style="display:flex;justify-content:flex-end;gap:10px;padding-top:10px;border-top:1px solid #E5E7EB;flex-wrap:wrap;">
                        <button type="button" onclick="document.getElementById('nilai-modal').style.display='none'"
                                style="padding:10px 18px;font-size:12.5px;font-weight:800;color:#64748B;background:#F1F5F9;border:1.5px solid #CBD5E1;border-radius:30px;cursor:pointer;transition:all .18s;"
                                onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
                            Batal
                        </button>
                        <button type="submit"
                                style="padding:10px 24px;font-size:13px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:30px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:6px;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;"
                                onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';" {{ (!$jadwal->sertifikasi || !$jadwal->sertifikasi->materi || $jadwal->sertifikasi->materi->count() == 0) ? 'disabled' : '' }}>
                            @include('components.icon',['name'=>'check','size'=>15]) Simpan Nilai
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fcc-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
    let currentNilaiPendaftaranId = null;

    function openNilaiModal(pendaftaranId, namaPeserta, existingNilai, transkripUrl) {
        currentNilaiPendaftaranId = pendaftaranId;
        document.getElementById('peserta-name').innerText = namaPeserta;
        
        const baseUrl = '{{ route('admin.sertifikasi.point.index') }}';
        document.getElementById('nilai-form').action = baseUrl + '/{{ $jadwal->id }}/pendaftaran/' + pendaftaranId;
        
        const inputs = document.querySelectorAll('input[name^="nilai["]');
        inputs.forEach(input => {
            input.value = '';
            input.style.borderColor = '#131218';
            input.style.backgroundColor = '#FFF';
            input.style.boxShadow = 'none';
        });

        const autoBadge = document.getElementById('badge-auto-extract');
        const rescanBtn = document.getElementById('btn-rescan-transkrip');
        const alertBanner = document.getElementById('rescan-alert-banner');

        if (alertBanner) {
            alertBanner.style.display = 'none';
            alertBanner.innerHTML = '';
        }

        const hasTranskrip = (transkripUrl && transkripUrl.trim() !== '');

        if (rescanBtn) {
            rescanBtn.style.display = hasTranskrip ? 'inline-flex' : 'none';
        }

        if (existingNilai && existingNilai.length > 0) {
            let countFilled = 0;
            existingNilai.forEach(n => {
                const input = document.getElementById('nilai-input-' + n.materi_sertifikasi_id);
                if (input && n.nilai !== null && n.nilai !== undefined) {
                    input.value = Math.round(n.nilai);
                    countFilled++;
                }
            });
            if (autoBadge) {
                autoBadge.style.display = hasTranskrip ? 'inline-block' : 'none';
                autoBadge.innerText = '✨ ' + countFilled + ' Nilai Terisi';
            }
        } else {
            if (autoBadge) autoBadge.style.display = 'none';
        }

        // Tampilkan Pratinjau Transkrip Nilai
        const pdfFrame = document.getElementById('preview-transkrip-pdf');
        const imgPreview = document.getElementById('preview-transkrip-img');
        const emptyBox = document.getElementById('preview-transkrip-empty');
        const openTabBtn = document.getElementById('transkrip-open-tab');

        pdfFrame.style.display = 'none';
        pdfFrame.src = '';
        imgPreview.style.display = 'none';
        imgPreview.src = '';
        emptyBox.style.display = 'none';
        openTabBtn.style.display = 'none';

        if (hasTranskrip) {
            openTabBtn.href = transkripUrl;
            openTabBtn.style.display = 'inline-block';
            
            const lower = transkripUrl.toLowerCase();
            if (lower.includes('.pdf')) {
                pdfFrame.src = transkripUrl;
                pdfFrame.style.display = 'block';
            } else {
                imgPreview.src = transkripUrl;
                imgPreview.style.display = 'block';
            }
        } else {
            emptyBox.style.display = 'block';
        }
        
        document.getElementById('nilai-modal').style.display = 'flex';
    }

    function triggerRescanTranskrip() {
        if (!currentNilaiPendaftaranId) {
            alert('Data pendaftaran tidak valid.');
            return;
        }

        const btn = document.getElementById('btn-rescan-transkrip');
        const spinner = document.getElementById('rescan-spinner');
        const icon = document.getElementById('rescan-icon');
        const text = document.getElementById('rescan-text');
        const banner = document.getElementById('rescan-alert-banner');
        const autoBadge = document.getElementById('badge-auto-extract');

        // Set Loading state
        btn.disabled = true;
        btn.style.opacity = '0.75';
        btn.style.cursor = 'not-allowed';
        if (spinner) spinner.style.display = 'inline-block';
        if (icon) icon.style.display = 'none';
        if (text) text.innerText = 'Memindai PDF...';

        if (banner) {
            banner.style.display = 'block';
            banner.style.background = '#EFF6FF';
            banner.style.color = '#1D4ED8';
            banner.style.border = '1.5px solid #93C5FD';
            banner.innerHTML = '⏳ <strong>Sedang memindai transkrip nilai...</strong> Sistem membaca nama modul dan mengekstrak nilai.';
        }

        const csrfToken = document.querySelector('#nilai-form input[name="_token"]')?.value 
            || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const url = '{{ url('admin/pendaftaran') }}/' + currentNilaiPendaftaranId + '/rescan-transkrip';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Gagal memindai ulang transkrip nilai.');
            }
            return data;
        })
        .then(data => {
            if (data.success && data.nilai && data.nilai.length > 0) {
                let populatedCount = 0;
                data.nilai.forEach(n => {
                    const matId = n.materi_sertifikasi_id || n.materi_pelatihan_id;
                    const input = document.getElementById('nilai-input-' + matId);
                    if (input && n.nilai !== null && n.nilai !== undefined) {
                        input.value = Math.round(n.nilai);

                        // Flash highlight effect
                        input.style.borderColor = '#16A34A';
                        input.style.backgroundColor = '#DCFCE7';
                        input.style.boxShadow = '0 0 0 3px rgba(22, 163, 74, 0.25)';
                        setTimeout(() => {
                            input.style.borderColor = '#131218';
                            input.style.backgroundColor = '#FFF';
                            input.style.boxShadow = 'none';
                        }, 2500);

                        populatedCount++;
                    }
                });

                if (autoBadge) {
                    autoBadge.style.display = 'inline-block';
                    autoBadge.innerText = '✨ ' + (data.matched_count || populatedCount) + ' Nilai Terdeteksi';
                }

                if (banner) {
                    banner.style.display = 'block';
                    banner.style.background = '#ECFDF5';
                    banner.style.color = '#065F46';
                    banner.style.border = '1.5px solid #10B981';
                    banner.innerHTML = '✅ <strong>Scan Berhasil!</strong> ' + (data.message || (populatedCount + ' nilai modul berhasil disinkronkan ke form input.'));
                }
            } else {
                if (banner) {
                    banner.style.display = 'block';
                    banner.style.background = '#FFFBEB';
                    banner.style.color = '#92400E';
                    banner.style.border = '1.5px solid #FCD34D';
                    banner.innerHTML = '⚠️ <strong>Hasil Pemindaian:</strong> ' + (data.message || 'Transkrip berhasil dibaca, namun belum ada materi yang cocok. Anda dapat memasukkan nilai secara manual.');
                }
            }
        })
        .catch(err => {
            console.error('Scan transkrip error:', err);
            if (banner) {
                banner.style.display = 'block';
                banner.style.background = '#FEF2F2';
                banner.style.color = '#991B1B';
                banner.style.border = '1.5px solid #F87171';
                banner.innerHTML = '❌ <strong>Gagal memindai:</strong> ' + err.message;
            }
        })
        .finally(() => {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
            if (spinner) spinner.style.display = 'none';
            if (icon) icon.style.display = 'inline-block';
            if (text) text.innerText = 'Scan Ulang Transkrip';
        });
    }
</script>
@endsection
