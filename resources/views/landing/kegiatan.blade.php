@extends('layouts.public')
@section('title','Kegiatan')
@section('page-content')
<div style="padding-top:68px; background:#F9FAFB; min-height: calc(100vh - 68px);">
    {{-- Page Header --}}
    <div style="background: linear-gradient(135deg, #131218 0%, #1c1b22 100%); padding: 76px 24px 64px; text-align: center; position: relative; overflow: hidden; border-bottom: 1px solid rgba(255, 200, 26, 0.08);">
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
    <div style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid #E2E4EB; padding: 16px 24px; position: sticky; top: 68px; z-index: 50; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
            <form method="GET" action="{{ route('landing.kegiatan') }}" style="display:flex; width:100%; justify-content:space-between; gap:16px; align-items:center; flex-wrap:wrap; margin:0;">
                
                <!-- Category Select (Segmented Control) -->
                <div style="display:inline-flex; gap:4px; background:#F1F3F6; padding:4px; border-radius:12px; border:1px solid #E2E4EB;">
                    @foreach([['semua','Semua Kegiatan'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
                    <button type="submit" name="jenis" value="{{ $v }}"
                        style="padding: 8px 18px; border-radius: 9px; border: none; font-size: 13px; font-weight: 800; cursor: pointer; transition: all .2s ease;
                               background: {{ request('jenis', 'semua') === $v || ($v === 'semua' && !request('jenis')) ? '#FFF' : 'transparent' }};
                               color: {{ request('jenis', 'semua') === $v || ($v === 'semua' && !request('jenis')) ? '#131218' : '#6B7280' }};
                               box-shadow: {{ request('jenis', 'semua') === $v || ($v === 'semua' && !request('jenis')) ? '0 2px 8px rgba(0,0,0,0.06)' : 'none' }};">
                        {{ $l }}
                    </button>
                    @endforeach
                </div>
                
                <!-- Search Input Group -->
                <div style="position:relative; display:flex; align-items:center; gap:8px;">
                    <div style="position:relative;">
                        <svg style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#9CA3AF; pointer-events:none;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pelatihan / sertifikasi..."
                            class="fcc-input" style="padding: 10px 16px 10px 38px; width: 260px; font-size:13px; border-radius:12px; border: 1.5px solid #E2E4EB; background:#FFF; transition:all 0.3s ease; outline:none;"
                            onfocus="this.style.borderColor='#FFC81A'; this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.15)'"
                            onblur="this.style.borderColor='#E2E4EB'; this.style.boxShadow='none'"
                            onkeydown="if(event.key==='Enter')this.form.submit()">
                    </div>
                    @if(request('q') || request('jenis'))
                    <a href="{{ route('landing.kegiatan') }}" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:12px; border:1.5px solid #E2E4EB; background:#FFF; color:#EF4444; transition:all 0.2s;" title="Reset Filter" onmouseover="this.style.background='#FEE2E2'" onmouseout="this.style.background='#FFF'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Grid Content --}}
    <div style="padding:48px 24px; max-width:1100px; margin:0 auto;">
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:28px;">
            @forelse($kegiatan as $k)
            @php 
                $isPel = $k->jenis_kegiatan === 'pelatihan'; 
                $accentColor = $isPel ? '#FFC81A' : '#8B5CF6';
                $accentBg = $isPel ? 'rgba(255,200,26,0.12)' : 'rgba(139,92,246,0.1)';
            @endphp
            <div class="fcc-card" style="overflow:hidden; border-radius:20px; border:1.5px solid #E2E4EB; background:#FFF; transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1); display:flex; flex-direction:column;"
                 onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 16px 36px rgba(0,0,0,0.06)'; this.style.borderColor='{{ $accentColor }}44';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,.03)'; this.style.borderColor='#E2E4EB';">
                
                {{-- Card Banner --}}
                <div style="height:148px; position:relative; overflow:hidden; background:linear-gradient(135deg, #131218 0%, #1e1b29 100%);">
                    @if($k->detail?->gambar)
                        <img src="{{ asset('storage/' . $k->detail->gambar) }}" style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0;" alt="Poster" />
                    @else
                        <div style="position:absolute; inset:0; opacity:.04; background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px); background-size:20px 20px;"></div>
                        <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                            <div style="width:64px; height:64px; border-radius:18px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); display:flex; align-items:center; justify-content:center;">
                                @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>30,'style'=>'color:'.$accentColor])
                            </div>
                        </div>
                    @endif
                    
                    {{-- Badges --}}
                    <div style="position:absolute; top:12px; left:12px;">
                        <span style="font-size:10.5px; font-weight:800; padding:4px 10px; border-radius:8px; background:{{ $accentBg }}; color:{{ $accentColor }}; border:1px solid {{ $accentColor }}30; text-transform:uppercase; letter-spacing:0.5px;">
                            {{ $k->jenis_kegiatan }}
                        </span>
                    </div>
                    @if($k->isFull())
                    <div style="position:absolute; top:12px; right:12px;">
                        <span style="font-size:10.5px; font-weight:800; padding:4px 10px; border-radius:8px; background:rgba(239,68,68,0.15); color:#EF4444; border:1px solid rgba(239,68,68,0.25); text-transform:uppercase;">
                            Penuh
                        </span>
                    </div>
                    @endif
                </div>
                
                {{-- Card Body --}}
                <div style="padding:22px 20px; display:flex; flex-direction:column; flex-grow:1; justify-content:space-between;">
                    <div>
                        <h4 style="color:#131218; font-size:16px; font-weight:900; margin:0 0 12px; line-height:1.45; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; height:46px;">
                            {{ $k->judul }}
                        </h4>
                        
                        <div style="display:flex; flex-direction:column; gap:8px; margin-bottom:18px;">
                            <div style="display:flex; align-items:center; gap:8px; color:#6B7280; font-size:13px; font-weight:500;">
                                <div style="width:22px; height:22px; border-radius:6px; background:#F3F4F6; display:flex; align-items:center; justify-content:center;">
                                    @include('components.icon',['name'=>'calendar','size'=>12,'style'=>'color:#6B7280'])
                                </div>
                                <span>{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Jadwal Menyusul (TBA)' }}</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px; color:#6B7280; font-size:13px; font-weight:500;">
                                <div style="width:22px; height:22px; border-radius:6px; background:#F3F4F6; display:flex; align-items:center; justify-content:center;">
                                    @include('components.icon',['name'=>'users','size'=>12,'style'=>'color:#6B7280'])
                                </div>
                                <span>Terisi <strong>{{ $k->terisi }}</strong> dari <strong>{{ $k->kuota }}</strong> peserta</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div style="background:#F9FAFB; border-radius:12px; border:1px solid #E5E7EB; padding:10px 14px; display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                            <span style="color:#6B7280; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">Biaya</span>
                            <span style="color:{{ $isPel ? '#D97706' : '#7C3AED' }}; font-weight:900; font-size:14.5px;">
                                {{ $k->biaya->isNotEmpty() ? 'Rp '.number_format($k->biaya->min('nominal'),0,',','.') : 'Gratis' }}
                            </span>
                        </div>
                        
                        <a href="{{ route('landing.show', $k) }}"
                           class="{{ $k->isFull() ? '' : 'fcc-btn-gold' }}"
                           style="display:block; text-align:center; text-decoration:none; padding:11px; border-radius:12px; font-size:13.5px; font-weight:800; transition:all 0.2s ease;
                                  {{ $k->isFull() ? 'background:#F3F4F6; border:1px solid #E5E7EB; color:#9CA3AF; cursor:not-allowed;' : 'box-shadow: 0 4px 12px rgba(255, 200, 26, 0.15);' }}">
                            {{ $k->isFull() ? 'Kuota Penuh' : 'Detail Program' }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column:span 3; padding:80px 48px; text-align:center; background:#FFF; border-radius:20px; border:1.5px solid #E2E4EB;">
                <div style="width:54px; height:54px; border-radius:50%; background:#FEE2E2; color:#EF4444; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <h4 style="margin:0 0 8px; color:#131218; font-size:16px; font-weight:900;">Kegiatan Tidak Ditemukan</h4>
                <p style="margin:0; color:#6B7280; font-size:14px;">Belum ada program pelatihan atau sertifikasi yang sesuai dengan kriteria pencarian Anda.</p>
            </div>
            @endforelse
        </div>
        @if($kegiatan->hasPages())
        <div style="margin-top:40px; display:flex; justify-content:center;">
            {{ $kegiatan->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
