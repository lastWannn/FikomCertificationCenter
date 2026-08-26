@extends('layouts.admin')
@section('title','Laporan & Statistik')
@section('page-title','Laporan & Statistik')

@push('styles')
<style>
  /* Base & Print Styling */
  .laporan-container {
    padding: 24px 28px;
    max-width: 1600px;
    margin: 0 auto;
    font-family: 'Inter', sans-serif;
  }
  .stat-card-glow {
    transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
  }
  .stat-card-glow:hover {
    transform: translateY(-4px);
    border-color: #FFC81A !important;
    box-shadow: 0 14px 28px rgba(255, 200, 26, 0.2) !important;
  }
  .badge-status {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 10.5px;
    font-weight: 900;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .badge-terverifikasi { background: #ECFDF5; color: #059669; border: 1px solid #10B981; }
  .badge-menunggu { background: #FFC81A; color: #131218; border: 1px solid #131218; }
  .badge-ditolak { background: #FEF2F2; color: #DC2626; border: 1px solid #EF4444; }
  .badge-kadaluarsa { background: #F3F4F6; color: #4B5563; border: 1px solid #9CA3AF; }

  @media print {
    body { background: #fff !important; color: #000 !important; }
    .no-print, header, sidebar, .fcc-sidebar, .fcc-header, #filter-bar { display: none !important; }
    .laporan-container { padding: 0 !important; width: 100% !important; max-width: 100% !important; }
    .fcc-card { border: 1px solid #ddd !important; box-shadow: none !important; margin-bottom: 20px !important; page-break-inside: avoid; }
    .print-header { display: block !important; margin-bottom: 24px; border-bottom: 2px solid #131218; padding-bottom: 12px; }
    .grid-print-2 { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 16px !important; }
  }
  .print-header { display: none; }
</style>
@endpush

@section('page-content')
<div class="laporan-container" style="position:relative;">

  {{-- ═══ LAPORAN SKELETON LOADING OVERLAY ═════════════════════════ --}}
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
    #laporan-skeleton-overlay {
      transition: opacity 0.35s ease, visibility 0.35s ease;
    }
  </style>

  <div id="laporan-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
    {{-- Filter Bar Skeleton --}}
    <div style="padding:18px 22px;margin-bottom:24px;border-radius:18px;background:#131218;display:flex;align-items:center;gap:12px;justify-content:space-between;">
      <div style="display:flex;gap:12px;align-items:center;width:60%;">
        <div class="fcc-skeleton-box" style="width:120px;height:34px;background:#24232C;"></div>
        <div class="fcc-skeleton-box" style="width:100px;height:34px;background:#24232C;"></div>
        <div class="fcc-skeleton-box" style="width:140px;height:34px;background:#24232C;"></div>
      </div>
      <div style="display:flex;gap:10px;">
        <div class="fcc-skeleton-box" style="width:100px;height:34px;background:#24232C;border-radius:30px;"></div>
        <div class="fcc-skeleton-box" style="width:120px;height:34px;background:#24232C;border-radius:30px;"></div>
      </div>
    </div>

    {{-- 4 Stat Cards Skeleton --}}
    <div style="display:grid;grid-template-columns:repeat(4, 1fr);gap:18px;margin-bottom:24px;">
      @for($s=0;$s<4;$s++)
      <div style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
          <div class="fcc-skeleton-box" style="width:60%;height:12px;"></div>
          <div class="fcc-skeleton-box" style="width:48px;height:48px;border-radius:14px;"></div>
        </div>
        <div class="fcc-skeleton-box" style="width:80%;height:26px;margin-bottom:6px;"></div>
        <div class="fcc-skeleton-box" style="width:40%;height:10px;"></div>
      </div>
      @endfor
    </div>

    {{-- 2 Columns Structured Skeleton --}}
    <div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">
      {{-- Left Side --}}
      <div style="display:flex;flex-direction:column;gap:24px;">
        <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
          <div style="display:flex;justify-content:space-between;margin-bottom:20px;">
            <div class="fcc-skeleton-box" style="width:40%;height:18px;"></div>
            <div class="fcc-skeleton-box" style="width:120px;height:30px;border-radius:10px;"></div>
          </div>
          <div class="fcc-skeleton-box" style="width:100%;height:220px;border-radius:14px;"></div>
        </div>
        <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
          <div class="fcc-skeleton-box" style="width:30%;height:16px;margin-bottom:16px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:40px;margin-bottom:10px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:40px;"></div>
        </div>
      </div>

      {{-- Right Side --}}
      <div style="display:flex;flex-direction:column;gap:24px;">
        <div style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
          <div class="fcc-skeleton-box" style="width:50%;height:16px;margin-bottom:16px;"></div>
          <div class="fcc-skeleton-box" style="width:130px;height:130px;border-radius:50%;margin:0 auto 16px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:30px;border-radius:8px;"></div>
        </div>
        <div style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
          <div class="fcc-skeleton-box" style="width:60%;height:16px;margin-bottom:16px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:80px;border-radius:8px;"></div>
        </div>
      </div>
    </div>
  </div>

  <script>
    (function() {
      setTimeout(function() {
        var sk = document.getElementById('laporan-skeleton-overlay');
        if (sk) {
          sk.style.opacity = '0';
          sk.style.visibility = 'hidden';
          setTimeout(function() { sk.style.display = 'none'; }, 350);
        }
      }, 450);
    })();
  </script>

  {{-- Filter & Action Bar --}}
  <div id="filter-bar" class="fcc-card no-print" style="padding:18px 22px;margin-bottom:24px;background:#131218;border:2px solid #131218;border-radius:18px;color:#FFF;box-shadow:0 6px 20px rgba(19,18,24,0.15);">
    <form method="GET" action="{{ route('admin.laporan.index') }}" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
      <div style="display:flex;align-items:center;gap:8px;">
        @include('components.icon',['name'=>'filter','size'=>16,'style'=>'color:#FFC81A'])
        <span style="font-size:13px;font-weight:900;letter-spacing:.5px;text-transform:uppercase;color:#FFC81A;">Filter Laporan:</span>
      </div>

      {{-- Tahun --}}
      <select name="tahun" class="fcc-input" onchange="this.form.submit()" style="width:auto;background:#24232C;color:#FFF;border:1.5px solid #363442;border-radius:10px;padding:8px 14px;font-size:13px;font-weight:800;cursor:pointer;">
        @foreach($availableYears as $y)
          <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
        @endforeach
      </select>

      {{-- Bulan --}}
      <select name="bulan" class="fcc-input" onchange="this.form.submit()" style="width:auto;background:#24232C;color:#FFF;border:1.5px solid #363442;border-radius:10px;padding:8px 14px;font-size:13px;font-weight:800;cursor:pointer;">
        <option value="">Semua Bulan</option>
        @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $v=>$l)
          <option value="{{ $v }}" {{ $bulan == $v ? 'selected' : '' }}>{{ $l }}</option>
        @endforeach
      </select>

      {{-- Jenis Kegiatan --}}
      <select name="jenis_kegiatan" class="fcc-input" onchange="this.form.submit()" style="width:auto;background:#24232C;color:#FFF;border:1.5px solid #363442;border-radius:10px;padding:8px 14px;font-size:13px;font-weight:800;cursor:pointer;">
        <option value="">Semua Jenis Kegiatan</option>
        <option value="pelatihan" {{ $jenisKegiatan == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
        <option value="sertifikasi" {{ $jenisKegiatan == 'sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
      </select>

      @if($bulan || $jenisKegiatan || $tahun != date('Y'))
        <a href="{{ route('admin.laporan.index') }}" style="color:#9CA3B0;font-size:12px;font-weight:800;text-decoration:none;padding:8px 14px;background:#24232C;border-radius:20px;border:1px solid #363442;">
          Reset
        </a>
      @endif

      {{-- Export Button --}}
      <div style="margin-left:auto;display:flex;gap:10px;">
        <a href="{{ route('admin.laporan.export-csv', ['tahun'=>$tahun,'bulan'=>$bulan,'jenis_kegiatan'=>$jenisKegiatan]) }}" style="padding:9px 20px;font-size:13px;font-weight:800;text-decoration:none;display:flex;align-items:center;gap:8px;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:30px;box-shadow:0 4px 12px rgba(255,200,26,0.3);transition:all .2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
          @include('components.icon',['name'=>'download','size'=>14])
          Export CSV
        </a>
      </div>
    </form>
  </div>

  {{-- 4 Main KPI Stat Cards Grid --}}
  <div style="display:grid;grid-template-columns:repeat(4, 1fr);gap:18px;margin-bottom:24px;">
    
    {{-- Card 1: Total Pendapatan --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:.8px;">Total Pendapatan</p>
        <div style="width:48px;height:48px;border-radius:14px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 14px rgba(255,200,26,0.3);">
          @include('components.icon',['name'=>'credit-card','size'=>22,'style'=>'color:#131218'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:23px;font-weight:900;color:#131218;letter-spacing:-.5px;">
        Rp {{ number_format($summary['total_pendapatan'],0,',','.') }}
      </h3>
      <p style="margin:0;font-size:11px;color:#6B7280;font-weight:600;">
        Rata-rata: Rp {{ number_format($summary['avg_transaksi'],0,',','.') }}/tx
      </p>
    </div>

    {{-- Card 2: Total Pendaftaran --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:.8px;">Pendaftaran Masuk</p>
        <div style="width:48px;height:48px;border-radius:14px;background:#131218;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 14px rgba(19,18,24,0.25);">
          @include('components.icon',['name'=>'clipboard-list','size'=>22,'style'=>'color:#FFC81A'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:23px;font-weight:900;color:#131218;letter-spacing:-.5px;">
        {{ number_format($summary['total_pendaftaran']) }} <span style="font-size:13px;font-weight:700;color:#6B7280;">Siswa/i</span>
      </h3>
      <p style="margin:0;font-size:11px;color:#10B981;font-weight:700;">
        Rate Sukses: {{ $summary['rate_verifikasi'] }}%
      </p>
    </div>

    {{-- Card 3 (Option 1): Sertifikat Diterbitkan --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:.8px;">Sertifikat Terbit</p>
        <div style="width:48px;height:48px;border-radius:14px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 14px rgba(255,200,26,0.3);">
          @include('components.icon',['name'=>'award','size'=>22,'style'=>'color:#131218'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:23px;font-weight:900;color:#131218;letter-spacing:-.5px;">
        {{ number_format($summary['total_sertifikat']) }} <span style="font-size:13px;font-weight:700;color:#6B7280;">Berkas</span>
      </h3>
      <p style="margin:0;font-size:11px;color:#6B7280;font-weight:600;">
        Rasio Terbit: {{ $summary['rate_sertifikat'] }}%
      </p>
    </div>

    {{-- Card 4 (Option 4): Efisiensi Kuota Kelas --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:.8px;">Keterisian Kuota</p>
        <div style="width:48px;height:48px;border-radius:14px;background:#131218;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 14px rgba(19,18,24,0.25);">
          @include('components.icon',['name'=>'users','size'=>22,'style'=>'color:#FFC81A'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:23px;font-weight:900;color:#131218;letter-spacing:-.5px;">
        {{ $summary['rate_kuota'] }}% <span style="font-size:13px;font-weight:700;color:#6B7280;">Terisi</span>
      </h3>
      <p style="margin:0;font-size:11px;color:#6B7280;font-weight:600;">
        {{ number_format($summary['total_terisi']) }} / {{ number_format($summary['total_kuota']) }} Peserta
      </p>
    </div>

  </div>

  {{-- 2-Column Structured Layout (Left Main 70% + Right Side 30%) --}}
  <div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">

    {{-- LEFT MAIN AREA (~70%) --}}
    <div style="display:flex;flex-direction:column;gap:24px;min-width:0;">



      {{-- Chart 1: Tren Pendapatan & Pendaftaran Bulanan --}}
      <div class="fcc-card" style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
          <div>
            <h4 style="margin:0;font-size:16px;font-weight:900;color:#131218;">{{ $chartTitle }}</h4>
            <p style="margin:2px 0 0;font-size:12px;color:#6B7280;">Perbandingan pendapatan (Rp) dan pendaftaran {{ $bulan ? 'harian pada bulan terpilih' : 'bulanan pada tahun ' . $tahun }}</p>
          </div>
          <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:14px;font-size:12px;font-weight:700;">
              <span style="display:inline-flex;align-items:center;gap:6px;color:#131218;">
                <span style="width:12px;height:12px;border-radius:3px;background:#FFC81A;border:1px solid #131218;"></span> Pendapatan (Rp)
              </span>
              <span style="display:inline-flex;align-items:center;gap:6px;color:#3B82F6;">
                <span style="width:12px;height:12px;border-radius:3px;background:#3B82F6;"></span> Pendaftaran
              </span>
            </div>
            <select id="laporan-chart-metric" class="fcc-input" style="width:auto;font-size:12px;font-weight:800;padding:6px 14px;border-radius:10px;border:1.5px solid #E5E7EB;background:#F8FAFC;cursor:pointer;">
              <option value="semua" selected>Semua</option>
              <option value="pendapatan">Pendapatan</option>
              <option value="pendaftaran">Pendaftaran</option>
            </select>
          </div>
        </div>

        <div style="position:relative;height:260px;width:100%;">
          <canvas id="chartLaporanBulanan"></canvas>
        </div>
      </div>

      {{-- Tabel Ringkasan Transaksi Terbaru --}}
      <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="padding:16px 20px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;">
          <div>
            <h4 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Rincian Transaksi Pendaftaran Terbaru</h4>
            <p style="margin:2px 0 0;font-size:11px;color:#6B7280;">10 Transaksi terakhir sesuai filter</p>
          </div>
        </div>
        <div style="overflow-x:auto;">
          <table style="width:100%;border-collapse:collapse;text-align:left;">
            <thead>
              <tr style="background:#F8FAFC;border-bottom:1.5px solid #E5E7EB;">
                <th style="padding:12px 16px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Peserta &amp; Instansi</th>
                <th style="padding:12px 16px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Kegiatan</th>
                <th style="padding:12px 16px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Nominal</th>
                <th style="padding:12px 16px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Status</th>
                <th style="padding:12px 16px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @forelse($transaksiTerbaru as $t)
                @php
                  $statusBayar = $t->pembayaran->status_pembayaran ?? 'belum_bayar';
                  $badgeClass = match($statusBayar) {
                    'terverifikasi' => 'badge-terverifikasi',
                    'menunggu_verifikasi', 'menunggu_pembayaran' => 'badge-menunggu',
                    'ditolak' => 'badge-ditolak',
                    default => 'badge-kadaluarsa'
                  };
                @endphp
                <tr style="border-bottom:1px solid #F1F5F9;">
                  <td style="padding:12px 16px;">
                    <p style="margin:0;font-size:13px;font-weight:900;color:#131218;">{{ $t->peserta->nama ?? '-' }}</p>
                    <p style="margin:0;font-size:11px;color:#6B7280;">{{ $t->peserta->instansi ?? 'Umum' }}</p>
                  </td>
                  <td style="padding:12px 16px;">
                    <p style="margin:0;font-size:12.5px;font-weight:800;color:#131218;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                      {{ $t->kegiatan->judul ?? '-' }}
                    </p>
                    <span style="font-size:10px;font-weight:800;color:#6B7280;text-transform:uppercase;">{{ ucfirst($t->kegiatan->jenis_kegiatan ?? '') }}</span>
                  </td>
                  <td style="padding:12px 16px;font-size:13px;font-weight:900;color:#131218;">
                    Rp {{ number_format($t->pembayaran->jumlah_bayar ?? $t->biaya->nominal ?? 0, 0, ',', '.') }}
                  </td>
                  <td style="padding:12px 16px;">
                    <span class="badge-status {{ $badgeClass }}">
                      {{ ucfirst(str_replace('_', ' ', $statusBayar)) }}
                    </span>
                  </td>
                  <td style="padding:12px 16px;font-size:11.5px;color:#6B7280;font-weight:600;">
                    {{ $t->tgl_daftar?->format('d/m/Y H:i') ?? '-' }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" style="padding:24px;text-align:center;color:#9CA3B0;font-size:13px;">
                    Tidak ada transaksi pendaftaran ditemukan.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>

    {{-- RIGHT SIDE AREA (~30%) --}}
    <div style="display:flex;flex-direction:column;gap:24px;">

      {{-- Option 2: Demografi & Asal Instansi Peserta Widget --}}
      <div class="fcc-card" style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
          <h4 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Demografi Peserta</h4>
          <span style="font-size:10.5px;font-weight:800;color:#131218;background:#FFC81A;padding:3px 8px;border-radius:6px;border:1px solid #131218;">Instansi</span>
        </div>

        <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:14px;">
          @php
            $totalDemo = max(1, array_sum($summary['demografi']));
            $demoItems = [
              ['FIKOM UMI',              $summary['demografi']['fikom'],     '#FFC81A'],
              ['UMI (Luar FIKOM)',       $summary['demografi']['umi'],       '#131218'],
              ['Kampus Lain / Eksternal', $summary['demografi']['eksternal'], '#3B82F6'],
              ['Masyarakat Umum',        $summary['demografi']['umum'],      '#9CA3AF'],
            ];
          @endphp
          @foreach($demoItems as [$lbl, $cnt, $bgColor])
          @php $pct = round(($cnt / $totalDemo) * 100); @endphp
          <div style="background:#F8FAFC;padding:9px 12px;border-radius:10px;border:1px solid #F1F5F9;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;font-size:12px;">
              <span style="font-weight:700;color:#131218;">{{ $lbl }}</span>
              <span style="font-weight:900;color:#131218;">{{ $cnt }} <span style="font-size:10.5px;color:#64748B;font-weight:600;">({{ $pct }}%)</span></span>
            </div>
            <div style="height:5px;background:#E5E7EB;border-radius:3px;overflow:hidden;">
              <div style="height:100%;background:{{ $bgColor }};width:{{ $pct }}%;"></div>
            </div>
          </div>
          @endforeach
        </div>

        @if(isset($rawInstansi) && $rawInstansi->isNotEmpty())
        <div style="border-top:1.5px solid #F1F5F9;padding-top:10px;">
          <p style="margin:0 0 6px;font-size:10.5px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Top 5 Instansi Terbanyak</p>
          <div style="display:flex;flex-wrap:wrap;gap:4px;">
            @foreach($rawInstansi as $ri)
            <span style="font-size:10.5px;font-weight:800;background:#F1F5F9;color:#131218;padding:3px 8px;border-radius:14px;border:1px solid #E2E8F0;">
              {{ Str::limit($ri->nama_instansi, 20) }}: {{ $ri->total }}
            </span>
            @endforeach
          </div>
        </div>
        @endif
      </div>

      {{-- Doughnut Status Pembayaran Widget --}}
      <div class="fcc-card" style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <h4 style="margin:0 0 14px;font-size:15px;font-weight:900;color:#131218;">Status Pembayaran</h4>
        <div style="position:relative;height:150px;">
          <canvas id="chartStatusPembayaran"></canvas>
        </div>
      </div>

      {{-- Doughnut Jenis Kegiatan Widget --}}
      <div class="fcc-card" style="padding:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <h4 style="margin:0 0 14px;font-size:15px;font-weight:900;color:#131218;">Proporsi Kegiatan</h4>
        <div style="position:relative;height:150px;">
          <canvas id="chartJenisKegiatan"></canvas>
        </div>
      </div>

      {{-- Top Kegiatan Terfavorit Widget --}}
      <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
        <div style="padding:16px 20px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;">
          <h4 style="margin:0;font-size:15px;font-weight:900;color:#131218;">10 Kegiatan Terfavorit</h4>
          <p style="margin:2px 0 0;font-size:11px;color:#6B7280;">Berdasarkan total peminat pendaftar</p>
        </div>
        <div style="max-height:380px;overflow-y:auto;">
          @forelse($perKegiatan as $i => $k)
            @php
              $maxCount = max(1, $perKegiatan->first()?->pendaftaran_count ?? 1);
              $percentage = round(($k->pendaftaran_count / $maxCount) * 100);
            @endphp
            <div style="padding:11px 16px;border-bottom:1px solid #F1F5F9;display:flex;align-items:center;gap:10px;">
              <div style="width:26px;height:26px;border-radius:8px;flex-shrink:0;
                background:{{ $i===0?'#FFC81A':($i===1?'#131218':($i===2?'#475569':'#F1F5F9')) }};
                border:{{ $i===0?'1px solid #131218':'none' }};
                display:flex;align-items:center;justify-content:center;
                font-size:11px;font-weight:900;color:{{ $i===0?'#131218':($i<3?'#FFF':'#6B7280') }};">
                {{ $i + 1 }}
              </div>
              <div style="flex:1;min-width:0;">
                <p style="margin:0;font-size:12px;font-weight:800;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  {{ $k->judul }}
                </p>
                <div style="display:flex;align-items:center;gap:6px;margin-top:3px;">
                  <span style="font-size:9px;font-weight:900;color:{{ $k->jenis_kegiatan === 'pelatihan' ? '#131218' : '#64748B' }};text-transform:uppercase;">
                    {{ $k->jenis_kegiatan }}
                  </span>
                  <div style="flex:1;height:4px;background:#E5E7EB;border-radius:2px;overflow:hidden;">
                    <div style="height:100%;background:{{ $i===0?'#FFC81A':'#131218' }};width:{{ $percentage }}%;"></div>
                  </div>
                </div>
              </div>
              <div style="text-align:right;flex-shrink:0;">
                <span style="font-size:13px;font-weight:900;color:#131218;">{{ $k->pendaftaran_count }}</span>
                <span style="display:block;font-size:9.5px;color:#9CA3B0;font-weight:600;">pendaftar</span>
              </div>
            </div>
          @empty
            <div style="padding:24px;text-align:center;color:#9CA3B0;font-size:13px;">Belum ada data kegiatan.</div>
          @endforelse
        </div>
      </div>

    </div>

  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
  let chartBulananInstance, chartStatusInstance, chartJenisInstance;

  function initLaporanCharts() {
    // Data dari Server (Dynamic Harian / Bulanan)
    const bulanLabels = {!! json_encode($chartLabels) !!};
    const dataPendapatan = {!! json_encode($pendapatanChartData) !!};
    const dataPendaftaran = {!! json_encode($pendaftaranChartData) !!};
    const statusCounts = {!! json_encode($statusPembayaranCounts) !!};
    const jenisCounts = {!! json_encode($jenisCounts) !!};

    // 1. Chart Main Laporan (Pendapatan & Pendaftaran)
    function renderMainChart() {
      const ctxBulanan = document.getElementById('chartLaporanBulanan');
      if (!ctxBulanan) return;

      const metric = document.getElementById('laporan-chart-metric')?.value || 'semua';
      if (chartBulananInstance) chartBulananInstance.destroy();

      const datasets = [];
      const scales = {
        x: { grid: { display: false } }
      };

      if (metric === 'semua' || metric === 'pendapatan') {
        datasets.push({
          label: 'Pendapatan (Rp)',
          data: dataPendapatan,
          type: 'line',
          borderColor: '#FFC81A',
          backgroundColor: 'rgba(255, 200, 26, 0.18)',
          borderWidth: 3,
          pointBackgroundColor: '#FFC81A',
          pointBorderColor: '#131218',
          pointBorderWidth: 2,
          pointRadius: 5,
          tension: 0.35,
          fill: true,
          yAxisID: metric === 'semua' ? 'yPendapatan' : 'y',
          order: 1
        });

        scales[metric === 'semua' ? 'yPendapatan' : 'y'] = {
          type: 'linear',
          position: 'left',
          grid: { color: '#F0F1F5' },
          ticks: {
            callback: function(val) {
              if (val >= 1000000) return 'Rp ' + (val/1000000).toFixed(1) + 'M';
              if (val >= 1000) return 'Rp ' + (val/1000).toFixed(0) + 'k';
              return 'Rp ' + val;
            }
          }
        };
      }

      if (metric === 'semua' || metric === 'pendaftaran') {
        datasets.push({
          label: 'Jumlah Pendaftaran',
          data: dataPendaftaran,
          type: 'bar',
          backgroundColor: '#3B82F6',
          hoverBackgroundColor: '#2563EB',
          borderRadius: 6,
          yAxisID: metric === 'semua' ? 'yPendaftaran' : 'y',
          order: 2
        });

        scales[metric === 'semua' ? 'yPendaftaran' : 'y'] = {
          type: 'linear',
          position: metric === 'semua' ? 'right' : 'left',
          grid: metric === 'pendaftaran' ? { color: '#F0F1F5' } : { drawOnChartArea: false },
          ticks: { precision: 0 }
        };
      }

      chartBulananInstance = new Chart(ctxBulanan, {
        type: 'bar',
        data: {
          labels: bulanLabels,
          datasets: datasets
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: { mode: 'index', intersect: false },
          plugins: {
            legend: { display: false },
            tooltip: {
              padding: 12,
              callbacks: {
                label: function(context) {
                  let label = context.dataset.label || '';
                  if (label) label += ': ';
                  if (context.dataset.label.includes('Pendapatan')) {
                    label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                  } else {
                    label += context.raw + ' Pendaftaran';
                  }
                  return label;
                }
              }
            }
          },
          scales: scales
        }
      });
    }

    renderMainChart();
    document.getElementById('laporan-chart-metric')?.removeEventListener('change', renderMainChart);
    document.getElementById('laporan-chart-metric')?.addEventListener('change', renderMainChart);

    // 2. Chart Doughnut Status Pembayaran
    const ctxStatus = document.getElementById('chartStatusPembayaran');
    if (ctxStatus) {
      if (chartStatusInstance) chartStatusInstance.destroy();
      chartStatusInstance = new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
          labels: ['Terverifikasi', 'Menunggu', 'Ditolak', 'Kadaluarsa'],
          datasets: [{
            data: [
              statusCounts['terverifikasi'] || 0,
              (statusCounts['menunggu_verifikasi'] || 0) + (statusCounts['menunggu_pembayaran'] || 0),
              statusCounts['ditolak'] || 0,
              statusCounts['kadaluarsa'] || 0
            ],
            backgroundColor: ['#10B981', '#FFC81A', '#EF4444', '#9CA3B0'],
            borderWidth: 0,
            hoverOffset: 4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'right', labels: { boxWidth: 12, font: { size: 11, weight: 'bold' } } }
          },
          cutout: '70%'
        }
      });
    }

    // 3. Chart Doughnut Jenis Kegiatan
    const ctxJenis = document.getElementById('chartJenisKegiatan');
    if (ctxJenis) {
      if (chartJenisInstance) chartJenisInstance.destroy();
      chartJenisInstance = new Chart(ctxJenis, {
        type: 'doughnut',
        data: {
          labels: ['Pelatihan', 'Sertifikasi'],
          datasets: [{
            data: [
              jenisCounts['pelatihan'] || 0,
              jenisCounts['sertifikasi'] || 0
            ],
            backgroundColor: ['#3B82F6', '#8B5CF6'],
            borderWidth: 0,
            hoverOffset: 4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'right', labels: { boxWidth: 12, font: { size: 11, weight: 'bold' } } }
          },
          cutout: '70%'
        }
      });
    }
  }

  document.addEventListener('DOMContentLoaded', initLaporanCharts);
  document.addEventListener('livewire:navigated', initLaporanCharts);
})();
</script>
@endpush
