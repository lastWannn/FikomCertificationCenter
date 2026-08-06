<div>
    {{-- Toast Notification --}}
    @if($toastMessage)
    <div style="padding: 12px 18px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); border: 1.5px solid rgba(16, 185, 129, 0.3); color: #059669; font-weight: 700; font-size: 13px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
        <span>{{ $toastMessage }}</span>
        <button type="button" wire:click="$set('toastMessage', null)" style="background: none; border: none; color: #059669; cursor: pointer; font-size: 16px; font-weight: 900;">&times;</button>
    </div>
    @endif

    {{-- Quick KPI Counters --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));gap:14px;margin-bottom:20px;">
        @foreach([
            ['Hadir', $counts['hadir'], 'check-circle', '#10B981', 'hadir'],
            ['Tidak Hadir', $counts['tidak_hadir'], 'x-circle', '#EF4444', 'tidak_hadir'],
            ['Belum Presensi', $counts['belum'], 'clock', '#F59E0B', 'belum'],
            ['Total Peserta', $counts['total'], 'users', '#131218', ''],
        ] as [$lbl, $val, $ic, $c, $stFilter])
        <div wire:click="$set('statusFilter', '{{ $stFilter }}')" class="fcc-card" style="padding:16px 20px;border-left:4px solid {{ $c }};cursor:pointer;transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                <p style="color:#9CA3B0;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;margin:0;">{{ $lbl }}</p>
                <div style="width:32px;height:32px;border-radius:10px;background:{{ $c }}18;display:flex;align-items:center;justify-content:center;">
                    @include('components.icon',['name'=>$ic,'size'=>16,'style'=>"color:{$c}"])
                </div>
            </div>
            <p style="margin:0;font-size:24px;font-weight:900;color:#131218;">{{ number_format($val) }}</p>
        </div>
        @endforeach
    </div>

    {{-- Filter & Search Bar --}}
    <div class="fcc-card" style="padding:16px 20px;margin-bottom:20px;border-radius:16px;">
        <div style="display:flex;gap:12px;align-items:center;justify-content:space-between;flex-wrap:wrap;">
            
            {{-- Search Bar --}}
            <div style="position:relative;flex:1;min-width:240px;">
                <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9CA3B0;display:flex;pointer-events:none;">
                    @include('components.icon', ['name'=>'search', 'size'=>15])
                </span>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Cari nama peserta, email, instansi..."
                       class="fcc-input" style="padding-left:36px;font-size:13px;height:38px;background:#FFF;"
                       autocomplete="off">
            </div>

            {{-- Status Filter --}}
            <select wire:model.live="statusFilter" class="fcc-input" style="width:auto;font-size:12.5px;height:38px;padding-top:0;padding-bottom:0;background:#FFF;cursor:pointer;">
                <option value="">Semua Status Kehadiran</option>
                <option value="hadir">Hadir</option>
                <option value="tidak_hadir">Tidak Hadir</option>
                <option value="belum">Belum Hadir</option>
            </select>

            @if($search || $statusFilter)
            <button type="button" wire:click="$set('search',''); $set('statusFilter','');" class="fcc-btn-outline-dark" style="padding:8px 14px;font-size:12.5px;height:38px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;background:#FFF;border:1.5px solid #E2E4EB;color:#EF4444;border-radius:10px;font-weight:700;">
                Reset Filter
            </button>
            @endif

        </div>
    </div>

    {{-- Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:16px;position:relative;">

        <div style="overflow-x:auto;">
            <table class="admin-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;width:60px;">No</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Peserta</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Instansi / Unit</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">No. HP</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;width:240px;">Live Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $index => $pd)
                    @php
                        $st = $pd->status_kehadiran ?? 'belum';
                        $btnHadirBg = $st === 'hadir' ? '#10B981' : '#F3F4F6';
                        $btnHadirColor = $st === 'hadir' ? '#FFF' : '#4B5563';
                        $btnTidakBg = $st === 'tidak_hadir' ? '#EF4444' : '#F3F4F6';
                        $btnTidakColor = $st === 'tidak_hadir' ? '#FFF' : '#4B5563';
                    @endphp
                    <tr class="tbl-row" style="border-top:1px solid #F0F1F3;transition:background .15s;" onmouseover="this.style.background='#FAFBFD'" onmouseout="this.style.background='transparent'">
                        
                        {{-- Nomor --}}
                        <td style="padding:14px 20px;text-align:center;font-size:13px;font-weight:700;color:#6B7280;vertical-align:middle;">
                            {{ $pendaftaran->firstItem() + $index }}
                        </td>

                        {{-- Peserta --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:800;color:#131218;">
                                {{ $pd->peserta->nama ?? '-' }}
                            </p>
                            <p style="margin:0;font-size:11.5px;color:#6B7280;">
                                {{ $pd->peserta->email ?? '-' }}
                            </p>
                        </td>

                        {{-- Instansi --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:13px;color:#374151;">
                            {{ $pd->peserta->instansi ?? 'Umum' }}
                        </td>

                        {{-- No. HP --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:13px;color:#374151;">
                            {{ $pd->peserta->no_hp ?? '-' }}
                        </td>

                        {{-- Reaktif Livewire Status Buttons --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:inline-flex;gap:4px;background:#F3F4F6;padding:3px;border-radius:10px;border:1px solid #E5E7EB;">
                                <button type="button" wire:click="markAttendance({{ $pd->id }}, 'hadir')"
                                        style="padding:6px 12px;border-radius:7px;border:none;font-size:11.5px;font-weight:800;cursor:pointer;transition:all 0.15s;
                                               background:{{ $st === 'hadir' ? '#10B981' : 'transparent' }};
                                               color:{{ $st === 'hadir' ? '#FFF' : '#6B7280' }};">
                                    ✓ Hadir
                                </button>
                                <button type="button" wire:click="markAttendance({{ $pd->id }}, 'tidak_hadir')"
                                        style="padding:6px 12px;border-radius:7px;border:none;font-size:11.5px;font-weight:800;cursor:pointer;transition:all 0.15s;
                                               background:{{ $st === 'tidak_hadir' ? '#EF4444' : 'transparent' }};
                                               color:{{ $st === 'tidak_hadir' ? '#FFF' : '#6B7280' }};">
                                    ✕ Alpha
                                </button>
                                <button type="button" wire:click="markAttendance({{ $pd->id }}, 'belum')"
                                        style="padding:6px 12px;border-radius:7px;border:none;font-size:11.5px;font-weight:800;cursor:pointer;transition:all 0.15s;
                                               background:{{ $st === 'belum' ? '#9CA3B0' : 'transparent' }};
                                               color:{{ $st === 'belum' ? '#FFF' : '#6B7280' }};">
                                    Belum
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#9CA3B0;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'users','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:700;color:#131218;margin:0 0 4px;">Belum Ada Peserta Ditemukan</p>
                            <p style="font-size:12.5px;color:#9CA3B0;margin:0;">Coba ubah kriteria pencarian atau status filter kehadiran.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pendaftaran->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8F9FB;">
            {{ $pendaftaran->links() }}
        </div>
        @endif
    </div>
</div>
