@extends('layouts.peserta')
@section('title','Pendaftaran Saya')
@section('page-title','Pendaftaran Saya')
@section('page-content')
<div style="padding:24px;">
    <div class="fcc-card" style="padding:0;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                    <th style="padding:12px 20px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Kegiatan</th>
                    <th style="padding:12px 12px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Jenis</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Tanggal Daftar</th>
                    <th style="padding:12px 12px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Status</th>
                    <th style="padding:12px 20px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftaran as $pd)
                @php
                $sc=match($pd->status_pendaftaran){
                    'terdaftar'=>['#10B981','Terdaftar'],
                    'menunggu_verifikasi'=>['#F59E0B','Menunggu Verifikasi'],
                    'ditolak'=>['#EF4444','Ditolak'],
                    default=>['#6B7280','Menunggu Bayar'],
                };
                @endphp
                <tr class="tbl-row" style="border-top:1px solid #F0F1F3;">
                    <td style="padding:13px 20px;">
                        <p style="font-size:14px;font-weight:700;color:#0F0F14;margin:0;">{{ Str::limit($pd->kegiatan->judul,38) }}</p>
                        <p style="font-size:11px;color:#A0A3AD;margin:2px 0 0;">{{ $pd->biaya?->nama_jenis ?? 'Gratis' }}</p>
                    </td>
                    <td style="padding:13px 12px;text-align:center;">
                        <span style="font-size:10px;font-weight:700;padding:3px 8px;border-radius:5px;background:{{ $pd->kegiatan->jenis_kegiatan==='pelatihan'?'rgba(255,200,26,.15)':'rgba(59,130,246,.12)' }};color:{{ $pd->kegiatan->jenis_kegiatan==='pelatihan'?'#B38F00':'#3B82F6' }};">{{ ucfirst($pd->kegiatan->jenis_kegiatan) }}</span>
                    </td>
                    <td style="padding:13px 12px;font-size:13px;color:#6B7280;">{{ $pd->tgl_daftar->format('d M Y') }}</td>
                    <td style="padding:13px 12px;text-align:center;"><span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">{{ $sc[1] }}</span></td>
                    <td style="padding:13px 20px;text-align:center;">
                        @if($pd->pembayaran && $pd->status_pendaftaran==='menunggu_pembayaran')
                        <a href="{{ route('peserta.pembayaran.show',$pd->pembayaran->id) }}" style="color:#FFC81A;font-size:13px;font-weight:700;text-decoration:none;">Bayar Sekarang</a>
                        @else
                        <a href="{{ route('peserta.pendaftaran.show', $pd) }}" style="color:#3B82F6;font-size:13px;font-weight:700;text-decoration:none;">Detail</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding:32px;text-align:center;color:#A0A3AD;font-size:14px;">Belum ada pendaftaran. <a href="{{ route('peserta.jelajahi') }}" style="color:#FFC81A;font-weight:700;text-decoration:none;">Jelajahi kegiatan &rarr;</a></td></tr>
                @endforelse
            </tbody>
        </table>
        @if($pendaftaran->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;">{{ $pendaftaran->links() }}</div>
        @endif
    </div>
</div>
@endsection
