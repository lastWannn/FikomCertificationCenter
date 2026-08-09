<div wire:poll.10s>
    {{-- Stat Cards Grid (Neo-Brutalist) --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
        {{-- Card 1: Menunggu Verifikasi --}}
        <div wire:click="$set('status', 'menunggu_verifikasi')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width:44px;height:44px;border-radius:12px;background:#FEF3C7;border:1.5px solid #F59E0B;display:flex;align-items:center;justify-content:center;color:#D97706;box-shadow:0 4px 10px rgba(245,158,11,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'clock','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Menunggu Verifikasi</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($counts['menunggu_verifikasi']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Transaksi</span></p>
            </div>
        </div>

        {{-- Card 2: Request Perpanjangan --}}
        <div wire:click="$set('status', 'req_perpanjangan')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'alert-circle','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Req. Perpanjangan</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($counts['req_perpanjangan']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Permintaan</span></p>
            </div>
        </div>

        {{-- Card 3: Terverifikasi --}}
        <div wire:click="$set('status', 'terverifikasi')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;box-shadow:0 4px 10px rgba(16,185,129,0.2);flex-shrink:0;">
                @include('components.icon',['name'=>'check-circle','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Terverifikasi</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($counts['terverifikasi']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Berhasil</span></p>
            </div>
        </div>

        {{-- Card 4: Total Transaksi --}}
        <div wire:click="$set('status', '')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width:44px;height:44px;border-radius:12px;background:#F1F5F9;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;">
                @include('components.icon',['name'=>'credit-card','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Transaksi</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($counts['total']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Transaksi</span></p>
            </div>
        </div>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Transaksi Pembayaran</h3>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                
                {{-- Search Bar --}}
                <div style="position:relative;width:240px;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748B;display:flex;pointer-events:none;">
                        @include('components.icon', ['name'=>'search', 'size'=>14])
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="q"
                           placeholder="Cari nama, email, kode..."
                           class="fcc-input" style="padding-left:34px;font-size:12.5px;height:36px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;"
                           autocomplete="off">
                </div>

                {{-- Status Select --}}
                <select wire:model.live="status" class="fcc-input" style="width:auto;font-size:12.5px;height:36px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;cursor:pointer;">
                    <option value="">Semua Status</option>
                    <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                    <option value="req_perpanjangan">Request Perpanjangan</option>
                    <option value="menunggu_pembayaran">Menunggu Bayar</option>
                    <option value="terverifikasi">Terverifikasi</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="kadaluarsa">Kadaluarsa</option>
                </select>

                {{-- Jenis Select --}}
                <select wire:model.live="jenis" class="fcc-input" style="width:auto;font-size:12.5px;height:36px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;cursor:pointer;">
                    <option value="">Semua Jenis</option>
                    <option value="pelatihan">Pelatihan</option>
                    <option value="sertifikasi">Sertifikasi</option>
                </select>

                @if($q || $status || $jenis)
                <button type="button" wire:click="resetFilters" style="padding:6px 12px;font-size:12px;height:36px;cursor:pointer;display:inline-flex;align-items:center;gap:4px;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:10px;font-weight:800;transition:all .18s;" title="Reset Filter">
                    ✕ Reset
                </button>
                @endif

                <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $pembayaran->total() }} Data</span>
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Kode Bayar</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Peserta</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Kegiatan</th>
                        <th style="padding:14px 16px;text-align:right;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Jumlah Ditransfer</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Status</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran as $p)
                    @php
                    $sc = match(true) {
                        $p->status_perpanjangan === 'menunggu' => ['#D97706', '#FEF3C7', '#FCD34D', 'Req. Perpanjangan'],
                        $p->status_pembayaran === 'terverifikasi' => ['#059669', '#ECFDF5', '#6EE7B7', 'Terverifikasi'],
                        $p->status_pembayaran === 'menunggu_verifikasi' => ['#D97706', '#FFFDF5', '#FFC81A', 'Menunggu Verifikasi'],
                        $p->status_pembayaran === 'ditolak' => ['#DC2626', '#FEF2F2', '#FCA5A5', 'Ditolak'],
                        $p->status_pembayaran === 'kadaluarsa' => ['#4B5563', '#F3F4F6', '#D1D5DB', 'Kadaluarsa'],
                        default => ['#2563EB', '#EFF6FF', '#93C5FD', 'Menunggu Bayar'],
                    };
                    $isPel = $p->pendaftaran?->kegiatan?->jenis_kegiatan === 'pelatihan';
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;cursor:pointer;transition:background .15s;"
                        onclick="window.location='{{ route('admin.pembayaran.show', $p) }}'"
                        onmouseover="this.style.background='#F8FAFC'"
                        onmouseout="this.style.background=''">
                        
                        {{-- Kode Pembayaran --}}
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <span style="font-size:12px;font-weight:900;color:#FFC81A;background:#131218;padding:4px 10px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;display:inline-block;">
                                {{ $p->kode_pembayaran }}
                            </span>
                        </td>

                        {{-- Peserta --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;">
                                {{ $p->pendaftaran?->peserta?->nama ?? '-' }}
                            </p>
                            <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;">
                                {{ $p->pendaftaran?->peserta?->email ?? '-' }}
                            </p>
                        </td>

                        {{-- Kegiatan --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <p style="margin:0 0 4px;font-size:13px;font-weight:800;color:#131218;">
                                {{ Str::limit($p->pendaftaran?->kegiatan?->judul ?? '-', 38) }}
                            </p>
                            <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;background:{{ $isPel?'#FFFDF5':'#EFF6FF' }};color:{{ $isPel?'#B38F00':'#2563EB' }};border:1px solid {{ $isPel?'#FFC81A':'#93C5FD' }};display:inline-block;white-space:nowrap;">
                                {{ ucfirst($p->pendaftaran?->kegiatan?->jenis_kegiatan ?? 'Kegiatan') }}
                            </span>
                        </td>

                        {{-- Jumlah Bayar --}}
                        <td style="padding:14px 16px;text-align:right;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:14px;font-weight:900;color:#131218;">
                                {{ $p->nominal_transfer_format }}
                            </p>
                            @if($p->kode_unik)
                            <p style="margin:0;font-size:10.5px;color:#94A3B8;font-weight:600;">
                                (Pokok: {{ $p->jumlah_bayar_format }})
                            </p>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            <span style="font-size:11px;font-weight:800;padding:3px 10px;border-radius:12px;background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[2] }};display:inline-block;white-space:nowrap;">
                                {{ $sc[3] }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <a href="{{ route('admin.pembayaran.show', $p) }}"
                               style="padding:6px 14px;font-size:12px;font-weight:800;background:#131218;color:#FFC81A;border-radius:8px;border:1px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:all .18s;"
                               onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';"
                               onclick="event.stopPropagation()">
                                Detail &rarr;
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:48px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'credit-card','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Tidak Ada Data Pembayaran Ditemukan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Coba gunakan kata kunci pencarian lain atau ubah filter status.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pembayaran->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8F9FB;">
            {{ $pembayaran->links() }}
        </div>
        @endif
    </div>
</div>
