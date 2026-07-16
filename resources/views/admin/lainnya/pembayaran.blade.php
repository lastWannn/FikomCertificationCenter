@extends('layouts.admin')
@section('title','Status Pembayaran')
@section('page-content')

@if(isset($countPerpanjanganPending) && $countPerpanjanganPending > 0)
<div style="background:rgba(245,158,11,.08);border-bottom:1.5px solid rgba(245,158,11,.25);
            padding:12px 24px;display:flex;align-items:center;gap:12px;">
    @include('components.icon',['name'=>'clock','size'=>16,'style'=>'color:#F59E0B'])
    <p style="margin:0;font-size:13px;font-weight:700;color:#B45309">
        {{ $countPerpanjanganPending }} permintaan perpanjangan waktu bayar menunggu persetujuan.
    </p>
    <a href="{{ route('admin.pembayaran.index',['perpanjangan'=>'menunggu']) }}"
       style="font-size:12px;font-weight:700;color:#F59E0B;text-decoration:none;
              padding:5px 12px;border-radius:7px;border:1px solid rgba(245,158,11,.3);
              background:rgba(245,158,11,.1);">
        Lihat Semua &rarr;
    </a>
</div>
@endif

<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Status Pembayaran</h1>
            <p style="color:#6B7280;font-size:14px;margin:0;">Verifikasi dan kelola semua pembayaran peserta.</p>
        </div>
        {{-- Filter --}}
        <form method="GET" action="{{ route('admin.pembayaran.index') }}" style="display:flex;gap:8px;">
            <select name="status" class="fcc-input" style="width:auto;" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach(['menunggu_pembayaran'=>'Menunggu Bayar','menunggu_verifikasi'=>'Menunggu Verifikasi','terverifikasi'=>'Terverifikasi','ditolak'=>'Ditolak','kadaluarsa'=>'Kadaluarsa'] as $v=>$l)
                <option value="{{ $v }}" {{ request('status')===$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="fcc-card" style="padding:0;overflow:hidden;">
        <table class="admin-table">
            <thead>
                <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                    <th style="padding:12px 20px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Kode</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Peserta</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Kegiatan</th>
                    <th style="padding:12px 12px;text-align:right;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Jumlah</th>
                    <th style="padding:12px 12px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Status</th>
                    <th style="padding:12px 20px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Aksi</th>
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
                @endphp
                <tr class="tbl-row" style="border-top:1px solid #F0F1F3;">
                    <td style="padding:12px 20px;font-size:12px;font-weight:700;color:#FFC81A;font-family:monospace;">{{ $p->kode_pembayaran }}</td>
                    <td style="padding:12px 12px;">
                        <p style="margin:0;font-size:13px;font-weight:700;color:#0F0F14;">{{ $p->pendaftaran->peserta->nama }}</p>
                        <p style="margin:0;font-size:11px;color:#A0A3AD;">{{ $p->pendaftaran->peserta->email }}</p>
                    </td>
                    <td style="padding:12px 12px;font-size:13px;color:#6B7280;">{{ Str::limit($p->pendaftaran->kegiatan->judul,30) }}</td>
                    <td style="padding:12px 12px;text-align:right;font-size:13px;font-weight:800;color:#0F0F14;">{{ $p->jumlah_bayar_format }}</td>
                    <td style="padding:12px 12px;text-align:center;"><span style="font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">{{ $sc[1] }}</span></td>
                    <td style="padding:12px 20px;text-align:center;">
                        <a href="{{ route('admin.pembayaran.show', $p) }}" style="color:#FFC81A;font-size:13px;font-weight:700;text-decoration:none;">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="padding:32px;text-align:center;color:#A0A3AD;font-size:14px;">Tidak ada data pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($pembayaran->hasPages())<div style="padding:14px 20px;border-top:1px solid #E2E4EB;">{{ $pembayaran->withQueryString()->links() }}</div>@endif
    </div>
</div>
@endsection
