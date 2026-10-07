<div>
    @php
        $jadwal = $kegiatan->jadwal;
        $belumDimulai = $jadwal && $jadwal->tgl_pelaksanaan && \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->gt(now()->startOfDay());
    @endphp

    <style>
      /* ── FCC PRESENSI DETAIL MANAGER MULTI-TIER RESPONSIVE STYLES ───── */
      
      /* KPI Counters Grid */
      .fcc-pdt-kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
      }
      /* Di iPad Landscape (1080px–1194px) & Tablet (640px–1023px):
         Sidebar admin menyita 256px, sehingga 2 Kolom memberikan ruang lega (~380px/kartu) tanpa sesak! */
      @media (max-width: 1239px) {
        .fcc-pdt-kpi-grid {
          grid-template-columns: repeat(2, 1fr) !important;
          gap: 12px !important;
          margin-bottom: 20px !important;
        }
      }
      @media (max-width: 639px) {
        .fcc-pdt-kpi-grid {
          grid-template-columns: repeat(2, 1fr) !important;
          gap: 10px !important;
          margin-bottom: 16px !important;
        }
      }
      @media (max-width: 400px) {
        .fcc-pdt-kpi-grid {
          grid-template-columns: 1fr !important;
          gap: 8px !important;
        }
      }

      .fcc-pdt-kpi-card {
        padding: 16px 18px;
        border-radius: 18px;
        background: #FFFFFF;
        border: 2px solid #E5E7EB;
        box-shadow: 0 4px 16px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        gap: 14px;
        cursor: pointer;
        transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease;
        box-sizing: border-box;
      }
      .fcc-pdt-kpi-card:hover {
        transform: translateY(-2px);
        border-color: #CBD5E1;
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
      }
      @media (max-width: 639px) {
        .fcc-pdt-kpi-card {
          padding: 12px 14px;
          border-radius: 14px;
          gap: 10px;
        }
        .fcc-pdt-kpi-card .kpi-icon-box {
          width: 36px !important;
          height: 36px !important;
          border-radius: 10px !important;
        }
        .fcc-pdt-kpi-card .kpi-icon-box svg {
          width: 16px !important;
          height: 16px !important;
        }
        .fcc-pdt-kpi-card .kpi-val {
          font-size: 18px !important;
        }
      }

      /* Main Card */
      .fcc-pdt-main-card {
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
        .fcc-pdt-main-card {
          border-radius: 16px;
        }
      }

      /* Filter Header Bar */
      .fcc-pdt-filter-header {
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
        .fcc-pdt-filter-header {
          flex-direction: column !important;
          align-items: stretch !important;
          gap: 12px !important;
          padding: 14px 16px !important;
        }
      }

      /* Baris Judul & Badge Data */
      .fcc-pdt-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        width: 100%;
        min-width: 0;
      }
      @media (min-width: 1240px) {
        .fcc-pdt-title-row {
          width: auto !important;
          gap: 12px !important;
        }
      }
      .fcc-pdt-title {
        margin: 0;
        font-size: 15px;
        font-weight: 900;
        color: #131218;
        line-height: 1.3;
        min-width: 0;
      }
      @media (max-width: 420px) {
        .fcc-pdt-title {
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

      /* Controls Filter */
      .fcc-pdt-filter-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        width: 100%;
      }
      @media (min-width: 1240px) {
        .fcc-pdt-filter-controls {
          width: auto !important;
        }
      }

      .fcc-pdt-search-box {
        position: relative;
        flex: 1 1 240px;
        min-width: 200px;
      }
      @media (max-width: 639px) {
        .fcc-pdt-search-box {
          flex: 1 1 100% !important;
          width: 100% !important;
        }
      }

      .fcc-pdt-select {
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
        .fcc-pdt-select {
          flex: 1 1 100% !important;
          width: 100% !important;
        }
      }

      /* Desktop & Tablet Table */
      .fcc-pdt-table-wrap {
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
      @media (max-width: 1023px) {
        .fcc-pdt-table-wrap table th,
        .fcc-pdt-table-wrap table td {
          padding-left: 10px !important;
          padding-right: 10px !important;
        }
      }
      @media (max-width: 767px) {
        .fcc-pdt-table-wrap {
          display: none !important;
        }
      }

      /* Mobile Card List */
      .fcc-pdt-cards-wrap {
        display: none;
        padding: 12px 12px;
        flex-direction: column;
        gap: 12px;
        background: #F8FAFC;
      }
      @media (max-width: 767px) {
        .fcc-pdt-cards-wrap {
          display: flex !important;
        }
      }

      .fcc-pdt-user-card {
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

      /* Footer Paginasi */
      .fcc-pdt-footer {
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
        .fcc-pdt-footer {
          flex-direction: column;
          align-items: stretch;
          padding: 14px 14px;
        }
        .fcc-pdt-footer-info {
          flex-direction: column;
          align-items: flex-start;
          gap: 8px;
        }
        .fcc-pdt-footer-info select {
          width: 100% !important;
        }
      }
    </style>

    {{-- Alert Kegiatan Belum Dimulai --}}
    @if($belumDimulai)
    <div style="margin-bottom:20px;padding:14px 18px;background:#FFFDF5;border:1.5px solid #FCD34D;border-radius:14px;display:flex;align-items:flex-start;gap:12px;box-shadow:0 2px 10px rgba(245,158,11,0.08);">
        @include('components.icon',['name'=>'alert-circle','size'=>20,'style'=>'color:#D97706;flex-shrink:0;margin-top:2px;'])
        <div>
            <h4 style="margin:0 0 3px;font-size:13.5px;font-weight:900;color:#92400E;">Pelaksanaan Kegiatan Belum Dimulai</h4>
            <p style="margin:0;font-size:12px;color:#B45309;font-weight:600;line-height:1.4;">
                Tanggal pelaksanaan ditetapkan pada <strong>{{ \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d F Y') }}</strong>. Pengelolaan presensi peserta baru dapat diverifikasi pada saat atau setelah tanggal pelaksanaan.
            </p>
        </div>
    </div>
    @endif

    {{-- Toast Notification --}}
    @if($toastMessage)
    <div style="padding:12px 16px;border-radius:12px;background:rgba(16, 185, 129, 0.12);border:1.5px solid rgba(16, 185, 129, 0.3);color:#059669;font-weight:800;font-size:13px;margin-bottom:18px;display:flex;align-items:center;justify-content:space-between;gap:10px;">
        <span style="display:flex;align-items:center;gap:6px;">
            @include('components.icon',['name'=>'check-circle','size'=>16]) {{ $toastMessage }}
        </span>
        <button type="button" wire:click="$set('toastMessage', null)" style="background:none;border:none;color:#059669;cursor:pointer;font-size:18px;font-weight:900;line-height:1;">&times;</button>
    </div>
    @endif

    {{-- ═══ 1. QUICK KPI COUNTERS (CLICKABLE FILTER TIER) ═══════════════ --}}
    <div class="fcc-pdt-kpi-grid">
        {{-- Card 1: Hadir --}}
        <div wire:click="$set('statusFilter', 'hadir')" class="fcc-pdt-kpi-card" style="{{ $statusFilter === 'hadir' ? 'border-color:#10B981;background:#F0FDF4;' : '' }}" title="Filter peserta Hadir">
            <div class="kpi-icon-box" style="width:42px;height:42px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;box-shadow:0 4px 10px rgba(16,185,129,0.2);flex-shrink:0;">
                @include('components.icon',['name'=>'check-circle','size'=>19])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Hadir</p>
                <p class="kpi-val" style="margin:2px 0 0;font-size:21px;font-weight:900;color:#131218;">{{ number_format($counts['hadir']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>

        {{-- Card 2: Tidak Hadir --}}
        <div wire:click="$set('statusFilter', 'tidak_hadir')" class="fcc-pdt-kpi-card" style="{{ $statusFilter === 'tidak_hadir' ? 'border-color:#EF4444;background:#FEF2F2;' : '' }}" title="Filter peserta Alpha">
            <div class="kpi-icon-box" style="width:42px;height:42px;border-radius:12px;background:#FEF2F2;border:1.5px solid #EF4444;display:flex;align-items:center;justify-content:center;color:#EF4444;box-shadow:0 4px 10px rgba(239,68,68,0.2);flex-shrink:0;">
                @include('components.icon',['name'=>'x-circle','size'=>19])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Tidak Hadir (Alpha)</p>
                <p class="kpi-val" style="margin:2px 0 0;font-size:21px;font-weight:900;color:#131218;">{{ number_format($counts['tidak_hadir']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>

        {{-- Card 3: Belum Presensi --}}
        <div wire:click="$set('statusFilter', 'belum')" class="fcc-pdt-kpi-card" style="{{ $statusFilter === 'belum' ? 'border-color:#F59E0B;background:#FFFDF5;' : '' }}" title="Filter peserta Belum Presensi">
            <div class="kpi-icon-box" style="width:42px;height:42px;border-radius:12px;background:#FEF3C7;border:1.5px solid #F59E0B;display:flex;align-items:center;justify-content:center;color:#D97706;box-shadow:0 4px 10px rgba(245,158,11,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'clock','size'=>19])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Belum Presensi</p>
                <p class="kpi-val" style="margin:2px 0 0;font-size:21px;font-weight:900;color:#131218;">{{ number_format($counts['belum']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>

        {{-- Card 4: Total Peserta --}}
        <div wire:click="$set('statusFilter', '')" class="fcc-pdt-kpi-card" style="{{ empty($statusFilter) ? 'border-color:#131218;' : '' }}" title="Tampilkan Semua Peserta">
            <div class="kpi-icon-box" style="width:42px;height:42px;border-radius:12px;background:#F1F5F9;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;">
                @include('components.icon',['name'=>'users','size'=>19])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Peserta</p>
                <p class="kpi-val" style="margin:2px 0 0;font-size:21px;font-weight:900;color:#131218;">{{ number_format($counts['total']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>
    </div>

    {{-- ═══ 2. MAIN CARD (FILTER + TABLE / MOBILE CARDS) ════════════════ --}}
    <div class="fcc-pdt-main-card">
        {{-- Filter & Header Bar --}}
        <div class="fcc-pdt-filter-header">
            {{-- Title Row with Anti-Wrap Badge --}}
            <div class="fcc-pdt-title-row">
                <h3 class="fcc-pdt-title">Daftar Peserta &amp; Live Status Kehadiran</h3>
                <span class="fcc-badge-data-pill">
                    <span style="font-weight:900;">{{ $pendaftaran->total() }}</span>&nbsp;Data
                </span>
            </div>

            {{-- Filter Inputs Row --}}
            <div class="fcc-pdt-filter-controls">
                {{-- Search Bar --}}
                <div class="fcc-pdt-search-box">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748B;display:flex;pointer-events:none;">
                        @include('components.icon', ['name'=>'search', 'size'=>14])
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                           placeholder="Cari nama, email, instansi..."
                           class="fcc-input" style="padding-left:34px;font-size:12.5px;height:38px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;width:100%;box-sizing:border-box;"
                           autocomplete="off">
                </div>

                {{-- Status Filter --}}
                <select wire:model.live="statusFilter" class="fcc-pdt-select">
                    <option value="">Semua Status Kehadiran</option>
                    <option value="hadir">Hadir</option>
                    <option value="tidak_hadir">Tidak Hadir (Alpha)</option>
                    <option value="belum">Belum Hadir</option>
                </select>

                @if($search || $statusFilter)
                <button type="button" wire:click="$set('search',''); $set('statusFilter','');" style="padding:8px 14px;font-size:12px;height:38px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:4px;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:10px;font-weight:800;transition:all .18s;white-space:nowrap;" title="Reset Filter">
                    ✕ Reset Filter
                </button>
                @endif
            </div>
        </div>

        {{-- ═══ 3A. DESKTOP & TABLET VIEW: TABLE ════════════════════════ --}}
        <div class="fcc-pdt-table-wrap">
            <table style="width:100%;border-collapse:collapse;min-width:880px;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 18px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:55px;min-width:55px;">No</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;min-width:240px;width:30%;">Peserta</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:170px;min-width:170px;">Instansi / Unit</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;min-width:140px;white-space:nowrap;">No. HP</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:260px;min-width:260px;white-space:nowrap;">Live Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $index => $pd)
                    @php
                        $st = $pd->status_kehadiran ?? 'belum';
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        
                        {{-- Nomor --}}
                        <td style="padding:14px 18px;text-align:center;font-size:13px;font-weight:800;color:#64748B;vertical-align:middle;">
                            {{ $pendaftaran->firstItem() + $index }}
                        </td>

                        {{-- Peserta --}}
                        <td style="padding:14px 16px;vertical-align:middle;min-width:240px;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;overflow-wrap:break-word;word-break:normal;line-height:1.35;">
                                {{ $pd->peserta->nama ?? '-' }}
                            </p>
                            <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;overflow-wrap:break-word;word-break:normal;">
                                {{ $pd->peserta->email ?? '-' }}
                            </p>
                        </td>

                        {{-- Instansi --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:12.5px;font-weight:700;color:#334155;min-width:170px;">
                            {{ $pd->peserta->instansi ?? 'Umum' }}
                        </td>

                        {{-- No. HP --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:12.5px;font-weight:700;color:#334155;white-space:nowrap;">
                            {{ $pd->peserta->no_hp ?? '-' }}
                        </td>

                        {{-- Reaktif Livewire Status Buttons --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;white-space:nowrap;">
                            @if($belumDimulai)
                                <button type="button" disabled style="padding:6px 14px;border-radius:10px;border:1.5px solid #CBD5E1;background:#F1F5F9;color:#94A3B8;font-size:12px;font-weight:800;cursor:not-allowed;display:inline-flex;align-items:center;gap:5px;" title="Kegiatan belum dimulai">
                                    @include('components.icon',['name'=>'clock','size'=>13]) Belum Dimulai
                                </button>
                            @else
                                <div style="display:inline-flex;gap:4px;background:#F1F5F9;padding:4px;border-radius:12px;border:1.5px solid #CBD5E1;">
                                    <button type="button" wire:click="markAttendance({{ $pd->id }}, 'hadir')"
                                            style="padding:6px 14px;border-radius:8px;border:none;font-size:12px;font-weight:900;cursor:pointer;transition:all 0.15s;
                                                   background:{{ $st === 'hadir' ? '#10B981' : 'transparent' }};
                                                   color:{{ $st === 'hadir' ? '#FFFFFF' : '#64748B' }};
                                                   box-shadow:{{ $st === 'hadir' ? '0 2px 8px rgba(16,185,129,0.3)' : 'none' }};">
                                        ✓ Hadir
                                    </button>
                                    <button type="button" wire:click="markAttendance({{ $pd->id }}, 'tidak_hadir')"
                                            style="padding:6px 14px;border-radius:8px;border:none;font-size:12px;font-weight:900;cursor:pointer;transition:all 0.15s;
                                                   background:{{ $st === 'tidak_hadir' ? '#EF4444' : 'transparent' }};
                                                   color:{{ $st === 'tidak_hadir' ? '#FFFFFF' : '#64748B' }};
                                                   box-shadow:{{ $st === 'tidak_hadir' ? '0 2px 8px rgba(239,68,68,0.3)' : 'none' }};">
                                        ✕ Alpha
                                    </button>
                                    <button type="button" wire:click="markAttendance({{ $pd->id }}, 'belum')"
                                            style="padding:6px 14px;border-radius:8px;border:none;font-size:12px;font-weight:900;cursor:pointer;transition:all 0.15s;
                                                   background:{{ $st === 'belum' ? '#64748B' : 'transparent' }};
                                                   color:{{ $st === 'belum' ? '#FFFFFF' : '#64748B' }};">
                                        Belum
                                    </button>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px 24px;text-align:center;">
                            <div class="fcc-empty-state-card" style="margin:0 auto;max-width:440px;">
                                <div class="fcc-empty-icon-wrap">
                                    @include('components.icon',['name'=>'users','size'=>26])
                                </div>
                                <h4 class="fcc-empty-title">
                                    {{ $search || $statusFilter ? 'Tidak Ada Peserta yang Cocok' : 'Belum Ada Peserta Terdaftar' }}
                                </h4>
                                <p class="fcc-empty-subtitle">
                                    @if($search || $statusFilter)
                                        Coba sesuaikan kata kunci pencarian atau reset filter status kehadiran.
                                    @else
                                        Peserta yang terdaftar pada kegiatan ini akan muncul secara real-time di sini.
                                    @endif
                                </p>
                                @if($search || $statusFilter)
                                <button type="button" wire:click="$set('search',''); $set('statusFilter','');" class="fcc-empty-reset-btn">
                                    @include('components.icon',['name'=>'refresh-cw','size'=>12]) Reset Semua Filter
                                </button>
                                @else
                                <div style="display:inline-flex;align-items:center;gap:7px;padding:5px 14px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:20px;font-size:11.5px;font-weight:700;color:#64748B;">
                                    <span style="width:7px;height:7px;border-radius:50%;background:#F59E0B;display:inline-block;box-shadow:0 0 6px rgba(245,158,11,0.5);"></span> Menunggu pendaftar masuk
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ═══ 3B. MOBILE VIEW: DEDICATED ATTENDANCE CARDS ══════════════ --}}
        <div class="fcc-pdt-cards-wrap">
            @forelse($pendaftaran as $index => $pd)
            @php
                $st = $pd->status_kehadiran ?? 'belum';
            @endphp
            <div class="fcc-pdt-user-card">
                {{-- Header Card: No & Badge & Instansi --}}
                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-size:11px;font-weight:900;background:#131218;color:#FFC81A;padding:2px 8px;border-radius:6px;flex-shrink:0;">
                            #{{ $pendaftaran->firstItem() + $index }}
                        </span>
                        <div>
                            <h4 style="margin:0;font-size:14px;font-weight:900;color:#131218;line-height:1.3;word-break:break-word;">
                                {{ $pd->peserta->nama ?? '-' }}
                            </h4>
                            <p style="margin:2px 0 0;font-size:11.5px;color:#64748B;word-break:break-word;">
                                {{ $pd->peserta->email ?? '-' }}
                            </p>
                        </div>
                    </div>

                    {{-- Current status badge --}}
                    @php
                    $badgeStyle = match($st) {
                        'hadir'       => 'background:#ECFDF5;border:1px solid #A7F3D0;color:#059669;',
                        'tidak_hadir' => 'background:#FEF2F2;border:1px solid #FCA5A5;color:#DC2626;',
                        default       => 'background:#F1F5F9;border:1px solid #CBD5E1;color:#64748B;',
                    };
                    $badgeText = match($st) {
                        'hadir'       => '✓ Hadir',
                        'tidak_hadir' => '✕ Alpha',
                        default       => 'Belum Hadir',
                    };
                    @endphp
                    <span style="font-size:10.5px;font-weight:800;padding:2px 8px;border-radius:6px;white-space:nowrap;flex-shrink:0;{{ $badgeStyle }}">
                        {{ $badgeText }}
                    </span>
                </div>

                {{-- Info Row: Instansi & No HP --}}
                <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:8px 12px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:6px;font-size:12px;">
                    <div style="display:flex;align-items:center;gap:5px;color:#334155;font-weight:700;">
                        @include('components.icon',['name'=>'building','size'=>12,'style'=>'color:#64748B'])
                        <span>{{ $pd->peserta->instansi ?? 'Umum' }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:5px;color:#0F172A;font-weight:800;">
                        @include('components.icon',['name'=>'phone','size'=>12,'style'=>'color:#64748B'])
                        <span>{{ $pd->peserta->no_hp ?? '-' }}</span>
                    </div>
                </div>

                {{-- Action Row: Attendance Buttons Group --}}
                <div>
                    @if($belumDimulai)
                        <div style="width:100%;padding:9px;text-align:center;border-radius:10px;background:#F1F5F9;border:1px solid #CBD5E1;color:#94A3B8;font-size:12px;font-weight:800;display:flex;align-items:center;justify-content:center;gap:6px;">
                            @include('components.icon',['name'=>'clock','size'=>13]) Kegiatan Belum Dimulai
                        </div>
                    @else
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:6px;background:#F1F5F9;padding:4px;border-radius:10px;border:1.5px solid #CBD5E1;">
                            <button type="button" wire:click="markAttendance({{ $pd->id }}, 'hadir')"
                                    style="padding:9px 6px;border-radius:8px;border:none;font-size:12px;font-weight:900;cursor:pointer;transition:all 0.15s;display:flex;align-items:center;justify-content:center;gap:4px;
                                           background:{{ $st === 'hadir' ? '#10B981' : 'transparent' }};
                                           color:{{ $st === 'hadir' ? '#FFFFFF' : '#64748B' }};
                                           box-shadow:{{ $st === 'hadir' ? '0 2px 8px rgba(16,185,129,0.3)' : 'none' }};">
                                ✓ Hadir
                            </button>
                            <button type="button" wire:click="markAttendance({{ $pd->id }}, 'tidak_hadir')"
                                    style="padding:9px 6px;border-radius:8px;border:none;font-size:12px;font-weight:900;cursor:pointer;transition:all 0.15s;display:flex;align-items:center;justify-content:center;gap:4px;
                                           background:{{ $st === 'tidak_hadir' ? '#EF4444' : 'transparent' }};
                                           color:{{ $st === 'tidak_hadir' ? '#FFFFFF' : '#64748B' }};
                                           box-shadow:{{ $st === 'tidak_hadir' ? '0 2px 8px rgba(239,68,68,0.3)' : 'none' }};">
                                ✕ Alpha
                            </button>
                            <button type="button" wire:click="markAttendance({{ $pd->id }}, 'belum')"
                                    style="padding:9px 6px;border-radius:8px;border:none;font-size:12px;font-weight:900;cursor:pointer;transition:all 0.15s;display:flex;align-items:center;justify-content:center;gap:4px;
                                           background:{{ $st === 'belum' ? '#64748B' : 'transparent' }};
                                           color:{{ $st === 'belum' ? '#FFFFFF' : '#64748B' }};">
                                Belum
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="fcc-empty-state-card">
                <div class="fcc-empty-icon-wrap">
                    @include('components.icon',['name'=>'users','size'=>26])
                </div>
                <h4 class="fcc-empty-title">
                    {{ $search || $statusFilter ? 'Tidak Ada Peserta yang Cocok' : 'Belum Ada Peserta Terdaftar' }}
                </h4>
                <p class="fcc-empty-subtitle">
                    @if($search || $statusFilter)
                        Coba sesuaikan kata kunci pencarian atau reset filter kehadiran.
                    @else
                        Peserta yang terdaftar pada kegiatan ini akan muncul di sini.
                    @endif
                </p>
                @if($search || $statusFilter)
                <button type="button" wire:click="$set('search',''); $set('statusFilter','');" class="fcc-empty-reset-btn">
                    @include('components.icon',['name'=>'refresh-cw','size'=>12]) Reset Semua Filter
                </button>
                @else
                <div style="display:inline-flex;align-items:center;gap:7px;padding:5px 14px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:20px;font-size:11.5px;font-weight:700;color:#64748B;">
                    <span style="width:7px;height:7px;border-radius:50%;background:#F59E0B;display:inline-block;box-shadow:0 0 6px rgba(245,158,11,0.5);"></span> Menunggu pendaftar masuk
                </div>
                @endif
            </div>
            @endforelse
        </div>

        {{-- ═══ 4. PAGINATION FOOTER ════════════════════════════════════ --}}
        <div class="fcc-pdt-footer">
            <div class="fcc-pdt-footer-info" style="display:flex;align-items:center;gap:10px;">
                <select wire:model.live="perPage" class="fcc-input" style="width:auto;font-size:12.5px;height:34px;padding:0 10px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;font-weight:700;cursor:pointer;color:#131218;outline:none;" title="Jumlah data per halaman">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 / hal</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 / hal</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 / hal</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 / hal</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 / hal</option>
                </select>
                <span style="font-size:12px;color:#64748B;font-weight:600;">
                    Menampilkan {{ $pendaftaran->firstItem() ?? 0 }}–{{ $pendaftaran->lastItem() ?? 0 }} dari {{ $pendaftaran->total() }} data
                </span>
            </div>
            <div>
                {{ $pendaftaran->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>
</div>
