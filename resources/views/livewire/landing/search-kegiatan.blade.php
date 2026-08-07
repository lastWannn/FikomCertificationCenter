<div style="background:#F8F9FA; min-height: calc(100vh - 240px);">
    {{-- Filter Bar --}}
    <div style="background: #FFFFFF; border-bottom: 1.5px solid #E5E7EB; padding: 14px 24px; position: sticky; top: 64px; z-index: 50; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
        <div style="max-width: 1100px; margin: 0 auto; display: flex; flex-direction: column; gap: 12px;">
            <div style="display:flex; width:100%; justify-content:space-between; gap:14px; align-items:center; flex-wrap:wrap; margin:0;">
                
                <!-- Category Select (Segmented Control) -->
                <div style="display:inline-flex; gap:4px; background:#F1F5F9; padding:4px; border-radius:12px; border:1px solid #E2E8F0;">
                    @foreach([['','Semua Kegiatan'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
                    <button type="button" wire:click="$set('jenis', '{{ $v }}')"
                        style="padding: 7px 18px; border-radius: 9px; border: {{ $jenis === $v ? '1.5px solid #131218' : 'none' }}; font-size: 13px; font-weight: 900; cursor: pointer; transition: all .2s ease;
                               background: {{ $jenis === $v ? '#FFC81A' : 'transparent' }};
                               color: {{ $jenis === $v ? '#131218' : '#64748B' }};
                               box-shadow: {{ $jenis === $v ? '0 2px 8px rgba(255,200,26,0.3)' : 'none' }};">
                        {{ $l }}
                    </button>
                    @endforeach
                </div>
                
                <!-- Search Input Group -->
                <div style="position:relative; display:flex; align-items:center; gap:8px;">
                    <div style="position:relative;">
                        <svg style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#64748B; pointer-events:none;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari pelatihan / sertifikasi..."
                            style="padding: 9px 16px 9px 38px; width: 260px; font-size:13px; font-weight:600; border-radius:12px; border: 1.5px solid #CBD5E1; background:#FFFFFF; color:#0F172A; transition:all 0.3s ease; outline:none;"
                            onfocus="this.style.borderColor='#FFC81A'; this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)'"
                            onblur="this.style.borderColor='#CBD5E1'; this.style.boxShadow='none'">
                    </div>
                    @if($search || $jenis || $kategoriId)
                    <button type="button" wire:click="resetFilters" style="display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:10px; border:1.5px solid rgba(239,68,68,0.4); background:rgba(239,68,68,0.1); color:#EF4444; transition:all 0.2s; cursor:pointer;" title="Reset Filter">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Grid Content / Table --}}
    <div style="padding:40px 24px; max-width:1100px; margin:0 auto; position:relative;">
        {{-- Loading Indicator --}}
        <div wire:loading style="position:absolute; top:16px; right:30px; background:#FFC81A; color:#131218; font-size:11px; font-weight:900; padding:4px 14px; border-radius:20px; z-index:10; box-shadow:0 4px 12px rgba(255,200,26,0.3); border:1px solid #131218;">
            Memuat Data...
        </div>

        <div style="overflow:hidden; border-radius:18px; border:1.5px solid #E2E8F0; background:#FFFFFF; box-shadow: 0 8px 24px rgba(0,0,0,0.05);">
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; text-align:left; color:#0F172A;">
                    <thead>
                        <tr style="background:#131218; border-bottom:2px solid #FFC81A;">
                            <th style="padding:16px 24px; font-size:11.5px; font-weight:900; color:#FFC81A; text-transform:uppercase; letter-spacing:1px;">Program / Kegiatan</th>
                            <th style="padding:16px 16px; font-size:11.5px; font-weight:900; color:#FFC81A; text-transform:uppercase; text-align:center;">Jenis</th>
                            <th style="padding:16px 16px; font-size:11.5px; font-weight:900; color:#FFC81A; text-transform:uppercase; text-align:center;">Batas Pendaftaran</th>
                            <th style="padding:16px 16px; font-size:11.5px; font-weight:900; color:#FFC81A; text-transform:uppercase;">Jadwal Pelaksanaan</th>
                            <th style="padding:16px 16px; font-size:11.5px; font-weight:900; color:#FFC81A; text-transform:uppercase; text-align:center;">Kuota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatan as $k)
                        @php 
                            $isPel = $k->jenis_kegiatan === 'pelatihan'; 
                            $accentColor = '#131218';
                            $accentBg = '#FFC81A';
                        @endphp
                        <tr onclick="window.location='{{ route('landing.show', $k) }}'"
                            style="border-top:1px solid #F1F5F9; transition:all 0.2s ease; cursor:pointer;"
                            onmouseover="this.style.background='#FFFBEB';"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding:18px 24px;">
                                <div style="display:flex; align-items:center; gap:14px;">
                                    <div style="width:42px; height:42px; border-radius:12px; background:#FFC81A; border:1.5px solid #131218; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#131218; box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                                        @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>20,'style'=>'color:#131218'])
                                    </div>
                                    <div>
                                        <h4 style="margin:0; color:#0F172A; font-size:15px; font-weight:900; line-height:1.35;">
                                            {{ $k->judul }}
                                        </h4>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:18px 16px; text-align:center; vertical-align:middle;">
                                <span style="font-size:11px; font-weight:900; padding:5px 14px; border-radius:100px; background:{{ $accentBg }}; color:{{ $accentColor }}; border:1.5px solid #131218; text-transform:uppercase; letter-spacing:0.5px;">
                                    {{ $k->jenis_kegiatan }}
                                </span>
                            </td>
                            <td style="padding:18px 16px; text-align:center; vertical-align:middle; font-size:13px; color:#475569; font-weight:700;">
                                <div style="display:inline-flex; align-items:center; gap:6px; background:#F8FAFC; padding:6px 14px; border-radius:8px; border:1px solid #E2E8F0;">
                                    @include('components.icon',['name'=>'clock','size'=>14,'style'=>'color:#D97706'])
                                    <span>{{ $k->jadwal?->tgl_batas_daftar?->format('d M Y') ?? '-' }}</span>
                                </div>
                            </td>
                            <td style="padding:18px 16px; vertical-align:middle; font-size:13.5px; color:#334155; font-weight:700;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    @include('components.icon',['name'=>'calendar','size'=>15,'style'=>'color:#D97706'])
                                    <span>{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Jadwal Menyusul' }}</span>
                                </div>
                            </td>
                            <td style="padding:18px 16px; text-align:center; vertical-align:middle;">
                                <span style="background:#F1F5F9; border:1px solid #CBD5E1; padding:6px 14px; border-radius:8px; font-size:13px; font-weight:900; color:#0F172A;">
                                    {{ $k->terisi }} / {{ $k->kuota }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding:64px 24px; text-align:center; color:#64748B; font-size:15px; font-weight:600;">
                                Belum ada program pelatihan atau sertifikasi yang sesuai dengan kriteria pencarian Anda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($kegiatan->hasPages())
        <div style="margin-top:32px; display:flex; justify-content:center;" class="fcc-pagination-light">
            {{ $kegiatan->links() }}
        </div>
        @endif
    </div>
</div>
