@extends('layouts.admin')
@section('title','Laporan & Statistik')
@section('page-title','Laporan & Statistik')

@push('styles')
<style>
  /* Base & Print Styling */
  .laporan-container {
    padding: 24px;
    max-width: 1600px;
    margin: 0 auto;
  }
  .stat-card-glow {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
  }
  .stat-card-glow:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 24px -6px rgba(19, 18, 24, 0.12);
  }
  .stat-icon-wrapper {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .badge-status {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .badge-terverifikasi { background: rgba(16, 185, 129, 0.12); color: #059669; }
  .badge-menunggu { background: rgba(255, 200, 26, 0.18); color: #9A7300; }
  .badge-ditolak { background: rgba(239, 68, 68, 0.12); color: #DC2626; }
  .badge-kadaluarsa { background: rgba(107, 114, 128, 0.12); color: #4B5563; }

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
<div class="laporan-container">

  {{-- Print Header (Only visible on print) --}}
  <div class="print-header">
    <div style="display:flex;justify-content:space-between;align-items:center;">
      <div>
        <h2 style="margin:0;font-size:22px;font-weight:900;color:#131218;">FIKOM CERTIFICATION CENTER</h2>
        <p style="margin:4px 0 0;font-size:13px;color:#4B5563;">Laporan Rekapitulasi & Statistik Eksekutif</p>
      </div>
      <div style="text-align:right;">
        <p style="margin:0;font-size:12px;font-weight:700;color:#131218;">Periode: {{ $bulan ? \Carbon\Carbon::create()->month((int)$bulan)->translatedFormat('F') : 'Semua Bulan' }} {{ $tahun }}</p>
        <p style="margin:2px 0 0;font-size:11px;color:#6B7280;">Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}</p>
      </div>
    </div>
  </div>

  {{-- Filter & Action Bar --}}
  <div id="filter-bar" class="fcc-card no-print" style="padding:16px 20px;margin-bottom:24px;background:#131218;border:none;color:#FFF;">
    <form method="GET" action="{{ route('admin.laporan.index') }}" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
      <div style="display:flex;align-items:center;gap:8px;">
        @include('components.icon',['name'=>'filter','size'=>16,'style'=>'color:#FFC81A'])
        <span style="font-size:13px;font-weight:800;letter-spacing:.5px;text-transform:uppercase;color:#FFC81A;">Filter Laporan:</span>
      </div>

      {{-- Tahun --}}
      <select name="tahun" class="fcc-input" style="width:auto;background:#24232C;color:#FFF;border-color:#363442;padding:8px 14px;font-size:13px;font-weight:700;">
        @foreach($availableYears as $y)
          <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
        @endforeach
      </select>

      {{-- Bulan --}}
      <select name="bulan" class="fcc-input" style="width:auto;background:#24232C;color:#FFF;border-color:#363442;padding:8px 14px;font-size:13px;font-weight:700;">
        <option value="">Semua Bulan</option>
        @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $v=>$l)
          <option value="{{ $v }}" {{ $bulan == $v ? 'selected' : '' }}>{{ $l }}</option>
        @endforeach
      </select>

      {{-- Jenis Kegiatan --}}
      <select name="jenis_kegiatan" class="fcc-input" style="width:auto;background:#24232C;color:#FFF;border-color:#363442;padding:8px 14px;font-size:13px;font-weight:700;">
        <option value="">Semua Jenis Kegiatan</option>
        <option value="pelatihan" {{ $jenisKegiatan == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
        <option value="sertifikasi" {{ $jenisKegiatan == 'sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
      </select>

      {{-- Submit & Reset --}}
      <button type="submit" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;font-weight:800;border:none;cursor:pointer;">
        Terapkan Filter
      </button>

      @if($bulan || $jenisKegiatan || $tahun != date('Y'))
        <a href="{{ route('admin.laporan.index') }}" style="color:#9CA3B0;font-size:12px;font-weight:700;text-decoration:none;padding:6px 10px;background:#24232C;border-radius:8px;">
          Reset
        </a>
      @endif

      {{-- Export & Print Buttons --}}
      <div style="margin-left:auto;display:flex;gap:10px;">
        <button type="button" onclick="window.print()" class="fcc-btn-dark" style="background:#24232C;color:#FFF;border:1px solid #363442;padding:9px 16px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
          Cetak PDF
        </button>

        <a href="{{ route('admin.laporan.export-csv', ['tahun'=>$tahun,'bulan'=>$bulan,'jenis_kegiatan'=>$jenisKegiatan]) }}" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;font-weight:800;text-decoration:none;display:flex;align-items:center;gap:6px;">
          @include('components.icon',['name'=>'download','size'=>14])
          Export CSV
        </a>
      </div>
    </form>
  </div>

  {{-- Summary KPI Cards --}}
  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
    
    {{-- Card 1: Total Pendapatan --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-left:4px solid #FFC81A;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#9CA3B0;text-transform:uppercase;letter-spacing:.8px;">Total Pendapatan</p>
        <div class="stat-icon-wrapper" style="background:rgba(255,200,26,0.15);">
          @include('components.icon',['name'=>'credit-card','size'=>20,'style'=>'color:#FFC81A'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:24px;font-weight:900;color:#131218;letter-spacing:-.5px;">
        Rp {{ number_format($summary['total_pendapatan'],0,',','.') }}
      </h3>
      <p style="margin:0;font-size:11px;color:#6B7280;font-weight:600;">
        Terverifikasi pada periode terpilih
      </p>
    </div>

    {{-- Card 2: Total Pendaftaran --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-left:4px solid #3B82F6;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#9CA3B0;text-transform:uppercase;letter-spacing:.8px;">Pendaftaran Masuk</p>
        <div class="stat-icon-wrapper" style="background:rgba(59,130,246,0.15);">
          @include('components.icon',['name'=>'clipboard-list','size'=>20,'style'=>'color:#3B82F6'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:24px;font-weight:900;color:#131218;letter-spacing:-.5px;">
        {{ number_format($summary['total_pendaftaran']) }} <span style="font-size:13px;font-weight:600;color:#6B7280;">Siswa/i</span>
      </h3>
      <p style="margin:0;font-size:11px;color:#6B7280;font-weight:600;">
        {{ number_format($summary['total_terverifikasi']) }} transaksi disetujui
      </p>
    </div>

    {{-- Card 3: Tingkat Verifikasi (Conversion Rate) --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-left:4px solid #10B981;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#9CA3B0;text-transform:uppercase;letter-spacing:.8px;">Tingkat Sukses</p>
        <div class="stat-icon-wrapper" style="background:rgba(16,185,129,0.15);">
          @include('components.icon',['name'=>'check','size'=>20,'style'=>'color:#10B981'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:24px;font-weight:900;color:#10B981;letter-spacing:-.5px;">
        {{ $summary['rate_verifikasi'] }}%
      </h3>
      <p style="margin:0;font-size:11px;color:#6B7280;font-weight:600;">
        Rasio pendaftaran tuntas dibayar
      </p>
    </div>

    {{-- Card 4: Rata-Rata Nilai Transaksi --}}
    <div class="fcc-card stat-card-glow" style="padding:20px;border-left:4px solid #8B5CF6;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;font-weight:800;color:#9CA3B0;text-transform:uppercase;letter-spacing:.8px;">Rata-Rata Omset</p>
        <div class="stat-icon-wrapper" style="background:rgba(139,92,246,0.15);">
          @include('components.icon',['name'=>'award','size'=>20,'style'=>'color:#8B5CF6'])
        </div>
      </div>
      <h3 style="margin:0 0 4px;font-size:24px;font-weight:900;color:#131218;letter-spacing:-.5px;">
        Rp {{ number_format($summary['avg_transaksi'],0,',','.') }}
      </h3>
      <p style="margin:0;font-size:11px;color:#6B7280;font-weight:600;">
        Per transaksi terverifikasi
      </p>
    </div>

  </div>

  {{-- Charts Section --}}
  <div class="grid-print-2" style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:24px;">
    
    {{-- Chart 1: Tren Pendapatan & Pendaftaran Bulanan --}}
    <div class="fcc-card" style="padding:22px;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
        <div>
          <h4 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Grafik Tren Pendapatan & Pendaftaran</h4>
          <p style="margin:2px 0 0;font-size:12px;color:#6B7280;">Perbandingan per bulan pada tahun {{ $tahun }}</p>
        </div>
        <div style="display:flex;align-items:center;gap:14px;font-size:12px;font-weight:700;">
          <span style="display:inline-flex;align-items:center;gap:6px;color:#131218;">
            <span style="width:12px;height:12px;border-radius:3px;background:#FFC81A;"></span> Pendapatan (Rp)
          </span>
          <span style="display:inline-flex;align-items:center;gap:6px;color:#3B82F6;">
            <span style="width:12px;height:12px;border-radius:3px;background:#3B82F6;"></span> Pendaftaran
          </span>
        </div>
      </div>

      <div style="position:relative;height:280px;width:100%;">
        <canvas id="chartLaporanBulanan"></canvas>
      </div>
    </div>

    {{-- Chart 2 & 3: Doughnut Status & Distribution --}}
    <div style="display:flex;flex-direction:column;gap:20px;">
      
      {{-- Doughnut Status Pembayaran --}}
      <div class="fcc-card" style="padding:20px;flex:1;">
        <h4 style="margin:0 0 14px;font-size:15px;font-weight:800;color:#131218;">Status Transaksi Pembayaran</h4>
        <div style="position:relative;height:160px;">
          <canvas id="chartStatusPembayaran"></canvas>
        </div>
      </div>

      {{-- Doughnut Jenis Kegiatan --}}
      <div class="fcc-card" style="padding:20px;flex:1;">
        <h4 style="margin:0 0 14px;font-size:15px;font-weight:800;color:#131218;">Proporsi Pelatihan vs Sertifikasi</h4>
        <div style="position:relative;height:160px;">
          <canvas id="chartJenisKegiatan"></canvas>
        </div>
      </div>

    </div>
  </div>

  {{-- Top Kegiatan Terfavorit & Rincian Transaksi --}}
  <div class="grid-print-2" style="display:grid;grid-template-columns:1fr 2fr;gap:20px;margin-bottom:24px;">

    {{-- Top Kegiatan --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;">
      <div style="padding:16px 20px;border-bottom:1px solid #E2E4EB;background:#F9FAFB;">
        <h4 style="margin:0;font-size:15px;font-weight:900;color:#131218;">10 Kegiatan Terfavorit</h4>
        <p style="margin:2px 0 0;font-size:11px;color:#6B7280;">Berdasarkan total peminat pendaftar</p>
      </div>
      <div style="max-height:420px;overflow-y:auto;">
        @forelse($perKegiatan as $i => $k)
          @php
            $maxCount = max(1, $perKegiatan->first()?->pendaftaran_count ?? 1);
            $percentage = round(($k->pendaftaran_count / $maxCount) * 100);
          @endphp
          <div style="padding:12px 18px;border-bottom:1px solid #F0F1F5;display:flex;align-items:center;gap:12px;">
            <div style="width:28px;height:28px;border-radius:8px;flex-shrink:0;
              background:{{ $i===0?'linear-gradient(135deg,#FFC81A,#FFD84D)':($i===1?'#9CA3B0':($i===2?'#D97706':'#F3F4F6')) }};
              display:flex;align-items:center;justify-content:center;
              font-size:12px;font-weight:900;color:{{ $i===0?'#131218':($i<3?'#FFF':'#6B7280') }};">
              {{ $i + 1 }}
            </div>
            <div style="flex:1;min-width:0;">
              <p style="margin:0;font-size:12.5px;font-weight:800;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $k->judul }}
              </p>
              <div style="display:flex;align-items:center;gap:8px;margin-top:4px;">
                <span style="font-size:10px;font-weight:700;color:{{ $k->jenis_kegiatan === 'pelatihan' ? '#3B82F6' : '#8B5CF6' }};text-transform:uppercase;">
                  {{ $k->jenis_kegiatan }}
                </span>
                <div style="flex:1;height:5px;background:#E5E7EB;border-radius:3px;overflow:hidden;">
                  <div style="height:100%;background:{{ $i===0?'#FFC81A':'#131218' }};width:{{ $percentage }}%;"></div>
                </div>
              </div>
            </div>
            <div style="text-align:right;flex-shrink:0;">
              <span style="font-size:14px;font-weight:900;color:#131218;">{{ $k->pendaftaran_count }}</span>
              <span style="display:block;font-size:10px;color:#9CA3B0;font-weight:600;">pendaftar</span>
            </div>
          </div>
        @empty
          <div style="padding:30px;text-align:center;color:#9CA3B0;font-size:13px;">Belum ada data kegiatan.</div>
        @endforelse
      </div>
    </div>

    {{-- Tabel Ringkasan Transaksi Terbaru --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;">
      <div style="padding:16px 20px;border-bottom:1px solid #E2E4EB;background:#F9FAFB;display:flex;justify-content:space-between;align-items:center;">
        <div>
          <h4 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Rincian Transaksi Pendaftaran Terbaru</h4>
          <p style="margin:2px 0 0;font-size:11px;color:#6B7280;">15 Transaksi terakhir sesuai filter</p>
        </div>
      </div>
      <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;text-align:left;">
          <thead>
            <tr style="background:#F3F4F6;border-bottom:1.5px solid #E2E4EB;">
              <th style="padding:10px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Peserta & Instansi</th>
              <th style="padding:10px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Kegiatan</th>
              <th style="padding:10px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Nominal</th>
              <th style="padding:10px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Status</th>
              <th style="padding:10px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Tanggal</th>
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
              <tr style="border-bottom:1px solid #F0F1F5;">
                <td style="padding:11px 14px;">
                  <p style="margin:0;font-size:12.5px;font-weight:800;color:#131218;">{{ $t->peserta->nama ?? '-' }}</p>
                  <p style="margin:0;font-size:10.5px;color:#6B7280;">{{ $t->peserta->instansi ?? 'Umum' }}</p>
                </td>
                <td style="padding:11px 14px;">
                  <p style="margin:0;font-size:12px;font-weight:700;color:#131218;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $t->kegiatan->judul ?? '-' }}
                  </p>
                  <span style="font-size:10px;color:#9CA3B0;">{{ ucfirst($t->kegiatan->jenis_kegiatan ?? '') }}</span>
                </td>
                <td style="padding:11px 14px;font-size:12.5px;font-weight:900;color:#131218;">
                  Rp {{ number_format($t->pembayaran->jumlah_bayar ?? $t->biaya->nominal ?? 0, 0, ',', '.') }}
                </td>
                <td style="padding:11px 14px;">
                  <span class="badge-status {{ $badgeClass }}">
                    {{ ucfirst(str_replace('_', ' ', $statusBayar)) }}
                  </span>
                </td>
                <td style="padding:11px 14px;font-size:11px;color:#6B7280;">
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

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
  
  // Data dari Server
  const dataPendapatan = {!! json_encode(array_values($pendapatanBulanan)) !!};
  const dataPendaftaran = {!! json_encode(array_values($pendaftaranBulanan)) !!};
  const statusCounts = {!! json_encode($statusPembayaranCounts) !!};
  const jenisCounts = {!! json_encode($jenisCounts) !!};

  // 1. Chart Combo Bulanan (Pendapatan & Pendaftaran)
  const ctxBulanan = document.getElementById('chartLaporanBulanan');
  if (ctxBulanan) {
    new Chart(ctxBulanan, {
      type: 'bar',
      data: {
        labels: bulanLabels,
        datasets: [
          {
            label: 'Pendapatan (Rp)',
            data: dataPendapatan,
            backgroundColor: '#FFC81A',
            hoverBackgroundColor: '#FFD84D',
            borderRadius: 6,
            yAxisID: 'yPendapatan',
            order: 2
          },
          {
            label: 'Jumlah Pendaftaran',
            data: dataPendaftaran,
            type: 'line',
            borderColor: '#3B82F6',
            backgroundColor: 'rgba(59,130,246,0.1)',
            borderWidth: 3,
            pointBackgroundColor: '#3B82F6',
            pointRadius: 4,
            tension: 0.35,
            fill: true,
            yAxisID: 'yPendaftaran',
            order: 1
          }
        ]
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
                if (context.dataset.yAxisID === 'yPendapatan') {
                  label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                } else {
                  label += context.raw + ' Pendaftaran';
                }
                return label;
              }
            }
          }
        },
        scales: {
          x: { grid: { display: false } },
          yPendapatan: {
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
          },
          yPendaftaran: {
            type: 'linear',
            position: 'right',
            grid: { drawOnChartArea: false },
            ticks: { precision: 0 }
          }
        }
      }
    });
  }

  // 2. Chart Doughnut Status Pembayaran
  const ctxStatus = document.getElementById('chartStatusPembayaran');
  if (ctxStatus) {
    new Chart(ctxStatus, {
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
    new Chart(ctxJenis, {
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
});
</script>
@endpush
