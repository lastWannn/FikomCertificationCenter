@extends('layouts.admin')
@section('title','Informasi & FAQ')
@section('page-content')
<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0;">Informasi & FAQ</h1>
        <div style="display:flex;gap:10px;align-items:center;">
            <form method="GET" style="display:flex;gap:6px;">
                <select name="jenis" class="fcc-input" style="width:auto;" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="info" {{ request('jenis')==='info'?'selected':'' }}>Informasi</option>
                    <option value="faq" {{ request('jenis')==='faq'?'selected':'' }}>FAQ</option>
                </select>
            </form>
            <a href="{{ route('admin.informasi.create') }}" class="fcc-btn-gold" style="padding:9px 20px;font-size:14px;text-decoration:none;">
                @include('components.icon',['name'=>'plus','size'=>15]) Tambah
            </a>
        </div>
    </div>
    <div style="display:flex;flex-direction:column;gap:12px;">
        @forelse($informasi as $i)
        <div class="fcc-card" style="padding:20px 24px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                        <span style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;background:{{ $i->jenis==='faq'?'rgba(59,130,246,.15)':'rgba(16,185,129,.12)' }};color:{{ $i->jenis==='faq'?'#3B82F6':'#10B981' }};">{{ strtoupper($i->jenis) }}</span>
                        <span style="font-size:11px;color:#A0A3AD;">{{ $i->created_at->format('d M Y') }}</span>
                    </div>
                    <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 6px;">{{ $i->judul }}</h3>
                    <p style="color:#6B7280;font-size:13px;line-height:1.6;margin:0;">{{ Str::limit(strip_tags($i->isi),120) }}</p>
                </div>
                <div style="display:flex;gap:8px;flex-shrink:0;">
                    <a href="{{ route('admin.informasi.edit', $i) }}" style="color:#FFC81A;display:flex;padding:4px;">@include('components.icon',['name'=>'edit','size'=>16])</a>
                    <form action="{{ route('admin.informasi.destroy', $i) }}" method="POST" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#EF4444;display:flex;padding:4px;">@include('components.icon',['name'=>'trash','size'=>16])</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="fcc-card" style="padding:48px;text-align:center;color:#A0A3AD;">Belum ada informasi.</div>
        @endforelse
    </div>
</div>
@endsection
