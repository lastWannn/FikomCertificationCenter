@extends('layouts.public')
@section('title','Kegiatan')
@section('page-content')
<div style="padding-top:68px;">
    {{-- Page Header --}}
    <div style="background:#131218;padding:52px 24px 44px;position:relative;overflow:hidden;">
        <div style="position:absolute;inset:0;opacity:.04;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div style="max-width:1100px;margin:0 auto;position:relative;z-index:1;">
            <a href="{{ route('landing.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.5);font-size:13px;text-decoration:none;margin-bottom:16px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg> Beranda
            </a>
            <h1 class="fcc-gold-text" style="font-size:clamp(28px,5vw,50px);font-weight:900;margin:0 0 10px;">Kegiatan FCC</h1>
            <p style="color:rgba(255,255,255,.55);font-size:16px;margin:0;">Seluruh program pelatihan dan sertifikasi yang tersedia</p>
        </div>
    </div>
    {{-- Filter --}}
    <div style="background:#FFF;border-bottom:1px solid #E2E4EB;padding:14px 24px;position:sticky;top:68px;z-index:50;">
        <div style="max-width:1100px;margin:0 auto;display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <form method="GET" action="{{ route('landing.kegiatan') }}" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <div style="display:inline-flex;gap:4px;background:#F7F8FA;padding:4px;border-radius:10px;border:1px solid #E2E4EB;">
                    @foreach([['semua','Semua'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
                    <button type="submit" name="jenis" value="{{ $v }}"
                        style="padding:6px 16px;border-radius:8px;border:none;font-size:13px;font-weight:700;cursor:pointer;transition:all .18s;
                               background:{{ request('jenis',$v==='semua'?'semua':'')===($v==='semua'&&!request('jenis')?'semua':$v) ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : 'transparent' }};
                               color:{{ (request('jenis','')===$v || ($v==='semua'&&!request('jenis'))) ? '#111' : '#6B7280' }};">
                        {{ $l }}
                    </button>
                    @endforeach
                </div>
                <div style="position:relative;">
                    <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#A0A3AD;pointer-events:none;" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kegiatan..."
                        class="fcc-input" style="padding-left:34px;width:220px;"
                        onkeydown="if(event.key==='Enter')this.form.submit()">
                </div>
            </form>
        </div>
    </div>
    {{-- Grid --}}
    <div style="padding:32px 24px;max-width:1100px;margin:0 auto;">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:18px;">
            @forelse($kegiatan as $k)
            @php $isPel=$k->jenis_kegiatan==='pelatihan'; @endphp
            <div class="fcc-card" style="overflow:hidden;transition:transform .22s,box-shadow .22s;"
                 onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 36px rgba(0,0,0,.12)'"
                 onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 1px 3px rgba(0,0,0,.05)'">
                <div style="height:140px;position:relative;overflow:hidden;background:linear-gradient(135deg,#1A1920,#131218);">
                    <div style="position:absolute;inset:0;opacity:.12;background-image:linear-gradient(rgba(255,200,26,.2) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,.2) 1px,transparent 1px);background-size:28px 28px;"></div>
                    <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                        @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>38,'style'=>'color:rgba(255,200,26,.35)'])
                    </div>
                    <div style="position:absolute;top:10px;left:10px;"><span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:5px;background:{{ $isPel?'rgba(255,200,26,.85)':'rgba(20,20,20,.85)' }};color:{{ $isPel?'#111':'#FFF' }};">{{ ucfirst($k->jenis_kegiatan) }}</span></div>
                    @if($k->isFull())<div style="position:absolute;top:10px;right:10px;"><span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:5px;background:rgba(239,68,68,.85);color:#FFF;">Penuh</span></div>@endif
                </div>
                <div style="padding:16px 18px;">
                    <p style="color:#0F0F14;font-size:14px;font-weight:800;margin:0 0 6px;line-height:1.35;">{{ Str::limit($k->judul,40) }}</p>
                    <div style="display:flex;flex-direction:column;gap:3px;margin-bottom:10px;">
                        <p style="color:#6B7280;font-size:12px;margin:0;display:flex;align-items:center;gap:5px;">
                            @include('components.icon',['name'=>'calendar','size'=>11,'style'=>'color:#FFC81A'])
                            {{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}
                        </p>
                        <p style="color:#6B7280;font-size:12px;margin:0;display:flex;align-items:center;gap:5px;">
                            @include('components.icon',['name'=>'users','size'=>11,'style'=>'color:#FFC81A'])
                            {{ $k->terisi }}/{{ $k->kuota }} peserta
                        </p>
                    </div>
                    <div style="background:#F7F8FA;border-radius:8px;padding:8px 12px;display:flex;justify-content:space-between;margin-bottom:12px;">
                        <span style="color:#6B7280;font-size:11px;">Mulai dari</span>
                        <span style="color:#FFC81A;font-weight:900;font-size:13px;">{{ $k->biaya->isNotEmpty() ? 'Rp '.number_format($k->biaya->min('nominal'),0,',','.') : 'Gratis' }}</span>
                    </div>
                    <a href="{{ route('landing.show', $k) }}"
                       class="{{ $k->isFull() ? '' : 'fcc-btn-gold' }}"
                       style="display:block;text-align:center;text-decoration:none;padding:9px;border-radius:9px;font-size:14px;font-weight:700;
                              {{ $k->isFull() ? 'background:rgba(100,100,100,.08);border:1px solid #E2E4EB;color:#A0A3AD;cursor:not-allowed;' : '' }}">
                        {{ $k->isFull() ? 'Kuota Penuh' : 'Lihat Detail' }}
                    </a>
                </div>
            </div>
            @empty
            <div style="grid-column:span 3;padding:48px;text-align:center;color:#A0A3AD;font-size:15px;">
                Belum ada kegiatan yang sesuai kriteria.
            </div>
            @endforelse
        </div>
        @if($kegiatan->hasPages())
        <div style="margin-top:28px;">{{ $kegiatan->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
