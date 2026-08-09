<div style="background:#F8F9FA; min-height: calc(100vh - 240px);">
    {{-- Filter Bar --}}
    <div style="background: #FFFFFF; border-bottom: 1.5px solid #E5E7EB; padding: 14px 24px; position: sticky; top: 64px; z-index: 50; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
        <div style="max-width: 1180px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
            
            <!-- Category Tabs (Semua | Pelatihan | Sertifikasi) -->
            <div style="display:inline-flex; gap:6px; background:#F1F5F9; padding:5px; border-radius:14px; border:1px solid #E2E8F0;">
                @foreach([['','Semua Kegiatan'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
                <button type="button" wire:click="$set('jenis', '{{ $v }}')"
                    style="padding: 8px 20px; border-radius: 10px; border: {{ $jenis === $v ? '1.5px solid #131218' : 'none' }}; font-size: 13px; font-weight: 900; cursor: pointer; transition: all .2s ease;
                           background: {{ $jenis === $v ? '#FFC81A' : 'transparent' }};
                           color: {{ $jenis === $v ? '#131218' : '#64748B' }};
                           box-shadow: {{ $jenis === $v ? '0 2px 8px rgba(255,200,26,0.3)' : 'none' }};">
                    {{ $l }}
                </button>
                @endforeach
            </div>
            
            <!-- Search & Kategori Selector -->
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <select wire:model.live="kategoriId" style="padding: 9px 14px; font-size:13px; font-weight:700; border-radius:12px; border: 1.5px solid #CBD5E1; background:#FFFFFF; color:#0F172A; outline:none; cursor:pointer;">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>

                <div style="position:relative;">
                    <svg style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#64748B; pointer-events:none;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kegiatan..."
                        style="padding: 9px 16px 9px 38px; width: 240px; font-size:13px; font-weight:600; border-radius:12px; border: 1.5px solid #CBD5E1; background:#FFFFFF; color:#0F172A; outline:none;"
                        onfocus="this.style.borderColor='#FFC81A'; this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)'"
                        onblur="this.style.borderColor='#CBD5E1'; this.style.boxShadow='none'">
                </div>

                @if($search || $jenis || $kategoriId)
                <button type="button" wire:click="resetFilters" style="display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:10px; border:1.5px solid rgba(239,68,68,0.4); background:rgba(239,68,68,0.1); color:#EF4444; font-size:12px; font-weight:800; cursor:pointer;" title="Reset Filter">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Reset
                </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Cards Grid Container --}}
    <div style="padding:40px 24px 60px; max-width:1180px; margin:0 auto; position:relative;">
        
        {{-- Loading Indicator --}}
        <div wire:loading style="position:absolute; top:16px; right:30px; background:#FFC81A; color:#131218; font-size:11px; font-weight:900; padding:5px 16px; border-radius:20px; z-index:10; box-shadow:0 4px 12px rgba(255,200,26,0.3); border:1.5px solid #131218;">
            Memuat Data...
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(340px, 1fr)); gap:24px;">
            @forelse($kegiatan as $k)
            @php
                $isPel = $k->jenis_kegiatan === 'pelatihan';
                $posterUrl = $k->detail?->gambar_url;
            @endphp
            <div style="border-radius:18px; border:2px solid #E5E7EB; background:#FFFFFF; overflow:hidden; display:flex; flex-direction:column; justify-content:space-between; transition:all 0.28s ease; box-shadow:0 4px 16px rgba(0,0,0,0.04);"
                 onmouseover="this.style.transform='translateY(-6px)'; this.style.borderColor='#FFC81A'; this.style.boxShadow='0 16px 32px rgba(0,0,0,0.08)';"
                 onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E5E7EB'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">

                <div>
                    {{-- Poster Banner --}}
                    <div style="position:relative; width:100%; height:185px; overflow:hidden; background:#131218;">
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
                        <div style="position:absolute;top:12px;left:12px;display:flex;gap:6px;">
                            <span style="font-size:10.5px; font-weight:900; padding:4px 10px; border-radius:6px; background:#FFC81A; color:#131218; border:1px solid #131218; text-transform:uppercase; letter-spacing:0.5px;">
                                {{ ucfirst($k->jenis_kegiatan) }}
                            </span>
                        </div>
                        <div style="position:absolute;top:12px;right:12px;">
                            <span style="font-size:10.5px; font-weight:800; color:{{ $k->isComingSoon() ? '#D97706' : ($k->isFull() ? '#EF4444' : '#131218') }}; background:#FFFFFF; padding:4px 10px; border-radius:6px; border:1px solid #131218; box-shadow:0 2px 8px rgba(0,0,0,0.15);">
                                {{ $k->isComingSoon() ? 'Segera Hadir' : ($k->isFull() ? 'Kuota Penuh' : ($k->biaya->isNotEmpty() ? 'Berbayar' : 'Gratis')) }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div style="padding:18px 20px 14px;">
                        
                        {{-- Title --}}
                        <h4 style="margin:0 0 12px; color:#131218; font-size:15.5px; font-weight:800; line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; height:44px;">
                            <a href="{{ route('landing.show', $k) }}" style="color:#131218; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#F59E0B'" onmouseout="this.style.color='#131218'">
                                {{ $k->judul }}
                            </a>
                        </h4>

                        {{-- Meta Info --}}
                        <div style="display:flex; flex-direction:column; gap:6px; font-size:12.5px; color:#4B5563; font-weight:700; margin-bottom:12px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                @include('components.icon',['name'=>'calendar','size'=>15,'style'=>'color:#D97706'])
                                <span>Pelaksanaan: <strong style="color:#131218;">{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Jadwal Menyusul' }}</strong></span>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                @include('components.icon',['name'=>'clock','size'=>15,'style'=>'color:#D97706'])
                                <span>Batas Daftar: <strong style="color:#131218;">{{ $k->jadwal?->tgl_batas_daftar?->format('d M Y') ?? '—' }}</strong></span>
                            </div>
                        </div>

                        {{-- Kuota Progress Bar --}}
                        <div style="background:#F8F9FA; border-radius:10px; padding:8px 10px; border:1px solid #E5E7EB; margin-bottom:12px;">
                            <div style="display:flex; justify-content:space-between; font-size:11px; color:#4B5563; margin-bottom:4px; font-weight:700;">
                                <span>Peserta Terdaftar</span>
                                <span style="color:#131218;font-weight:800;">{{ $k->terisi }} / {{ $k->kuota }}</span>
                            </div>
                            <div style="height:5px; background:#E5E7EB; border-radius:3px; overflow:hidden;">
                                <div style="height:5px; border-radius:3px; transition:width 0.3s;
                                            background:{{ $k->isComingSoon() ? '#F59E0B' : ($k->isFull() ? '#EF4444' : '#FFC81A') }};
                                            width:{{ $k->kuota>0 ? min(100, round($k->terisi/$k->kuota*100)) : 0 }}%;"></div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Action Button --}}
                <div style="padding:0 20px 18px;">
                    <a href="{{ route('landing.show', $k) }}"
                       style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none; padding:11px 14px; border-radius:10px; font-size:13px; font-weight:800; transition:all 0.2s ease; width:100%; box-sizing:border-box;
                              {{ $k->isComingSoon() ? 'background:#FFFBEB; border:1.5px solid #F59E0B; color:#D97706;' : ($k->isFull() ? 'background:#F3F4F6; border:1px solid #E5E7EB; color:#9CA3AF; cursor:not-allowed;' : 'background:#FFC81A; color:#131218; border:1.5px solid #131218; box-shadow:0 4px 12px rgba(255,200,26,0.3);') }}">
                        {{ $k->isComingSoon() ? 'Segera Hadir →' : ($k->isFull() ? 'Kuota Penuh' : 'Detail & Daftar →') }}
                    </a>
                </div>
            </div>
            @empty
            <div style="grid-column:1 / -1; padding:64px 24px; text-align:center; color:#64748B; background:#FFFFFF; border:2px solid #E5E7EB; border-radius:18px;">
                <div style="width:56px; height:56px; border-radius:16px; background:#FFFDF5; border:1.5px solid #FFC81A; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:#D97706;">
                    @include('components.icon',['name'=>'info','size'=>26])
                </div>
                <h3 style="margin:0 0 6px; color:#0F172A; font-size:16px; font-weight:900;">Kegiatan Tidak Ditemukan</h3>
                <p style="margin:0; font-size:13.5px; color:#64748B;">Belum ada program pelatihan atau sertifikasi yang sesuai dengan kata kunci pencarian Anda.</p>
            </div>
            @endforelse
        </div>

        @if($kegiatan->hasPages())
        <div style="margin-top:36px; display:flex; justify-content:center;" class="fcc-pagination-light">
            {{ $kegiatan->links() }}
        </div>
        @endif
    </div>
</div>
