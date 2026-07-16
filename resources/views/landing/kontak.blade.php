@extends('layouts.public')
@section('title','Hubungi Kami')
@section('page-content')
<div style="padding-top:68px;">
    <div style="background:#131218;padding:52px 24px 44px;position:relative;overflow:hidden;">
        <div style="position:absolute;inset:0;opacity:.04;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div style="max-width:1000px;margin:0 auto;position:relative;z-index:1;text-align:center;">
            <h1 class="fcc-gold-text" style="font-size:clamp(28px,5vw,50px);font-weight:900;margin:0 0 10px;">Hubungi Kami</h1>
            <p style="color:rgba(255,255,255,.55);font-size:16px;margin:0;">Tim FCC siap menjawab pertanyaanmu seputar pendaftaran dan program</p>
        </div>
    </div>
    <div style="padding:52px 24px;max-width:1000px;margin:0 auto;">
        @if(session('success'))
        <div style="padding:14px 18px;background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);border-radius:10px;color:#10B981;font-size:14px;font-weight:600;margin-bottom:28px;">&#10003; {{ session('success') }}</div>
        @endif
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;">
            {{-- Form --}}
            <div>
                <h2 style="font-size:20px;font-weight:800;color:#0F0F14;margin:0 0 20px;">Kirim Pesan</h2>
                <form action="{{ route('landing.kontak.post') }}" method="POST">
                    @csrf
                    @foreach([['nama','Nama Lengkap','text','Nama kamu','user'],['email','Email','email','email@example.com','mail']] as [$n,$l,$t,$p,$ic])
                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:11px;font-weight:700;color:#6B7280;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">{{ $l }} *</label>
                        <div style="position:relative;">
                            @include('components.icon',['name'=>$ic,'size'=>14,'style'=>'position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#A0A3AD;pointer-events:none;'])
                            <input type="{{ $t }}" name="{{ $n }}" value="{{ old($n) }}" placeholder="{{ $p }}" required class="fcc-input" style="padding-left:38px;"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>
                        @error($n)<p style="color:#EF4444;font-size:12px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    @endforeach
                    <div style="margin-bottom:20px;">
                        <label style="display:block;font-size:11px;font-weight:700;color:#6B7280;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Pesan *</label>
                        <textarea name="pesan" rows="5" required placeholder="Tuliskan pertanyaan atau pesanmu…" class="fcc-input" style="resize:vertical;">{{ old('pesan') }}</textarea>
                        @error('pesan')<p style="color:#EF4444;font-size:12px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:12px;font-size:15px;">
                        @include('components.icon',['name'=>'arrow-right','size'=>15]) Kirim Pesan
                    </button>
                </form>
            </div>
            {{-- Info --}}
            <div>
                <h2 style="font-size:20px;font-weight:800;color:#0F0F14;margin:0 0 20px;">Informasi Kontak</h2>
                <div style="display:flex;flex-direction:column;gap:18px;margin-bottom:24px;">
                    @foreach([
                        ['map-pin','Alamat',$kontak->alamat ?? 'Jl. Urip Sumoharjo No.225, Makassar 90232'],
                        ['phone','Telepon',$kontak->telepon ?? '(0411) 455 855'],
                        ['mail','Email',$kontak->email ?? 'fcc@fikom.umi.ac.id'],
                        ['globe','Website','www.fcc.fikom.umi.ac.id'],
                    ] as [$ic,$lbl,$val])
                    <div style="display:flex;gap:14px;align-items:flex-start;">
                        <div style="width:40px;height:40px;border-radius:11px;flex-shrink:0;background:rgba(255,200,26,.12);border:1px solid rgba(255,200,26,.22);display:flex;align-items:center;justify-content:center;">
                            @include('components.icon',['name'=>$ic,'size'=>17,'style'=>'color:#FFC81A'])
                        </div>
                        <div>
                            <p style="margin:0 0 2px;color:#6B7280;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">{{ $lbl }}</p>
                            <p style="margin:0;color:#0F0F14;font-size:14px;">{{ $val }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($kontak?->maps_embed)
                <div style="border-radius:12px;overflow:hidden;height:200px;">{!! $kontak->maps_embed !!}</div>
                @else
                <div style="background:#F7F8FA;border-radius:12px;padding:28px;text-align:center;height:200px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;">
                    @include('components.icon',['name'=>'map-pin','size'=>32,'style'=>'color:rgba(255,200,26,.35)'])
                    <p style="color:#A0A3AD;font-size:13px;margin:0;">Kampus UMI Makassar</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
