<div>
    {{-- Stat Cards Grid (Neo-Brutalist) --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
        {{-- Card 1: Total Kegiatan --}}
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'clipboard-list','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Kegiatan</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $kegiatanList->total() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span></p>
            </div>
        </div>

        {{-- Card 2: Pelatihan --}}
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;">
                @include('components.icon',['name'=>'book-open','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Pelatihan</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ \App\Models\Kegiatan::visibleToPublic()->doesntHave('arsip')->where('jenis_kegiatan','pelatihan')->count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span></p>
            </div>
        </div>

        {{-- Card 3: Sertifikasi --}}
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'award','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Sertifikasi</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ \App\Models\Kegiatan::visibleToPublic()->doesntHave('arsip')->where('jenis_kegiatan','sertifikasi')->count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span></p>
            </div>
        </div>

        {{-- Card 4: Total Peserta --}}
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;">
                @include('components.icon',['name'=>'users','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Peserta Terdaftar</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ \App\Models\Pendaftaran::whereHas('kegiatan', fn($q)=>$q->visibleToPublic()->doesntHave('arsip'))->where('status_pendaftaran','terdaftar')->count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Kegiatan Presensi</h3>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                
                {{-- Search Bar --}}
                <div style="position:relative;width:240px;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748B;display:flex;pointer-events:none;">
                        @include('components.icon', ['name'=>'search', 'size'=>14])
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="q"
                           placeholder="Cari nama kegiatan..."
                           class="fcc-input" style="padding-left:34px;font-size:12.5px;height:36px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;"
                           autocomplete="off">
                </div>

                {{-- Jenis Select --}}
                <select wire:model.live="jenis" class="fcc-input" style="width:auto;font-size:12.5px;height:36px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;cursor:pointer;">
                    <option value="">Semua Jenis Kegiatan</option>
                    <option value="pelatihan">Pelatihan</option>
                    <option value="sertifikasi">Sertifikasi</option>
                </select>

                @if($q || $jenis)
                <button type="button" wire:click="resetFilters" style="padding:6px 12px;font-size:12px;height:36px;cursor:pointer;display:inline-flex;align-items:center;gap:4px;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:10px;font-weight:800;transition:all .18s;" title="Reset Filter">
                    ✕ Reset
                </button>
                @endif

                <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $kegiatanList->total() }} Data</span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Nama Kegiatan</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:130px;">Jenis</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:180px;">Jadwal Pelaksanaan</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:160px;">Peserta Terdaftar</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:320px;">Aksi Presensi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatanList as $kegiatan)
                    @php
                        $isPel = $kegiatan->jenis_kegiatan === 'pelatihan';
                        $jadwal = $kegiatan->jadwal;
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        
                        {{-- Nama Kegiatan --}}
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div style="width:42px;height:42px;border-radius:10px;background:{{ $isPel?'rgba(255,200,26,.18)':'rgba(59,130,246,.14)' }};border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>18,'style'=>'color:'.($isPel?'#131218':'#2563EB')])
                                </div>
                                <div>
                                    <a href="{{ route('admin.presensi.show', $kegiatan) }}" style="font-size:14px;font-weight:900;color:#131218;text-decoration:none;margin:0;display:block;line-height:1.3;transition:color .15s;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#131218'">
                                        {{ $kegiatan->judul }}
                                    </a>
                                </div>
                            </div>
                        </td>

                        {{-- Jenis --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:{{ $isPel?'#FFFDF5':'#EFF6FF' }};color:{{ $isPel?'#B38F00':'#2563EB' }};border:1px solid {{ $isPel?'#FFC81A':'#93C5FD' }};display:inline-block;white-space:nowrap;">
                                {{ ucfirst($kegiatan->jenis_kegiatan) }}
                            </span>
                        </td>

                        {{-- Jadwal Pelaksanaan --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13px;font-weight:800;color:#131218;">
                                {{ $jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}
                            </p>
                            <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:600;">
                                ⏰ {{ $jadwal?->jam_mulai ? substr($jadwal->jam_mulai, 0, 5) : '-' }} &ndash; {{ $jadwal?->jam_selesai ? substr($jadwal->jam_selesai, 0, 5) : '-' }} WITA
                            </p>
                        </td>

                        {{-- Peserta Terdaftar --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            <span style="font-size:11px;font-weight:800;padding:4px 12px;border-radius:20px;background:#ECFDF5;color:#059669;border:1px solid #A7F3D0;display:inline-block;">
                                👥 {{ $kegiatan->total_peserta }} Peserta
                            </span>
                        </td>

                        {{-- Aksi Presensi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;white-space:nowrap;">
                            <div style="display:inline-flex;gap:6px;align-items:center;justify-content:center;">
                                {{-- Kelola Presensi --}}
                                <a href="{{ route('admin.presensi.show', $kegiatan) }}"
                                   style="padding:6px 14px;font-size:12px;font-weight:800;background:#131218;color:#FFC81A;border-radius:8px;border:1px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .18s;"
                                   onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                                    @include('components.icon',['name'=>'users','size'=>14]) Kelola Presensi
                                </a>

                                {{-- Cetak PDF Presensi Kertas --}}
                                <a href="{{ route('admin.cetak.presensi', $kegiatan) }}" target="_blank"
                                   style="padding:6px 12px;font-size:12px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:8px;border:1.5px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .18s;"
                                   title="Cetak Lembar Presensi PDF">
                                    @include('components.icon',['name'=>'printer','size'=>13]) PDF
                                </a>

                                {{-- Export CSV --}}
                                <a href="{{ route('admin.presensi.export', $kegiatan) }}"
                                   style="padding:6px 12px;font-size:12px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:8px;border:1.5px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .18s;"
                                   title="Export Data CSV">
                                    @include('components.icon',['name'=>'download','size'=>13]) CSV
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'clipboard-list','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Tidak Ada Kegiatan Ditemukan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Coba gunakan kata kunci pencarian lain atau ubah filter jenis kegiatan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kegiatanList->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8FAFC;">
            {{ $kegiatanList->links() }}
        </div>
        @endif
    </div>
</div>
