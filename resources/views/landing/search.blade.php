@extends('layouts.public')
@section('title','Hasil Pencarian')
@section('page-content')
<div class="page-content-wrap" style="padding-top:68px;">
  <div style="background:#131218;padding:40px 24px 32px;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;opacity:.04;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:64px 64px;"></div>
    <div style="max-width:900px;margin:0 auto;position:relative;z-index:1;">
      <p style="color:rgba(255,255,255,.5);font-size:13px;margin:0 0 12px;">
        Menampilkan hasil untuk:
      </p>
      <h1 style="color:#FFF;font-size:clamp(20px,3.5vw,32px);font-weight:900;margin:0 0 18px;">"<span class="fcc-gold-text">{{ $q }}</span>"</h1>
      {{-- Search bar --}}
      <form action="{{ route('landing.search') }}" method="GET" id="search-form" style="display:flex;gap:8px;max-width:600px;">
        <div style="position:relative;flex:1;">
          <svg style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.4);pointer-events:none;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" name="q" value="{{ $q }}" id="main-search" placeholder="Cari kegiatan..." autocomplete="off"
                 class="fcc-input" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#FFF;padding-left:42px;"
                 onkeydown="if(event.key==='Enter'){event.preventDefault();this.form.submit();}">
          <div id="search-dropdown" style="display:none;position:absolute;top:100%;left:0;right:0;margin-top:4px;background:#FFF;border-radius:12px;box-shadow:0 12px 36px rgba(0,0,0,.18);z-index:200;overflow:hidden;max-height:360px;overflow-y:auto;"></div>
        </div>
        <button type="submit" class="fcc-btn-gold" style="padding:0 20px;font-size:14px;flex-shrink:0;">Cari</button>
      </form>
    </div>
  </div>

  <div style="max-width:900px;margin:0 auto;padding:32px 24px;">
    @if($kegiatan->isEmpty())
    <div style="text-align:center;padding:56px 0;">
      <div style="width:64px;height:64px;border-radius:18px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
        @include('components.icon',['name'=>'search','size'=>28,'style'=>'color:#C0C4CF'])
      </div>
      <p style="font-size:18px;font-weight:900;color:#131218;margin:0 0 8px;">Tidak Ada Hasil</p>
      <p style="color:#9CA3B0;font-size:14px;margin:0 0 22px;">Tidak ada kegiatan yang cocok dengan "<strong>{{ $q }}</strong>".</p>
      <a href="{{ route('landing.kegiatan') }}" class="fcc-btn-dark" style="padding:10px 22px;font-size:14px;text-decoration:none;">
        @include('components.icon',['name'=>'list','size'=>13,'style'=>'color:#FFC81A']) Lihat Semua Kegiatan
      </a>
    </div>
    @else
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
      <p style="font-size:15px;color:#6B7280;margin:0;"><span style="font-weight:800;color:#131218;">{{ $kegiatan->count() }}</span> hasil ditemukan</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
      @foreach($kegiatan as $k)
      <a href="{{ route('landing.show', $k) }}" style="text-decoration:none;">
        <div class="fcc-card ch" style="padding:18px 20px;">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
            <div style="width:36px;height:36px;border-radius:10px;background:#131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              @include('components.icon',['name'=>$k->jenis_kegiatan==='pelatihan'?'book-open':'award','size'=>16,'style'=>'color:#FFC81A'])
            </div>
            <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $k->jenis_kegiatan==='pelatihan'?'rgba(255,200,26,.14)':'rgba(59,130,246,.12)' }};color:{{ $k->jenis_kegiatan==='pelatihan'?'#9A7300':'#3B82F6' }};">{{ ucfirst($k->jenis_kegiatan) }}</span>
          </div>
          <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 6px;line-height:1.35;">{{ $k->judul }}</p>
          <p style="font-size:12px;color:#9CA3B0;margin:0 0 12px;">{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}</p>
          <div style="display:flex;justify-content:space-between;align-items:center;padding-top:10px;border-top:1px solid #E2E4EB;">
            <span style="font-size:13px;font-weight:800;color:#131218;">
              {{ $k->biaya->isEmpty() ? 'Gratis' : 'Rp '.number_format($k->biaya->min('nominal'),0,',','.') }}
            </span>
            <span style="font-size:12px;color:#FFC81A;font-weight:700;">Detail &rarr;</span>
          </div>
        </div>
      </a>
      @endforeach
    </div>
    @endif
  </div>
</div>
@endsection
@push('scripts')
@vite('resources/js/pages/landing-search.js')
@endpush
