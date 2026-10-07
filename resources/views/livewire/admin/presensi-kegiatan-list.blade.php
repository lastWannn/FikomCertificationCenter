<div>
    <style>
      /* ── FCC PRESENSI KEGIATAN LIST MULTI-TIER RESPONSIVE STYLES ────── */
      .fcc-pkeg-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
      }
      /* Di iPad Landscape (1080px–1194px) & Tablet (640px–1023px):
         Sidebar admin menyita 256px, sehingga 2 Kolom memberikan ruang lega (~380px/kartu) tanpa sesak! */
      @media (max-width: 1239px) {
        .fcc-pkeg-stat-grid {
          grid-template-columns: repeat(2, 1fr) !important;
          gap: 12px !important;
          margin-bottom: 20px !important;
        }
      }
      @media (max-width: 639px) {
        .fcc-pkeg-stat-grid {
          grid-template-columns: repeat(2, 1fr) !important;
          gap: 10px !important;
          margin-bottom: 16px !important;
        }
      }
      @media (max-width: 400px) {
        .fcc-pkeg-stat-grid {
          grid-template-columns: 1fr !important;
          gap: 8px !important;
        }
      }

      /* Stat Card Inner */
      .fcc-pkeg-stat-card {
        padding: 16px 18px;
        border-radius: 18px;
        background: #FFFFFF;
        border: 2px solid #E5E7EB;
        box-shadow: 0 4px 16px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        gap: 14px;
        box-sizing: border-box;
      }
      @media (max-width: 639px) {
        .fcc-pkeg-stat-card {
          padding: 12px 14px;
          border-radius: 14px;
          gap: 10px;
        }
        .fcc-pkeg-stat-card .stat-icon-box {
          width: 36px !important;
          height: 36px !important;
          border-radius: 10px !important;
        }
        .fcc-pkeg-stat-card .stat-icon-box svg {
          width: 16px !important;
          height: 16px !important;
        }
        .fcc-pkeg-stat-card .stat-val {
          font-size: 18px !important;
        }
      }

      /* Card Main Wrapper */
      .fcc-pkeg-main-card {
        padding: 0;
        overflow: hidden;
        border-radius: 20px;
        background: #FFFFFF;
        border: 2px solid #E5E7EB;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        position: relative;
        box-sizing: border-box;
      }
      @media (max-width: 639px) {
        .fcc-pkeg-main-card {
          border-radius: 16px;
        }
      }

      /* Header & Filters */
      .fcc-pkeg-filter-header {
        padding: 16px 22px;
        border-bottom: 2px solid #E5E7EB;
        background: #F8FAFC;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
      }
      /* Di iPad & Tablet (<= 1239px): Tata letak vertikal bertumpuk agar judul dan filter tidak bertubrukan */
      @media (max-width: 1239px) {
        .fcc-pkeg-filter-header {
          flex-direction: column !important;
          align-items: stretch !important;
          gap: 12px !important;
          padding: 14px 16px !important;
        }
      }

      /* Baris Judul & Badge Data */
      .fcc-pkeg-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        width: 100%;
        min-width: 0;
      }
      @media (min-width: 1240px) {
        .fcc-pkeg-title-row {
          width: auto !important;
          gap: 12px !important;
        }
      }
      .fcc-pkeg-title {
        margin: 0;
        font-size: 15px;
        font-weight: 900;
        color: #131218;
        line-height: 1.3;
        min-width: 0;
      }
      @media (max-width: 420px) {
        .fcc-pkeg-title {
          font-size: 14px;
        }
      }

      /* Badge Data: Anti-Wrap Pill Guard */
      .fcc-badge-data-pill {
        font-size: 11px;
        font-weight: 800;
        color: #131218;
        background: #FFC81A;
        padding: 4px 10px;
        border-radius: 9999px;
        border: 1.5px solid #131218;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        line-height: 1.2;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
      }

      .fcc-pkeg-filter-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
      }
      @media (min-width: 1240px) {
        .fcc-pkeg-filter-controls {
          width: auto !important;
        }
      }

      .fcc-pkeg-search-box {
        position: relative;
        flex: 1 1 240px;
        min-width: 200px;
      }
      @media (max-width: 639px) {
        .fcc-pkeg-search-box {
          flex: 1 1 100% !important;
          width: 100% !important;
        }
      }

      .fcc-pkeg-filter-select {
        font-size: 12.5px;
        height: 38px;
        padding: 0 12px;
        background: #FFF;
        border: 1.5px solid #CBD5E1;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        box-sizing: border-box;
        flex: 0 1 auto;
        min-width: 180px;
      }
      @media (max-width: 639px) {
        .fcc-pkeg-filter-select {
          flex: 1 1 100% !important;
          width: 100% !important;
        }
      }

      /* Desktop & Tablet Table */
      .fcc-pkeg-table-wrap {
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
      @media (max-width: 1023px) {
        .fcc-pkeg-table-wrap table th,
        .fcc-pkeg-table-wrap table td {
          padding-left: 10px !important;
          padding-right: 10px !important;
        }
      }
      @media (max-width: 767px) {
        .fcc-pkeg-table-wrap {
          display: none !important;
        }
      }

      /* Mobile Card List */
      .fcc-pkeg-cards-wrap {
        display: none;
        padding: 12px 12px;
        flex-direction: column;
        gap: 12px;
        background: #F8FAFC;
      }
      @media (max-width: 767px) {
        .fcc-pkeg-cards-wrap {
          display: flex !important;
        }
      }

      .fcc-pkeg-item-card {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 14px;
        padding: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
        gap: 11px;
        box-sizing: border-box;
      }
      .fcc-pkeg-item-card:hover {
        border-color: #CBD5E1;
      }

      /* Empty State Box */
      .fcc-empty-state-card {
        padding: 36px 18px;
        text-align: center;
        background: #FFFFFF;
        border-radius: 14px;
        border: 1.5px dashed #CBD5E1;
        margin: 4px;
        box-sizing: border-box;
      }
      .fcc-empty-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #FFFDF5;
        border: 1.5px solid #FFC81A;
        color: #131218;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        box-shadow: 0 4px 12px rgba(255, 200, 26, 0.2);
      }
      .fcc-empty-title {
        font-size: 15px;
        font-weight: 900;
        color: #131218;
        margin: 0 0 4px;
      }
      .fcc-empty-subtitle {
        font-size: 12.5px;
        color: #64748B;
        margin: 0 0 14px;
        max-width: 360px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.4;
      }
      .fcc-empty-reset-btn {
        padding: 8px 18px;
        border-radius: 20px;
        background: #131218;
        color: #FFC81A;
        font-size: 12px;
        font-weight: 800;
        border: 1.5px solid #131218;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.18s;
      }
      .fcc-empty-reset-btn:hover {
        background: #FFC81A;
        color: #131218;
      }

      /* Pagination Footer */
      .fcc-pkeg-footer {
        padding: 14px 20px;
        border-top: 1px solid #E2E4EB;
        background: #F8FAFC;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
      }
      @media (max-width: 639px) {
        .fcc-pkeg-footer {
          flex-direction: column;
          align-items: stretch;
          padding: 14px 14px;
        }
        .fcc-pkeg-footer-info {
          flex-direction: column;
          align-items: flex-start;
          gap: 8px;
        }
        .fcc-pkeg-footer-info select {
          width: 100% !important;
        }
      }
    </style>

    {{-- ═══ 1. STAT CARDS GRID (NEO-BRUTALIST MULTI-TIER) ═══════════════ --}}
    <div class="fcc-pkeg-stat-grid">
        {{-- Card 1: Total Kegiatan --}}
        <div class="fcc-pkeg-stat-card">
            <div class="stat-icon-box" style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'clipboard-list','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Kegiatan</p>
                <p class="stat-val" style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $kegiatanList->total() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span></p>
            </div>
        </div>

        {{-- Card 2: Pelatihan --}}
        <div class="fcc-pkeg-stat-card">
            <div class="stat-icon-box" style="width:44px;height:44px;border-radius:12px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;">
                @include('components.icon',['name'=>'book-open','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Pelatihan</p>
                <p class="stat-val" style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ \App\Models\Kegiatan::visibleToPublic()->doesntHave('arsip')->where('jenis_kegiatan','pelatihan')->count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span></p>
            </div>
        </div>

        {{-- Card 3: Sertifikasi --}}
        <div class="fcc-pkeg-stat-card">
            <div class="stat-icon-box" style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'award','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Sertifikasi</p>
                <p class="stat-val" style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ \App\Models\Kegiatan::visibleToPublic()->doesntHave('arsip')->where('jenis_kegiatan','sertifikasi')->count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span></p>
            </div>
        </div>

        {{-- Card 4: Total Peserta --}}
        <div class="fcc-pkeg-stat-card">
            <div class="stat-icon-box" style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;">
                @include('components.icon',['name'=>'users','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Peserta Terdaftar</p>
                <p class="stat-val" style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ \App\Models\Pendaftaran::whereHas('kegiatan', fn($q)=>$q->visibleToPublic()->doesntHave('arsip'))->where('status_pendaftaran','terdaftar')->count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>
    </div>

    {{-- ═══ 2. MAIN CARD (FILTER + TABLE / MOBILE CARDS) ════════════════ --}}
    <div class="fcc-pkeg-main-card">
        {{-- Filter & Header Bar --}}
        <div class="fcc-pkeg-filter-header">
            <div class="fcc-pkeg-title-row">
                <h3 class="fcc-pkeg-title">Daftar Kegiatan Presensi</h3>
                <span class="fcc-badge-data-pill">
                    <span style="font-weight:900;">{{ $kegiatanList->total() }}</span>&nbsp;Data
                </span>
            </div>

            <div class="fcc-pkeg-filter-controls">
                {{-- Search Bar --}}
                <div class="fcc-pkeg-search-box">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748B;display:flex;pointer-events:none;">
                        @include('components.icon', ['name'=>'search', 'size'=>14])
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="q"
                           placeholder="Cari nama kegiatan..."
                           class="fcc-input" style="padding-left:34px;font-size:12.5px;height:38px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;width:100%;box-sizing:border-box;"
                           autocomplete="off">
                </div>

                {{-- Jenis Select --}}
                <select wire:model.live="jenis" class="fcc-pkeg-filter-select">
                    <option value="">Semua Jenis Kegiatan</option>
                    <option value="pelatihan">Pelatihan</option>
                    <option value="sertifikasi">Sertifikasi</option>
                </select>

                @if($q || $jenis)
                <button type="button" wire:click="resetFilters" style="padding:8px 14px;font-size:12px;height:38px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:4px;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:10px;font-weight:800;transition:all .18s;" title="Reset Filter">
                    ✕ Reset Filter
                </button>
                @endif
            </div>
        </div>

        {{-- ═══ 3A. DESKTOP & TABLET VIEW: TABLE ════════════════════════ --}}
        <div class="fcc-pkeg-table-wrap">
            <table style="width:100%;border-collapse:collapse;min-width:960px;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;min-width:280px;width:32%;white-space:nowrap;">Nama Kegiatan</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:110px;min-width:110px;white-space:nowrap;">Jenis</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:180px;min-width:180px;white-space:nowrap;">Jadwal Pelaksanaan</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;min-width:140px;white-space:nowrap;">Peserta Terdaftar</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:290px;min-width:290px;white-space:nowrap;">Aksi Presensi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatanList as $kegiatan)
                    @php
                        $isPel  = $kegiatan->jenis_kegiatan === 'pelatihan';
                        $jadwal = $kegiatan->jadwal;
                        $isBelum = $jadwal?->tgl_pelaksanaan && \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->gt(now()->startOfDay());
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        
                        {{-- Nama Kegiatan --}}
                        <td style="padding:14px 20px;vertical-align:middle;min-width:280px;">
                            <div style="display:flex;align-items:center;gap:12px;min-width:260px;">
                                <div style="width:42px;height:42px;border-radius:10px;background:{{ $isPel?'rgba(255,200,26,.18)':'rgba(59,130,246,.14)' }};border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>18,'style'=>'color:'.($isPel?'#131218':'#2563EB')])
                                </div>
                                <div style="min-width:0;flex:1;">
                                    <a href="{{ route('admin.presensi.show', $kegiatan) }}" style="font-size:14px;font-weight:900;color:#131218;text-decoration:none;margin:0;display:block;line-height:1.4;transition:color .15s;overflow-wrap:break-word;word-break:normal;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#131218'">
                                        {{ $kegiatan->judul }}
                                    </a>
                                </div>
                            </div>
                        </td>

                        {{-- Jenis --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;white-space:nowrap;">
                            <span style="font-size:10.5px;font-weight:800;padding:3px 10px;border-radius:12px;background:{{ $isPel?'#FFFDF5':'#EFF6FF' }};color:{{ $isPel?'#B38F00':'#2563EB' }};border:1px solid {{ $isPel?'#FFC81A':'#93C5FD' }};display:inline-block;white-space:nowrap;">
                                {{ ucfirst($kegiatan->jenis_kegiatan) }}
                            </span>
                        </td>

                        {{-- Jadwal Pelaksanaan --}}
                        <td style="padding:14px 16px;vertical-align:middle;white-space:nowrap;">
                            <div style="display:flex;align-items:center;gap:6px;margin-bottom:2px;flex-wrap:wrap;">
                                <span style="font-size:13px;font-weight:800;color:#131218;">
                                    {{ $jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}
                                </span>
                                @if($isBelum)
                                <span style="font-size:10px;font-weight:800;padding:2px 7px;border-radius:6px;background:#FFFDF5;color:#D97706;border:1px solid #FCD34D;display:inline-flex;align-items:center;gap:3px;" title="Kegiatan belum dimulai">
                                    @include('components.icon',['name'=>'clock','size'=>11]) Belum Dimulai
                                </span>
                                @endif
                            </div>
                            <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:600;">
                                ⏰ {{ $jadwal?->jam_mulai ? substr($jadwal->jam_mulai, 0, 5) : '-' }} &ndash; {{ $jadwal?->jam_selesai ? substr($jadwal->jam_selesai, 0, 5) : '-' }} WITA
                            </p>
                        </td>

                        {{-- Peserta Terdaftar --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            <span style="font-size:11.5px;font-weight:800;padding:4px 12px;border-radius:20px;background:#ECFDF5;color:#059669;border:1px solid #A7F3D0;display:inline-block;white-space:nowrap;">
                                👥 {{ $kegiatan->total_peserta }} Peserta
                            </span>
                        </td>

                        {{-- Aksi Presensi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;white-space:nowrap;">
                            <div style="display:inline-flex;gap:6px;align-items:center;justify-content:center;">
                                {{-- Kelola Presensi --}}
                                <a href="{{ route('admin.presensi.show', $kegiatan) }}"
                                   style="padding:7px 14px;font-size:12px;font-weight:800;background:#131218;color:#FFC81A;border-radius:8px;border:1px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .18s;"
                                   onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                                    @include('components.icon',['name'=>'users','size'=>14]) Kelola Presensi
                                </a>

                                {{-- Cetak PDF Presensi Kertas --}}
                                <a href="{{ route('admin.cetak.presensi', $kegiatan) }}" target="_blank"
                                   style="padding:7px 11px;font-size:12px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:8px;border:1.5px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .18s;"
                                   title="Cetak Lembar Presensi PDF">
                                    @include('components.icon',['name'=>'printer','size'=>13]) PDF
                                </a>

                                {{-- Export CSV --}}
                                <a href="{{ route('admin.presensi.export', $kegiatan) }}"
                                   style="padding:7px 11px;font-size:12px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:8px;border:1.5px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .18s;"
                                   title="Export Data CSV">
                                    @include('components.icon',['name'=>'download','size'=>13]) CSV
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px 24px;text-align:center;">
                            <div class="fcc-empty-state-card" style="margin:0 auto;max-width:440px;">
                                <div class="fcc-empty-icon-wrap">
                                    @include('components.icon',['name'=>'clipboard-list','size'=>26])
                                </div>
                                <h4 class="fcc-empty-title">
                                    {{ $q || $jenis ? 'Tidak Ada Kegiatan yang Cocok' : 'Belum Ada Kegiatan Presensi' }}
                                </h4>
                                <p class="fcc-empty-subtitle">
                                    @if($q || $jenis)
                                        Coba sesuaikan kata kunci pencarian atau reset filter jenis kegiatan.
                                    @else
                                        Daftar kegiatan aktif akan muncul secara otomatis di sini.
                                    @endif
                                </p>
                                @if($q || $jenis)
                                <button type="button" wire:click="resetFilters" class="fcc-empty-reset-btn">
                                    @include('components.icon',['name'=>'refresh-cw','size'=>12]) Reset Filter
                                </button>
                                @else
                                <div style="display:inline-flex;align-items:center;gap:7px;padding:5px 14px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:20px;font-size:11.5px;font-weight:700;color:#64748B;">
                                    <span style="width:7px;height:7px;border-radius:50%;background:#10B981;display:inline-block;box-shadow:0 0 6px rgba(16,185,129,0.5);"></span> Sinkronisasi Real-Time Aktif
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ═══ 3B. MOBILE VIEW: DEDICATED TOUCH CARDS ═══════════════════ --}}
        <div class="fcc-pkeg-cards-wrap">
            @forelse($kegiatanList as $kegiatan)
            @php
                $isPel  = $kegiatan->jenis_kegiatan === 'pelatihan';
                $jadwal = $kegiatan->jadwal;
                $isBelum = $jadwal?->tgl_pelaksanaan && \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->gt(now()->startOfDay());
            @endphp
            <div class="fcc-pkeg-item-card">
                {{-- Top Badge Row --}}
                <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:6px;">
                    <span style="font-size:10.5px;font-weight:800;padding:2px 8px;border-radius:8px;background:{{ $isPel?'#FFFDF5':'#EFF6FF' }};color:{{ $isPel?'#B38F00':'#2563EB' }};border:1px solid {{ $isPel?'#FFC81A':'#93C5FD' }};">
                        {{ ucfirst($kegiatan->jenis_kegiatan) }}
                    </span>

                    <span style="font-size:11px;font-weight:800;padding:3px 10px;border-radius:20px;background:#ECFDF5;color:#059669;border:1px solid #A7F3D0;">
                        👥 {{ $kegiatan->total_peserta }} Peserta
                    </span>
                </div>

                {{-- Activity Title --}}
                <div>
                    <a href="{{ route('admin.presensi.show', $kegiatan) }}"
                       style="font-size:14.5px;font-weight:900;color:#131218;text-decoration:none;line-height:1.35;display:block;">
                        {{ $kegiatan->judul }}
                    </a>
                </div>

                {{-- Schedule Details --}}
                <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:10px 12px;display:flex;flex-direction:column;gap:5px;font-size:12px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:4px;">
                        <span style="color:#64748B;font-weight:700;display:flex;align-items:center;gap:5px;">
                            @include('components.icon',['name'=>'calendar','size'=>12]) Pelaksanaan:
                        </span>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <strong style="color:#0F172A;">{{ $jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}</strong>
                            @if($isBelum)
                            <span style="font-size:9.5px;font-weight:800;padding:1px 6px;border-radius:4px;background:#FFFDF5;color:#D97706;border:1px solid #FCD34D;">
                                Belum Dimulai
                            </span>
                            @endif
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px dashed #E2E8F0;padding-top:4px;">
                        <span style="color:#64748B;font-weight:700;display:flex;align-items:center;gap:5px;">
                            @include('components.icon',['name'=>'clock','size'=>12]) Waktu:
                        </span>
                        <strong style="color:#0F172A;">
                            {{ $jadwal?->jam_mulai ? substr($jadwal->jam_mulai, 0, 5) : '-' }} &ndash; {{ $jadwal?->jam_selesai ? substr($jadwal->jam_selesai, 0, 5) : '-' }} WITA
                        </strong>
                    </div>
                </div>

                {{-- Action Buttons Mobile --}}
                <div style="display:flex;flex-direction:column;gap:8px;margin-top:2px;">
                    {{-- Primary Gold Button: Kelola Presensi --}}
                    <a href="{{ route('admin.presensi.show', $kegiatan) }}"
                       style="padding:10px 16px;font-size:13px;font-weight:900;background:#131218;color:#FFC81A;border-radius:10px;border:1.5px solid #131218;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 3px 10px rgba(0,0,0,0.1);">
                        @include('components.icon',['name'=>'users','size'=>15]) Kelola Presensi
                    </a>

                    {{-- Secondary Actions: PDF & CSV --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                        <a href="{{ route('admin.cetak.presensi', $kegiatan) }}" target="_blank"
                           style="padding:8px 10px;font-size:12px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:8px;border:1.5px solid #CBD5E1;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:5px;">
                            @include('components.icon',['name'=>'printer','size'=>13]) Cetak PDF
                        </a>
                        <a href="{{ route('admin.presensi.export', $kegiatan) }}"
                           style="padding:8px 10px;font-size:12px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:8px;border:1.5px solid #CBD5E1;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:5px;">
                            @include('components.icon',['name'=>'download','size'=>13]) Export CSV
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="fcc-empty-state-card">
                <div class="fcc-empty-icon-wrap">
                    @include('components.icon',['name'=>'clipboard-list','size'=>26])
                </div>
                <h4 class="fcc-empty-title">
                    {{ $q || $jenis ? 'Tidak Ada Kegiatan yang Cocok' : 'Belum Ada Kegiatan Presensi' }}
                </h4>
                <p class="fcc-empty-subtitle">
                    @if($q || $jenis)
                        Coba sesuaikan kata kunci pencarian atau reset filter jenis kegiatan.
                    @else
                        Daftar kegiatan aktif akan muncul di sini.
                    @endif
                </p>
                @if($q || $jenis)
                <button type="button" wire:click="resetFilters" class="fcc-empty-reset-btn">
                    @include('components.icon',['name'=>'refresh-cw','size'=>12]) Reset Filter
                </button>
                @else
                <div style="display:inline-flex;align-items:center;gap:7px;padding:5px 14px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:20px;font-size:11.5px;font-weight:700;color:#64748B;">
                    <span style="width:7px;height:7px;border-radius:50%;background:#10B981;display:inline-block;box-shadow:0 0 6px rgba(16,185,129,0.5);"></span> Sinkronisasi Real-Time Aktif
                </div>
                @endif
            </div>
            @endforelse
        </div>

        {{-- ═══ 4. PAGINATION FOOTER ════════════════════════════════════ --}}
        <div class="fcc-pkeg-footer">
            <div class="fcc-pkeg-footer-info" style="display:flex;align-items:center;gap:10px;">
                <select wire:model.live="perPage" class="fcc-input" style="width:auto;font-size:12.5px;height:34px;padding:0 10px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;font-weight:700;cursor:pointer;color:#131218;outline:none;" title="Jumlah data per halaman">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 / hal</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 / hal</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 / hal</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 / hal</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 / hal</option>
                </select>
                <span style="font-size:12px;color:#64748B;font-weight:600;">
                    Menampilkan {{ $kegiatanList->firstItem() ?? 0 }}–{{ $kegiatanList->lastItem() ?? 0 }} dari {{ $kegiatanList->total() }} data
                </span>
            </div>
            <div>
                {{ $kegiatanList->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>
</div>
