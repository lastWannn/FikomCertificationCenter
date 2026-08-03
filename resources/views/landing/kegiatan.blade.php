@extends('layouts.public')
@section('title','Kegiatan')
@section('page-content')
<div style="padding-top:68px; background:linear-gradient(180deg, #131218 0%, #0e0d14 120px, #0e0d14 100%); min-height: calc(100vh - 68px);">
    {{-- Page Header --}}
    <div style="background: #131218; padding: 76px 24px 64px; text-align: center; position: relative; overflow: hidden; border-bottom: none;">
        <!-- Glow effects -->
        <div style="position: absolute; top: -50%; left: -20%; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(255, 200, 26, 0.06), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; bottom: -50%; right: -20%; width: 450px; height: 450px; border-radius: 50%; background: radial-gradient(circle, rgba(59, 130, 246, 0.04), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; inset: 0; opacity: .03; background-image: linear-gradient(rgba(255, 200, 26, 1) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 200, 26, 1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <div style="position: relative; z-index: 1; max-width: 800px; margin: 0 auto;">
            <a href="{{ route('landing.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.5);font-size:13px;text-decoration:none;margin-bottom:20px;transition:all 0.2s;" onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='rgba(255,255,255,.5)'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg> Kembali ke Beranda
            </a>
            <h1 style="color: #FFF; font-size: clamp(30px, 5.5vw, 48px); font-weight: 900; margin: 0 0 16px; letter-spacing: -1.2px; line-height: 1.15;">
                Kegiatan <span class="fcc-gold-text">FCC UMI</span>
            </h1>
            <p style="color: rgba(255, 255, 255, 0.55); font-size: 16px; margin: 0; line-height: 1.6; font-weight: 500; max-width: 520px; margin: 0 auto;">
                Seluruh daftar program pelatihan kompetensi & sertifikasi profesi FIKOM UMI yang tersedia.
            </p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div style="background: rgba(14, 13, 20, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,.05); padding: 16px 24px; position: sticky; top: 68px; z-index: 50; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
        <div style="max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
            <form method="GET" action="{{ route('landing.kegiatan') }}" style="display:flex; width:100%; justify-content:space-between; gap:16px; align-items:center; flex-wrap:wrap; margin:0;">
                
                <!-- Category Select (Segmented Control) -->
                <div style="display:inline-flex; gap:4px; background:rgba(255,255,255,.04); padding:4px; border-radius:12px; border:1px solid rgba(255,255,255,.08);">
                    @foreach([['semua','Semua Kegiatan'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
                    <button type="submit" name="jenis" value="{{ $v }}"
                        style="padding: 8px 18px; border-radius: 9px; border: none; font-size: 13px; font-weight: 800; cursor: pointer; transition: all .2s ease;
                               background: {{ request('jenis', 'semua') === $v || ($v === 'semua' && !request('jenis')) ? '#FFC81A' : 'transparent' }};
                               color: {{ request('jenis', 'semua') === $v || ($v === 'semua' && !request('jenis')) ? '#131218' : 'rgba(255,255,255,.5)' }};
                               box-shadow: {{ request('jenis', 'semua') === $v || ($v === 'semua' && !request('jenis')) ? '0 2px 8px rgba(0,0,0,0.2)' : 'none' }};">
                        {{ $l }}
                    </button>
                    @endforeach
                </div>
                
                <!-- Search Input Group -->
                <div style="position:relative; display:flex; align-items:center; gap:8px;">
                    <div style="position:relative;">
                        <svg style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:rgba(255,255,255,.4); pointer-events:none;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pelatihan / sertifikasi..."
                            class="fcc-input-dark" style="padding: 10px 16px 10px 38px; width: 260px; font-size:13px; border-radius:12px; border: 1.5px solid rgba(255,255,255,.08); background:rgba(255,255,255,.03); color:#FFF; transition:all 0.3s ease; outline:none;"
                            onfocus="this.style.borderColor='#FFC81A'; this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.15)'"
                            onblur="this.style.borderColor='rgba(255,255,255,.08)'; this.style.boxShadow='none'"
                            onkeydown="if(event.key==='Enter')this.form.submit()">
                    </div>
                    @if(request('q') || request('jenis'))
                    <a href="{{ route('landing.kegiatan') }}" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:12px; border:1.5px solid rgba(239,68,68,0.2); background:rgba(239,68,68,0.1); color:#EF4444; transition:all 0.2s;" title="Reset Filter" onmouseover="this.style.background='rgba(239,68,68,0.2)'" onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </a>
                    @endif
                </div>
            </form>

            <!-- Category Sub-Filters -->
            <div style="width:100%; border-top:1px solid rgba(255,255,255,.05); margin-top:16px; padding-top:16px; display:flex; gap:10px; overflow-x:auto; padding-bottom:4px;">
                <style>
                    .cat-pill {
                        padding:6px 14px; border-radius:20px; font-size:12px; font-weight:700; white-space:nowrap; text-decoration:none; transition:all 0.2s;
                    }
                    .cat-pill.active {
                        background: rgba(255,200,26,.15); color: #FFC81A; border: 1px solid rgba(255,200,26,.3);
                    }
                    .cat-pill.inactive {
                        background: rgba(255,255,255,.03); color: rgba(255,255,255,.5); border: 1px solid rgba(255,255,255,.08);
                    }
                    .cat-pill.inactive:hover {
                        background: rgba(255,255,255,.08); color: #FFF; border-color: rgba(255,255,255,.15);
                    }
                </style>
                <a href="{{ request()->fullUrlWithQuery(['kategori' => null]) }}" class="cat-pill {{ !request('kategori') ? 'active' : 'inactive' }}">
                    Semua Kategori
                </a>
                @foreach($kategoris ?? [] as $kat)
                <a href="{{ request()->fullUrlWithQuery(['kategori' => $kat->id]) }}" class="cat-pill {{ request('kategori') == $kat->id ? 'active' : 'inactive' }}">
                    {{ $kat->nama_kategori }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Grid Content --}}
    {{-- Table Content --}}
    <div style="padding:48px 24px; max-width:1100px; margin:0 auto;">
        <div class="fcc-card-dark" style="overflow:hidden; border-radius:20px; border:1.5px solid rgba(255,255,255,.08); background:rgba(255,255,255,.03); box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; text-align:left; color:#FFF;">
                    <thead>
                        <tr style="background:rgba(255,255,255,.04); border-bottom:1.5px solid rgba(255,255,255,.08);">
                            <th style="padding:16px 24px; font-size:11px; font-weight:800; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:1px;">Program / Kegiatan</th>
                            <th style="padding:16px 16px; font-size:11px; font-weight:800; color:rgba(255,255,255,.5); text-transform:uppercase; text-align:center;">Jenis</th>
                            <th style="padding:16px 16px; font-size:11px; font-weight:800; color:rgba(255,255,255,.5); text-transform:uppercase;">Jadwal Pelaksanaan</th>
                            <th style="padding:16px 16px; font-size:11px; font-weight:800; color:rgba(255,255,255,.5); text-transform:uppercase; text-align:center;">Kuota</th>
                            <th style="padding:16px 24px; font-size:11px; font-weight:800; color:rgba(255,255,255,.5); text-transform:uppercase; text-align:center; width:160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatan as $k)
                        @php 
                            $isPel = $k->jenis_kegiatan === 'pelatihan'; 
                            $accentColor = $isPel ? '#FFC81A' : '#A78BFA';
                            $accentBg = $isPel ? 'rgba(255,200,26,0.15)' : 'rgba(139,92,246,0.12)';
                        @endphp
                        <tr style="border-top:1px solid rgba(255,255,255,.06); transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,.02)'" onmouseout="this.style.background='transparent'">
                            <td style="padding:18px 24px;">
                                <div style="display:flex; align-items:center; gap:16px;">
                                    <div style="width:46px; height:46px; border-radius:12px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>22,'style'=>'color:'.$accentColor])
                                    </div>
                                    <div>
                                        <h4 style="margin:0 0 4px; color:#FFF; font-size:15px; font-weight:800; line-height:1.35;">
                                            <a href="{{ route('landing.show', $k) }}" style="color:#FFF; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#FFF'">
                                                {{ $k->judul }}
                                            </a>
                                        </h4>
                                        <span style="font-size:12px; color:rgba(255,255,255,.45); font-weight:500;">
                                            Biaya: <strong style="color:{{ $accentColor }}">{{ $k->biaya->isNotEmpty() ? 'Berbayar' : 'Gratis' }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:18px 16px; text-align:center; vertical-align:middle;">
                                <span style="font-size:10.5px; font-weight:800; padding:4px 12px; border-radius:8px; background:{{ $accentBg }}; color:{{ $accentColor }}; border:1px solid {{ $accentColor }}30; text-transform:uppercase; letter-spacing:0.5px;">
                                    {{ $k->jenis_kegiatan }}
                                </span>
                            </td>
                            <td style="padding:18px 16px; vertical-align:middle; font-size:13.5px; color:rgba(255,255,255,.7); font-weight:600;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    @include('components.icon',['name'=>'calendar','size'=>14,'style'=>'color:rgba(255,255,255,.4)'])
                                    <span>{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Jadwal Menyusul' }}</span>
                                </div>
                            </td>
                            <td style="padding:18px 16px; text-align:center; vertical-align:middle;">
                                <span style="background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.08); padding:5px 12px; border-radius:8px; font-size:12.5px; font-weight:700; color:#FFF;">
                                    {{ $k->terisi }} / {{ $k->kuota }}
                                </span>
                            </td>
                            <td style="padding:18px 24px; text-align:center; vertical-align:middle;">
                                <a href="{{ route('landing.show', $k) }}"
                                   class="{{ $k->isFull() ? '' : 'fcc-btn-gold btn-shine' }}"
                                   style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; padding:9px 16px; border-radius:10px; font-size:13px; font-weight:800; transition:all 0.2s ease; width:100%;
                                          {{ $k->isFull() ? 'background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); color:rgba(255,255,255,.4); cursor:not-allowed;' : '' }}">
                                    {{ $k->isFull() ? 'Kuota Penuh' : 'Detail Program' }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding:60px 24px; text-align:center; color:rgba(255,255,255,.4); font-size:14.5px;">
                                Belum ada program pelatihan atau sertifikasi yang sesuai dengan kriteria pencarian Anda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($kegiatan->hasPages())
        <div style="margin-top:40px; display:flex; justify-content:center;" class="fcc-pagination-dark">
            {{ $kegiatan->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<style>
/* Temporary style override for pagination to look good on dark background */
.fcc-pagination-dark nav { display: flex; align-items: center; justify-content: center; }
.fcc-pagination-dark nav svg { width: 20px; height: 20px; }
.fcc-pagination-dark nav a, .fcc-pagination-dark nav span.relative { background: rgba(255,255,255,.03) !important; border: 1px solid rgba(255,255,255,.08) !important; color: #FFF !important; margin: 0 4px; border-radius: 8px !important; box-shadow: none !important; }
.fcc-pagination-dark nav span[aria-current="page"] span { background: #FFC81A !important; color: #131218 !important; border-color: #FFC81A !important; }
.fcc-pagination-dark nav a:hover { background: rgba(255,255,255,.1) !important; border-color: rgba(255,255,255,.15) !important; }
</style>
@endsection
