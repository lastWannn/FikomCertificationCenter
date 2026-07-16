@extends('layouts.public')
@section('title', $kegiatan->judul ?? 'Detail Kegiatan')
@section('page-content')
<div style="padding-top:68px;background:#F7F8FA;min-height:100vh;">
    <div style="max-width:900px;margin:0 auto;padding:40px 24px;">
        <a href="{{ route('landing.kegiatan') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:20px;">
            @include('components.icon',['name'=>'chevron-left','size'=>15]) Kembali ke Kegiatan
        </a>
        <div class="fcc-card" style="overflow:hidden;">
            <div style="height:200px;background:linear-gradient(135deg,#131218,#1A1920);display:flex;align-items:center;justify-content:center;">
                @include('components.icon',['name'=>$kegiatan->jenis_kegiatan==='pelatihan'?'book-open':'award','size'=>56,'style'=>'color:rgba(255,200,26,.4)'])
            </div>
            <div style="padding:28px 32px;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:12px;">
                    <div>
                        <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;margin-bottom:10px;display:inline-block;
                            background:{{ $kegiatan->jenis_kegiatan==='pelatihan'?'rgba(255,200,26,.15)':'rgba(59,130,246,.12)' }};
                            color:{{ $kegiatan->jenis_kegiatan==='pelatihan'?'#B38F00':'#3B82F6' }};">
                            {{ ucfirst($kegiatan->jenis_kegiatan) }}
                        </span>
                        <h1 style="font-size:clamp(20px,3vw,28px);font-weight:900;color:#0F0F14;margin:0;">{{ $kegiatan->judul }}</h1>
                    </div>
                    @if(!$kegiatan->isFull())
                    @auth('peserta')
                    <form action="{{ route('peserta.kegiatan.daftar', $kegiatan) }}" method="POST">
                        @csrf
                        @if($kegiatan->biaya->isNotEmpty())
                        <select name="biaya_kegiatan_id" class="fcc-input" style="margin-bottom:8px;" required>
                            <option value="">-- Pilih jenis biaya --</option>
                            @foreach($kegiatan->biaya as $b)
                            <option value="{{ $b->id }}">{{ $b->nama_jenis }} — {{ $b->nominal_format }}</option>
                            @endforeach
                        </select>
                        @else
                        <input type="hidden" name="biaya_kegiatan_id" value="">
                        @endif
                        <button type="submit" class="fcc-btn-gold" style="padding:10px 22px;font-size:14px;width:100%;">Daftar Sekarang</button>
                    </form>
                    @else
                    <a href="{{ route('auth.login') }}" class="fcc-btn-gold" style="padding:10px 22px;font-size:14px;text-decoration:none;">Masuk untuk Daftar</a>
                    @endauth
                    @endif
                </div>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px;">
                    @foreach([['calendar','Pelaksanaan',$kegiatan->jadwal?->tgl_pelaksanaan?->format('d M Y')??'TBA'],
                               ['users','Kuota',$kegiatan->terisi.'/'.$kegiatan->kuota.' peserta'],
                               ['credit-card','Biaya',$kegiatan->biaya->isNotEmpty()?'Mulai Rp '.number_format($kegiatan->biaya->min('nominal'),0,',','.'):'Gratis']] as [$ic,$l,$v])
                    <div style="background:#F7F8FA;border-radius:10px;padding:14px 16px;">
                        <p style="color:#A0A3AD;font-size:11px;font-weight:700;margin:0 0 4px;text-transform:uppercase;letter-spacing:.7px;display:flex;align-items:center;gap:5px;">
                            @include('components.icon',['name'=>$ic,'size'=>11,'style'=>'color:#FFC81A']) {{ $l }}
                        </p>
                        <p style="color:#0F0F14;font-size:15px;font-weight:800;margin:0;">{{ $v }}</p>
                    </div>
                    @endforeach
                </div>
                <div style="color:#6B7280;font-size:15px;line-height:1.85;">{!! nl2br(e($kegiatan->detail?->isi ?? 'Informasi lengkap kegiatan ini segera tersedia.')) !!}</div>
            </div>
        </div>
    </div>
</div>
@endsection
