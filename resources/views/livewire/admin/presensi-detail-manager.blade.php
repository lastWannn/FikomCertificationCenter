<div>
    {{-- Toast Notification --}}
    @if($toastMessage)
    <div style="padding: 12px 18px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); border: 1.5px solid rgba(16, 185, 129, 0.3); color: #059669; font-weight: 800; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
        <span>✓ {{ $toastMessage }}</span>
        <button type="button" wire:click="$set('toastMessage', null)" style="background: none; border: none; color: #059669; cursor: pointer; font-size: 18px; font-weight: 900;">&times;</button>
    </div>
    @endif

    {{-- Quick KPI Counters (Neo-Brutalist) --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;margin-bottom:24px;">
        {{-- Card 1: Hadir --}}
        <div wire:click="$set('statusFilter', 'hadir')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;box-shadow:0 4px 10px rgba(16,185,129,0.2);flex-shrink:0;">
                @include('components.icon',['name'=>'check-circle','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Hadir</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($counts['hadir']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>

        {{-- Card 2: Tidak Hadir --}}
        <div wire:click="$set('statusFilter', 'tidak_hadir')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width:44px;height:44px;border-radius:12px;background:#FEF2F2;border:1.5px solid #EF4444;display:flex;align-items:center;justify-content:center;color:#EF4444;box-shadow:0 4px 10px rgba(239,68,68,0.2);flex-shrink:0;">
                @include('components.icon',['name'=>'x-circle','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Tidak Hadir (Alpha)</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($counts['tidak_hadir']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>

        {{-- Card 3: Belum Presensi --}}
        <div wire:click="$set('statusFilter', 'belum')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width:44px;height:44px;border-radius:12px;background:#FEF3C7;border:1.5px solid #F59E0B;display:flex;align-items:center;justify-content:center;color:#D97706;box-shadow:0 4px 10px rgba(245,158,11,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'clock','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Belum Presensi</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($counts['belum']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>

        {{-- Card 4: Total Peserta --}}
        <div wire:click="$set('statusFilter', '')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width:44px;height:44px;border-radius:12px;background:#F1F5F9;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;">
                @include('components.icon',['name'=>'users','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Peserta</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($counts['total']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Peserta &amp; Live Status Kehadiran</h3>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                
                {{-- Search Bar --}}
                <div style="position:relative;width:240px;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748B;display:flex;pointer-events:none;">
                        @include('components.icon', ['name'=>'search', 'size'=>14])
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                           placeholder="Cari nama, email, instansi..."
                           class="fcc-input" style="padding-left:34px;font-size:12.5px;height:36px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;"
                           autocomplete="off">
                </div>

                {{-- Status Filter --}}
                <select wire:model.live="statusFilter" class="fcc-input" style="width:auto;font-size:12.5px;height:36px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;cursor:pointer;">
                    <option value="">Semua Status Kehadiran</option>
                    <option value="hadir">Hadir</option>
                    <option value="tidak_hadir">Tidak Hadir (Alpha)</option>
                    <option value="belum">Belum Hadir</option>
                </select>

                @if($search || $statusFilter)
                <button type="button" wire:click="$set('search',''); $set('statusFilter','');" style="padding:6px 12px;font-size:12px;height:36px;cursor:pointer;display:inline-flex;align-items:center;gap:4px;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:10px;font-weight:800;transition:all .18s;" title="Reset Filter">
                    ✕ Reset
                </button>
                @endif

                <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $pendaftaran->total() }} Data</span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:60px;">No</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Peserta</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Instansi / Unit</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">No. HP</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:260px;">Live Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $index => $pd)
                    @php
                        $st = $pd->status_kehadiran ?? 'belum';
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        
                        {{-- Nomor --}}
                        <td style="padding:14px 20px;text-align:center;font-size:13px;font-weight:800;color:#64748B;vertical-align:middle;">
                            {{ $pendaftaran->firstItem() + $index }}
                        </td>

                        {{-- Peserta --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;">
                                {{ $pd->peserta->nama ?? '-' }}
                            </p>
                            <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;">
                                {{ $pd->peserta->email ?? '-' }}
                            </p>
                        </td>

                        {{-- Instansi --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:13px;font-weight:700;color:#334155;">
                            {{ $pd->peserta->instansi ?? 'Umum' }}
                        </td>

                        {{-- No. HP --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:13px;font-weight:700;color:#334155;">
                            {{ $pd->peserta->no_hp ?? '-' }}
                        </td>

                        {{-- Reaktif Livewire Status Buttons --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:inline-flex;gap:4px;background:#F1F5F9;padding:4px;border-radius:12px;border:1.5px solid #CBD5E1;">
                                <button type="button" wire:click="markAttendance({{ $pd->id }}, 'hadir')"
                                        style="padding:6px 14px;border-radius:8px;border:none;font-size:12px;font-weight:900;cursor:pointer;transition:all 0.15s;
                                               background:{{ $st === 'hadir' ? '#10B981' : 'transparent' }};
                                               color:{{ $st === 'hadir' ? '#FFFFFF' : '#64748B' }};
                                               box-shadow:{{ $st === 'hadir' ? '0 2px 8px rgba(16,185,129,0.3)' : 'none' }};">
                                    ✓ Hadir
                                </button>
                                <button type="button" wire:click="markAttendance({{ $pd->id }}, 'tidak_hadir')"
                                        style="padding:6px 14px;border-radius:8px;border:none;font-size:12px;font-weight:900;cursor:pointer;transition:all 0.15s;
                                               background:{{ $st === 'tidak_hadir' ? '#EF4444' : 'transparent' }};
                                               color:{{ $st === 'tidak_hadir' ? '#FFFFFF' : '#64748B' }};
                                               box-shadow:{{ $st === 'tidak_hadir' ? '0 2px 8px rgba(239,68,68,0.3)' : 'none' }};">
                                    ✕ Alpha
                                </button>
                                <button type="button" wire:click="markAttendance({{ $pd->id }}, 'belum')"
                                        style="padding:6px 14px;border-radius:8px;border:none;font-size:12px;font-weight:900;cursor:pointer;transition:all 0.15s;
                                               background:{{ $st === 'belum' ? '#64748B' : 'transparent' }};
                                               color:{{ $st === 'belum' ? '#FFFFFF' : '#64748B' }};">
                                    Belum
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'users','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Peserta Ditemukan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Coba ubah kriteria pencarian atau status filter kehadiran.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pendaftaran->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8FAFC;">
            {{ $pendaftaran->links() }}
        </div>
        @endif
    </div>
</div>
