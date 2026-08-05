@extends('layouts.admin')
@section('title','Manajemen Sertifikat')
@section('page-title','Manajemen Sertifikat')

@section('page-content')
<div style="padding:24px;">

    {{-- Header & Title --}}
    <div style="margin-bottom:20px;">
        <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">Manajemen Sertifikat</h1>
        <p style="color:#6B7280;font-size:13.5px;margin:0;">Upload template latar sertifikat dan terbitkan sertifikat digital peserta.</p>
    </div>

    {{-- Top Section: Upload Latar & Quick Actions --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">
        
        {{-- Card 1: Upload Template Latar --}}
        <div class="fcc-card" style="padding:22px 24px;border-radius:16px;">
            <h3 style="font-size:15px;font-weight:900;color:#131218;margin:0 0 16px;display:flex;align-items:center;gap:8px;">
                @include('components.icon',['name'=>'image','size'=>16,'style'=>'color:#FFC81A'])
                Upload Template Latar Sertifikat
            </h3>
            <form action="{{ route('admin.sertifikat.upload-latar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom:14px;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                        Pilih Kegiatan *
                    </label>
                    <select name="kegiatan_id" class="fcc-input" required style="font-size:13px;height:38px;padding-top:0;padding-bottom:0;">
                        <option value="">-- Pilih Kegiatan --</option>
                        @foreach($kegiatan as $k)
                        <option value="{{ $k->id }}">{{ Str::limit($k->judul, 45) }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom:18px;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                        File Latar (PNG/JPG, A4 Landscape) *
                    </label>
                    <input type="file" name="latar" accept="image/png,image/jpeg,image/jpg" class="fcc-input" style="padding:8px;font-size:12.5px;" required>
                    <p style="font-size:11px;color:#9CA3B0;margin:6px 0 0;">
                        Resolusi disarankan: 3508 × 2480 px (A4 Landscape 300 DPI)
                    </p>
                </div>
                <button type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:10px 18px;font-size:13px;border-radius:10px;font-weight:800;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:6px;">
                    @include('components.icon',['name'=>'upload','size'=>15]) Upload Template Latar
                </button>
            </form>
        </div>

        {{-- Card 2: Terbitkan Sertifikat Info --}}
        <div class="fcc-card" style="padding:22px 24px;border-radius:16px;display:flex;flex-direction:column;justify-content:space-between;">
            <div>
                <h3 style="font-size:15px;font-weight:900;color:#131218;margin:0 0 12px;display:flex;align-items:center;gap:8px;">
                    @include('components.icon',['name'=>'award','size'=>16,'style'=>'color:#FFC81A'])
                    Penerbitan Sertifikat Peserta
                </h3>
                <p style="color:#6B7280;font-size:13px;line-height:1.6;margin:0 0 16px;">
                    Sertifikat dapat diterbitkan per kegiatan kepada peserta yang telah memenuhi syarat pendaftaran. Pilih kegiatan di bawah ini untuk mengelola sertifikat peserta:
                </p>
                <div style="background:#F8F9FB;border:1px solid #E2E4EB;border-radius:12px;padding:14px 16px;">
                    <p style="margin:0 0 8px;font-size:12px;font-weight:700;color:#131218;">Daftar Kegiatan Siap Terbit:</p>
                    <div style="display:flex;flex-direction:column;gap:8px;max-height:140px;overflow-y:auto;">
                        @foreach($kegiatan->take(5) as $kg)
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:12.5px;">
                            <span style="color:#374151;font-weight:600;">{{ Str::limit($kg->judul, 32) }}</span>
                            <a href="{{ route('admin.sertifikat.peserta', $kg) }}" class="fcc-btn-dark" style="padding:4px 10px;font-size:11px;text-decoration:none;border-radius:6px;">
                                Kelola Peserta &rarr;
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabel Sertifikat Diterbitkan --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:16px;">
        <div style="padding:16px 20px;border-bottom:1.5px solid #E2E4EB;font-size:14px;font-weight:900;color:#131218;display:flex;align-items:center;gap:8px;">
            @include('components.icon',['name'=>'file-check','size'=>16,'style'=>'color:#10B981'])
            Daftar Sertifikat Terbit
        </div>
        <div style="overflow-x:auto;">
            <table class="admin-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">No. Sertifikat</th>
                        <th style="padding:14px 14px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Peserta</th>
                        <th style="padding:14px 14px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Kegiatan</th>
                        <th style="padding:14px 14px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Tgl Terbit</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">File Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sertifikat as $s)
                    <tr class="tbl-row" style="border-top:1px solid #F0F1F3;">
                        <td style="padding:14px 20px;font-size:13px;font-weight:800;color:#3B82F6;font-family:monospace;">
                            {{ $s->nomor_sertifikat }}
                        </td>
                        <td style="padding:14px 14px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:700;color:#131218;">{{ $s->pendaftaran->peserta->nama ?? '-' }}</p>
                            <p style="margin:0;font-size:11.5px;color:#6B7280;">{{ $s->pendaftaran->peserta->email ?? '-' }}</p>
                        </td>
                        <td style="padding:14px 14px;font-size:13px;color:#374151;font-weight:600;">
                            {{ Str::limit($s->pendaftaran->kegiatan->judul ?? '-', 35) }}
                        </td>
                        <td style="padding:14px 14px;text-align:center;font-size:13px;color:#6B7280;font-weight:600;">
                            {{ $s->tgl_terbit?->format('d M Y') ?? '-' }}
                        </td>
                        <td style="padding:14px 20px;text-align:center;">
                            @if($s->file_sertifikat)
                            <a href="{{ asset('storage/'.$s->file_sertifikat) }}" target="_blank" class="fcc-btn-outline-dark" style="padding:6px 12px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;border-radius:8px;font-weight:700;">
                                @include('components.icon',['name'=>'download','size'=>13]) Unduh PDF
                            </a>
                            @else
                            <a href="{{ route('admin.cetak.sertifikat', $s) }}" target="_blank" class="fcc-btn-gold" style="padding:6px 12px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;border-radius:8px;font-weight:800;">
                                @include('components.icon',['name'=>'printer','size'=>13]) Cetak PDF
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#9CA3B0;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'award','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:700;color:#131218;margin:0 0 4px;">Belum Ada Sertifikat Diterbitkan</p>
                            <p style="font-size:12.5px;color:#9CA3B0;margin:0;">Sertifikat yang telah diterbitkan untuk peserta akan muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sertifikat->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8F9FB;">
            {{ $sertifikat->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
