@extends('layouts.peserta')
@section('title','Jelajahi Kegiatan')
@section('page-title','Jelajahi Kegiatan')
@section('page-content')
<div style="padding:24px;">
    {{-- Search + Filter --}}
    <form method="GET" action="{{ route('peserta.jelajahi') }}" style="display:flex;gap:10px;margin-bottom:22px;align-items:center;flex-wrap:wrap;">
        <div style="flex:1;min-width:200px;position:relative;">
            <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#A0A3AD;pointer-events:none;" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kegiatan..." class="fcc-input" style="padding-left:36px;"
                   onkeydown="if(event.key==='Enter')this.form.submit()">
        </div>
        <div style="display:inline-flex;gap:4px;background:#F7F8FA;padding:4px;border-radius:10px;border:1px solid #E2E4EB;">
            @foreach([['semua','Semua'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
            <button type="submit" name="jenis" value="{{ $v }}"
                style="padding:6px 14px;border-radius:8px;border:none;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;
                       background:{{ (request('jenis')===$v || (!request('jenis')&&$v==='semua')) ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : 'transparent' }};
                       color:{{ (request('jenis')===$v || (!request('jenis')&&$v==='semua')) ? '#111' : '#6B7280' }};">
                {{ $l }}
            </button>
            @endforeach
        </div>
    </form>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
        @forelse($kegiatan as $k)
        @php $sudah=in_array($k->id,$sudahDaftar); $isPel=$k->jenis_kegiatan==='pelatihan'; @endphp
        <div class="fcc-card" style="overflow:hidden;transition:transform .22s,box-shadow .22s;"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 30px rgba(0,0,0,.1)'"
             onmouseout="this.style.transform='translateY(0)';this.style.boxShadow=''">
            <div style="height:130px;position:relative;background:linear-gradient(135deg,#131218,#1A1920);">
                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                    @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>36,'style'=>'color:rgba(255,200,26,.35)'])
                </div>
                <div style="position:absolute;top:8px;left:8px;"><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:4px;background:{{ $isPel?'rgba(255,200,26,.85)':'rgba(20,20,20,.85)' }};color:{{ $isPel?'#111':'#FFF' }};">{{ ucfirst($k->jenis_kegiatan) }}</span></div>
                @if($sudah)<div style="position:absolute;top:8px;right:8px;"><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:4px;background:rgba(16,185,129,.85);color:#FFF;">&#10003; Terdaftar</span></div>@endif
                @if($k->isFull()&&!$sudah)<div style="position:absolute;top:8px;right:8px;"><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:4px;background:rgba(239,68,68,.85);color:#FFF;">Penuh</span></div>@endif
            </div>
            <div style="padding:14px 16px;">
                <p style="font-size:14px;font-weight:800;color:#0F0F14;margin:0 0 4px;line-height:1.35;">{{ Str::limit($k->judul,38) }}</p>
                <p style="font-size:11px;color:#A0A3AD;margin:0 0 8px;">{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }} &bull; {{ $k->terisi }}/{{ $k->kuota }}</p>
                <p style="font-size:13px;color:#FFC81A;font-weight:800;margin:0 0 12px;">{{ $k->biaya->isNotEmpty() ? 'Rp '.number_format($k->biaya->min('nominal'),0,',','.') : 'Gratis' }}</p>
                @if($sudah)
                <a href="{{ route('peserta.pendaftaran') }}" style="display:block;text-align:center;padding:8px;border-radius:9px;border:1.5px solid #10B981;color:#10B981;font-size:13px;font-weight:700;text-decoration:none;">&#10003; Sudah Terdaftar</a>
                @elseif($k->isFull())
                <button disabled style="width:100%;padding:8px;border-radius:9px;border:1px solid #E2E4EB;background:rgba(100,100,100,.08);color:#A0A3AD;font-size:13px;font-weight:700;cursor:not-allowed;">Kuota Penuh</button>
                @else
                <button onclick="showDaftarModal('{{ $k->hashid }}', '{{ addslashes($k->judul) }}', {{ $k->biaya->toJson() }})"
                    class="fcc-btn-gold" style="width:100%;justify-content:center;padding:8px;font-size:13px;">Daftar</button>
                @endif
            </div>
        </div>
        @empty
        <div style="grid-column:span 3;text-align:center;padding:48px;color:#A0A3AD;font-size:15px;">Tidak ada kegiatan ditemukan.</div>
        @endforelse
    </div>
    @if($kegiatan->hasPages())
    <div style="margin-top:24px;">{{ $kegiatan->withQueryString()->links() }}</div>
    @endif
</div>

{{-- Modal Daftar --}}
<div id="daftar-modal" style="display:none;position:fixed;inset:0;z-index:2000;background:rgba(0,0,0,.5);backdrop-filter:blur(4px);display:none;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#FFF;border-radius:18px;max-width:420px;width:100%;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.2);">
        <div style="background:linear-gradient(135deg,#131218,#1A1920);padding:22px 24px;display:flex;justify-content:space-between;align-items:center;">
            <div>
                <p style="margin:0;color:#FFF;font-weight:800;font-size:16px;">Konfirmasi Pendaftaran</p>
                <p style="margin:4px 0 0;color:rgba(255,255,255,.5);font-size:12px;" id="modal-judul"></p>
            </div>
            <button onclick="closeDaftarModal()" style="background:rgba(255,255,255,.1);border:none;border-radius:8px;color:rgba(255,255,255,.7);padding:6px 8px;cursor:pointer;display:flex;">
                @include('components.icon',['name'=>'x','size'=>16])
            </button>
        </div>
        <form id="daftar-form" method="POST" style="padding:22px 24px;">
            @csrf
            <div id="biaya-section"></div>
            <button type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:12px;font-size:15px;">
                @include('components.icon',['name'=>'check','size'=>16]) Konfirmasi Pendaftaran
            </button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
@vite('resources/js/pages/landing-jelajahi.js')
@endpush
