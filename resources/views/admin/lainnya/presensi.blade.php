@extends('layouts.admin')
@section('title','Presensi Peserta')
@section('page-content')
<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Presensi Peserta</h1>
            <p style="color:#6B7280;font-size:14px;margin:0;">Kelola kehadiran peserta per kegiatan.</p>
        </div>
        <form method="GET" action="{{ route('admin.presensi.index') }}" style="display:flex;gap:8px;align-items:center;">
            <select name="kegiatan_id" class="fcc-input" style="width:auto;" onchange="this.form.submit()">
                <option value="">-- Semua Kegiatan --</option>
                @foreach($kegiatan as $k)
                <option value="{{ $k->id }}" {{ request('kegiatan_id')==$k->id?'selected':'' }}>{{ Str::limit($k->judul,40) }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="fcc-card" style="padding:0;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                    <th style="padding:12px 20px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Peserta</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Kegiatan</th>
                    <th style="padding:12px 12px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Status Kehadiran</th>
                    <th style="padding:12px 20px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Ubah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftaran as $pd)
                @php $sc=match($pd->status_kehadiran){'hadir'=>['#10B981','Hadir'],'tidak_hadir'=>['#EF4444','Tidak Hadir'],default=>['#6B7280','Belum']}; @endphp
                <tr class="tbl-row" style="border-top:1px solid #F0F1F3;">
                    <td style="padding:12px 20px;">
                        <p style="margin:0;font-size:13px;font-weight:700;color:#0F0F14;">{{ $pd->peserta->nama }}</p>
                        <p style="margin:0;font-size:11px;color:#A0A3AD;">{{ $pd->peserta->instansi??$pd->peserta->email }}</p>
                    </td>
                    <td style="padding:12px 12px;font-size:13px;color:#6B7280;">{{ Str::limit($pd->kegiatan->judul,35) }}</td>
                    <td style="padding:12px 12px;text-align:center;">
                        <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">{{ $sc[1] }}</span>
                    </td>
                    <td style="padding:12px 20px;text-align:center;">
                        <form action="{{ route('admin.presensi.hadir', $pd) }}" method="POST" style="display:inline-flex;gap:6px;align-items:center;">
                            @csrf
                            <select name="status_kehadiran" class="fcc-input" style="width:auto;font-size:12px;padding:5px 10px;" onchange="this.form.submit()">
                                <option value="belum" {{ $pd->status_kehadiran==='belum'?'selected':'' }}>Belum</option>
                                <option value="hadir" {{ $pd->status_kehadiran==='hadir'?'selected':'' }}>Hadir</option>
                                <option value="tidak_hadir" {{ $pd->status_kehadiran==='tidak_hadir'?'selected':'' }}>Tidak Hadir</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="padding:32px;text-align:center;color:#A0A3AD;font-size:14px;">Tidak ada data presensi.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($pendaftaran->hasPages())<div style="padding:14px 20px;border-top:1px solid #E2E4EB;">{{ $pendaftaran->withQueryString()->links() }}</div>@endif
    </div>
</div>
@endsection
