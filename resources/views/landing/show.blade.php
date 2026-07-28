@extends('layouts.public')
@section('title', $kegiatan->judul ?? 'Detail Kegiatan')
@section('page-content')
<style>
    .fcc-detail-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
        align-items: start;
    }
    @media(min-width: 768px) {
        .fcc-detail-grid {
            grid-template-columns: 320px 1fr;
        }
    }
</style>
<div style="padding-top:68px;background:linear-gradient(180deg, #131218 0%, #0e0d14 120px, #0e0d14 100%);min-height:100vh;">
    <div style="max-width:1100px;margin:0 auto;padding:40px 24px;">
        <!-- Back Link -->
        <a href="{{ route('landing.kegiatan') }}" style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.5);font-size:13px;text-decoration:none;margin-bottom:24px;font-weight:600;transition:color 0.2s;" onmouseover="this.style.color='#FFF'" onmouseout="this.style.color='rgba(255,255,255,.5)'">
            @include('components.icon',['name'=>'chevron-left','size'=>15]) Kembali ke Kegiatan
        </a>

        <!-- Main Split Grid -->
        <div class="fcc-detail-grid">
            
            <!-- Left Side: Poster -->
            <div class="fcc-card-dark" style="overflow:hidden; border-radius:18px; border:1.5px solid rgba(255,255,255,.08); background:rgba(255,255,255,.03); box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                @if($kegiatan->detail?->gambar_url)
                    <div style="position:relative; width:100%; aspect-ratio:3/4; overflow:hidden;">
                        <img src="{{ $kegiatan->detail->gambar_url }}" alt="{{ $kegiatan->judul }}" style="width:100%; height:100%; object-fit:cover; display:block;" />
                    </div>
                @else
                    <!-- Generated Premium Poster Placeholder -->
                    <div style="position:relative; width:100%; aspect-ratio:3/4; background:linear-gradient(135deg,#131218 0%,#1C1B22 100%); display:flex; flex-direction:column; justify-content:space-between; padding:32px 24px; overflow:hidden;">
                        <!-- Grid overlay pattern -->
                        <div style="position:absolute; inset:0; opacity:.05; background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px); background-size:22px 22px;"></div>
                        <!-- Radial glow -->
                        <div style="position:absolute; top:-20%; right:-20%; width:150px; height:150px; border-radius:50%; background:radial-gradient(circle, rgba(255,200,26,0.15), transparent 70%);"></div>
                        
                        <!-- Header badge on poster placeholder -->
                        <div>
                            <span style="font-size:10px; font-weight:800; padding:4px 10px; border-radius:6px; border:1px solid rgba(255,200,26,0.3); background:rgba(255,200,26,0.1); color:#FFC81A; text-transform:uppercase; letter-spacing:1px;">
                                FCC UMI
                            </span>
                        </div>
                        
                        <!-- Middle decoration (Huge glowing icon) -->
                        <div style="display:flex; justify-content:center; align-items:center; margin:20px 0;">
                            <div style="width:90px; height:90px; border-radius:30px; background:rgba(255,255,255,0.03); border:1.5px solid rgba(255,255,255,0.07); display:flex; align-items:center; justify-content:center; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
                                @include('components.icon',['name'=>$kegiatan->jenis_kegiatan==='pelatihan'?'book-open':'award','size'=>44,'style'=>'color:#FFC81A'])
                            </div>
                        </div>
                        
                        <!-- Footer Text of placeholder -->
                        <div style="position:relative; z-index:1; text-align:center;">
                            <h4 style="color:#FFF; font-size:16px; font-weight:900; margin:0 0 6px; line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                {{ $kegiatan->judul }}
                            </h4>
                            <p style="color:rgba(255,255,255,0.4); font-size:11px; margin:0; text-transform:uppercase; letter-spacing:1.5px; font-weight:700;">
                                FIKOM CERTIFICATION CENTER
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Side: Details & Actions -->
            <div class="fcc-card-dark" style="padding:32px; border-radius:18px; border:1.5px solid rgba(255,255,255,.08); background:rgba(255,255,255,.03); box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                
                <!-- Category and Registration Status -->
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; flex-wrap:wrap; gap:10px;">
                    <span style="font-size:11px; font-weight:800; padding:4px 12px; border-radius:8px; text-transform:uppercase; letter-spacing:0.5px;
                        background:{{ $kegiatan->jenis_kegiatan==='pelatihan'?'rgba(255,200,26,.15)':'rgba(139,92,246,0.1)' }};
                        color:{{ $kegiatan->jenis_kegiatan==='pelatihan'?'#FFC81A':'#A78BFA' }};">
                        {{ ucfirst($kegiatan->jenis_kegiatan) }}
                    </span>
                    
                    @if($kegiatan->isFull())
                        <span style="font-size:11px; font-weight:800; padding:4px 12px; border-radius:8px; background:rgba(239,68,68,0.12); color:#EF4444; border:1px solid rgba(239,68,68,0.2); text-transform:uppercase; letter-spacing:0.5px;">
                            Kuota Penuh
                        </span>
                    @endif
                </div>

                <!-- Event Title -->
                <h1 style="font-size:clamp(22px,3.5vw,30px); font-weight:900; color:#FFF; margin:0 0 20px; line-height:1.25;">
                    {{ $kegiatan->judul }}
                </h1>

                <!-- Key Metrics (Date, Kuota, Default Price Summary) -->
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:28px;">
                    @foreach([
                        ['calendar', 'Pelaksanaan', $kegiatan->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA'],
                        ['users', 'Kuota', $kegiatan->terisi . ' / ' . $kegiatan->kuota . ' Peserta'],
                        ['credit-card', 'Status Biaya', $kegiatan->biaya->isNotEmpty() ? 'Berbayar' : 'Gratis']
                    ] as [$ic, $l, $v])
                    <div style="background:rgba(255,255,255,.03); border:1.5px solid rgba(255,255,255,.08); border-radius:12px; padding:14px 16px;">
                        <p style="color:rgba(255,255,255,.5); font-size:10.5px; font-weight:700; margin:0 0 6px; text-transform:uppercase; letter-spacing:0.8px; display:flex; align-items:center; gap:6px;">
                            @include('components.icon',['name'=>$ic,'size'=>12,'style'=>'color:#FFC81A']) {{ $l }}
                        </p>
                        <p style="color:#FFF; font-size:14.5px; font-weight:800; margin:0;">{{ $v }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- All Prices Breakdown (Harganya ditampilkan semua) -->
                <div style="background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.08); border-radius:14px; padding:20px; margin-bottom:28px;">
                    <h3 style="font-size:12px; font-weight:800; color:#FFF; margin:0 0 16px; text-transform:uppercase; letter-spacing:1px; display:flex; align-items:center; gap:6px;">
                        @include('components.icon',['name'=>'credit-card','size'=>14,'style'=>'color:#FFC81A']) Rincian Biaya Kegiatan
                    </h3>
                    
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        @if($kegiatan->biaya->isNotEmpty())
                            @foreach($kegiatan->biaya as $b)
                            <div style="display:flex; align-items:center; justify-content:space-between; padding-bottom:10px; border-bottom:1px dashed rgba(255,255,255,.1); font-size:13.5px;">
                                <span style="color:rgba(255,255,255,.6); font-weight:600; max-width:70%;">{{ $b->nama_jenis }}</span>
                                <span style="color:#FFC81A; font-weight:900; font-size:15px;">{{ $b->nominal_format }}</span>
                            </div>
                            @endforeach
                        @else
                            <div style="display:flex; align-items:center; justify-content:space-between; font-size:14px; color:#10B981; font-weight:800; padding:6px 0;">
                                <span>Semua Kategori Pendaftar</span>
                                <span style="background:rgba(16,185,129,0.1); padding:4px 12px; border-radius:20px;">Gratis</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Short Description / Content -->
                <div style="margin-bottom:32px;">
                    <h3 style="font-size:12px; font-weight:800; color:#FFF; margin:0 0 12px; text-transform:uppercase; letter-spacing:1px; display:flex; align-items:center; gap:6px;">
                        @include('components.icon',['name'=>'info','size'=>13,'style'=>'color:#FFC81A']) Deskripsi Kegiatan
                    </h3>
                    <div style="color:rgba(255,255,255,.6); font-size:14.5px; line-height:1.75; font-weight:500;">
                        {!! nl2br(e($kegiatan->detail?->isi ?? 'Informasi lengkap mengenai program ini akan segera dirilis.')) !!}
                    </div>
                </div>

                <!-- Kurikulum / Materi -->
                @php
                    $materiList = collect();
                    if ($kegiatan->jenis_kegiatan === 'pelatihan') {
                        $materiList = $kegiatan->kegiatanPelatihan?->jadwalPelatihan?->pelatihan?->materi ?? collect();
                    } else {
                        $materiList = $kegiatan->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi?->materi ?? collect();
                    }
                @endphp

                @if($materiList->isNotEmpty())
                <div style="margin-bottom:32px;">
                    <h3 style="font-size:12px; font-weight:800; color:#FFF; margin:0 0 16px; text-transform:uppercase; letter-spacing:1px; display:flex; align-items:center; gap:6px;">
                        @include('components.icon',['name'=>'book-open','size'=>13,'style'=>'color:#FFC81A']) Kurikulum & Materi
                    </h3>
                    <div style="display:flex; flex-direction:column; gap:10px;">
                        @foreach($materiList as $idx => $mt)
                        <div style="background:rgba(255,255,255,.02); border:1px solid rgba(255,255,255,.06); border-radius:12px; padding:14px 16px; display:flex; gap:16px; align-items:flex-start; transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,.04)'" onmouseout="this.style.background='rgba(255,255,255,.02)'">
                            <div style="width:28px; height:28px; border-radius:8px; background:rgba(255,200,26,.1); color:#FFC81A; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:900; flex-shrink:0;">
                                {{ $idx + 1 }}
                            </div>
                            <div>
                                <h4 style="margin:0 0 6px; color:#FFF; font-size:14px; font-weight:700;">{{ $mt->judul_materi }}</h4>
                                <p style="margin:0; color:rgba(255,255,255,.5); font-size:13px; line-height:1.5;">{{ $mt->deskripsi ?? 'Tidak ada deskripsi spesifik untuk materi ini.' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Registration Actions / Form -->
                <div style="border-top:1.5px solid rgba(255,255,255,.08); padding-top:24px;">
                    @if(!$kegiatan->isFull())
                        @auth('peserta')
                            <form action="{{ route('peserta.kegiatan.daftar', $kegiatan) }}" method="POST" style="margin:0;">
                                @csrf
                                @if($kegiatan->biaya->isNotEmpty())
                                    <div style="margin-bottom:16px;">
                                        <label style="font-size:11px; font-weight:800; color:#FFF; text-transform:uppercase; letter-spacing:0.8px; display:block; margin-bottom:8px;">Pilih Opsi Biaya Anda:</label>
                                        <select name="biaya_kegiatan_id" class="fcc-input-dark" style="width:100%; border-radius:12px; border:1.5px solid rgba(255,255,255,.08); background:rgba(255,255,255,.03); color:#FFF; padding:10px 14px; outline:none;" required>
                                            <option value="">-- Pilih jenis biaya --</option>
                                            @foreach($kegiatan->biaya as $b)
                                            <option value="{{ $b->id }}">{{ $b->nama_jenis }} — {{ $b->nominal_format }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="biaya_kegiatan_id" value="">
                                @endif
                                <button type="submit" class="fcc-btn-gold btn-shine" style="padding:14px 28px; font-size:15px; width:100%; justify-content:center; border-radius:12px;">Daftar Sekarang</button>
                            </form>
                        @else
                            <div style="text-align:center;">
                                <p style="color:rgba(255,255,255,.6); font-size:13px; margin:0 0 12px; font-weight:500;">Masuk ke akun peserta Anda untuk melakukan pendaftaran.</p>
                                <a href="{{ route('auth.login') }}" class="fcc-btn-gold btn-shine" style="padding:14px 28px; font-size:15px; text-decoration:none; display:inline-flex; width:100%; justify-content:center; border-radius:12px;">Masuk untuk Daftar</a>
                            </div>
                        @endauth
                    @else
                        <button class="fcc-btn-gold" style="padding:14px 28px; font-size:15px; width:100%; justify-content:center; border-radius:12px; background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); color:rgba(255,255,255,.4); cursor:not-allowed; box-shadow:none;" disabled>Pendaftaran Ditutup (Kuota Penuh)</button>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>
<style>
/* Style for dark mode select options */
select.fcc-input-dark option {
    background: #131218;
    color: #FFF;
}
</style>
@endsection
