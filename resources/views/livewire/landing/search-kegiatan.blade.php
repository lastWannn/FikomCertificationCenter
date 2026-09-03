<div style="background:#F8F9FA; min-height: calc(100vh - 240px); box-sizing:border-box; width:100%;">
    {{-- Filter Bar --}}
    <div class="fcc-kegiatan-filter-bar">
        <div style="max-width: 1180px; margin: 0 auto; width: 100%;" class="fcc-filter-inner">
            
            <!-- Category Tabs (Semua | Pelatihan | Sertifikasi) -->
            <div class="fcc-category-tabs">
                @foreach([['','Semua Kegiatan'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
                <button type="button" wire:click="$set('jenis', '{{ $v }}')"
                    class="fcc-cat-tab-btn {{ $jenis === $v ? 'active' : '' }}">
                    {{ $l }}
                </button>
                @endforeach
            </div>
            
            <!-- Search & Kategori Selector -->
            <div class="fcc-search-controls">
                <select wire:model.live="kategoriId" class="fcc-kat-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>

                <div class="fcc-search-input-wrap">
                    <svg style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#64748B; pointer-events:none;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari program..."
                        class="fcc-search-inp"
                        onfocus="this.style.borderColor='#FFC81A'; this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)'"
                        onblur="this.style.borderColor='#CBD5E1'; this.style.boxShadow='none'">
                </div>

                @if($search || $jenis || $kategoriId)
                <button type="button" wire:click="resetFilters" class="fcc-reset-btn" title="Reset Filter">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    <span>Reset</span>
                </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Cards Grid Container --}}
    <div class="fcc-kegiatan-container">
        
        {{-- Loading Indicator --}}
        <div wire:loading style="position:absolute; top:16px; right:20px; background:#FFC81A; color:#131218; font-size:11px; font-weight:900; padding:5px 16px; border-radius:20px; z-index:10; box-shadow:0 4px 12px rgba(255,200,26,0.3); border:1.5px solid #131218;">
            Memuat Data...
        </div>

        <div class="fcc-kegiatan-cards-grid">
            @forelse($kegiatan as $k)
            @php
                $isPel = $k->jenis_kegiatan === 'pelatihan';
                $posterUrl = $k->detail?->gambar_url;
            @endphp
            <div class="fcc-kegiatan-card"
                 style="cursor:pointer;"
                 onclick="window.location.href='{{ route('landing.show', $k) }}';"
                 onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='#FFC81A'; this.style.boxShadow='0 14px 28px rgba(0,0,0,0.08)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E5E7EB'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">

                <div>
                    {{-- Poster Banner --}}
                    <div class="fcc-poster-wrap">
                        @if($posterUrl)
                        <img src="{{ $posterUrl }}" alt="{{ $k->judul }}" style="width:100%; height:100%; object-fit:cover; object-position:center top; display:block; transition:transform 0.4s ease;"
                             onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        @else
                        <div style="width:100%; height:100%; background:#131218; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px;">
                            @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>36,'style'=>'color:#FFC81A'])
                            <span style="font-size:11px; font-weight:800; color:#FFC81A; text-transform:uppercase; letter-spacing:1.5px;">{{ ucfirst($k->jenis_kegiatan) }}</span>
                        </div>
                        @endif

                        {{-- Floating Badges over Poster --}}
                        <div style="position:absolute;top:10px;left:10px;display:flex;gap:6px;">
                            <span style="font-size:10px; font-weight:900; padding:3px 8px; border-radius:6px; background:#FFC81A; color:#131218; border:1px solid #131218; text-transform:uppercase; letter-spacing:0.5px;">
                                {{ ucfirst($k->jenis_kegiatan) }}
                            </span>
                        </div>
                        <div style="position:absolute;top:10px;right:10px;">
                            <span style="font-size:10px; font-weight:800; color:{{ $k->isComingSoon() ? '#D97706' : ($k->isRegistrationClosed() ? '#EF4444' : ($k->isFull() ? '#EF4444' : '#131218')) }}; background:#FFFFFF; padding:3px 8px; border-radius:6px; border:1px solid #131218; box-shadow:0 2px 8px rgba(0,0,0,0.15);">
                                {{ $k->isComingSoon() ? 'Segera Hadir' : ($k->isRegistrationClosed() ? 'Pendaftaran Ditutup' : ($k->isFull() ? 'Kuota Penuh' : ($k->biaya->isNotEmpty() ? 'Berbayar' : 'Gratis'))) }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div style="padding:16px 18px 12px; box-sizing:border-box;">
                        
                        {{-- Title --}}
                        <h4 style="margin:0 0 10px; color:#131218; font-size:15px; font-weight:800; line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; min-height:42px;">
                            <a href="{{ route('landing.show', $k) }}" style="color:#131218; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#F59E0B'" onmouseout="this.style.color='#131218'">
                                {{ $k->judul }}
                            </a>
                        </h4>

                        {{-- Meta Info --}}
                        <div style="display:flex; flex-direction:column; gap:6px; font-size:12px; color:#4B5563; font-weight:700; margin-bottom:12px;">
                            <div style="display:flex; align-items:center; gap:7px;">
                                @include('components.icon',['name'=>'calendar','size'=>14,'style'=>'color:#D97706;flex-shrink:0;'])
                                <span style="word-break:break-word;">Pelaksanaan: <strong style="color:#131218;">{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Jadwal Menyusul' }}</strong></span>
                            </div>
                            <div style="display:flex; align-items:center; gap:7px;">
                                @include('components.icon',['name'=>'clock','size'=>14,'style'=>'color:#D97706;flex-shrink:0;'])
                                <span style="word-break:break-word;">Batas Daftar: <strong style="color:#131218;">{{ $k->jadwal?->tgl_batas_daftar?->format('d M Y') ?? '—' }}</strong></span>
                            </div>
                        </div>

                        {{-- Kuota Progress Bar --}}
                        <div style="background:#F8F9FA; border-radius:10px; padding:8px 10px; border:1px solid #E5E7EB; margin-bottom:10px;">
                            <div style="display:flex; justify-content:space-between; font-size:11px; color:#4B5563; margin-bottom:4px; font-weight:700;">
                                <span>Peserta Terdaftar</span>
                                <span style="color:#131218;font-weight:800;">{{ $k->terisi }} / {{ $k->kuota }}</span>
                            </div>
                            <div style="height:5px; background:#E5E7EB; border-radius:3px; overflow:hidden;">
                                <div style="height:5px; border-radius:3px; transition:width 0.3s;
                                            background:{{ $k->isComingSoon() ? '#F59E0B' : ($k->isRegistrationClosed() || $k->isFull() ? '#EF4444' : '#FFC81A') }};
                                            width:{{ $k->kuota>0 ? min(100, round($k->terisi/$k->kuota*100)) : 0 }}%;"></div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Action Button --}}
                <div style="padding:0 18px 16px; box-sizing:border-box;">
                    @if($k->isRegistrationClosed())
                    <button disabled
                       style="display:inline-flex; align-items:center; justify-content:center; padding:10px 14px; border-radius:10px; font-size:13px; font-weight:800; width:100%; box-sizing:border-box; background:#F3F4F6; border:1px solid #E5E7EB; color:#9CA3AF; cursor:not-allowed;">
                        Pendaftaran Ditutup
                    </button>
                    @elseif($k->isComingSoon())
                    <a href="{{ route('landing.show', $k) }}"
                       style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; padding:10px 14px; border-radius:10px; font-size:13px; font-weight:800; transition:all 0.2s ease; width:100%; box-sizing:border-box; background:#FFFBEB; border:1.5px solid #F59E0B; color:#D97706;">
                        Segera Hadir →
                    </a>
                    @elseif($k->isFull())
                    <button disabled
                       style="display:inline-flex; align-items:center; justify-content:center; padding:10px 14px; border-radius:10px; font-size:13px; font-weight:800; width:100%; box-sizing:border-box; background:#F3F4F6; border:1px solid #E5E7EB; color:#9CA3AF; cursor:not-allowed;">
                        Kuota Penuh
                    </button>
                    @else
                    <a href="{{ route('landing.show', $k) }}"
                       style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; padding:10px 14px; border-radius:10px; font-size:13px; font-weight:800; transition:all 0.2s ease; width:100%; box-sizing:border-box; background:#FFC81A; color:#131218; border:1.5px solid #131218; box-shadow:0 4px 12px rgba(255,200,26,0.3);">
                        Detail &amp; Daftar →
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div style="grid-column:1 / -1; padding:48px 20px; text-align:center; color:#64748B; background:#FFFFFF; border:2px solid #E5E7EB; border-radius:18px; width:100%; box-sizing:border-box;">
                <div style="width:52px; height:52px; border-radius:14px; background:#FFFDF5; border:1.5px solid #FFC81A; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; color:#D97706;">
                    @include('components.icon',['name'=>'info','size'=>24])
                </div>
                <h3 style="margin:0 0 6px; color:#0F172A; font-size:15.5px; font-weight:900;">Kegiatan Tidak Ditemukan</h3>
                <p style="margin:0; font-size:13px; color:#64748B; max-width:400px; margin:0 auto;">Belum ada program pelatihan atau sertifikasi yang sesuai dengan filter pencarian Anda.</p>
            </div>
            @endforelse
        </div>

        @if($kegiatan->hasPages())
        <div style="margin-top:32px; display:flex; justify-content:center;" class="fcc-pagination-light">
            {{ $kegiatan->links() }}
        </div>
        @endif
    </div>
</div>

<style>
/* Filter Bar Styling */
.fcc-kegiatan-filter-bar {
    background: #FFFFFF;
    border-bottom: 1.5px solid #E5E7EB;
    padding: 14px 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    box-sizing: border-box;
    width: 100%;
}
.fcc-filter-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    flex-wrap: wrap;
    box-sizing: border-box;
}
.fcc-category-tabs {
    display: inline-flex;
    gap: 4px;
    background: #F1F5F9;
    padding: 4px;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    box-sizing: border-box;
}
.fcc-cat-tab-btn {
    padding: 7px 16px;
    border-radius: 9px;
    border: none;
    font-size: 12.5px;
    font-weight: 800;
    cursor: pointer;
    transition: all .2s ease;
    background: transparent;
    color: #64748B;
    white-space: nowrap;
}
.fcc-cat-tab-btn.active {
    background: #FFC81A;
    color: #131218;
    border: 1.5px solid #131218;
    box-shadow: 0 2px 8px rgba(255,200,26,0.3);
    font-weight: 900;
}
.fcc-search-controls {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    box-sizing: border-box;
}
.fcc-kat-select {
    padding: 8px 12px;
    font-size: 12.5px;
    font-weight: 700;
    border-radius: 10px;
    border: 1.5px solid #CBD5E1;
    background: #FFFFFF;
    color: #0F172A;
    outline: none;
    cursor: pointer;
    box-sizing: border-box;
}
.fcc-search-input-wrap {
    position: relative;
    box-sizing: border-box;
}
.fcc-search-inp {
    padding: 8px 14px 8px 36px;
    width: 220px;
    font-size: 12.5px;
    font-weight: 600;
    border-radius: 10px;
    border: 1.5px solid #CBD5E1;
    background: #FFFFFF;
    color: #0F172A;
    outline: none;
    box-sizing: border-box;
}
.fcc-reset-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 8px 12px;
    border-radius: 10px;
    border: 1.5px solid rgba(239,68,68,0.4);
    background: rgba(239,68,68,0.1);
    color: #EF4444;
    font-size: 12px;
    font-weight: 800;
    cursor: pointer;
    box-sizing: border-box;
}

/* Cards Layout */
.fcc-kegiatan-container {
    padding: 36px 24px 64px;
    max-width: 1180px;
    margin: 0 auto;
    position: relative;
    box-sizing: border-box;
    width: 100%;
}
.fcc-kegiatan-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
    gap: 24px;
    width: 100%;
    box-sizing: border-box;
}
.fcc-kegiatan-card {
    border-radius: 18px;
    border: 2px solid #E5E7EB;
    background: #FFFFFF;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.28s ease;
    box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    box-sizing: border-box;
    width: 100%;
}
.fcc-poster-wrap {
    position: relative;
    width: 100%;
    height: 185px;
    overflow: hidden;
    background: #131218;
}

/* Mobile & Tablet Responsiveness */
@media (max-width: 767px) {
    .fcc-kegiatan-filter-bar {
        padding: 12px 14px;
    }
    .fcc-filter-inner {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    .fcc-category-tabs {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        text-align: center;
    }
    .fcc-cat-tab-btn {
        padding: 7px 4px;
        font-size: 11.5px;
        text-align: center;
        justify-content: center;
    }
    .fcc-search-controls {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
    }
    .fcc-kat-select {
        width: 100%;
    }
    .fcc-search-input-wrap {
        width: 100%;
    }
    .fcc-search-inp {
        width: 100%;
    }
    .fcc-reset-btn {
        width: 100%;
        justify-content: center;
    }
    .fcc-kegiatan-container {
        padding: 24px 14px 48px;
    }
    .fcc-kegiatan-cards-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .fcc-poster-wrap {
        height: 170px;
    }
}
</style>
