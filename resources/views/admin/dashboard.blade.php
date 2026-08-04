@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('page-content')
<div style="padding:20px 24px;">

  {{-- Stat cards --}}
  <div id="stats-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px;">
    @foreach([
      ['Pelatihan',   $stats['pelatihan'],   '+', 'book-open',   '#FFC81A', route('admin.pelatihan.index')],
      ['Sertifikasi', $stats['sertifikasi'], '+', 'award',       '#3B82F6', route('admin.sertifikasi.index')],
      ['Peserta',     $stats['peserta'],     '',  'users',       '#10B981', route('admin.pengguna.peserta')],
      ['Pendapatan',  'Rp '.number_format($stats['pendapatan'],0,',','.'), '', 'credit-card', '#9333EA', route('admin.laporan.index')],
    ] as [$lbl,$val,$suf,$ic,$c,$link])
    <a href="{{ $link }}" style="text-decoration:none;display:flex;flex-direction:column;" class="ch">
      <div class="fcc-card" style="padding:18px 20px;border-left:4px solid {{ $c }};height:100%;display:flex;flex-direction:column;justify-content:space-between;min-height:128px;box-sizing:border-box;">
        <div>
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
            <p style="color:#9CA3B0;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;margin:0;">{{ $lbl }}</p>
            <div style="width:36px;height:36px;border-radius:10px;background:{{ $c }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              @include('components.icon',['name'=>$ic,'size'=>17,'style'=>"color:{$c}"])
            </div>
          </div>
          <p style="margin:0;color:#131218;font-size:26px;font-weight:900;letter-spacing:-.5px;">{{ $val }}{{ $suf }}</p>
        </div>
        <p id="stat-delta-{{ $loop->index }}" style="margin:6px 0 0;font-size:11px;color:#9CA3B0;min-height:16px;line-height:16px;"></p>
      </div>
    </a>
    @endforeach
  </div>

  {{-- Pending banner --}}
  @php $pendingBayar = \App\Models\Pembayaran::where('status_pembayaran','menunggu_verifikasi')->count(); @endphp
  @if($pendingBayar > 0)
  <div style="background:rgba(255,200,26,.08);border:1.5px solid rgba(255,200,26,.3);border-radius:12px;padding:14px 18px;margin-bottom:18px;display:flex;align-items:center;gap:12px;">
    <div style="width:36px;height:36px;border-radius:10px;background:#FFC81A;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    </div>
    <div style="flex:1;"><p style="margin:0;font-weight:800;color:#131218;">{{ $pendingBayar }} pembayaran menunggu verifikasi</p></div>
    <a href="{{ route('admin.pembayaran.index',['status'=>'menunggu_verifikasi']) }}" class="fcc-btn-gold" style="padding:8px 18px;font-size:13px;text-decoration:none;flex-shrink:0;">Verifikasi</a>
  </div>
  @endif

  {{-- Passed / Expired Activities Banner --}}
  @php
    $passedKegiatans = \App\Models\Kegiatan::passed()->doesntHave('arsip')->with(['kegiatanPelatihan.jadwalPelatihan.pelatihan', 'kegiatanSertifikasi.jadwalSertifikasi.sertifikasi'])->get();
  @endphp
  @if($passedKegiatans->count() > 0)
  <div style="background:#FFFBEB;border:1.5px solid #FDE68A;border-radius:12px;padding:16px 20px;margin-bottom:18px;">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:10px;flex-wrap:wrap;">
      <div style="display:flex;align-items:center;gap:12px;">
        <div style="width:38px;height:38px;border-radius:10px;background:#F59E0B;display:flex;align-items:center;justify-content:center;color:#FFF;font-weight:900;font-size:18px;flex-shrink:0;">
          ⚠
        </div>
        <div>
          <h4 style="margin:0;font-weight:800;color:#92400E;font-size:14.5px;">Pemberitahuan: {{ $passedKegiatans->count() }} Kegiatan Telah Melewati Tanggal Pelaksanaan</h4>
          <p style="margin:2px 0 0;font-size:12px;color:#B45309;">Silakan perpanjang pendaftaran/jadwal kegiatan atau tandai sebagai selesai (Arsipkan).</p>
        </div>
      </div>
      <a href="{{ route('admin.kegiatan.index') }}" class="fcc-btn-gold" style="padding:8px 16px;font-size:12.5px;text-decoration:none;flex-shrink:0;background:#F59E0B;color:#FFF;border:none;border-radius:8px;font-weight:800;">
        Kelola Kegiatan →
      </a>
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:10px;">
      @foreach($passedKegiatans->take(4) as $pk)
      @php
        $detail = $pk->detail;
        $editUrl = $pk->jenis_kegiatan === 'pelatihan' ? ($detail ? route('admin.pelatihan.edit', $detail) : '#') : ($detail ? route('admin.sertifikasi.edit', $detail) : '#');
      @endphp
      <div style="background:#FFF;border:1px solid #FCD34D;border-radius:8px;padding:8px 12px;font-size:12px;display:flex;align-items:center;gap:10px;">
        <span style="font-weight:800;color:#131218;">{{ $pk->judul }}</span>
        <span style="color:#D97706;font-size:11px;font-weight:600;">(Lewat {{ $pk->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Tgl' }})</span>
        <div style="display:flex;gap:6px;">
          <a href="{{ $editUrl }}" style="color:#2563EB;font-size:11px;font-weight:800;text-decoration:none;background:#EFF6FF;padding:2px 8px;border-radius:5px;border:1px solid #BFDBFE;">Perpanjang</a>
          <a href="{{ route('admin.arsip.create', ['kegiatan_id' => $pk->id]) }}" style="color:#059669;font-size:11px;font-weight:800;text-decoration:none;background:#ECFDF5;padding:2px 8px;border-radius:5px;border:1px solid #A7F3D0;">Arsipkan</a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- Charts + Pembayaran --}}
  <div style="display:grid;grid-template-columns:3fr 2fr;gap:16px;margin-bottom:16px;">
    {{-- Chart pendapatan --}}
    <div class="fcc-card" style="padding:22px;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
        <div>
          <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 2px;">Pendapatan Bulanan</p>
          <p style="font-size:11px;color:#9CA3B0;margin:0;" id="chart-year-label">{{ date('Y') }}</p>
        </div>
        <select id="chart-year" class="fcc-input" style="width:auto;font-size:12px;padding:6px 10px;" onchange="loadCharts()">
          @foreach(range(date('Y'),date('Y')-3) as $y)
          <option value="{{ $y }}" {{ date('Y')==$y?'selected':'' }}>{{ $y }}</option>
          @endforeach
        </select>
      </div>
      <div style="position:relative;height:200px;">
        <canvas id="chartPendapatan"></canvas>
      </div>
    </div>

    {{-- Pembayaran menunggu --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;">
      <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;align-items:center;">
        <p style="font-size:14px;font-weight:800;color:#131218;margin:0;">Menunggu Verifikasi</p>
        @if($pendingBayar)<span style="background:#FFC81A;color:#131218;font-size:10px;font-weight:900;padding:2px 8px;border-radius:20px;">{{ $pendingBayar }}</span>@endif
      </div>
      @forelse($pembayaranMenunggu as $p)
      <a href="{{ route('admin.pembayaran.show', $p) }}" style="display:flex;align-items:center;gap:10px;padding:12px 16px;border-top:1px solid #F0F1F5;text-decoration:none;transition:background .18s;" onmouseover="this.style.background='#F7F8FA'" onmouseout="this.style.background=''">
        <div style="width:34px;height:34px;border-radius:10px;background:#131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div style="flex:1;min-width:0;">
          <p style="margin:0;font-size:13px;font-weight:700;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p->pendaftaran->peserta->nama }}</p>
          <p style="margin:0;font-size:10px;color:#9CA3B0;">{{ Str::limit($p->pendaftaran->kegiatan->judul,26) }}</p>
        </div>
        <p style="margin:0;font-size:13px;font-weight:900;color:#FFC81A;white-space:nowrap;">{{ $p->jumlah_bayar_format }}</p>
      </a>
      @empty
      <div style="padding:24px;text-align:center;color:#9CA3B0;font-size:13px;">Tidak ada pembayaran menunggu.</div>
      @endforelse
    </div>
  </div>

  {{-- Chart pendaftaran + Pie kegiatan --}}
  <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px;">
    <div class="fcc-card" style="padding:22px;">
      <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 18px;">Pendaftaran Bulanan</p>
      <div style="position:relative;height:180px;">
        <canvas id="chartPendaftaran"></canvas>
      </div>
    </div>
    <div class="fcc-card" style="padding:22px;">
      <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 18px;">Jenis Kegiatan</p>
      <div style="position:relative;height:150px;">
        <canvas id="chartJenis"></canvas>
      </div>
      <div id="jenis-legend" style="display:flex;gap:16px;justify-content:center;margin-top:12px;"></div>
    </div>
  </div>

  {{-- Kegiatan terbaru --}}
  <div class="fcc-card" style="padding:0;overflow:hidden;">
    <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;align-items:center;">
      <p style="font-size:14px;font-weight:800;color:#131218;margin:0;">Kegiatan Aktif Terbaru</p>
      <a href="{{ route('admin.kegiatan.index') }}" style="font-size:12px;color:#FFC81A;font-weight:700;text-decoration:none;">Lihat semua &rarr;</a>
    </div>
    <table style="width:100%;border-collapse:collapse;">
      <thead><tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
        @foreach(['Kegiatan','Peserta','Tgl','Aksi'] as $h)
        <th style="padding:9px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">{{ $h }}</th>
        @endforeach
      </tr></thead>
      <tbody>
        @forelse($kegiatanTerbaru as $k)
        <tr class="tbl-row" style="border-top:1px solid #F0F1F5;">
          <td style="padding:11px 14px;">
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $k->judul }}</p>
            <span style="font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;background:{{ $k->jenis_kegiatan==='pelatihan'?'rgba(255,200,26,.14)':'rgba(59,130,246,.12)' }};color:{{ $k->jenis_kegiatan==='pelatihan'?'#9A7300':'#3B82F6' }};">{{ ucfirst($k->jenis_kegiatan) }}</span>
          </td>
          <td style="padding:11px 14px;">
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ $k->terisi }}/{{ $k->kuota }}</p>
            <div style="width:80px;height:4px;background:#E2E4EB;border-radius:2px;margin-top:4px;">
              <div style="height:4px;border-radius:2px;background:{{ $k->isFull()?'#EF4444':'#131218' }};width:{{ $k->kuota>0?min(100,round($k->terisi/$k->kuota*100)):0 }}%;"></div>
            </div>
          </td>
          <td style="padding:11px 14px;font-size:12px;color:#9CA3B0;">{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? '—' }}</td>
          <td style="padding:11px 14px;">
            <a href="{{ route('admin.kegiatan.show', $k) }}" style="color:#FFC81A;font-size:12px;font-weight:700;text-decoration:none;">Detail &rarr;</a>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" style="padding:20px;text-align:center;color:#9CA3B0;font-size:13px;">Belum ada kegiatan.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
@push('page-data')
<script>
window.PAGE_DATA = {!! json_encode([
    'api' => [
        'base'  => url('/admin/api'),
        'stats' => route('admin.api.chart.stats'),
    ],
]) !!};
</script>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@vite('resources/js/pages/admin-dashboard.js')
@endpush
