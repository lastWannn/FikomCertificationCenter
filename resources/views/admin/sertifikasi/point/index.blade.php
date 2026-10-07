@extends('layouts.admin')
@section('title', 'Point Peserta Sertifikasi')

@section('page-content')
<div class="fcc-point-container" style="padding:24px;position:relative;">

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
      #point-sertifikasi-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }

      /* Desktop Table (>= 1024px) */
      .fcc-point-desktop-table {
        display: block;
      }
      /* Card Grid (< 1024px) */
      .fcc-point-cards {
        display: none;
      }
      .fcc-point-header-wrap {
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

      /* Tablet & Small Laptop (< 1024px) */
      @media (max-width: 1023px) {
        .fcc-point-desktop-table {
          display: none !important;
        }
        .fcc-point-cards {
          display: grid !important;
          grid-template-columns: repeat(2, 1fr) !important;
          gap: 16px !important;
          padding: 16px !important;
        }
        .fcc-point-container {
          padding: 20px 16px !important;
        }
        .fcc-stat-grid {
          grid-template-columns: repeat(3, 1fr) !important;
          gap: 12px !important;
        }
      }

      /* Small Tablet & Phablet (< 768px) */
      @media (max-width: 767px) {
        .fcc-point-container {
          padding: 16px 14px !important;
        }
        .fcc-point-title {
          font-size: 19px !important;
        }
        .fcc-point-header-wrap {
          flex-direction: column !important;
          align-items: stretch !important;
          gap: 10px !important;
        }
        .fcc-point-header-title-row {
          display: flex !important;
          justify-content: space-between !important;
          align-items: center !important;
          width: 100% !important;
        }
        .fcc-stat-grid {
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) !important;
          gap: 12px !important;
          margin-bottom: 18px !important;
        }
      }

      /* Mobile Standard (< 640px) */
      @media (max-width: 639px) {
        .fcc-point-cards {
          grid-template-columns: 1fr !important;
          gap: 12px !important;
          padding: 12px !important;
        }
        .fcc-stat-grid {
          grid-template-columns: 1fr !important;
          gap: 10px !important;
        }
      }

      /* Compact Phone (< 420px) */
      @media (max-width: 419px) {
        .fcc-point-container {
          padding: 12px 10px !important;
        }
        .fcc-point-cards {
          padding: 10px !important;
          gap: 10px !important;
        }
        .fcc-point-title {
          font-size: 17.5px !important;
        }
      }
    </style>

    <div id="point-sertifikasi-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:110px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:200px;height:12px;"></div>
        </div>
      </div>
      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
        @for($sc=0;$sc<3;$sc++)
        <div style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;align-items:center;gap:14px;">
          <div class="fcc-skeleton-box" style="width:44px;height:44px;border-radius:12px;flex-shrink:0;"></div>
          <div style="flex:1;">
            <div class="fcc-skeleton-box" style="width:65%;height:12px;margin-bottom:6px;"></div>
            <div class="fcc-skeleton-box" style="width:40%;height:20px;"></div>
          </div>
        </div>
        @endfor
      </div>
      <div style="padding:28px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('point-sertifikasi-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;flex-wrap:wrap;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;flex-shrink:0;">Evaluasi Nilai</span>
                <h1 class="fcc-point-title" style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Point Peserta Sertifikasi</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Pilih batch jadwal sertifikasi di bawah ini untuk menginput dan mengelola nilai/point peserta.</p>
        </div>
    </div>

    {{-- STAT CARDS GRID --}}
    <div class="fcc-stat-grid">
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'award','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Batch Sertifikasi</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $jadwal->total() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Jadwal</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'users','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Peserta Terdaftar</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ \App\Models\Pendaftaran::whereHas('kegiatan', fn($q)=>$q->where('jenis_kegiatan','sertifikasi'))->whereIn('status_pendaftaran', ['terdaftar', 'lulus', 'tidak_lulus'])->count() }}
                    <span style="font-size:12px;font-weight:700;color:#94A3B8;">Orang</span>
                </p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;">
                @include('components.icon',['name'=>'check-circle','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Peserta Ter-Evaluasi</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ \App\Models\Pendaftaran::whereHas('kegiatan', fn($q)=>$q->where('jenis_kegiatan','sertifikasi'))->where('status_pendaftaran', 'lulus')->count() }}
                    <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span>
                </p>
            </div>
        </div>
    </div>

    {{-- LIST JADWAL TABEL --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div class="fcc-point-header-wrap" style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;">
            <div class="fcc-point-header-title-row" style="display:flex;align-items:center;justify-content:space-between;width:100%;gap:12px;">
                <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Batch Sertifikasi</h3>
                <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;white-space:nowrap;flex-shrink:0;">{{ $jadwal->total() }} Data Batch</span>
            </div>
        </div>

        {{-- Desktop Table View (>= 1024px) --}}
        <div class="fcc-point-desktop-table" style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:50px;">No</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;min-width:180px;">Program Sertifikasi &amp; Batch</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:160px;">Waktu Pelaksanaan</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;">Peserta Terdaftar</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $index => $item)
                    @php
                        $terisi = $item->kegiatan ? $item->kegiatan->pendaftaran->whereIn('status_pendaftaran', ['terdaftar', 'lulus', 'tidak_lulus'])->count() : 0;
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;color:#64748B;font-weight:800;font-size:13px;">
                            <span style="display:inline-flex;width:28px;height:28px;border-radius:8px;background:#F1F5F9;border:1px solid #CBD5E1;align-items:center;justify-content:center;color:#131218;font-weight:900;">{{ $jadwal->firstItem() + $index }}</span>
                        </td>
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <p style="margin:0 0 3px;font-size:14px;font-weight:900;color:#131218;">
                                {{ $item->sertifikasi->judul ?? 'Sertifikasi Tidak Ditemukan' }}
                            </p>
                            @if($item->nama_kegiatan)
                            <span style="font-size:11px;font-weight:800;color:#131218;background:#FFC81A;padding:2px 8px;border-radius:6px;border:1px solid #131218;display:inline-block;">
                                {{ $item->nama_kegiatan }}
                            </span>
                            @endif
                        </td>
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            @php $isBelum = $item->tgl_pelaksanaan && \Carbon\Carbon::parse($item->tgl_pelaksanaan)->gt(now()->startOfDay()); @endphp
                            <div style="display:inline-flex;flex-direction:column;align-items:center;gap:4px;">
                                <div style="display:inline-flex;align-items:center;gap:6px;background:#F8FAFC;border:1px solid #CBD5E1;padding:4px 12px;border-radius:20px;font-size:12.5px;font-weight:800;color:#334155;white-space:nowrap;">
                                    @include('components.icon',['name'=>'calendar','size'=>14,'style'=>'color:#131218;flex-shrink:0;'])
                                    <span>{{ \Carbon\Carbon::parse($item->tgl_pelaksanaan)->translatedFormat('d M Y') }}</span>
                                </div>
                                @if($isBelum)
                                <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:6px;background:#FFFDF5;color:#D97706;border:1px solid #FCD34D;display:inline-flex;align-items:center;gap:3px;white-space:nowrap;" title="Sertifikasi belum dimulai">
                                    @include('components.icon',['name'=>'clock','size'=>11]) Belum Dimulai
                                </span>
                                @endif
                            </div>
                        </td>
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            <span style="font-weight:900;font-size:12.5px;padding:4px 14px;border-radius:20px;border:1px solid #131218;display:inline-block;white-space:nowrap;{{ $terisi >= $item->kuota_peserta ? 'background:#ECFDF5;color:#10B981;border-color:#10B981;' : 'background:#FFC81A;color:#131218;' }}">
                                👥 {{ $terisi }} / {{ $item->kuota_peserta }}
                            </span>
                        </td>
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <a href="{{ route('admin.sertifikasi.point.show', $item->id) }}"
                               style="padding:6px 16px;font-size:12px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:20px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:6px;text-decoration:none;white-space:nowrap;transition:all .18s;"
                               onmouseover="this.style.transform='scale(1.04)';" onmouseout="this.style.transform='scale(1)';">
                                @include('components.icon',['name'=>'edit-3','size'=>13]) Input Nilai
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:48px 24px;color:#94A3B8;">
                            <div style="width:52px;height:52px;background:#F7F8FA;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'calendar','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-weight:900;color:#131218;margin:0 0 4px;font-size:14px;">Belum Ada Jadwal Sertifikasi</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Jadwal sertifikasi yang aktif akan muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Responsive Multi-Tier Card Grid (< 1024px: 2 columns on Tablet, 1 column on Mobile) --}}
        <div class="fcc-point-cards">
            @forelse($jadwal as $index => $item)
            @php
                $terisi = $item->kegiatan ? $item->kegiatan->pendaftaran->whereIn('status_pendaftaran', ['terdaftar', 'lulus', 'tidak_lulus'])->count() : 0;
                $isBelum = $item->tgl_pelaksanaan && \Carbon\Carbon::parse($item->tgl_pelaksanaan)->gt(now()->startOfDay());
            @endphp
            <div class="fcc-point-card-item" style="background:#FFFFFF;border:2px solid #E5E7EB;border-radius:16px;padding:16px;box-shadow:0 2px 10px rgba(0,0,0,0.03);display:flex;flex-direction:column;justify-content:space-between;gap:12px;">
                <div>
                {{-- Top: Number, Title, & Batch Tag --}}
                <div style="display:flex;align-items:flex-start;gap:10px;">
                    <span style="display:inline-flex;width:28px;height:28px;border-radius:8px;background:#F1F5F9;border:1px solid #CBD5E1;align-items:center;justify-content:center;color:#131218;font-weight:900;font-size:12px;flex-shrink:0;">
                        {{ $jadwal->firstItem() + $index }}
                    </span>
                    <div style="flex:1;min-width:0;">
                        <h4 style="margin:0 0 6px;font-size:14.5px;font-weight:900;color:#131218;line-height:1.35;">
                            {{ $item->sertifikasi->judul ?? 'Sertifikasi Tidak Ditemukan' }}
                        </h4>
                        @if($item->nama_kegiatan)
                        <span style="font-size:11px;font-weight:800;color:#131218;background:#FFC81A;padding:2px 8px;border-radius:6px;border:1px solid #131218;display:inline-block;">
                            {{ $item->nama_kegiatan }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Badges Row: Tanggal, Status, Kuota --}}
                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:8px;padding:10px 12px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;">
                    <div style="display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:800;color:#334155;white-space:nowrap;">
                        @include('components.icon',['name'=>'calendar','size'=>13,'style'=>'color:#131218;flex-shrink:0;'])
                        <span>{{ \Carbon\Carbon::parse($item->tgl_pelaksanaan)->translatedFormat('d M Y') }}</span>
                    </div>

                    @if($isBelum)
                    <span style="font-size:10.5px;font-weight:800;padding:2px 7px;border-radius:6px;background:#FFFDF5;color:#D97706;border:1px solid #FCD34D;display:inline-flex;align-items:center;gap:3px;white-space:nowrap;">
                        @include('components.icon',['name'=>'clock','size'=>10]) Belum Dimulai
                    </span>
                    @endif

                    <span style="font-weight:900;font-size:11px;padding:3px 10px;border-radius:14px;border:1px solid #131218;margin-left:auto;white-space:nowrap;{{ $terisi >= $item->kuota_peserta ? 'background:#ECFDF5;color:#10B981;border-color:#10B981;' : 'background:#FFC81A;color:#131218;' }}">
                        👥 {{ $terisi }} / {{ $item->kuota_peserta }}
                    </span>
                </div>
            </div>

            {{-- Action Button --}}
            <div>
                <a href="{{ route('admin.sertifikasi.point.show', $item->id) }}"
                   style="width:100%;padding:10px 16px;font-size:13px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:14px;display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;box-shadow:0 3px 8px rgba(255,200,26,0.3);transition:all .18s;box-sizing:border-box;"
                   onmouseover="this.style.background='#F5B700';" onmouseout="this.style.background='#FFC81A';">
                    @include('components.icon',['name'=>'edit-3','size'=>14]) Input Nilai Peserta
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:36px 16px;color:#94A3B8;">
            <div style="width:48px;height:48px;background:#F7F8FA;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                @include('components.icon',['name'=>'calendar','size'=>22,'style'=>'color:#9CA3B0'])
            </div>
            <p style="font-weight:900;color:#131218;margin:0 0 4px;font-size:14px;">Belum Ada Jadwal Sertifikasi</p>
            <p style="font-size:12px;color:#64748B;margin:0;">Jadwal sertifikasi yang aktif akan muncul di sini.</p>
        </div>
            @endforelse
        </div>

        @if($jadwal->hasPages())
        <div style="padding:16px 24px;border-top:1px solid #F1F5F9;overflow-x:auto;">
            {{ $jadwal->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
