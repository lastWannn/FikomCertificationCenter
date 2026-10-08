<div wire:poll.15s>
  <style>
    /* ── Base Responsive Views ── */
    .fcc-peserta-desktop-table {
      display: block;
    }
    .fcc-peserta-mobile-list {
      display: none;
    }
    .fcc-peserta-stats-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    /* ── Tablet Breakpoints (768px – 1023px) ── */
    @media (max-width: 1023px) {
      .fcc-peserta-stats-grid {
        gap: 12px !important;
        margin-bottom: 20px !important;
      }
    }

    /* ── Mobile & Phablet Breakpoints (< 768px) ── */
    @media (max-width: 767px) {
      .fcc-peserta-desktop-table {
        display: none !important;
      }
      .fcc-peserta-mobile-list {
        display: flex !important;
        flex-direction: column !important;
        gap: 12px !important;
        padding: 14px !important;
      }
      .fcc-peserta-stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 12px !important;
        margin-bottom: 18px !important;
      }
      .fcc-peserta-stats-grid > div:last-child {
        grid-column: span 2 !important;
      }
    }

    /* ── Mobile Standard (< 640px) ── */
    @media (max-width: 639px) {
      .fcc-peserta-filter-header {
        padding: 14px 16px !important;
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 12px !important;
      }
      .fcc-peserta-filter-title-row {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        width: 100% !important;
      }
      .fcc-peserta-filter-controls {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        gap: 10px !important;
      }
      .fcc-peserta-search-box {
        width: 100% !important;
      }
      .fcc-peserta-filter-actions-row {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        width: 100% !important;
        flex-wrap: wrap !important;
      }
      .fcc-peserta-filter-actions-row select {
        flex: 1 !important;
        min-width: 130px !important;
      }
      .fcc-peserta-filter-actions-row a,
      .fcc-peserta-filter-actions-row button {
        flex: 1 !important;
        justify-content: center !important;
        text-align: center !important;
      }
      .fcc-peserta-pagination-bar {
        flex-direction: column !important;
        align-items: center !important;
        gap: 12px !important;
        padding: 14px 16px !important;
      }
      .fcc-peserta-pagination-info {
        width: 100% !important;
        justify-content: space-between !important;
      }
    }

    /* ── Compact Mobile (< 420px) ── */
    @media (max-width: 419px) {
      .fcc-peserta-stats-grid {
        grid-template-columns: 1fr !important;
        gap: 10px !important;
      }
      .fcc-peserta-stats-grid > div:last-child {
        grid-column: auto !important;
      }
      .fcc-peserta-mobile-list {
        padding: 10px !important;
        gap: 10px !important;
      }
      .fcc-peserta-mobile-actions {
        flex-direction: column !important;
        gap: 8px !important;
      }
      .fcc-peserta-mobile-actions button {
        width: 100% !important;
        justify-content: center !important;
      }
    }
  </style>

  {{-- Flash Message Notification --}}
  @if($message)
  @php $isSuccess = $messageType === 'success'; @endphp
  <div style="padding: 12px 18px; border-radius: 12px; background: {{ $isSuccess ? 'rgba(16, 185, 129, 0.12)' : 'rgba(239, 68, 68, 0.12)' }}; border: 1.5px solid {{ $isSuccess ? 'rgba(16, 185, 129, 0.3)' : 'rgba(239, 68, 68, 0.3)' }}; color: {{ $isSuccess ? '#059669' : '#DC2626' }}; font-weight: 800; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
    <span>{{ $message }}</span>
    <button type="button" wire:click="$set('message', null)" style="background: none; border: none; color: {{ $isSuccess ? '#059669' : '#DC2626' }}; cursor: pointer; font-size: 18px; font-weight: 900;">&times;</button>
  </div>
  @endif

  {{-- Summary Stats Cards (Neo-Brutalist) --}}
  <div class="fcc-peserta-stats-grid">
    {{-- Card 1: Total Peserta --}}
    <div wire:click="$set('status', '')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:44px;height:44px;border-radius:12px;background:#F1F5F9;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;">
        @include('components.icon',['name'=>'users','size'=>20])
      </div>
      <div>
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Peserta</p>
        <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($stats['total']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Orang</span></p>
      </div>
    </div>

    {{-- Card 2: Terverifikasi --}}
    <div wire:click="$set('status', 'aktif')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;box-shadow:0 4px 10px rgba(16,185,129,0.2);flex-shrink:0;">
        @include('components.icon',['name'=>'check-circle','size'=>20])
      </div>
      <div>
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Terverifikasi</p>
        <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($stats['terverifikasi']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Akun</span></p>
      </div>
    </div>

    {{-- Card 3: Belum Verifikasi --}}
    <div wire:click="$set('status', '')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:44px;height:44px;border-radius:12px;background:#FEF3C7;border:1.5px solid #F59E0B;display:flex;align-items:center;justify-content:center;color:#D97706;box-shadow:0 4px 10px rgba(245,158,11,0.25);flex-shrink:0;">
        @include('components.icon',['name'=>'x-circle','size'=>20])
      </div>
      <div>
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Belum Verifikasi OTP</p>
        <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($stats['belum_verifikasi']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Akun</span></p>
      </div>
    </div>
  </div>

  {{-- Main Neo-Brutalist Table Card --}}
  <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
    {{-- Filter Header --}}
    <div class="fcc-peserta-filter-header" style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
      <div class="fcc-peserta-filter-title-row" style="display:flex;align-items:center;gap:10px;">
        <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Akun Peserta</h3>
        <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;white-space:nowrap;">
          {{ $peserta->total() }} Data
        </span>
      </div>
      
      <div class="fcc-peserta-filter-controls" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        {{-- Search Input --}}
        <div class="fcc-peserta-search-box" style="position:relative;width:240px;">
          <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748B;display:flex;pointer-events:none;">
            @include('components.icon', ['name'=>'search', 'size'=>14])
          </span>
          <input type="text" wire:model.live.debounce.300ms="search"
                 placeholder="Cari nama, email, HP, instansi..."
                 class="fcc-input" style="width:100%;box-sizing:border-box;padding-left:34px;font-size:12.5px;height:38px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;outline:none;"
                 autocomplete="off">
        </div>

        <div class="fcc-peserta-filter-actions-row" style="display:flex;align-items:center;gap:8px;">
          {{-- Status Select --}}
          <select wire:model.live="status" class="fcc-input" style="font-size:12.5px;height:38px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;cursor:pointer;outline:none;">
            <option value="">Semua Status Akun</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
          </select>

          @if($search || $status || $perPage != 15)
          <button type="button" wire:click="$set('search', ''); $set('status', ''); $set('perPage', 15)" style="padding:6px 12px;font-size:12px;height:38px;cursor:pointer;display:inline-flex;align-items:center;gap:4px;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:10px;font-weight:800;transition:all .18s;white-space:nowrap;" title="Reset Filter">
            ✕ Reset
          </button>
          @endif

          {{-- Export Button --}}
          <a href="{{ route('admin.export.peserta') }}" style="padding:6px 14px;font-size:12px;height:38px;box-sizing:border-box;font-weight:800;background:#FFFFFF;color:#131218;border-radius:10px;border:1.5px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .18s;white-space:nowrap;" onmouseover="this.style.background='#131218';this.style.color='#FFC81A';" onmouseout="this.style.background='#FFFFFF';this.style.color='#131218';">
            @include('components.icon',['name'=>'download','size'=>14]) Export CSV
          </a>
        </div>
      </div>
    </div>

    {{-- Desktop Table View (>= 768px) --}}
    <div class="fcc-peserta-desktop-table" style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr style="background:#131218;color:#FFFFFF;">
            <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Peserta &amp; Instansi</th>
            <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">No. WhatsApp</th>
            <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;">Status</th>
            <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:110px;">Kegiatan</th>
            <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;">Terdaftar</th>
            <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:220px;">Aksi Akun</th>
          </tr>
        </thead>
        <tbody>
          @forelse($peserta as $p)
          @php 
            if (is_null($p->email_verified_at)) {
              $sc = ['#D97706', '#FEF3C7', '#FCD34D', 'Belum Verifikasi (OTP)'];
            } else if (($p->status_akun ?? 'aktif') === 'aktif') {
              $sc = ['#059669', '#ECFDF5', '#A7F3D0', 'Aktif'];
            } else {
              $sc = ['#DC2626', '#FEF2F2', '#FCA5A5', 'Nonaktif'];
            }
          @endphp
          <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
            
            {{-- Peserta & Instansi --}}
            <td style="padding:14px 20px;vertical-align:middle;">
              <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#131218;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                  @include('components.icon',['name'=>'user','size'=>18,'style'=>'color:#FFC81A'])
                </div>
                <div style="min-width:0;">
                  <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:240px;">{{ $p->nama }}</p>
                  <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;">{{ $p->email }} &bull; <span style="color:#131218;font-weight:700;">{{ $p->instansi ?? 'Umum' }}</span></p>
                </div>
              </div>
            </td>

            {{-- No WhatsApp --}}
            <td style="padding:14px 16px;vertical-align:middle;">
              <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $p->no_hp)) }}" target="_blank" style="color:#059669;text-decoration:none;display:inline-flex;align-items:center;gap:5px;font-weight:800;font-size:13px;background:#ECFDF5;padding:4px 10px;border-radius:8px;border:1px solid #A7F3D0;" title="Hubungi via WhatsApp">
                @include('components.icon',['name'=>'phone','size'=>13]) {{ $p->no_hp }}
              </a>
            </td>

            {{-- Status --}}
            <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
              <span style="font-size:11px;font-weight:800;padding:3px 10px;border-radius:12px;background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[2] }};display:inline-block;white-space:nowrap;">
                {{ $sc[3] }}
              </span>
            </td>

            {{-- Kegiatan Count --}}
            <td style="padding:14px 16px;text-align:center;vertical-align:middle;font-size:14px;font-weight:900;color:#131218;">
              <span style="background:#F1F5F9;padding:4px 10px;border-radius:8px;border:1px solid #CBD5E1;display:inline-block;">
                {{ $p->pendaftaran_count }}
              </span>
            </td>

            {{-- Terdaftar Date --}}
            <td style="padding:14px 16px;vertical-align:middle;font-size:12.5px;color:#64748B;font-weight:700;white-space:nowrap;">
              📅 {{ $p->created_at->format('d M Y') }}
            </td>

            {{-- Aksi Akun --}}
            <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
              <div style="display:flex;gap:6px;justify-content:center;align-items:center;">
                
                {{-- Detail Modal Button --}}
                <button type="button" onclick="loadPesertaDetail('{{ route('admin.pengguna.peserta.detail', $p) }}')" style="background:#FFFFFF;border:1.5px solid #131218;border-radius:8px;padding:6px 9px;cursor:pointer;color:#131218;display:inline-flex;align-items:center;transition:all .18s;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';" title="Lihat Detail Peserta">
                  @include('components.icon',['name'=>'eye','size'=>15])
                </button>

                {{-- Instant Livewire Status Toggle Buttons --}}
                @if($p->status_akun !== 'aktif')
                <button type="button" wire:click="toggleStatus({{ $p->id }}, 'aktif')" style="background:#ECFDF5;border:1px solid #A7F3D0;color:#059669;padding:6px 12px;border-radius:8px;font-size:11.5px;font-weight:800;cursor:pointer;transition:all .18s;white-space:nowrap;" title="Aktifkan Akun">
                  Aktifkan
                </button>
                @else
                <button type="button" wire:click="toggleStatus({{ $p->id }}, 'nonaktif')" style="background:#FEF3C7;border:1px solid #FCD34D;color:#D97706;padding:6px 12px;border-radius:8px;font-size:11.5px;font-weight:800;cursor:pointer;transition:all .18s;white-space:nowrap;" title="Nonaktifkan Akun">
                  Nonaktif
                </button>
                @endif

                {{-- Hapus Akun Button --}}
                <button type="button" onclick="fccConfirm({
                    title: 'Hapus Akun Peserta',
                    msg: 'Apakah Anda yakin ingin menghapus akun peserta \'{{ addslashes($p->nama) }}\'?',
                    danger: true,
                    btnText: 'Ya, Hapus Akun',
                    onConfirm: function() { @this.deletePeserta({{ $p->id }}); }
                })" style="background:#FEF2F2;border:1px solid #FCA5A5;color:#DC2626;padding:6px 10px;border-radius:8px;font-size:11.5px;font-weight:800;cursor:pointer;transition:all .18s;white-space:nowrap;" title="Hapus Akun Peserta">
                  Hapus
                </button>

              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="padding:48px 20px;text-align:center;color:#94A3B8;">
              <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                @include('components.icon',['name'=>'users','size'=>24,'style'=>'color:#9CA3B0'])
              </div>
              <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Tidak Ada Peserta Ditemukan</p>
              <p style="font-size:12.5px;color:#64748B;margin:0;">Tidak ada data peserta yang cocok dengan kriteria pencarian.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Mobile Cards List View (< 768px) --}}
    <div class="fcc-peserta-mobile-list">
      @forelse($peserta as $p)
      @php 
        if (is_null($p->email_verified_at)) {
          $sc = ['#D97706', '#FEF3C7', '#FCD34D', 'Belum OTP'];
        } else if (($p->status_akun ?? 'aktif') === 'aktif') {
          $sc = ['#059669', '#ECFDF5', '#A7F3D0', 'Aktif'];
        } else {
          $sc = ['#DC2626', '#FEF2F2', '#FCA5A5', 'Nonaktif'];
        }
      @endphp
      <div class="fcc-peserta-card-item" style="background:#FFFFFF;border:1.5px solid #E2E8F0;border-radius:16px;padding:16px;box-shadow:0 2px 8px rgba(0,0,0,0.03);display:flex;flex-direction:column;gap:12px;">
        {{-- Top Row: Avatar, Name, Email, and Status Badge --}}
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;">
          <div style="display:flex;align-items:center;gap:10px;min-width:0;flex:1;">
            <div style="width:40px;height:40px;border-radius:10px;background:#131218;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#FFC81A;font-weight:900;font-size:15px;flex-shrink:0;">
              {{ strtoupper(substr($p->nama ?? 'P', 0, 1)) }}
            </div>
            <div style="min-width:0;flex:1;">
              <h4 style="margin:0 0 2px;font-size:14.5px;font-weight:900;color:#131218;line-height:1.3;word-break:break-word;">
                {{ $p->nama }}
              </h4>
              <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;word-break:break-all;">
                {{ $p->email }}
              </p>
            </div>
          </div>
          <span style="font-size:10.5px;font-weight:800;padding:3px 9px;border-radius:10px;background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[2] }};white-space:nowrap;flex-shrink:0;">
            {{ $sc[3] }}
          </span>
        </div>

        {{-- Details Section: Instansi, WhatsApp & Activities --}}
        <div style="display:flex;flex-direction:column;gap:8px;padding:10px 12px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;">
          <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px;font-size:11.5px;">
            <span style="color:#64748B;font-weight:600;">
              🏛️ <strong style="color:#131218;">{{ $p->instansi ?? 'Umum' }}</strong>
            </span>
            <span style="color:#64748B;font-weight:600;">
              📅 {{ $p->created_at->format('d M Y') }}
            </span>
          </div>

          <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;padding-top:6px;border-top:1px dashed #CBD5E1;">
            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $p->no_hp)) }}" target="_blank"
               style="color:#059669;text-decoration:none;display:inline-flex;align-items:center;gap:5px;font-weight:800;font-size:12px;background:#ECFDF5;padding:4px 10px;border-radius:8px;border:1px solid #A7F3D0;" title="Hubungi via WhatsApp">
              @include('components.icon',['name'=>'phone','size'=>13]) {{ $p->no_hp }}
            </a>

            <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFFFFF;border:1px solid #CBD5E1;padding:3px 10px;border-radius:8px;display:inline-flex;align-items:center;gap:4px;">
              🎯 {{ $p->pendaftaran_count }} Kegiatan
            </span>
          </div>
        </div>

        {{-- Actions Row --}}
        <div class="fcc-peserta-mobile-actions" style="display:flex;gap:8px;padding-top:4px;border-top:1px dashed #E2E8F0;">
          {{-- Detail Button --}}
          <button type="button" onclick="loadPesertaDetail('{{ route('admin.pengguna.peserta.detail', $p) }}')"
                  style="flex:1;padding:9px 12px;border-radius:10px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;font-size:12px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:5px;transition:all .18s;"
                  onmouseover="this.style.background='#FFC81A';"
                  onmouseout="this.style.background='#FFFFFF';">
            @include('components.icon',['name'=>'eye','size'=>14]) Detail
          </button>

          {{-- Toggle Status --}}
          @if($p->status_akun !== 'aktif')
          <button type="button" wire:click="toggleStatus({{ $p->id }}, 'aktif')"
                  style="flex:1;padding:9px 12px;border-radius:10px;border:1.5px solid #10B981;background:#ECFDF5;color:#059669;font-size:12px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:4px;transition:all .18s;">
            Aktifkan
          </button>
          @else
          <button type="button" wire:click="toggleStatus({{ $p->id }}, 'nonaktif')"
                  style="flex:1;padding:9px 12px;border-radius:10px;border:1.5px solid #F59E0B;background:#FEF3C7;color:#D97706;font-size:12px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:4px;transition:all .18s;">
            Nonaktif
          </button>
          @endif

          {{-- Hapus Button --}}
          <button type="button" onclick="fccConfirm({
              title: 'Hapus Akun Peserta',
              msg: 'Apakah Anda yakin ingin menghapus akun peserta \'{{ addslashes($p->nama) }}\'?',
              danger: true,
              btnText: 'Ya, Hapus Akun',
              onConfirm: function() { @this.deletePeserta({{ $p->id }}); }
          })" style="padding:9px 12px;border-radius:10px;border:1.5px solid #FCA5A5;background:#FEF2F2;color:#DC2626;font-size:12px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:4px;transition:all .18s;">
            @include('components.icon',['name'=>'trash','size'=>14]) Hapus
          </button>
        </div>
      </div>
      @empty
      <div style="padding:36px 16px;text-align:center;color:#94A3B8;background:#FFFFFF;border-radius:16px;">
        <div style="width:48px;height:48px;border-radius:14px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
          @include('components.icon',['name'=>'users','size'=>22,'style'=>'color:#9CA3B0'])
        </div>
        <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 4px;">Tidak Ada Peserta</p>
        <p style="font-size:12px;color:#64748B;margin:0;">Tidak ada data peserta yang cocok dengan kriteria filter.</p>
      </div>
      @endforelse
    </div>

    {{-- Responsive Pagination Bar --}}
    <div class="fcc-peserta-pagination-bar" style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
      <div class="fcc-peserta-pagination-info" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <select wire:model.live="perPage" class="fcc-input" style="width:auto;font-size:12.5px;height:34px;padding:0 10px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;font-weight:700;cursor:pointer;color:#131218;outline:none;" title="Jumlah data per halaman">
          <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 / hal</option>
          <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 / hal</option>
          <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 / hal</option>
          <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 / hal</option>
          <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 / hal</option>
        </select>
        <span style="font-size:12px;color:#64748B;font-weight:600;">
          Menampilkan {{ $peserta->firstItem() ?? 0 }}–{{ $peserta->lastItem() ?? 0 }} dari {{ $peserta->total() }} data
        </span>
      </div>
      <div>
        {{ $peserta->links('vendor.pagination.default') }}
      </div>
    </div>
  </div>
</div>
