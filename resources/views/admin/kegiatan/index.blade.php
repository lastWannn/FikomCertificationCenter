@extends('layouts.admin')
@section('title','Kegiatan Aktif')
@section('page-title','Kegiatan Aktif')
@section('page-content')
<div style="padding:20px 24px;">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:12px;">
    <p style="color:#6B7280;font-size:14px;margin:0;">Semua kegiatan yang sedang aktif dan terlihat oleh publik.</p>
    <div style="display:flex;gap:8px;">
      <form method="GET" style="display:flex;gap:8px;">
        <select name="jenis" class="fcc-input" style="width:auto;" onchange="this.form.submit()">
          <option value="">Semua Jenis</option>
          <option value="pelatihan"   {{ request('jenis')==='pelatihan'?'selected':'' }}>Pelatihan</option>
          <option value="sertifikasi" {{ request('jenis')==='sertifikasi'?'selected':'' }}>Sertifikasi</option>
        </select>
      </form>
      <a href="{{ route('admin.jadwal-pelatihan.index') }}" class="fcc-btn-gold" style="padding:9px 16px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'plus','size'=>13]) Jadwal Baru
      </a>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
    @forelse($kegiatan as $k)
    @php $isPel = $k->jenis_kegiatan==='pelatihan'; @endphp
    <div class="fcc-card ch" style="overflow:hidden;">
      {{-- Status bar --}}
      <div style="height:4px;background:{{ $isPel?'linear-gradient(90deg,#FFC81A,#FFD84D)':'linear-gradient(90deg,#3B82F6,#60A5FA)' }};"></div>
      <div style="padding:16px 18px;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
          <span style="font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;
            background:{{ $isPel?'rgba(255,200,26,.14)':'rgba(59,130,246,.12)' }};
            color:{{ $isPel?'#9A7300':'#3B82F6' }};">{{ ucfirst($k->jenis_kegiatan) }}</span>
          @if($k->isFull())
          <span style="font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;background:rgba(239,68,68,.12);color:#EF4444;">Penuh</span>
          @endif
        </div>
        <p style="margin:0 0 6px;font-size:14px;font-weight:800;color:#131218;line-height:1.3;">{{ Str::limit($k->judul,42) }}</p>
        <p style="margin:0 0 12px;font-size:12px;color:#9CA3B0;">
          {{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}
          &bull; {{ $k->jadwal?->jam_mulai ? substr($k->jadwal->jam_mulai, 0, 5) : '' }} &ndash; {{ $k->jadwal?->jam_selesai ? substr($k->jadwal->jam_selesai, 0, 5) : '' }}
        </p>

        {{-- Kuota progress --}}
        <div style="margin-bottom:12px;">
          <div style="display:flex;justify-content:space-between;font-size:11px;color:#9CA3B0;margin-bottom:4px;">
            <span>Peserta Terdaftar</span>
            <span style="font-weight:700;color:#131218;">{{ $k->terisi }}/{{ $k->kuota }}</span>
          </div>
          <div style="height:5px;background:#E2E4EB;border-radius:3px;">
            <div style="height:5px;border-radius:3px;transition:width .3s;
              background:{{ $k->isFull()?'#EF4444':($k->terisi/$k->kuota>0.8?'#F59E0B':'#131218') }};
              width:{{ $k->kuota>0?min(100,round($k->terisi/$k->kuota*100)):0 }}%;"></div>
          </div>
        </div>

        {{-- Biaya --}}
        <div style="background:#F7F8FA;border-radius:8px;padding:8px 12px;display:flex;justify-content:space-between;margin-bottom:14px;">
          <span style="font-size:11px;color:#9CA3B0;">Biaya</span>
          <span style="font-size:13px;font-weight:800;color:#131218;">
            @if($k->biaya->isEmpty()) Gratis
            @else Rp {{ number_format($k->biaya->min('nominal'),0,',','.') }}+
            @endif
          </span>
        </div>

        <div style="display:flex;gap:8px;">
          <a href="{{ route('admin.kegiatan.show', $k) }}" class="fcc-btn-dark" style="flex:1;justify-content:center;padding:8px;font-size:13px;text-decoration:none;">
            @include('components.icon',['name'=>'eye','size'=>13,'style'=>'color:#FFC81A']) Detail
          </a>
          <a href="{{ route('admin.pembayaran.index',['kegiatan_id'=>$k->id]) }}"
             style="display:flex;align-items:center;gap:6px;padding:8px 12px;border-radius:9px;
                    border:1.5px solid #E2E4EB;background:#F7F8FA;font-size:12px;font-weight:700;
                    color:#6B7280;text-decoration:none;transition:all .18s;"
             onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
            @include('components.icon',['name'=>'credit-card','size'=>13])
          </a>
        </div>
      </div>
    </div>
    @empty
    <div style="grid-column:span 3;padding:52px;text-align:center;color:#9CA3B0;" class="fcc-card">
      <div style="width:60px;height:60px;border-radius:18px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
        @include('components.icon',['name'=>'zap','size'=>28,'style'=>'color:#9CA3B0'])
      </div>
      <p style="font-size:15px;font-weight:700;color:#131218;margin:0 0 6px;">Belum Ada Kegiatan Aktif</p>
      <p style="font-size:13px;color:#9CA3B0;margin:0 0 20px;">Aktifkan jadwal pelatihan atau sertifikasi untuk mulai menerima pendaftaran.</p>
      <div style="display:flex;gap:10px;justify-content:center;">
        <a href="{{ route('admin.jadwal-pelatihan.index') }}" class="fcc-btn-dark" style="padding:10px 20px;font-size:13px;text-decoration:none;">
          @include('components.icon',['name'=>'book-open','size'=>14,'style'=>'color:#FFC81A']) Jadwal Pelatihan
        </a>
        <a href="{{ route('admin.jadwal-sertifikasi.index') }}" class="fcc-btn-outline-dark" style="padding:10px 20px;font-size:13px;">
          @include('components.icon',['name'=>'award','size'=>14]) Jadwal Sertifikasi
        </a>
      </div>
    </div>
    @endforelse
  </div>
  @if($kegiatan->hasPages())
  <div style="margin-top:18px;">{{ $kegiatan->withQueryString()->links() }}</div>
  @endif
</div>
@endsection
