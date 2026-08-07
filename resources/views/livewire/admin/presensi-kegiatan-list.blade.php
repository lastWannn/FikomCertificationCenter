<div>
    {{-- Toolbar Filter & Search Bar --}}
    <div class="fcc-card" style="padding:16px 20px;margin-bottom:20px;border-radius:16px;">
        <div style="display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;">
            
            {{-- Search Bar --}}
            <div style="position:relative;flex:1;min-width:240px;">
                <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9CA3B0;display:flex;pointer-events:none;">
                    @include('components.icon', ['name'=>'search', 'size'=>15])
                </span>
                <input type="text" wire:model.live.debounce.300ms="q"
                       placeholder="Cari nama kegiatan..."
                       class="fcc-input" style="padding-left:36px;font-size:13px;height:38px;background:#FFF;"
                       autocomplete="off">
            </div>

            {{-- Dropdown Filters --}}
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                {{-- Jenis Select --}}
                <select wire:model.live="jenis" class="fcc-input" style="width:auto;font-size:12.5px;height:38px;padding-top:0;padding-bottom:0;background:#FFF;cursor:pointer;">
                    <option value="">Semua Jenis Kegiatan</option>
                    <option value="pelatihan">Pelatihan</option>
                    <option value="sertifikasi">Sertifikasi</option>
                </select>

                @if($q || $jenis)
                <button type="button" wire:click="resetFilters" class="fcc-btn-outline-dark" style="padding:8px 14px;font-size:12.5px;height:38px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;background:#FFF;border:1.5px solid #E2E4EB;color:#EF4444;border-radius:10px;font-weight:700;" title="Reset Semua Filter">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M2.5 22v-6h6"/><path d="M2 11.5a10 10 0 0 1 18.8-4.3L21.5 8M22 12.5a10 10 0 0 1-18.8 4.3L2.5 16"/></svg>
                    Reset Filter
                </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Tabel Presensi Kegiatan --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:16px;position:relative;">

        <div style="overflow-x:auto;">
            <table class="admin-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Nama Kegiatan</th>
                        <th style="padding:14px 14px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Jenis</th>
                        <th style="padding:14px 14px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Jadwal Pelaksanaan</th>
                        <th style="padding:14px 14px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Peserta Terdaftar</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Aksi Presensi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatanList as $kegiatan)
                    @php
                        $isPel = $kegiatan->jenis_kegiatan === 'pelatihan';
                        $jadwal = $kegiatan->jadwal;
                    @endphp
                    <tr class="tbl-row" style="border-top:1px solid #F0F1F3;transition:background .15s;" onmouseover="this.style.background='#FAFBFD'" onmouseout="this.style.background='transparent'">
                        
                        {{-- Nama Kegiatan --}}
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">
                                {{ $kegiatan->judul }}
                            </p>
                        </td>

                        {{-- Jenis --}}
                        <td style="padding:14px 14px;vertical-align:middle;">
                            <span style="font-size:10px;font-weight:800;padding:2px 7px;border-radius:4px;
                                background:{{ $isPel?'rgba(255,200,26,.14)':'rgba(59,130,246,.12)' }};
                                color:{{ $isPel?'#9A7300':'#3B82F6' }};text-transform:uppercase;">
                                {{ ucfirst($kegiatan->jenis_kegiatan) }}
                            </span>
                        </td>

                        {{-- Jadwal Pelaksanaan --}}
                        <td style="padding:14px 14px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:700;color:#131218;">
                                {{ $jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}
                            </p>
                            <p style="margin:0;font-size:11.5px;color:#6B7280;">
                                {{ $jadwal?->jam_mulai ? substr($jadwal->jam_mulai, 0, 5) : '-' }} &ndash; {{ $jadwal?->jam_selesai ? substr($jadwal->jam_selesai, 0, 5) : '-' }} WITA
                            </p>
                        </td>

                        {{-- Peserta Terdaftar --}}
                        <td style="padding:14px 14px;text-align:center;vertical-align:middle;">
                            <span style="font-size:11px;font-weight:800;padding:4px 10px;border-radius:20px;background:rgba(16,185,129,.12);color:#059669;display:inline-block;">
                                {{ $kegiatan->total_peserta }} Peserta
                            </span>
                        </td>

                        {{-- Aksi Presensi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;white-space:nowrap;">
                            <div style="display:inline-flex;gap:6px;align-items:center;justify-content:center;">
                                {{-- Kelola Presensi --}}
                                <a href="{{ route('admin.presensi.show', $kegiatan) }}" class="fcc-btn-gold"
                                   style="padding:6px 14px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;border-radius:8px;font-weight:800;">
                                    @include('components.icon',['name'=>'users','size'=>14]) Kelola Presensi
                                </a>

                                {{-- Cetak PDF Presensi Kertas --}}
                                <a href="{{ route('admin.cetak.presensi', $kegiatan) }}" target="_blank" class="fcc-btn-outline-dark"
                                   style="padding:6px 12px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;border-radius:8px;background:#FFF;border:1.5px solid #E2E4EB;font-weight:700;"
                                   title="Cetak Lembar Presensi PDF">
                                    @include('components.icon',['name'=>'printer','size'=>13]) PDF
                                </a>

                                {{-- Export CSV --}}
                                <a href="{{ route('admin.presensi.export', $kegiatan) }}" class="fcc-btn-outline-dark"
                                   style="padding:6px 12px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;border-radius:8px;background:#FFF;border:1.5px solid #E2E4EB;font-weight:700;"
                                   title="Export Data CSV">
                                    @include('components.icon',['name'=>'download','size'=>13]) CSV
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#9CA3B0;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'clipboard-list','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:700;color:#131218;margin:0 0 4px;">Tidak Ada Kegiatan Ditemukan</p>
                            <p style="font-size:12.5px;color:#9CA3B0;margin:0;">Coba gunakan kata kunci pencarian lain atau ubah filter jenis kegiatan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kegiatanList->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8F9FB;">
            {{ $kegiatanList->links() }}
        </div>
        @endif
    </div>
</div>
