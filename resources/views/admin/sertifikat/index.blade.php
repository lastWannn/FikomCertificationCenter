@extends('layouts.admin')
@section('title','Manajemen Sertifikat')
@section('page-title','Manajemen Sertifikat')

@section('page-content')
<div style="padding:24px;">

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Penerbitan &amp; Sertifikasi</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Manajemen Sertifikat</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Upload template latar sertifikat dan terbitkan sertifikat digital peserta.</p>
        </div>
    </div>

    {{-- Top Section: Upload Latar & Quick Actions --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:20px;margin-bottom:24px;">
        
        {{-- Card 1: Upload Template Latar --}}
        <div class="fcc-card" style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
            <h3 style="font-size:15px;font-weight:900;color:#131218;margin:0 0 16px;display:flex;align-items:center;gap:8px;">
                <div style="width:32px;height:32px;border-radius:10px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;">
                    @include('components.icon',['name'=>'image','size'=>16])
                </div>
                Upload Template Latar Sertifikat
            </h3>
            <form action="{{ route('admin.sertifikat.upload-latar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom:14px;">
                    <label style="font-size:11px;font-weight:800;color:#64748B;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                        Pilih Kegiatan *
                    </label>
                    <select name="kegiatan_id" class="fcc-input" required style="font-size:13px;height:40px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
                        <option value="">-- Pilih Kegiatan --</option>
                        @foreach($kegiatan as $k)
                        <option value="{{ $k->id }}">{{ Str::limit($k->judul, 45) }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom:18px;">
                    <label style="font-size:11px;font-weight:800;color:#64748B;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                        File Latar (PNG/JPG, A4 Landscape) *
                    </label>
                    <input type="file" name="latar" accept="image/png,image/jpeg,image/jpg" class="fcc-input" style="padding:8px 12px;font-size:12.5px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;width:100%;" required>
                    <p style="font-size:11px;color:#94A3B8;margin:6px 0 0;font-weight:500;">
                        Resolusi disarankan: 3508 × 2480 px (A4 Landscape 300 DPI)
                    </p>
                </div>
                <button type="submit" style="width:100%;padding:10px 18px;font-size:13px;border-radius:10px;font-weight:800;cursor:pointer;border:1.5px solid #131218;background:#131218;color:#FFC81A;display:inline-flex;align-items:center;justify-content:center;gap:8px;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                    @include('components.icon',['name'=>'upload','size'=>15]) Upload Template Latar
                </button>
            </form>
        </div>

        {{-- Card 2: Terbitkan Sertifikat Info --}}
        <div class="fcc-card" style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);display:flex;flex-direction:column;justify-content:space-between;">
            <div>
                <h3 style="font-size:15px;font-weight:900;color:#131218;margin:0 0 12px;display:flex;align-items:center;gap:8px;">
                    <div style="width:32px;height:32px;border-radius:10px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;">
                        @include('components.icon',['name'=>'award','size'=>16])
                    </div>
                    Penerbitan Sertifikat Peserta
                </h3>
                <p style="color:#64748B;font-size:13px;line-height:1.6;margin:0 0 16px;font-weight:500;">
                    Sertifikat dapat diterbitkan per kegiatan kepada peserta yang telah memenuhi syarat pendaftaran. Pilih kegiatan di bawah ini untuk mengelola sertifikat peserta:
                </p>
                <div style="background:#F8FAFC;border:1.5px solid #E2E4EB;border-radius:14px;padding:16px;">
                    <p style="margin:0 0 10px;font-size:12px;font-weight:800;color:#131218;text-transform:uppercase;letter-spacing:0.5px;">Daftar Kegiatan Siap Terbit:</p>
                    <div style="display:flex;flex-direction:column;gap:8px;max-height:140px;overflow-y:auto;">
                        @foreach($kegiatan->take(5) as $kg)
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:12.5px;">
                            <span style="color:#131218;font-weight:700;">{{ Str::limit($kg->judul, 32) }}</span>
                            <a href="{{ route('admin.sertifikat.peserta', $kg) }}" style="padding:4px 10px;font-size:11px;font-weight:800;color:#FFC81A;background:#131218;border-radius:6px;text-decoration:none;border:1px solid #131218;transition:all .15s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                                Kelola Peserta &rarr;
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabel Sertifikat Diterbitkan (Neo-Brutalist) --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Sertifikat Terbit</h3>
            </div>
            <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $sertifikat->total() }} Sertifikat</span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">No. Sertifikat</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Peserta</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Kegiatan</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;">Tgl Terbit</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:160px;">File Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sertifikat as $s)
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        
                        {{-- No. Sertifikat --}}
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <span style="font-size:12px;font-weight:900;color:#FFC81A;background:#131218;padding:4px 10px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;display:inline-block;">
                                {{ $s->nomor_sertifikat }}
                            </span>
                        </td>

                        {{-- Peserta --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;">{{ $s->pendaftaran->peserta->nama ?? '-' }}</p>
                            <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;">{{ $s->pendaftaran->peserta->email ?? '-' }}</p>
                        </td>

                        {{-- Kegiatan --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:13px;color:#131218;font-weight:800;">
                            {{ Str::limit($s->pendaftaran->kegiatan->judul ?? '-', 38) }}
                        </td>

                        {{-- Tgl Terbit --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;font-size:13px;color:#64748B;font-weight:700;">
                            📅 {{ $s->tgl_terbit?->format('d M Y') ?? '-' }}
                        </td>

                        {{-- File Sertifikat --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            @if($s->file_sertifikat)
                            <a href="{{ asset('storage/'.$s->file_sertifikat) }}" target="_blank"
                               style="padding:6px 14px;font-size:12px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:8px;border:1.5px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .18s;"
                               onmouseover="this.style.background='#131218';this.style.color='#FFFFFF';" onmouseout="this.style.background='#FFFFFF';this.style.color='#131218';">
                                @include('components.icon',['name'=>'download','size'=>13]) Unduh PDF
                            </a>
                            @else
                            <a href="{{ route('admin.cetak.sertifikat', $s) }}" target="_blank"
                               style="padding:6px 14px;font-size:12px;font-weight:800;background:#131218;color:#FFC81A;border-radius:8px;border:1px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .18s;"
                               onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                                @include('components.icon',['name'=>'printer','size'=>13]) Cetak PDF
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'award','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Sertifikat Diterbitkan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Sertifikat yang telah diterbitkan untuk peserta akan muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sertifikat->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8FAFC;">
            {{ $sertifikat->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
