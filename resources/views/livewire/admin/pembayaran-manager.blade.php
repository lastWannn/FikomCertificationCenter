<div wire:poll.10s>
    <style>
      /* ── LIVEWIRE PEMBAYARAN MANAGER MULTI-TIER RESPONSIVE STYLES ── */
      .fcc-pm-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
      }
      @media (max-width: 1023px) {
        .fcc-pm-stats-grid {
          grid-template-columns: repeat(2, 1fr);
          gap: 14px;
          margin-bottom: 20px;
        }
      }
      @media (max-width: 639px) {
        .fcc-pm-stats-grid {
          grid-template-columns: repeat(2, 1fr);
          gap: 10px;
          margin-bottom: 16px;
        }
      }
      @media (max-width: 420px) {
        .fcc-pm-stats-grid {
          grid-template-columns: 1fr;
          gap: 8px;
        }
      }

      .fcc-pm-stat-card {
        padding: 18px 20px;
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
      .fcc-pm-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        border-color: #CBD5E1;
      }
      .fcc-pm-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
      }
      .fcc-pm-stat-label {
        margin: 0;
        font-size: 11px;
        font-weight: 800;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1.2;
      }
      .fcc-pm-stat-val {
        margin: 3px 0 0;
        font-size: 22px;
        font-weight: 900;
        color: #131218;
        line-height: 1.1;
      }
      .fcc-pm-stat-val span {
        font-size: 12px;
        font-weight: 700;
        color: #94A3B8;
      }

      @media (max-width: 639px) {
        .fcc-pm-stat-card {
          padding: 12px 14px;
          gap: 10px;
          border-radius: 14px;
        }
        .fcc-pm-stat-icon {
          width: 38px;
          height: 38px;
          border-radius: 10px;
        }
        .fcc-pm-stat-label {
          font-size: 10px;
          letter-spacing: 0.3px;
        }
        .fcc-pm-stat-val {
          font-size: 18px;
        }
        .fcc-pm-stat-val span {
          display: none;
        }
      }

      /* Card Container */
      .fcc-pm-main-card {
        border-radius: 20px;
        background: #FFFFFF;
        border: 2px solid #E5E7EB;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        position: relative;
        overflow: hidden;
      }
      @media (max-width: 639px) {
        .fcc-pm-main-card {
          border-radius: 16px;
        }
      }

      /* Filter Header Bar */
      .fcc-pm-filter-bar {
        padding: 18px 24px;
        border-bottom: 2px solid #E5E7EB;
        background: #F8FAFC;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
      }
      .fcc-pm-filter-title {
        margin: 0;
        font-size: 16px;
        font-weight: 900;
        color: #131218;
      }
      .fcc-pm-filter-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
      }
      .fcc-pm-search-wrap {
        position: relative;
        width: 240px;
      }

      @media (max-width: 1023px) {
        .fcc-pm-filter-bar {
          padding: 16px 20px;
        }
      }

      @media (max-width: 767px) {
        .fcc-pm-filter-bar {
          flex-direction: column;
          align-items: stretch;
          gap: 12px;
          padding: 14px 16px;
        }
        .fcc-pm-filter-controls {
          width: 100%;
          display: flex;
          flex-direction: column;
          gap: 10px;
        }
        .fcc-pm-search-wrap {
          width: 100%;
        }
        .fcc-pm-select-row {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 8px;
          width: 100%;
        }
        .fcc-pm-select-row select {
          width: 100% !important;
        }
        .fcc-pm-reset-btn {
          width: 100%;
          justify-content: center;
        }
      }

      /* Table Retention on Tablet & Desktop (>= 640px) */
      .fcc-pm-table-wrap {
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
      .fcc-pm-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 820px;
      }

      /* Mobile Card List (< 640px) */
      .fcc-pm-mobile-cards {
        display: none;
      }
      @media (max-width: 639px) {
        .fcc-pm-table-wrap {
          display: none;
        }
        .fcc-pm-mobile-cards {
          display: flex;
          flex-direction: column;
          gap: 12px;
          padding: 14px 12px;
          background: #F8FAFC;
        }
      }

      .fcc-pm-mcard {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 14px;
        padding: 14px 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        cursor: pointer;
        transition: transform .15s ease, border-color .15s ease, box-shadow .15s ease;
        position: relative;
      }
      .fcc-pm-mcard:hover, .fcc-pm-mcard:active {
        transform: translateY(-2px);
        border-color: #CBD5E1;
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
      }
      .fcc-pm-mcard-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        flex-wrap: wrap;
      }
      .fcc-pm-mcard-amount-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 10px 12px;
        margin: 10px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      /* Pagination Bar */
      .fcc-pm-pagination {
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
        .fcc-pm-pagination {
          flex-direction: column;
          align-items: center;
          gap: 10px;
          padding: 14px 12px;
          text-align: center;
        }
        .fcc-pm-pagination > div {
          width: 100%;
          justify-content: center;
        }
      }
    </style>

    {{-- Stat Cards Grid (Multi-Tier Neo-Brutalist) --}}
    <div class="fcc-pm-stats-grid">
        {{-- Card 1: Menunggu Verifikasi --}}
        <div wire:click="$set('status', 'menunggu_verifikasi')" class="fcc-pm-stat-card" style="{{ $status === 'menunggu_verifikasi' ? 'border-color:#F59E0B;background:#FFFDF5;' : '' }}">
            <div class="fcc-pm-stat-icon" style="background:#FEF3C7;border:1.5px solid #F59E0B;color:#D97706;box-shadow:0 4px 10px rgba(245,158,11,0.25);">
                @include('components.icon',['name'=>'clock','size'=>20])
            </div>
            <div>
                <p class="fcc-pm-stat-label">Menunggu Verifikasi</p>
                <p class="fcc-pm-stat-val">{{ number_format($counts['menunggu_verifikasi']) }} <span>Transaksi</span></p>
            </div>
        </div>

        {{-- Card 2: Request Perpanjangan --}}
        <div wire:click="$set('status', 'req_perpanjangan')" class="fcc-pm-stat-card" style="{{ $status === 'req_perpanjangan' ? 'border-color:#FFC81A;background:#FFFDF5;' : '' }}">
            <div class="fcc-pm-stat-icon" style="background:#FFFDF5;border:1.5px solid #FFC81A;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                @include('components.icon',['name'=>'alert-circle','size'=>20])
            </div>
            <div>
                <p class="fcc-pm-stat-label">Req. Perpanjangan</p>
                <p class="fcc-pm-stat-val">{{ number_format($counts['req_perpanjangan']) }} <span>Permintaan</span></p>
            </div>
        </div>

        {{-- Card 3: Terverifikasi --}}
        <div wire:click="$set('status', 'terverifikasi')" class="fcc-pm-stat-card" style="{{ $status === 'terverifikasi' ? 'border-color:#10B981;background:#F0FDF4;' : '' }}">
            <div class="fcc-pm-stat-icon" style="background:#ECFDF5;border:1.5px solid #10B981;color:#10B981;box-shadow:0 4px 10px rgba(16,185,129,0.2);">
                @include('components.icon',['name'=>'check-circle','size'=>20])
            </div>
            <div>
                <p class="fcc-pm-stat-label">Terverifikasi</p>
                <p class="fcc-pm-stat-val">{{ number_format($counts['terverifikasi']) }} <span>Berhasil</span></p>
            </div>
        </div>

        {{-- Card 4: Total Transaksi --}}
        <div wire:click="$set('status', '')" class="fcc-pm-stat-card" style="{{ $status === '' ? 'border-color:#131218;' : '' }}">
            <div class="fcc-pm-stat-icon" style="background:#F1F5F9;border:1.5px solid #131218;color:#131218;">
                @include('components.icon',['name'=>'credit-card','size'=>20])
            </div>
            <div>
                <p class="fcc-pm-stat-label">Total Transaksi</p>
                <p class="fcc-pm-stat-val">{{ number_format($counts['total']) }} <span>Transaksi</span></p>
            </div>
        </div>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-pm-main-card">
        {{-- Filter Bar --}}
        <div class="fcc-pm-filter-bar">
            <div style="display:flex;align-items:center;justify-content:space-between;width:100%;max-width:100%;" class="fcc-pm-title-row-inner">
                <h3 class="fcc-pm-filter-title">Daftar Transaksi Pembayaran</h3>
                <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:3px 12px;border-radius:20px;border:1px solid #131218;white-space:nowrap;">
                    {{ $pembayaran->total() }} Data
                </span>
            </div>

            <div class="fcc-pm-filter-controls">
                {{-- Search Bar --}}
                <div class="fcc-pm-search-wrap">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748B;display:flex;pointer-events:none;">
                        @include('components.icon', ['name'=>'search', 'size'=>14])
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="q"
                           placeholder="Cari nama, email, kode..."
                           class="fcc-input" style="padding-left:34px;font-size:12.5px;height:36px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;width:100%;box-sizing:border-box;"
                           autocomplete="off">
                </div>

                {{-- Status & Jenis Select Row --}}
                <div class="fcc-pm-select-row" style="display:inline-flex;gap:8px;">
                    {{-- Status Select --}}
                    <select wire:model.live="status" class="fcc-input" style="font-size:12.5px;height:36px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;cursor:pointer;">
                        <option value="">Semua Status</option>
                        <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                        <option value="req_perpanjangan">Request Perpanjangan</option>
                        <option value="menunggu_pembayaran">Menunggu Bayar</option>
                        <option value="terverifikasi">Terverifikasi</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="kadaluarsa">Kadaluarsa</option>
                    </select>

                    {{-- Jenis Select --}}
                    <select wire:model.live="jenis" class="fcc-input" style="font-size:12.5px;height:36px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;cursor:pointer;">
                        <option value="">Semua Jenis</option>
                        <option value="pelatihan">Pelatihan</option>
                        <option value="sertifikasi">Sertifikasi</option>
                    </select>
                </div>

                @if($q || $status || $jenis)
                <button type="button" wire:click="resetFilters" class="fcc-pm-reset-btn" style="padding:6px 12px;font-size:12px;height:36px;cursor:pointer;display:inline-flex;align-items:center;gap:4px;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:10px;font-weight:800;transition:all .18s;" title="Reset Filter">
                    ✕ Reset
                </button>
                @endif
            </div>
        </div>

        {{-- ── TABULAR VIEW FOR DESKTOP & TABLET (>= 640px) ─────── --}}
        <div class="fcc-pm-table-wrap">
            <table class="fcc-pm-table">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;white-space:nowrap;">Kode Bayar</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;white-space:nowrap;">Peserta</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;min-width:220px;width:28%;white-space:nowrap;">Kegiatan</th>
                        <th style="padding:14px 16px;text-align:right;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;white-space:nowrap;">Jumlah Ditransfer</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;white-space:nowrap;">Status</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:110px;white-space:nowrap;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran as $p)
                    @php
                    $sc = match(true) {
                        $p->status_perpanjangan === 'menunggu' => ['#D97706', '#FEF3C7', '#FCD34D', 'Req. Perpanjangan'],
                        $p->status_pembayaran === 'terverifikasi' => ['#059669', '#ECFDF5', '#6EE7B7', 'Terverifikasi'],
                        $p->status_pembayaran === 'menunggu_verifikasi' => ['#D97706', '#FFFDF5', '#FFC81A', 'Menunggu Verifikasi'],
                        $p->status_pembayaran === 'ditolak' => ['#DC2626', '#FEF2F2', '#FCA5A5', 'Ditolak'],
                        $p->status_pembayaran === 'kadaluarsa' => ['#4B5563', '#F3F4F6', '#D1D5DB', 'Kadaluarsa'],
                        default => ['#2563EB', '#EFF6FF', '#93C5FD', 'Menunggu Bayar'],
                    };
                    $isPel = $p->pendaftaran?->kegiatan?->jenis_kegiatan === 'pelatihan';
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;cursor:pointer;transition:background .15s;"
                        onclick="window.location='{{ route('admin.pembayaran.show', $p) }}'"
                        onmouseover="this.style.background='#F8FAFC'"
                        onmouseout="this.style.background=''">
                        
                        {{-- Kode Pembayaran --}}
                        <td style="padding:14px 20px;vertical-align:middle;white-space:nowrap;">
                            <span style="font-size:12px;font-weight:900;color:#FFC81A;background:#131218;padding:4px 10px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;display:inline-block;">
                                {{ $p->kode_pembayaran }}
                            </span>
                        </td>

                        {{-- Peserta --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;white-space:nowrap;">
                                {{ $p->pendaftaran?->peserta?->nama ?? '-' }}
                            </p>
                            <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;">
                                {{ $p->pendaftaran?->peserta?->email ?? '-' }}
                            </p>
                        </td>

                        {{-- Kegiatan --}}
                        <td style="padding:14px 16px;vertical-align:middle;min-width:220px;">
                            <p style="margin:0 0 4px;font-size:13px;font-weight:800;color:#131218;overflow-wrap:break-word;word-break:normal;line-height:1.35;">
                                {{ Str::limit($p->pendaftaran?->kegiatan?->judul ?? '-', 45) }}
                            </p>
                            <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:{{ $isPel?'#FFFDF5':'#EFF6FF' }};color:{{ $isPel?'#B38F00':'#2563EB' }};border:1px solid {{ $isPel?'#FFC81A':'#93C5FD' }};display:inline-block;white-space:nowrap;">
                                {{ ucfirst($p->pendaftaran?->kegiatan?->jenis_kegiatan ?? 'Kegiatan') }}
                            </span>
                        </td>

                        {{-- Jumlah Bayar --}}
                        <td style="padding:14px 16px;text-align:right;vertical-align:middle;white-space:nowrap;">
                            <p style="margin:0 0 2px;font-size:14px;font-weight:900;color:#131218;font-family:monospace;">
                                {{ $p->nominal_transfer_format }}
                            </p>
                            @if($p->kode_unik)
                            <p style="margin:0;font-size:10.5px;color:#94A3B8;font-weight:600;">
                                (Pokok: {{ $p->jumlah_bayar_format }})
                            </p>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;white-space:nowrap;">
                            <span style="font-size:11px;font-weight:800;padding:3px 10px;border-radius:12px;background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[2] }};display:inline-block;white-space:nowrap;">
                                {{ $sc[3] }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;white-space:nowrap;">
                            <a href="{{ route('admin.pembayaran.show', $p) }}"
                               style="padding:6px 14px;font-size:12px;font-weight:800;background:#131218;color:#FFC81A;border-radius:8px;border:1px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:all .18s;"
                               onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';"
                               onclick="event.stopPropagation()">
                                Detail &rarr;
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:48px 20px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'credit-card','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Tidak Ada Data Pembayaran Ditemukan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Coba gunakan kata kunci pencarian lain atau ubah filter status.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── MOBILE CARD LIST VIEW (< 640px) ─────────────────── --}}
        <div class="fcc-pm-mobile-cards">
            @forelse($pembayaran as $p)
            @php
            $sc = match(true) {
                $p->status_perpanjangan === 'menunggu' => ['#D97706', '#FEF3C7', '#FCD34D', 'Req. Perpanjangan'],
                $p->status_pembayaran === 'terverifikasi' => ['#059669', '#ECFDF5', '#6EE7B7', 'Terverifikasi'],
                $p->status_pembayaran === 'menunggu_verifikasi' => ['#D97706', '#FFFDF5', '#FFC81A', 'Menunggu Verifikasi'],
                $p->status_pembayaran === 'ditolak' => ['#DC2626', '#FEF2F2', '#FCA5A5', 'Ditolak'],
                $p->status_pembayaran === 'kadaluarsa' => ['#4B5563', '#F3F4F6', '#D1D5DB', 'Kadaluarsa'],
                default => ['#2563EB', '#EFF6FF', '#93C5FD', 'Menunggu Bayar'],
            };
            $isPel = $p->pendaftaran?->kegiatan?->jenis_kegiatan === 'pelatihan';
            @endphp
            <div class="fcc-pm-mcard" onclick="window.location='{{ route('admin.pembayaran.show', $p) }}'">
                {{-- Header: Kode Bayar & Status Badge --}}
                <div class="fcc-pm-mcard-top">
                    <span style="font-size:11.5px;font-weight:900;color:#FFC81A;background:#131218;padding:3px 9px;border-radius:6px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;display:inline-block;">
                        {{ $p->kode_pembayaran }}
                    </span>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <span style="font-size:9.5px;font-weight:800;padding:2px 7px;border-radius:10px;background:{{ $isPel?'#FFFDF5':'#EFF6FF' }};color:{{ $isPel?'#B38F00':'#2563EB' }};border:1px solid {{ $isPel?'#FFC81A':'#93C5FD' }};">
                            {{ ucfirst($p->pendaftaran?->kegiatan?->jenis_kegiatan ?? 'Kegiatan') }}
                        </span>
                        <span style="font-size:10.5px;font-weight:800;padding:2px 8px;border-radius:10px;background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[2] }};">
                            {{ $sc[3] }}
                        </span>
                    </div>
                </div>

                {{-- Peserta --}}
                <div style="margin-bottom:8px;">
                    <p style="margin:0 0 2px;font-size:14px;font-weight:900;color:#131218;line-height:1.2;">
                        {{ $p->pendaftaran?->peserta?->nama ?? '-' }}
                    </p>
                    <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;display:flex;align-items:center;gap:4px;">
                        @include('components.icon',['name'=>'mail','size'=>11])
                        <span>{{ $p->pendaftaran?->peserta?->email ?? '-' }}</span>
                    </p>
                </div>

                {{-- Kegiatan --}}
                <div style="margin-bottom:8px;">
                    <p style="margin:0;font-size:12.5px;font-weight:700;color:#334155;line-height:1.35;">
                        {{ $p->pendaftaran?->kegiatan?->judul ?? '-' }}
                    </p>
                </div>

                {{-- Nominal Box --}}
                <div class="fcc-pm-mcard-amount-box">
                    <div>
                        <span style="font-size:10.5px;font-weight:700;color:#64748B;text-transform:uppercase;letter-spacing:0.4px;display:block;">
                            Total Ditransfer:
                        </span>
                        @if($p->kode_unik)
                        <span style="font-size:10px;color:#94A3B8;font-weight:600;">
                            (Pokok: {{ $p->jumlah_bayar_format }})
                        </span>
                        @endif
                    </div>
                    <span style="font-size:14.5px;font-weight:900;color:#131218;font-family:monospace;">
                        {{ $p->nominal_transfer_format }}
                    </span>
                </div>

                {{-- Card Action Button --}}
                <div style="margin-top:10px;">
                    <a href="{{ route('admin.pembayaran.show', $p) }}"
                       style="display:flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:8px 12px;font-size:12.5px;font-weight:800;background:#131218;color:#FFC81A;border-radius:10px;text-decoration:none;border:1px solid #131218;box-sizing:border-box;transition:all .18s;"
                       onclick="event.stopPropagation()">
                        Detail Pembayaran &rarr;
                    </a>
                </div>
            </div>
            @empty
            <div style="padding:36px 16px;text-align:center;color:#94A3B8;background:#FFF;border-radius:14px;border:1px dashed #CBD5E1;">
                <div style="width:44px;height:44px;border-radius:12px;background:#F1F5F9;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    @include('components.icon',['name'=>'credit-card','size'=>20,'style'=>'color:#9CA3B0'])
                </div>
                <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 4px;">Tidak Ada Data Ditemukan</p>
                <p style="font-size:12px;color:#64748B;margin:0;">Coba gunakan kata kunci pencarian atau ubah filter.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination Footer --}}
        <div class="fcc-pm-pagination">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <select wire:model.live="perPage" class="fcc-input" style="width:auto;font-size:12.5px;height:34px;padding:0 10px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;font-weight:700;cursor:pointer;color:#131218;outline:none;" title="Jumlah data per halaman">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 / hal</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 / hal</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 / hal</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 / hal</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 / hal</option>
                </select>
                <span style="font-size:12px;color:#64748B;font-weight:600;">
                    Menampilkan {{ $pembayaran->firstItem() ?? 0 }}–{{ $pembayaran->lastItem() ?? 0 }} dari {{ $pembayaran->total() }} data
                </span>
            </div>
            <div>
                {{ $pembayaran->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>
</div>
