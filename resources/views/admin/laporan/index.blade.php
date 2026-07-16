@extends('layouts.admin')
@section('title','Laporan & Statistik')
@section('page-title','Laporan & Statistik')
@section('page-content')
<div style="padding:20px 24px;">
  {{-- Filter --}}
  <form method="GET" style="display:flex;gap:10px;align-items:center;margin-bottom:20px;flex-wrap:wrap;">
    <select name="tahun" class="fcc-input" style="width:auto;">
      @foreach($availableYears as $y)
      <option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>{{ $y }}</option>
      @endforeach
    </select>
    <select name="bulan" class="fcc-input" style="width:auto;">
      <option value="">Semua Bulan</option>
      @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $v=>$l)
      <option value="{{ $v }}" {{ $bulan==$v?'selected':'' }}>{{ $l }}</option>
      @endforeach
    </select>
    <button type="submit" class="fcc-btn-dark" style="padding:10px 20px;font-size:13px;">
      @include('components.icon',['name'=>'filter','size'=>13,'style'=>'color:#FFC81A']) Filter
    </button>
    <a href="{{ route('admin.laporan.export-csv') }}" class="fcc-btn-gold" style="padding:10px 18px;font-size:13px;text-decoration:none;margin-left:auto;">
      @include('components.icon',['name'=>'download','size'=>13]) Export CSV
    </a>
  </form>

  {{-- Summary cards --}}
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">
    @foreach([
      ['Total Peserta',       number_format($summary['total_peserta']),                'users',        '#3B82F6'],
      ['Total Pendaftaran',   number_format($summary['total_pendaftaran']),             'clipboard-list','#10B981'],
      ['Terverifikasi',       number_format($summary['total_terverifikasi']),           'check',        '#131218'],
      ['Total Pendapatan',    'Rp '.number_format($summary['total_pendapatan'],0,',','.'),'credit-card','#FFC81A'],
    ] as [$l,$v,$ic,$c])
    <div class="fcc-card" style="padding:18px 20px;border-left:4px solid {{ $c }};">
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
        <div style="width:36px;height:36px;border-radius:10px;background:{{ $c=='#131218'?'#131218':$c.'18' }};display:flex;align-items:center;justify-content:center;">
          @include('components.icon',['name'=>$ic,'size'=>17,'style'=>"color:".($c=='#131218'?'#FFC81A':$c)])
        </div>
        <p style="margin:0;font-size:11px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">{{ $l }}</p>
      </div>
      <p style="margin:0;font-size:24px;font-weight:900;color:#131218;">{{ $v }}</p>
    </div>
    @endforeach
  </div>

  <div style="display:grid;grid-template-columns:3fr 2fr;gap:16px;">
    {{-- Chart pendapatan --}}
    <div class="fcc-card" style="padding:20px;">
      <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 18px;">Pendapatan Bulanan {{ $tahun }}</p>
      @php
      $bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
      $maxPendapatan = $pendapatan->max('total') ?: 1;
      @endphp
      <div style="display:flex;align-items:flex-end;gap:6px;height:160px;">
        @for($b=1;$b<=12;$b++)
        @php $data = $pendapatan->firstWhere('bulan',$b); $height = $data ? round(($data->total/$maxPendapatan)*100) : 0; @endphp
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;">
          <p style="margin:0;font-size:9px;color:#9CA3B0;font-weight:700;">
            {{ $data ? 'Rp '.number_format($data->total/1000).'k' : '' }}
          </p>
          <div style="width:100%;border-radius:4px 4px 0 0;min-height:4px;
            background:{{ $height > 0 ? 'linear-gradient(to top,#131218,#1C1B22)' : '#F0F1F5' }};
            height:{{ $height }}%;"
            onmouseover="this.style.background='linear-gradient(to top,#FFC81A,#FFD84D)'"
            onmouseout="this.style.background='{{ $height > 0 ? 'linear-gradient(to top,#131218,#1C1B22)' : '#F0F1F5' }}'">
          </div>
          <p style="margin:0;font-size:9px;color:#9CA3B0;">{{ $bulanLabels[$b-1] }}</p>
        </div>
        @endfor
      </div>
    </div>

    {{-- Top kegiatan --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;">
      <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;">
        <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">Kegiatan Paling Diminati</p>
      </div>
      @foreach($perKegiatan as $i=>$k)
      <div style="display:flex;align-items:center;gap:12px;padding:11px 16px;border-top:1px solid #F0F1F5;">
        <div style="width:26px;height:26px;border-radius:7px;flex-shrink:0;
          background:{{ $i===0?'linear-gradient(135deg,#FFC81A,#FFD84D)':($i===1?'linear-gradient(135deg,#9CA3B0,#CBD5E1)':($i===2?'rgba(180,120,60,.15)':'#F7F8FA')) }};
          display:flex;align-items:center;justify-content:center;
          font-size:11px;font-weight:900;color:{{ $i<3?($i===0?'#131218':'#6B7280'):'#9CA3B0' }};">
          {{ $i+1 }}
        </div>
        <div style="flex:1;min-width:0;">
          <p style="margin:0;font-size:12px;font-weight:700;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $k->judul }}</p>
          <p style="margin:0;font-size:10px;color:#9CA3B0;">{{ ucfirst($k->jenis_kegiatan) }}</p>
        </div>
        <span style="font-size:13px;font-weight:900;color:#131218;white-space:nowrap;">{{ $k->pendaftaran_count }}</span>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
