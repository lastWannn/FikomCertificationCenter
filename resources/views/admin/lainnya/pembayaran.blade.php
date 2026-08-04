@extends('layouts.admin')
@section('title','Status Pembayaran')
@section('page-title','Status Pembayaran')

@section('page-content')

@if(isset($countPerpanjanganPending) && $countPerpanjanganPending > 0)
<div style="background:#FFFDF5;border-bottom:1.5px solid #FCD34D;padding:14px 24px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
    <div style="display:flex;align-items:center;gap:10px;">
        <div style="width:32px;height:32px;border-radius:8px;background:#F59E0B;display:flex;align-items:center;justify-content:center;color:#FFF;flex-shrink:0;">
            @include('components.icon',['name'=>'clock','size'=>16,'style'=>'color:#FFF'])
        </div>
        <p style="margin:0;font-size:13.5px;font-weight:800;color:#92400E;">
            {{ $countPerpanjanganPending }} Permintaan perpanjangan waktu bayar menunggu persetujuan Anda.
        </p>
    </div>
    <a href="{{ route('admin.pembayaran.index',['perpanjangan'=>'menunggu']) }}"
       class="fcc-btn-gold" style="padding:6px 14px;font-size:12px;text-decoration:none;">
        Tinjau Permintaan &rarr;
    </a>
</div>
@endif

<div style="padding:24px;">
    {{-- Header & Title --}}
    <div style="margin-bottom:20px;">
        <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">Status Pembayaran</h1>
        <p style="color:#6B7280;font-size:13.5px;margin:0;">Verifikasi, cari, dan kelola semua transaksi pembayaran peserta.</p>
    </div>

    {{-- Toolbar Filter & Search Bar --}}
    <div class="fcc-card" style="padding:16px 20px;margin-bottom:20px;border-radius:16px;">
        <form method="GET" action="{{ route('admin.pembayaran.index') }}" style="display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;">
            
            {{-- Search Bar --}}
            <div style="position:relative;flex:1;min-width:240px;">
                <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9CA3B0;display:flex;pointer-events:none;">
                    @include('components.icon', ['name'=>'search', 'size'=>15])
                </span>
                <input type="text" id="search-input" name="q" value="{{ request('q') }}"
                       placeholder="Ketik nama, email, kode unik, atau kode bayar..."
                       class="fcc-input" style="padding-left:36px;font-size:13px;height:38px;"
                       oninput="clearTimeout(window.searchTimer); window.searchTimer = setTimeout(() => this.form.submit(), 350);"
                       autocomplete="off">
            </div>

            {{-- Dropdown Filters --}}
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                {{-- Status Select --}}
                <select name="status" class="fcc-input" style="width:auto;font-size:12.5px;height:38px;padding-top:0;padding-bottom:0;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    @foreach([
                        'menunggu_verifikasi'=>'Menunggu Verifikasi',
                        'req_perpanjangan'=>'Request Perpanjangan',
                        'menunggu_pembayaran'=>'Menunggu Bayar',
                        'terverifikasi'=>'Terverifikasi',
                        'ditolak'=>'Ditolak',
                        'kadaluarsa'=>'Kadaluarsa'
                    ] as $v=>$l)
                    <option value="{{ $v }}" {{ (request('status')===$v || (request('perpanjangan')==='menunggu' && $v==='req_perpanjangan'))?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>

                {{-- Jenis Select --}}
                <select name="jenis" class="fcc-input" style="width:auto;font-size:12.5px;height:38px;padding-top:0;padding-bottom:0;" onchange="this.form.submit()">
                    <option value="">Semua Jenis</option>
                    <option value="pelatihan" {{ request('jenis')==='pelatihan'?'selected':'' }}>Pelatihan</option>
                    <option value="sertifikasi" {{ request('jenis')==='sertifikasi'?'selected':'' }}>Sertifikasi</option>
                </select>

                <button type="submit" class="fcc-btn-gold" style="padding:8px 16px;font-size:12.5px;height:38px;cursor:pointer;">
                    Cari
                </button>

                @if(request('q') || request('status') || request('jenis') || request('perpanjangan'))
                <a href="{{ route('admin.pembayaran.index') }}" class="fcc-btn-outline-dark" style="padding:8px 14px;font-size:12.5px;height:38px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;background:#FFF;border:1.5px solid #E2E4EB;color:#EF4444;border-radius:10px;font-weight:700;" title="Reset Semua Filter">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M2.5 22v-6h6"/><path d="M2 11.5a10 10 0 0 1 18.8-4.3L21.5 8M22 12.5a10 10 0 0 1-18.8 4.3L2.5 16"/></svg>
                    Reset Filter
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel Pembayaran --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:16px;">
        <div style="overflow-x:auto;">
            <table class="admin-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Kode Pembayaran</th>
                        <th style="padding:14px 14px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Peserta</th>
                        <th style="padding:14px 14px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Kegiatan</th>
                        <th style="padding:14px 14px;text-align:right;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Jumlah Ditransfer</th>
                        <th style="padding:14px 14px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Status</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran as $p)
                    @php
                    $sc=match($p->status_pembayaran){
                        'terverifikasi'=>['#10B981','Terverifikasi'],
                        'menunggu_verifikasi'=>['#F59E0B','Menunggu Verifikasi'],
                        'ditolak'=>['#EF4444','Ditolak'],
                        'kadaluarsa'=>['#6B7280','Kadaluarsa'],
                        default=>['#3B82F6','Menunggu Bayar'],
                    };
                    $isPel = $p->pendaftaran?->kegiatan?->jenis_kegiatan === 'pelatihan';
                    @endphp
                    <tr class="tbl-row"
                        onclick="window.location='{{ route('admin.pembayaran.show', $p) }}'"
                        style="border-top:1px solid #F0F1F3;cursor:pointer;transition:background .15s;"
                        onmouseover="this.style.background='#FAFBFD'"
                        onmouseout="this.style.background='transparent'">
                        
                        {{-- Kode Pembayaran --}}
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <p style="margin:0;font-size:13px;font-weight:800;color:#131218;font-family:monospace;">
                                {{ $p->kode_pembayaran }}
                            </p>
                        </td>

                        {{-- Peserta --}}
                        <td style="padding:14px 14px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:700;color:#131218;">
                                {{ $p->pendaftaran?->peserta?->nama ?? '-' }}
                            </p>
                            <p style="margin:0;font-size:11.5px;color:#6B7280;">
                                {{ $p->pendaftaran?->peserta?->email ?? '-' }}
                            </p>
                        </td>

                        {{-- Kegiatan --}}
                        <td style="padding:14px 14px;vertical-align:middle;">
                            <p style="margin:0 0 3px;font-size:13px;font-weight:700;color:#374151;">
                                {{ Str::limit($p->pendaftaran?->kegiatan?->judul ?? '-', 38) }}
                            </p>
                            <span style="font-size:10px;font-weight:800;padding:2px 7px;border-radius:4px;background:{{ $isPel?'rgba(255,200,26,.14)':'rgba(59,130,246,.12)' }};color:{{ $isPel?'#9A7300':'#3B82F6' }};text-transform:uppercase;">
                                {{ ucfirst($p->pendaftaran?->kegiatan?->jenis_kegiatan ?? 'Kegiatan') }}
                            </span>
                        </td>

                        {{-- Jumlah Bayar --}}
                        <td style="padding:14px 14px;text-align:right;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:14px;font-weight:900;color:#131218;">
                                {{ $p->nominal_transfer_format }}
                            </p>
                            @if($p->kode_unik)
                            <p style="margin:0;font-size:10.5px;color:#9CA3B0;">
                                (Pokok: {{ $p->jumlah_bayar_format }})
                            </p>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td style="padding:14px 14px;text-align:center;vertical-align:middle;">
                            <span style="font-size:11px;font-weight:800;padding:4px 10px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};display:inline-block;">
                                {{ $sc[1] }}
                            </span>
                            @if($p->status_perpanjangan === 'menunggu')
                            <div style="margin-top:4px;">
                                <span style="font-size:10px;font-weight:800;padding:2px 8px;border-radius:10px;background:#FEF3C7;color:#D97706;border:1px solid #FCD34D;">Req. Perpanjangan</span>
                            </div>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <a href="{{ route('admin.pembayaran.show', $p) }}" class="fcc-btn-dark" style="padding:6px 14px;font-size:12px;text-decoration:none;" onclick="event.stopPropagation()">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:48px;text-align:center;color:#9CA3B0;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'credit-card','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:700;color:#131218;margin:0 0 4px;">Tidak Ada Data Pembayaran Ditemukan</p>
                            <p style="font-size:12.5px;color:#9CA3B0;margin:0;">Coba gunakan kata kunci pencarian lain atau ubah filter status.</p>
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

@if(request('q'))
<script>
document.addEventListener("DOMContentLoaded", function() {
    const el = document.getElementById('search-input');
    if (el) {
        el.focus();
        const val = el.value;
        el.value = '';
        el.value = val;
    }
});
</script>
@endif
@endsection
