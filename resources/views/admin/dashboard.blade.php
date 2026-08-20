@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')

@push('styles')
<style>
  .calendar-day-cell { position: relative; }
  .calendar-day-cell[data-tooltip]:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(-6px);
    background: #131218;
    color: #FFC81A;
    font-size: 11px;
    font-weight: 800;
    padding: 6px 12px;
    border-radius: 8px;
    border: 1.5px solid #FFC81A;
    white-space: nowrap;
    pointer-events: none;
    z-index: 100;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
  }
</style>
@endpush

@section('page-content')
<div style="padding:24px 28px;background:#F6F8FB;min-height:100vh;font-family:'Inter',sans-serif;">



  {{-- Stat Cards Grid (4 Columns Aligned with Home Page Aesthetics) --}}
  <div id="stats-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:24px;">
    @foreach([
      ['Total Pelatihan',   $stats['pelatihan'],   'Program aktif',     'book-open',   '#FFC81A', '#131218', 'rgba(255,200,26,0.3)', route('admin.pelatihan.index')],
      ['Total Sertifikasi', $stats['sertifikasi'], 'Sertifikasi resmi', 'award',       '#131218', '#FFC81A', 'rgba(19,18,24,0.25)',   route('admin.sertifikasi.index')],
      ['Total Peserta',     number_format($stats['peserta']), 'Siswa/i terdaftar', 'users', '#FFC81A', '#131218', 'rgba(255,200,26,0.3)', route('admin.pengguna.peserta')],
      ['Total Pendapatan',  'Rp '.number_format($stats['pendapatan'],0,',','.'), 'Terverifikasi', 'credit-card', '#131218', '#FFC81A', 'rgba(19,18,24,0.25)', route('admin.laporan.index')],
    ] as [$lbl,$val,$suf,$ic,$bg,$fg,$glow,$link])
    <a href="{{ $link }}" style="text-decoration:none;display:flex;flex-direction:column;" class="taskora-stat-link">
      <div class="fcc-card" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);display:flex;align-items:center;gap:16px;transition:all .28s ease;"
           onmouseover="this.style.transform='translateY(-4px)';this.style.borderColor='#FFC81A';this.style.boxShadow='0 14px 28px rgba(255,200,26,0.2)';"
           onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#E5E7EB';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">
        <div style="width:52px;height:52px;border-radius:14px;background:{{ $bg }};border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 16px {{ $glow }};">
          @include('components.icon',['name'=>$ic,'size'=>22,'style'=>"color:{$fg}"])
        </div>
        <div style="flex:1;min-width:0;">
          <p style="margin:0 0 2px;color:#64748B;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:0.5px;">{{ $lbl }}</p>
          <p style="margin:0;color:#131218;font-size:24px;font-weight:900;letter-spacing:-0.02em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $val }}</p>
          <p id="stat-delta-{{ $loop->index }}" style="margin:2px 0 0;font-size:11px;color:#131218;font-weight:700;">{{ $suf }}</p>
        </div>
      </div>
    </a>
    @endforeach
  </div>

  {{-- 2 Columns Grid (Main Area + Side Widgets Area) --}}
  <div style="display:grid;grid-template-columns:1fr 330px;gap:24px;align-items:start;">

    {{-- MAIN LEFT AREA (~70%) --}}
    <div style="display:flex;flex-direction:column;gap:24px;min-width:0;">

      {{-- Pending Payment Banner --}}
      @php $pendingBayar = \App\Models\Pembayaran::where('status_pembayaran','menunggu_verifikasi')->count(); @endphp
      @if($pendingBayar > 0)
      <div class="fcc-card" style="background:#FFFDF5;border:2px solid #FFC81A;border-radius:18px;padding:18px 24px;display:flex;align-items:center;gap:16px;box-shadow:0 6px 18px rgba(255,200,26,0.15);">
        <div style="width:46px;height:46px;border-radius:14px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(255,200,26,0.3);">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <div style="flex:1;">
          <p style="margin:0;font-weight:900;color:#131218;font-size:14.5px;">{{ $pendingBayar }} Pembayaran Menunggu Verifikasi</p>
          <p style="margin:2px 0 0;font-size:12px;color:#4B5563;font-weight:500;">Ada transaksi peserta yang memerlukan tindakan verifikasi segera.</p>
        </div>
        <a href="{{ route('admin.pembayaran.index',['status'=>'menunggu_verifikasi']) }}" style="padding:9px 20px;font-size:12.5px;font-weight:800;text-decoration:none;flex-shrink:0;background:#131218;color:#FFC81A;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.15);transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Verifikasi Sekarang</a>
      </div>
      @endif

      {{-- Expired Activities Banner --}}
      @php
        $passedKegiatans = \App\Models\Kegiatan::passed()->doesntHave('arsip')->with(['kegiatanPelatihan.jadwalPelatihan.pelatihan', 'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi'])->get();
      @endphp
      @if($passedKegiatans->count() > 0)
      <div class="fcc-card" style="background:#FFFFFF;border:2px solid #E5E7EB;border-radius:18px;padding:18px 22px;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px;flex-wrap:wrap;">
          <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:38px;height:38px;border-radius:12px;background:#FEE2E2;border:1px solid #EF4444;display:flex;align-items:center;justify-content:center;color:#EF4444;font-weight:800;font-size:16px;flex-shrink:0;">
              ⚠
            </div>
            <div>
              <h4 style="margin:0;font-weight:900;color:#131218;font-size:14px;">{{ $passedKegiatans->count() }} Kegiatan Melewati Tanggal Pelaksanaan</h4>
              <p style="margin:2px 0 0;font-size:12px;color:#64748B;">Perpanjang jadwal kegiatan atau pindahkan ke arsip.</p>
            </div>
          </div>
          <a href="{{ route('admin.kegiatan.index') }}" style="padding:7px 16px;font-size:12px;text-decoration:none;flex-shrink:0;background:#131218;color:#FFC81A;border-radius:20px;border:1.5px solid #131218;font-weight:800;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
            Kelola Kegiatan &rarr;
          </a>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:10px;">
          @foreach($passedKegiatans->take(4) as $pk)
          @php
            $detail = $pk->detail;
            $editUrl = $pk->jenis_kegiatan === 'pelatihan' ? ($detail ? route('admin.pelatihan.edit', $detail) : '#') : ($detail ? route('admin.sertifikasi.edit', $detail) : '#');
          @endphp
          <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:8px 12px;font-size:12px;display:flex;align-items:center;gap:10px;">
            <span style="font-weight:700;color:#0F172A;">{{ $pk->judul }}</span>
            <span style="color:#64748B;font-size:11px;">(Lewat {{ $pk->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Tgl' }})</span>
            <div style="display:flex;gap:6px;">
              <a href="{{ $editUrl }}" style="color:#131218;font-size:11px;font-weight:800;text-decoration:none;background:#FFC81A;padding:3px 9px;border-radius:6px;border:1px solid #131218;">Perpanjang</a>
              <form action="{{ route('admin.kegiatan.arsipkan', $pk) }}" method="POST" style="margin:0;display:inline;">
                @csrf
                <button type="button" onclick="fccConfirmAction(this, 'Tandai Selesai & Arsipkan', 'Apakah Anda yakin ingin menandai kegiatan {{ addslashes($pk->judul) }} selesai dan memindahkannya ke Arsip Kegiatan?', 'Ya, Arsipkan', false)" style="color:#FFFFFF;font-size:11px;font-weight:800;background:#131218;padding:3px 9px;border-radius:6px;border:none;cursor:pointer;">Arsipkan</button>
              </form>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      {{-- Combined Combo Chart: Pendapatan & Pendaftaran --}}
      <div class="fcc-card" style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:12px;">
          <div>
            <h3 style="margin:0 0 2px;font-size:16px;font-weight:900;color:#131218;">Grafik Tren Pendapatan &amp; Pendaftaran</h3>
            <p style="margin:0;font-size:12px;color:#64748B;">Perbandingan pendapatan (Rp) dan jumlah pendaftaran per bulan tahun <span id="chart-year-label">{{ date('Y') }}</span></p>
          </div>
          <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:14px;font-size:12px;font-weight:800;">
              <span style="display:inline-flex;align-items:center;gap:6px;color:#131218;">
                <span style="width:12px;height:12px;border-radius:3px;background:#FFC81A;border:1px solid #131218;"></span> Pendapatan (Rp)
              </span>
              <span style="display:inline-flex;align-items:center;gap:6px;color:#3B82F6;">
                <span style="width:12px;height:12px;border-radius:3px;background:#3B82F6;"></span> Pendaftaran
              </span>
            </div>
            <select id="chart-metric" class="fcc-input" style="width:auto;font-size:12px;font-weight:800;padding:6px 14px;border-radius:10px;border:1.5px solid #E5E7EB;background:#F8FAFC;">
              <option value="semua" selected>Semua</option>
              <option value="pendapatan">Pendapatan</option>
              <option value="pendaftaran">Pendaftaran</option>
            </select>
            <select id="chart-year" class="fcc-input" style="width:auto;font-size:12px;font-weight:800;padding:6px 14px;border-radius:10px;border:1.5px solid #E5E7EB;background:#F8FAFC;">
              @foreach(range(date('Y'),date('Y')-3) as $y)
              <option value="{{ $y }}" {{ date('Y')==$y?'selected':'' }}>Tahun {{ $y }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div style="position:relative;height:260px;">
          <canvas id="chartPendapatanPendaftaran"></canvas>
        </div>
      </div>

      {{-- Widget 3: Tabel Kegiatan Aktif Terbaru --}}
      <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;display:flex;justify-content:space-between;align-items:center;background:#F8FAFC;">
          <div>
            <h3 style="margin:0 0 2px;font-size:16px;font-weight:900;color:#131218;">Kegiatan Aktif Terbaru</h3>
            <p style="margin:0;font-size:12px;color:#64748B;">Program yang sedang berjalan dan membuka pendaftaran</p>
          </div>
          <a href="{{ route('admin.kegiatan.index') }}" style="font-size:12px;font-weight:800;color:#131218;text-decoration:none;background:#FFC81A;padding:6px 14px;border-radius:20px;border:1px solid #131218;transition:all .18s;" onmouseover="this.style.background='#131218';this.style.color='#FFC81A';" onmouseout="this.style.background='#FFC81A';this.style.color='#131218';">Lihat semua &rarr;</a>
        </div>
        <table style="width:100%;border-collapse:collapse;">
          <thead>
            <tr style="background:#F8FAFC;border-bottom:1.5px solid #E5E7EB;">
              @foreach(['Kegiatan','Peserta','Tgl Pelaksanaan','Aksi'] as $h)
              <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">{{ $h }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @forelse($kegiatanTerbaru as $k)
            <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#FAFAFA'" onmouseout="this.style.background=''">
              <td style="padding:14px 18px;">
                <p style="margin:0 0 4px;font-size:13.5px;font-weight:800;color:#131218;max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $k->judul }}</p>
                <span style="font-size:10px;font-weight:900;padding:3px 9px;border-radius:6px;text-transform:uppercase;letter-spacing:0.5px;background:{{ $k->jenis_kegiatan==='pelatihan'?'#FFC81A':'#131218' }};color:{{ $k->jenis_kegiatan==='pelatihan'?'#131218':'#FFC81A' }};border:1px solid #131218;">{{ ucfirst($k->jenis_kegiatan) }}</span>
              </td>
              <td style="padding:14px 18px;">
                <p style="margin:0 0 4px;font-size:13px;font-weight:800;color:#131218;">{{ $k->terisi }}/{{ $k->kuota }}</p>
                <div style="width:90px;height:5px;background:#E5E7EB;border-radius:3px;overflow:hidden;">
                  <div style="height:5px;border-radius:3px;background:{{ $k->isFull()?'#EF4444':'#FFC81A' }};width:{{ $k->kuota>0?min(100,round($k->terisi/$k->kuota*100)):0 }}%;"></div>
                </div>
              </td>
              <td style="padding:14px 18px;font-size:12.5px;color:#4B5563;font-weight:600;">{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? '—' }}</td>
              <td style="padding:14px 18px;">
                <a href="{{ route('admin.kegiatan.show', $k) }}" style="color:#FFC81A;font-size:12px;font-weight:800;text-decoration:none;background:#131218;padding:6px 14px;border-radius:20px;border:1px solid #131218;transition:all .15s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Detail &rarr;</a>
              </td>
            </tr>
            @empty
            <tr><td colspan="4" style="padding:28px;text-align:center;color:#94A3B8;font-size:13px;">Belum ada kegiatan aktif.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>

    {{-- RIGHT SIDE WIDGETS AREA (~30%) --}}
    <div style="display:flex;flex-direction:column;gap:24px;">

      {{-- Mini Calendar Widget (AJAX Enabled) --}}
      <div id="mini-calendar-widget" class="fcc-card" style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);transition:opacity .2s;">
        {{-- Calendar grid --}}
        @php
          $currentCalDate = $calendarDate ?? now();
          $today = now();
          $startOfMonth = $currentCalDate->copy()->startOfMonth();
          $daysInMonth = $currentCalDate->daysInMonth;
          $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)
          $kegiatanMap = $tanggalKegiatanMap ?? [];
          $isCurrentRealMonth = $currentCalDate->format('Y-m') === $today->format('Y-m');
        @endphp

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
          <button type="button" id="cal-prev-btn" onclick="loadCalendarMonth('{{ $prevMonth }}')" title="Bulan Sebelumnya" style="width:30px;height:30px;border-radius:8px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;font-weight:900;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
            &larr;
          </button>

          <div style="text-align:center;">
            <h3 id="cal-month-label" style="margin:0;font-size:15px;font-weight:900;color:#131218;">
              {{ $currentCalDate->translatedFormat('F Y') }}
            </h3>
            <button type="button" id="cal-reset-btn" onclick="loadCalendarMonth('{{ now()->format('Y-m') }}')" style="display:{{ $isCurrentRealMonth ? 'none' : 'inline-block' }};font-size:10px;font-weight:800;color:#3B82F6;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;">Ke Bulan Ini</button>
          </div>

          <button type="button" id="cal-next-btn" onclick="loadCalendarMonth('{{ $nextMonth }}')" title="Bulan Berikutnya" style="width:30px;height:30px;border-radius:8px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;font-weight:900;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
            &rarr;
          </button>
        </div>

        <div style="display:grid;grid-template-columns:repeat(7, 1fr);gap:4px;text-align:center;font-size:11px;font-weight:800;color:#94A3B8;margin-bottom:8px;">
          <span>Mg</span><span>Sn</span><span>Sl</span><span>Rb</span><span>Km</span><span>Jm</span><span>St</span>
        </div>
        <div id="cal-days-grid" style="display:grid;grid-template-columns:repeat(7, 1fr);gap:4px;text-align:center;">
          @for($i = 0; $i < $startDayOfWeek; $i++)
            <div style="padding:6px;font-size:12px;color:#CBD5E1;"></div>
          @endfor
          @for($day = 1; $day <= $daysInMonth; $day++)
            @php 
              $isToday = ($isCurrentRealMonth && $day == $today->day);
              $hasActivity = isset($kegiatanMap[$day]) && count($kegiatanMap[$day]) > 0;
              $activityTitles = $hasActivity ? implode(', ', $kegiatanMap[$day]) : '';
            @endphp
            <div class="calendar-day-cell"
                 title="{{ $hasActivity ? $activityTitles : ($isToday ? 'Hari ini' : '') }}"
                 @if($hasActivity) data-tooltip="{{ $activityTitles }}" @endif
                 style="position:relative;padding:7px 0;font-size:12px;font-weight:{{ ($isToday || $hasActivity) ? '900' : '600' }};border-radius:10px;cursor:{{ $hasActivity ? 'pointer' : 'default' }};
                        background:{{ $isToday ? '#FFC81A' : 'transparent' }};
                        color:{{ $isToday ? '#131218' : ($hasActivity ? '#131218' : '#334155') }};
                        border:{{ $isToday ? '1.5px solid #131218' : 'none' }};
                        box-shadow:{{ $isToday ? '0 4px 12px rgba(255, 200, 26, 0.35)' : 'none' }};">
              {{ $day }}
              @if($hasActivity)
                <div style="position:absolute;bottom:2px;left:50%;transform:translateX(-50%);display:flex;gap:2.5px;align-items:center;">
                  @foreach(array_slice($kegiatanMap[$day], 0, 3) as $actItem)
                    <span style="width:4px;height:4px;border-radius:50%;background:{{ $isToday ? '#131218' : '#FFC81A' }};border:{{ $isToday ? 'none' : '1px solid #131218' }};"></span>
                  @endforeach
                </div>
              @endif
            </div>
          @endfor
        </div>

        {{-- Legenda Kalender --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:14px;padding-top:10px;border-top:1.5px solid #F1F5F9;font-size:10.5px;font-weight:700;">
          <span style="display:inline-flex;align-items:center;gap:5px;color:#131218;">
            <span style="width:10px;height:10px;border-radius:3px;background:#FFC81A;border:1px solid #131218;"></span> Hari Ini
          </span>
          <span style="display:inline-flex;align-items:center;gap:5px;color:#131218;">
            <span style="width:6px;height:6px;border-radius:50%;background:#FFC81A;border:1px solid #131218;"></span> Tanggal Kegiatan
          </span>
        </div>
      </div>

      {{-- Status Pendaftar Chart Widget --}}
      <div class="fcc-card" style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
          <h3 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Status Pendaftar</h3>
          <span style="font-size:10.5px;font-weight:800;color:#131218;background:#FFC81A;padding:3px 8px;border-radius:6px;border:1px solid #131218;">Transaksi</span>
        </div>
        <div style="position:relative;height:150px;margin-bottom:10px;">
          <canvas id="chartStatusPendaftar"></canvas>
        </div>
        <div id="status-pendaftar-legend" style="display:flex;flex-direction:column;gap:2px;margin-top:8px;"></div>
      </div>



      {{-- Menunggu Verifikasi List Widget --}}
      <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="padding:16px 20px;border-bottom:2px solid #E5E7EB;display:flex;justify-content:space-between;align-items:center;background:#F8FAFC;">
          <h3 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Menunggu Verifikasi</h3>
          @if($pendingBayar)
          <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;">{{ $pendingBayar }}</span>
          @endif
        </div>
        @forelse($pembayaranMenunggu as $p)
        <a href="{{ route('admin.pembayaran.show', $p) }}" style="display:flex;align-items:center;gap:12px;padding:14px 18px;border-top:1px solid #F8FAFC;text-decoration:none;transition:background .18s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
          <div style="width:36px;height:36px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 10px rgba(255,200,26,0.25);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <div style="flex:1;min-width:0;">
            <p style="margin:0;font-size:13px;font-weight:900;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p->pendaftaran->peserta->nama }}</p>
            <p style="margin:0;font-size:11px;color:#64748B;">{{ Str::limit($p->pendaftaran->kegiatan->judul, 22) }}</p>
          </div>
          <p style="margin:0;font-size:12.5px;font-weight:900;color:#131218;white-space:nowrap;">{{ $p->jumlah_bayar_format }}</p>
        </a>
        @empty
        <div style="padding:24px;text-align:center;color:#94A3B8;font-size:13px;">Tidak ada pembayaran menunggu.</div>
        @endforelse
      </div>

    </div>

  </div>

</div>
@endsection

@push('page-data')
<script>
window.PAGE_DATA = {!! json_encode([
    'api' => [
        'base'     => url('/admin/api'),
        'stats'    => route('admin.api.chart.stats'),
        'calendar' => route('admin.api.calendar'),
    ],
]) !!};
</script>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@vite('resources/js/pages/admin-dashboard.js')
@endpush

