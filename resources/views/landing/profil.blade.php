@extends('layouts.public')
@section('title','Profil FCC')
@section('page-content')
<div style="padding-top:68px;">
    <div style="background:#131218;padding:52px 24px 44px;text-align:center;position:relative;overflow:hidden;">
        <div style="position:absolute;inset:0;opacity:.04;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div style="position:relative;z-index:1;">
            <h1 class="fcc-gold-text" style="font-size:clamp(28px,5vw,50px);font-weight:900;margin:0 0 10px;">Profil FCC</h1>
            <p style="color:rgba(255,255,255,.55);font-size:16px;margin:0;">Mengenal FIKOM Certification Center lebih dekat</p>
        </div>
    </div>
    {{-- Tabs --}}
    <div style="background:#FFF;border-bottom:1px solid #E2E4EB;position:sticky;top:68px;z-index:50;">
        <div style="max-width:1100px;margin:0 auto;padding:0 24px;display:flex;gap:0;" id="profil-tabs">
            @foreach([['tentang','Tentang Kami'],['visi','Visi Misi & Tujuan'],['mitra','Mitra Kami']] as [$v,$l])
            <button onclick="showTab('{{ $v }}')" id="tab-{{ $v }}"
                style="padding:16px 24px;border:none;background:none;font-weight:700;font-size:14px;cursor:pointer;transition:all .2s;margin-bottom:-1px;
                       color:{{ $loop->first?'#FFC81A':'#6B7280' }};border-bottom:{{ $loop->first?'3px solid #FFC81A':'3px solid transparent' }};">
                {{ $l }}
            </button>
            @endforeach
        </div>
    </div>
    <div style="padding:52px 24px;max-width:1100px;margin:0 auto;">
        {{-- Tentang --}}
        <div id="content-tentang">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:start;">
                <div>
                    <h3 style="font-size:24px;font-weight:900;color:#0F0F14;margin:0 0 16px;">Tentang <span style="color:#FFC81A;">FIKOM Certification Center</span></h3>
                    <p style="color:#6B7280;font-size:15px;line-height:1.85;margin:0 0 16px;">{{ $konten['tentang_kami']?->isi ?? 'FIKOM Certification Center (FCC) adalah unit pelaksana di bawah Fakultas Ilmu Komputer Universitas Muslim Indonesia.' }}</p>
                    <p style="color:#6B7280;font-size:15px;line-height:1.85;">FCC berdiri untuk menjawab kebutuhan industri akan tenaga kerja yang kompeten, bersertifikat, dan siap menghadapi tantangan ekonomi digital.</p>
                </div>
                <div style="background:#F7F8FA;border-radius:16px;padding:28px;">
                    @foreach([['Tahun Berdiri','2020'],['Total Peserta','342+'],['Program Aktif','25+'],['Mitra Industri','12+']] as [$l,$v])
                    <div style="display:flex;justify-content:space-between;padding:13px 0;border-bottom:1px solid #E2E4EB;">
                        <span style="color:#6B7280;font-size:14px;">{{ $l }}</span>
                        <span style="color:#FFC81A;font-weight:900;font-size:16px;">{{ $v }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- Visi Misi --}}
        <div id="content-visi" style="display:none;">
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
                @foreach([['star','Visi','#FFC81A','Menjadi pusat sertifikasi dan pelatihan teknologi informasi terkemuka di kawasan Indonesia Timur.'],
                           ['zap','Misi','#10B981','Menyelenggarakan pelatihan berkualitas, mengembangkan sertifikasi terstandar, dan membangun kemitraan strategis dengan industri.'],
                           ['check','Tujuan','#3B82F6','Menghasilkan lulusan kompeten bersertifikasi dan meningkatkan daya saing mahasiswa UMI di dunia kerja.']] as [$ic,$t,$c,$txt])
                <div class="fcc-card" style="padding:24px;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                        <div style="width:38px;height:38px;border-radius:10px;background:{{ $c }}15;border:1px solid {{ $c }}44;display:flex;align-items:center;justify-content:center;">
                            @include('components.icon',['name'=>$ic,'size'=>18,'style'=>"color:{$c}"])
                        </div>
                        <span style="font-size:18px;font-weight:900;color:#0F0F14;">{{ $t }}</span>
                    </div>
                    <p style="color:#6B7280;font-size:14px;line-height:1.8;margin:0;">{{ $txt }}</p>
                </div>
                @endforeach
            </div>
        </div>
        {{-- Mitra --}}
        <div id="content-mitra" style="display:none;">
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;">
                @foreach($mitras as $m)
                <div class="fcc-card" style="padding:20px;text-align:center;transition:transform .22s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width:58px;height:58px;border-radius:16px;margin:0 auto 12px;background:{{ $m->warna ? $m->warna.'18' : '#FFC81A18' }};border:2px solid {{ $m->warna ? $m->warna.'30' : '#FFC81A30' }};display:flex;align-items:center;justify-content:center;">
                        @if($m->logo)
                        <img src="{{ asset('storage/'.$m->logo) }}" alt="{{ $m->nama_mitra }}" style="width:36px;height:36px;object-fit:contain;">
                        @else
                        <span style="color:{{ $m->warna ?? '#FFC81A' }};font-size:{{ strlen($m->inisial??'MI')>3?10:13 }}px;font-weight:900;">{{ $m->inisial ?? substr($m->nama_mitra,0,3) }}</span>
                        @endif
                    </div>
                    <p style="color:#0F0F14;font-size:13px;font-weight:700;margin:0;line-height:1.4;">{{ $m->nama_mitra }}</p>
                    <p style="color:#A0A3AD;font-size:11px;margin:4px 0 0;">Mitra Resmi FCC</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

