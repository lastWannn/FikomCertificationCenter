@extends('layouts.admin')
@section('title','No. Rekening')
@section('page-content')
<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <div>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Nomor Rekening</h1>
            <p style="color:#6B7280;font-size:14px;margin:0;">Kelola rekening tujuan pembayaran. Hanya satu yang aktif.</p>
        </div>
        <a href="{{ route('admin.rekening.create') }}" class="fcc-btn-gold" style="padding:9px 20px;font-size:14px;text-decoration:none;">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Rekening
        </a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
        @forelse($rekening as $r)
        <div class="fcc-card" style="padding:22px;{{ $r->is_active?'border-color:#FFC81A;background:rgba(255,200,26,.02);':'' }}">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px;">
                <div style="width:44px;height:44px;border-radius:12px;background:{{ $r->is_active?'rgba(255,200,26,.15)':'rgba(100,100,100,.08)' }};border:1px solid {{ $r->is_active?'rgba(255,200,26,.3)':'#E2E4EB' }};display:flex;align-items:center;justify-content:center;">
                    @include('components.icon',['name'=>'wallet','size'=>20,'style'=>"color:".($r->is_active?'#FFC81A':'#A0A3AD')])
                </div>
                @if($r->is_active)
                <span style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;background:rgba(255,200,26,.15);color:#B38F00;">&#9733; Aktif</span>
                @endif
            </div>
            <p style="font-size:16px;font-weight:900;color:#0F0F14;margin:0 0 4px;">{{ $r->bank }}</p>
            <p style="font-size:18px;font-weight:800;color:#FFC81A;font-family:monospace;margin:0 0 4px;letter-spacing:1px;">{{ $r->no_rekening }}</p>
            <p style="font-size:13px;color:#6B7280;margin:0 0 16px;">a.n. {{ $r->nama_pemilik }}</p>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                @if(!$r->is_active)
                <form action="{{ route('admin.rekening.aktifkan', $r) }}" method="POST" style="flex:1;">
                    @csrf
                    <button type="submit" style="width:100%;padding:7px;border-radius:8px;border:1.5px solid rgba(255,200,26,.3);background:rgba(255,200,26,.08);color:#B38F00;font-size:12px;font-weight:700;cursor:pointer;">Aktifkan</button>
                </form>
                @endif
                <a href="{{ route('admin.rekening.edit', $r) }}" style="flex:1;display:block;text-align:center;padding:7px;border-radius:8px;border:1px solid #E2E4EB;color:#6B7280;font-size:12px;font-weight:700;text-decoration:none;">Edit</a>
                <form action="{{ route('admin.rekening.destroy', $r) }}" method="POST" onsubmit="return confirm('Hapus rekening ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="padding:7px 10px;border-radius:8px;border:1px solid rgba(239,68,68,.3);background:rgba(239,68,68,.08);color:#EF4444;font-size:12px;cursor:pointer;">
                        @include('components.icon',['name'=>'trash','size'=>13])
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="grid-column:span 3;padding:48px;text-align:center;color:#A0A3AD;" class="fcc-card">Belum ada rekening terdaftar.</div>
        @endforelse
    </div>
</div>
@endsection
