@extends('layouts.admin')
@section('title','Sertifikat')
@section('page-content')
<div style="padding:24px;">
    <div style="margin-bottom:22px;">
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Manajemen Sertifikat</h1>
        <p style="color:#6B7280;font-size:14px;margin:0;">Upload latar sertifikat dan terbitkan sertifikat untuk peserta.</p>
    </div>
    <div style="display:grid;grid-template-columns:1fr 2fr;gap:18px;margin-bottom:24px;">
        {{-- Upload Latar --}}
        <div class="fcc-card" style="padding:24px;">
            <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 16px;">Upload Template Latar</h3>
            <form action="{{ route('admin.sertifikat.upload-latar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom:12px;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kegiatan</label>
                    <select name="kegiatan_id" class="fcc-input">
                        <option value="">-- Pilih Kegiatan --</option>
                        @foreach($kegiatan as $k)
                        <option value="{{ $k->id }}">{{ Str::limit($k->judul,40) }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom:16px;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">File Latar (PNG/JPG, A4)</label>
                    <input type="file" name="latar" accept="image/*" class="fcc-input" style="padding:8px;" required>
                    <p style="font-size:11px;color:#A0A3AD;margin:4px 0 0;">Resolusi disarankan: 2480 × 3508 px (A4 landscape: 3508 × 2480 px)</p>
                </div>
                <button type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:10px;font-size:14px;">
                    @include('components.icon',['name'=>'upload','size'=>14']) Upload Latar
                </button>
            </form>
        </div>
        {{-- Terbitkan Sertifikat --}}
        <div class="fcc-card" style="padding:24px;">
            <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 16px;">Terbitkan Sertifikat</h3>
            <p style="color:#6B7280;font-size:13px;margin:0 0 16px;">Pilih peserta yang sudah menyelesaikan kegiatan untuk diterbitkan sertifikatnya.</p>
            <div style="font-size:13px;color:#A0A3AD;">Pilih dari tabel sertifikat di bawah, kemudian klik tombol Terbitkan.</div>
        </div>
    </div>

    {{-- Tabel Sertifikat --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;">
        <div style="padding:16px 20px;border-bottom:1px solid #E2E4EB;font-size:15px;font-weight:700;color:#0F0F14;">Daftar Sertifikat Diterbitkan</div>
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                    <th style="padding:12px 20px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">No. Sertifikat</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Peserta</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Kegiatan</th>
                    <th style="padding:12px 12px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Tgl Terbit</th>
                    <th style="padding:12px 20px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">File</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sertifikat as $s)
                <tr class="tbl-row" style="border-top:1px solid #F0F1F3;">
                    <td style="padding:12px 20px;font-size:12px;font-weight:700;color:#3B82F6;font-family:monospace;">{{ $s->nomor_sertifikat }}</td>
                    <td style="padding:12px 12px;font-size:13px;font-weight:700;color:#0F0F14;">{{ $s->pendaftaran->peserta->nama }}</td>
                    <td style="padding:12px 12px;font-size:13px;color:#6B7280;">{{ Str::limit($s->pendaftaran->kegiatan->judul,30) }}</td>
                    <td style="padding:12px 12px;text-align:center;font-size:13px;color:#6B7280;">{{ $s->tgl_terbit->format('d M Y') }}</td>
                    <td style="padding:12px 20px;text-align:center;">
                        @if($s->file_sertifikat)
                        <a href="{{ asset('storage/'.$s->file_sertifikat) }}" target="_blank" style="color:#3B82F6;font-size:13px;font-weight:700;text-decoration:none;">&#8595; Unduh</a>
                        @else
                        <span style="color:#A0A3AD;font-size:12px;">Belum ada file</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding:32px;text-align:center;color:#A0A3AD;font-size:14px;">Belum ada sertifikat diterbitkan.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($sertifikat->hasPages())<div style="padding:14px 20px;border-top:1px solid #E2E4EB;">{{ $sertifikat->links() }}</div>@endif
    </div>
</div>
@endsection
