@extends('layouts.admin')
@section('title','Instruktur')
@section('page-title','Instruktur')
@section('page-content')
<div style="padding:20px 24px;">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
    <p style="color:#6B7280;font-size:14px;margin:0;">Daftar instruktur yang mengampu program pelatihan.</p>
    <a href="{{ route('admin.instruktur.create') }}" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;text-decoration:none;">
      @include('components.icon',['name'=>'plus','size'=>14]) Tambah Instruktur
    </a>
  </div>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
    @forelse($instruktur as $ins)
    <div class="fcc-card ch" style="padding:20px 22px;">
      <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:14px;">
        <div style="width:48px;height:48px;border-radius:14px;background:#131218;
            display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
          </svg>
        </div>
        <div style="flex:1;min-width:0;">
          <p style="margin:0 0 2px;font-size:14px;font-weight:800;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $ins->nama }}</p>
          <p style="margin:0;font-size:11px;color:#9CA3B0;">{{ $ins->email }}</p>
        </div>
      </div>
      <div style="background:#F7F8FA;border-radius:8px;padding:9px 12px;margin-bottom:12px;">
        <p style="margin:0;font-size:11px;color:#9CA3B0;margin-bottom:2px;">Keahlian</p>
        <p style="margin:0;font-size:13px;font-weight:600;color:#131218;">{{ $ins->keahlian }}</p>
      </div>
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <span style="font-size:12px;color:#6B7280;">{{ $ins->pelatihan_count }} Program Pelatihan</span>
        <span style="font-size:12px;color:{{ $ins->kelamin==='L'?'#3B82F6':'#EC4899' }};font-weight:600;">
          {{ $ins->kelamin==='L'?'Laki-laki':'Perempuan' }}
        </span>
      </div>
      <div style="display:flex;gap:8px;">
        <a href="{{ route('admin.instruktur.edit', $ins) }}" class="fcc-btn-dark" style="flex:1;justify-content:center;padding:8px;font-size:13px;text-decoration:none;">
          @include('components.icon',['name'=>'edit','size'=>13,'style'=>'color:#FFC81A']) Edit
        </a>
        <form action="{{ route('admin.instruktur.destroy', $ins) }}" method="POST" onsubmit="return confirm('Hapus instruktur ini?')">
          @csrf @method('DELETE')
          <button type="submit" style="padding:8px 12px;border-radius:9px;border:1.5px solid rgba(239,68,68,.25);background:rgba(239,68,68,.06);color:#EF4444;cursor:pointer;display:flex;align-items:center;">
            @include('components.icon',['name'=>'trash','size'=>13])
          </button>
        </form>
      </div>
    </div>
    @empty
    <div style="grid-column:span 3;padding:48px;text-align:center;" class="fcc-card">
      <div style="width:56px;height:56px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
        @include('components.icon',['name'=>'users','size'=>26,'style'=>'color:#9CA3B0'])
      </div>
      <p style="font-size:15px;font-weight:700;color:#131218;margin:0 0 8px;">Belum Ada Instruktur</p>
      <a href="{{ route('admin.instruktur.create') }}" class="fcc-btn-gold" style="padding:10px 22px;font-size:14px;text-decoration:none;">
        @include('components.icon',['name'=>'plus','size'=>14]) Tambah Instruktur
      </a>
    </div>
    @endforelse
  </div>
  @if($instruktur->hasPages())<div style="margin-top:16px;">{{ $instruktur->links() }}</div>@endif
</div>
@endsection
