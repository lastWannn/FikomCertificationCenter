@extends('layouts.admin')
@section('title','Input Nilai')
@section('page-title','Input Nilai Peserta')
@section('page-content')
<div style="padding:20px 24px;max-width:760px;">
  <a href="{{ route('admin.nilai.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:16px;">
    @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
  </a>
  <div class="fcc-card" style="padding:22px;margin-bottom:14px;">
    <div style="display:flex;align-items:center;gap:14px;">
      <div style="width:44px;height:44px;border-radius:12px;background:#131218;display:flex;align-items:center;justify-content:center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </div>
      <div>
        <p style="margin:0;font-size:16px;font-weight:900;color:#131218;">{{ $pendaftaran->peserta->nama }}</p>
        <p style="margin:0;font-size:12px;color:#9CA3B0;">{{ $pendaftaran->kegiatan->judul }}</p>
      </div>
    </div>
  </div>
  @php
    $jadwal = $pendaftaran->kegiatan?->jadwal;
    $belumDimulai = $jadwal && $jadwal->tgl_pelaksanaan && \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->gt(now()->startOfDay());
  @endphp
  @if($belumDimulai)
  <div style="margin-bottom:14px;padding:14px 18px;background:#FFFDF5;border:1.5px solid #FCD34D;border-radius:14px;display:flex;align-items:center;gap:12px;">
    @include('components.icon',['name'=>'alert-circle','size'=>20,'style'=>'color:#D97706;flex-shrink:0;'])
    <div>
      <p style="margin:0;font-size:13.5px;font-weight:900;color:#92400E;">Pelaksanaan Kegiatan Belum Dimulai</p>
      <p style="margin:2px 0 0;font-size:12px;color:#B45309;font-weight:600;">Jadwal pelaksanaan kegiatan ini adalah <strong>{{ \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d F Y') }}</strong>. Penginputan nilai baru dapat dilakukan saat atau setelah tanggal pelaksanaan.</p>
    </div>
  </div>
  @endif
  <div class="fcc-card" style="padding:22px;">
    <form action="{{ route('admin.nilai.store', $pendaftaran) }}" method="POST">
      @csrf
      @php
      $isPel = $pendaftaran->kegiatan->jenis_kegiatan === 'pelatihan';
      $materiList = $isPel
          ? $pendaftaran->kegiatan->kegiatanPelatihan?->jadwalPelatihan?->pelatihan?->materi ?? collect()
          : $pendaftaran->kegiatan->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi?->materi ?? collect();
      $prefix = $isPel ? 'pel' : 'sert';
      @endphp
      @forelse($materiList as $m)
      @php $existingNilai = $pendaftaran->nilai->where($isPel?'materi_pelatihan_id':'materi_sertifikasi_id',$m->id)->first(); @endphp
      <div style="display:flex;align-items:center;gap:16px;padding:12px 0;border-top:1px solid #F0F1F5;">
        <div style="flex:1;">
          <p style="margin:0;font-size:14px;font-weight:700;color:#131218;">{{ $m->urutan }}. {{ $m->judul_materi }}</p>
        </div>
        <div style="flex-shrink:0;display:flex;align-items:center;gap:8px;">
          <input type="number" name="nilai[{{ $prefix }}-{{ $m->id }}]"
                 value="{{ old('nilai.'.$prefix.'-'.$m->id, $existingNilai?->nilai) }}"
                 min="0" max="100" step="0.5" placeholder="0–100"
                 {{ $belumDimulai ? 'disabled' : '' }}
                 class="fcc-input" style="width:90px;text-align:center;{{ $belumDimulai ? 'background:#F1F5F9;cursor:not-allowed;' : '' }}"
                 onkeydown="if(event.key==='Enter')event.preventDefault();">
          <span style="font-size:11px;color:#9CA3B0;">/100</span>
        </div>
      </div>
      @empty
      <p style="color:#9CA3B0;font-size:13px;">Belum ada materi yang terdaftar untuk kegiatan ini.</p>
      @endforelse
      @if($materiList->count() > 0)
      <div style="margin-top:18px;padding-top:14px;border-top:1px solid #E2E4EB;">
        <button type="submit" {{ $belumDimulai ? 'disabled' : '' }} class="fcc-btn-dark" style="padding:11px 24px;font-size:14px;{{ $belumDimulai ? 'opacity:0.6;cursor:not-allowed;' : '' }}">
          @include('components.icon',['name'=>'check','size'=>14,'style'=>'color:#FFC81A']) Simpan Nilai
        </button>
      </div>
      @endif
    </form>
  </div>
</div>
@endsection
