@extends('layouts.public')
@section('title', $kegiatan->judul ?? 'Detail Kegiatan')
@section('page-content')
<div style="padding-top:84px; background:#131218; min-height: calc(100vh - 84px);">
    
    {{-- ═══ TOP HERO CARD — Integrated Poster, Info & Action Panel ════════════════════ --}}
    <div style="background:#131218; border-bottom:1.5px solid rgba(255,200,26,0.2); padding:44px 24px 48px; position:relative; overflow:hidden;">
        <!-- Subtle Glow -->
        <div style="position:absolute; top:-40%; right:-10%; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle, rgba(255,200,26,0.07), transparent 70%); pointer-events:none;"></div>
        
        <div style="max-width:1180px; margin:0 auto; position:relative; z-index:1;">
            
            {{-- Top Breadcrumb & Status --}}
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
                <a href="{{ route('landing.kegiatan') }}" style="display:inline-flex;align-items:center;gap:6px;color:#FFC81A;font-size:12.5px;font-weight:800;text-decoration:none;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    @include('components.icon',['name'=>'chevron-left','size'=>15]) Kembali ke Daftar Kegiatan
                </a>

                <div style="display:flex; align-items:center; gap:8px;">
                    <span style="font-size:10.5px; font-weight:900; padding:4px 12px; border-radius:100px; text-transform:uppercase; letter-spacing:1px; background:#FFC81A; color:#131218;">
                        {{ ucfirst($kegiatan->jenis_kegiatan) }}
                    </span>

                    @if($kegiatan->isFull())
                        <span style="font-size:10.5px; font-weight:900; padding:4px 12px; border-radius:100px; background:rgba(239,68,68,0.15); color:#EF4444; border:1px solid rgba(239,68,68,0.3); text-transform:uppercase;">
                            Kuota Penuh
                        </span>
                    @else
                        <span style="font-size:10.5px; font-weight:900; padding:4px 12px; border-radius:100px; background:rgba(16,185,129,0.15); color:#10B981; border:1px solid rgba(16,185,129,0.3); text-transform:uppercase;">
                            Pendaftaran Dibuka
                        </span>
                    @endif
                </div>
            </div>

            {{-- Split Hero Box: Poster Left, Title & Registration Action Right --}}
            <div style="display:grid; grid-template-columns: 280px 1fr; gap:36px; align-items:stretch;" class="fcc-hero-grid">
                
                {{-- Left Poster Image --}}
                <div style="border-radius:18px; overflow:hidden; border:2px solid #FFC81A; background:#1E1D26; box-shadow:0 12px 32px rgba(0,0,0,0.5); display:flex; align-items:center; justify-content:center;">
                    @if($kegiatan->detail?->gambar_url)
                        <img src="{{ $kegiatan->detail->gambar_url }}" alt="{{ $kegiatan->judul }}" style="width:100%; height:100%; max-height:360px; object-fit:cover; display:block;" />
                    @else
                        <div style="padding:32px 20px; width:100%; height:100%; background:linear-gradient(135deg, #1E1D26 0%, #131218 100%); display:flex; flex-direction:column; justify-content:space-between; text-align:center; min-height:280px;">
                            <span style="font-size:10px; font-weight:900; padding:3px 10px; border-radius:100px; background:#FFC81A; color:#131218; text-transform:uppercase; letter-spacing:1px; align-self:center;">
                                OFFICIAL PROGRAM
                            </span>
                            <div style="width:68px; height:68px; border-radius:20px; background:#FFC81A; display:flex; align-items:center; justify-content:center; margin:0 auto; color:#131218; box-shadow:0 6px 20px rgba(255,200,26,0.3);">
                                @include('components.icon',['name'=>$kegiatan->jenis_kegiatan==='pelatihan'?'book-open':'award','size'=>32,'style'=>'color:#131218'])
                            </div>
                            <div>
                                <h4 style="color:#FFFFFF; font-size:15px; font-weight:900; margin:0 0 4px;">{{ $kegiatan->judul }}</h4>
                                <p style="color:#FFC81A; font-size:11px; margin:0; text-transform:uppercase; font-weight:800;">FCC FIKOM UMI</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right Hero Content & Action --}}
                <div style="background:#1E1D26; border:1.5px solid rgba(255,200,26,0.25); border-radius:18px; padding:32px; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
                    <div>
                        <h1 style="font-size:clamp(22px, 3vw, 32px); font-weight:900; color:#FFFFFF; margin:0 0 20px; line-height:1.25; letter-spacing:-0.5px;">
                            {{ $kegiatan->judul }}
                        </h1>

                        <!-- Meta Info Row -->
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap:14px; margin-bottom:24px;">
                            <div style="background:#131218; border:1px solid rgba(255,200,26,0.2); border-radius:12px; padding:12px 16px;">
                                <p style="color:#FFC81A; font-size:10px; font-weight:900; margin:0 0 4px; text-transform:uppercase; display:flex; align-items:center; gap:4px;">
                                    @include('components.icon',['name'=>'calendar','size'=>12,'style'=>'color:#FFC81A']) Pelaksanaan
                                </p>
                                <p style="color:#FFFFFF; font-size:13.5px; font-weight:800; margin:0;">
                                    {{ $kegiatan->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}
                                </p>
                            </div>
                            <div style="background:#131218; border:1px solid rgba(255,200,26,0.2); border-radius:12px; padding:12px 16px;">
                                <p style="color:#FFC81A; font-size:10px; font-weight:900; margin:0 0 4px; text-transform:uppercase; display:flex; align-items:center; gap:4px;">
                                    @include('components.icon',['name'=>'clock','size'=>12,'style'=>'color:#FFC81A']) Batas Daftar
                                </p>
                                <p style="color:#FFFFFF; font-size:13.5px; font-weight:800; margin:0;">
                                    {{ $kegiatan->jadwal?->tgl_batas_daftar?->format('d M Y') ?? '-' }}
                                </p>
                            </div>
                            <div style="background:#131218; border:1px solid rgba(255,200,26,0.2); border-radius:12px; padding:12px 16px;">
                                <p style="color:#FFC81A; font-size:10px; font-weight:900; margin:0 0 4px; text-transform:uppercase; display:flex; align-items:center; gap:4px;">
                                    @include('components.icon',['name'=>'users','size'=>12,'style'=>'color:#FFC81A']) Kuota
                                </p>
                                <p style="color:#FFFFFF; font-size:13.5px; font-weight:800; margin:0;">
                                    {{ $kegiatan->terisi }} / {{ $kegiatan->kuota }} Peserta
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Action Bar: Price + CTA Button --}}
                    @php
                        $percentage = $kegiatan->kuota > 0 ? min(100, round(($kegiatan->terisi / $kegiatan->kuota) * 100)) : 0;
                        $sudahDaftar = auth('peserta')->check() && auth('peserta')->user()->pendaftaran()->where('kegiatan_id', $kegiatan->id)->exists(); 
                    @endphp
                    <div style="background:#131218; border:1.5px solid #FFC81A; border-radius:14px; padding:20px 24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-top:28px;">
                        <div>
                            <p style="color:#FFC81A; font-size:11px; font-weight:900; margin:0 0 6px; text-transform:uppercase; letter-spacing:1px;">Rincian Biaya Pendaftaran</p>
                            @if($kegiatan->biaya->isNotEmpty())
                                <div style="display:flex; flex-direction:column; gap:4px;">
                                    @foreach($kegiatan->biaya as $b)
                                        <div style="display:flex; align-items:center; gap:8px; font-size:13px;">
                                            <span style="color:rgba(255,255,255,0.75); font-weight:600;">{{ $b->nama_jenis }}:</span>
                                            <strong style="color:#FFC81A; font-weight:900; font-size:15px;">{{ $b->nominal_format }}</strong>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <h3 style="color:#10B981; font-size:22px; font-weight:900; margin:0;">GRATIS</h3>
                            @endif
                        </div>

                        <div style="flex-grow:1; max-width:240px;">
                            @if($sudahDaftar)
                                <a href="{{ route('peserta.pendaftaran') }}" style="display:flex; text-align:center; padding:12px 20px; border-radius:30px; font-size:13.5px; font-weight:900; justify-content:center; text-decoration:none; color:#10B981; border:2px solid #10B981; background:rgba(16,185,129,0.15);">
                                    ✓ Sudah Terdaftar
                                </a>
                            @elseif(!$kegiatan->isFull())
                                @auth('peserta')
                                    <button type="button" 
                                        onclick="showDaftarModal('{{ $kegiatan->hashid }}', '{{ addslashes($kegiatan->judul) }}', {{ $kegiatan->biaya->toJson() }})" 
                                        style="padding:13px 24px; font-size:14px; font-weight:900; width:100%; justify-content:center; border-radius:30px; background:#FFC81A; color:#131218; border:none; cursor:pointer; box-shadow:0 6px 20px rgba(255,200,26,0.35); transition:all 0.2s;"
                                        onmouseover="this.style.background='#FFFFFF';"
                                        onmouseout="this.style.background='#FFC81A';">
                                        Daftar Sekarang ➔
                                    </button>
                                @else
                                    <a href="{{ route('auth.login') }}" style="padding:13px 24px; font-size:14px; font-weight:900; text-decoration:none; display:inline-flex; width:100%; justify-content:center; border-radius:30px; background:#FFC81A; color:#131218; box-shadow:0 6px 20px rgba(255,200,26,0.35);">
                                        Masuk untuk Daftar ➔
                                    </a>
                                @endauth
                            @else
                                <button style="padding:13px 24px; font-size:13.5px; font-weight:900; width:100%; justify-content:center; border-radius:30px; background:#131218; border:1px solid rgba(255,255,255,0.2); color:rgba(255,255,255,0.4);" disabled>
                                    Kuota Penuh
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ═══ BOTTOM COMPACT DETAILS (2 Columns Side-by-Side) ═══════════════════════════ --}}
    <div style="background:#F8F9FA; padding:48px 24px 72px;">
        <div style="max-width:1180px; margin:0 auto;">
            <div style="display:grid; grid-template-columns: 1.4fr 1fr; gap:32px; align-items:start;" class="fcc-details-grid">
                
                {{-- Left: Deskripsi & Fasilitas --}}
                <div style="display:flex; flex-direction:column; gap:28px;">
                    
                    {{-- Deskripsi Program --}}
                    <div style="background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:20px; padding:28px; box-shadow:0 8px 24px rgba(0,0,0,0.04);">
                        <h3 style="font-size:16px; font-weight:900; color:#0F172A; margin:0 0 16px; text-transform:uppercase; letter-spacing:0.8px; display:flex; align-items:center; gap:8px;">
                            <div style="width:4px; height:20px; background:#FFC81A; border-radius:2px;"></div>
                            @include('components.icon',['name'=>'info','size'=>16,'style'=>'color:#D97706']) Deskripsi Program
                        </h3>
                        <div style="color:#334155; font-size:14.5px; line-height:1.8; font-weight:500;">
                            {!! nl2br(e($kegiatan->detail?->isi ?? 'Informasi lengkap mengenai program ini akan segera dirilis oleh panitia FIKOM Certification Center.')) !!}
                        </div>
                    </div>

                    {{-- Benefit / Fasilitas Peserta --}}
                    <div style="background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:20px; padding:24px 28px; box-shadow:0 8px 24px rgba(0,0,0,0.04);">
                        <h3 style="font-size:14px; font-weight:900; color:#0F172A; margin:0 0 16px; text-transform:uppercase; letter-spacing:0.8px;">
                            Fasilitas &amp; Benefit Keikutsertaan
                        </h3>
                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:14px;">
                            <div style="display:flex; align-items:center; gap:10px; font-size:13.5px; color:#0F172A; font-weight:700;">
                                @include('components.icon',['name'=>'check-circle','size'=>16,'style'=>'color:#D97706'])
                                <span>Sertifikat Resmi BNSP / Global</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13.5px; color:#0F172A; font-weight:700;">
                                @include('components.icon',['name'=>'check-circle','size'=>16,'style'=>'color:#D97706'])
                                <span>Instruktur Dosen &amp; Praktisi IT</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13.5px; color:#0F172A; font-weight:700;">
                                @include('components.icon',['name'=>'check-circle','size'=>16,'style'=>'color:#D97706'])
                                <span>Akses Modul &amp; Material Pelatihan</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px; font-size:13.5px; color:#0F172A; font-weight:700;">
                                @include('components.icon',['name'=>'check-circle','size'=>16,'style'=>'color:#D97706'])
                                <span>Portofolio &amp; Pengakuan Kerja</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Silabus & Help Desk --}}
                <div style="display:flex; flex-direction:column; gap:28px;">
                    
                    {{-- Silabus Materi --}}
                    @php
                        $materiList = collect();
                        if ($kegiatan->jenis_kegiatan === 'pelatihan') {
                            $materiList = $kegiatan->kegiatanPelatihan?->jadwalPelatihan?->pelatihan?->materi ?? collect();
                        } else {
                            $materiList = $kegiatan->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi?->materi ?? collect();
                        }
                    @endphp

                    @if($materiList->isNotEmpty())
                    <div style="background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:20px; padding:28px; box-shadow:0 8px 24px rgba(0,0,0,0.04);">
                        <h3 style="font-size:16px; font-weight:900; color:#0F172A; margin:0 0 18px; text-transform:uppercase; letter-spacing:0.8px; display:flex; align-items:center; gap:8px;">
                            <div style="width:4px; height:20px; background:#FFC81A; border-radius:2px;"></div>
                            @include('components.icon',['name'=>'book-open','size'=>16,'style'=>'color:#D97706']) Silabus Materi
                        </h3>
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            @foreach($materiList as $idx => $mt)
                            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:14px; padding:14px 16px; display:flex; gap:14px; align-items:flex-start;">
                                <div style="width:26px; height:26px; border-radius:8px; background:#FFC81A; border:1px solid #131218; color:#131218; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:900; flex-shrink:0;">
                                    {{ $idx + 1 }}
                                </div>
                                <div>
                                    <h4 style="margin:0 0 4px; color:#0F172A; font-size:14px; font-weight:900;">{{ $mt->judul_materi }}</h4>
                                    <p style="margin:0; color:#64748B; font-size:12.5px; line-height:1.5;">{{ $mt->deskripsi ?? 'Materi inti pelatihan profesional.' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Help / Penyelenggara Card --}}
                    <div style="background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:20px; padding:24px; box-shadow:0 8px 24px rgba(0,0,0,0.04);">
                        <div style="display:flex; align-items:center; gap:14px; margin-bottom:16px;">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo FCC UMI" style="width:38px; height:38px; object-fit:contain;">
                            <div>
                                <p style="color:#0F172A; font-size:14px; font-weight:900; margin:0;">FIKOM Certification Center</p>
                                <p style="color:#D97706; font-size:11.5px; font-weight:800; margin:2px 0 0;">Universitas Muslim Indonesia</p>
                            </div>
                        </div>
                        <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" 
                           style="display:inline-flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:11px; border-radius:12px; background:#131218; color:#FFC81A; font-size:13px; font-weight:900; text-decoration:none; box-shadow:0 4px 12px rgba(0,0,0,0.15);">
                            @include('components.icon',['name'=>'phone','size'=>14,'style'=>'color:#FFC81A']) Tanya Panitia (WhatsApp)
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 960px) {
    .fcc-show-layout {
        grid-template-columns: 1fr !important;
    }
}
</style>

{{-- Modal Konfirmasi Daftar --}}
<div id="daftar-modal" style="display:none;position:fixed;inset:0;z-index:2000;background:rgba(0,0,0,.75);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:16px;">
    <div style="background:#1E1D26;border-radius:22px;max-width:440px;width:100%;overflow:hidden;border:2px solid #FFC81A;box-shadow:0 24px 60px rgba(0,0,0,.6);">
        <div style="background:#131218;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,200,26,0.25);">
            <div>
                <p style="margin:0;color:#FFFFFF;font-weight:900;font-size:16px;">Konfirmasi Pendaftaran</p>
                <p style="margin:4px 0 0;color:#FFC81A;font-size:12px;" id="modal-judul"></p>
            </div>
            <button onclick="closeDaftarModal()" style="background:#1E1D26;border:none;border-radius:8px;color:rgba(255,255,255,.7);padding:6px 8px;cursor:pointer;display:flex;">
                @include('components.icon',['name'=>'x','size'=>16])
            </button>
        </div>
        <form id="daftar-form" method="POST" style="padding:22px 24px;">
            @csrf
            <div id="biaya-section"></div>
            <button type="submit" style="width:100%;justify-content:center;padding:13px;font-size:14.5px;font-weight:900;background:#FFC81A;color:#131218;border:none;border-radius:30px;cursor:pointer;margin-top:16px;display:flex;align-items:center;gap:8px;box-shadow:0 6px 20px rgba(255,200,26,0.35);">
                @include('components.icon',['name'=>'check','size'=>16]) Konfirmasi Pendaftaran
            </button>
        </form>
    </div>
</div>

@push('scripts')
@vite('resources/js/pages/landing-jelajahi.js')
@endpush
@endsection
