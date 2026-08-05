@extends('layouts.admin')
@section('title','Terbitkan Sertifikat Peserta')
@section('page-title','Terbitkan Sertifikat Peserta')

@section('page-content')
<div style="padding:24px;">

    {{-- Navigasi Kembali --}}
    <div style="margin-bottom:14px;">
        <a href="{{ route('admin.sertifikat.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;font-weight:600;transition:color 0.2s;"
           onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#6B7280'">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Manajemen Sertifikat
        </a>
    </div>

    {{-- Header & Terbitkan Semua Form --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:14px;">
        <div>
            <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">{{ $kegiatan->judul }}</h1>
            <p style="color:#6B7280;font-size:13.5px;margin:0;">Kelola penerbitan sertifikat digital per peserta kegiatan ini.</p>
        </div>

        {{-- Form Terbitkan Semua --}}
        <form action="{{ route('admin.sertifikat.terbitkan-semua', $kegiatan) }}" method="POST">
            @csrf
            <div style="display:flex;gap:8px;align-items:center;">
                <input type="date" name="tgl_terbit" value="{{ date('Y-m-d') }}" required class="fcc-input" style="width:auto;font-size:12.5px;height:38px;">
                <button type="submit" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;height:38px;display:inline-flex;align-items:center;gap:6px;border-radius:10px;font-weight:800;cursor:pointer;border:none;"
                        onclick="return fccConfirmAction(this, 'Terbitkan Sertifikat', 'Apakah Anda yakin ingin menerbitkan sertifikat untuk semua peserta yang terdaftar?', 'Ya, Terbitkan', false)">
                    @include('components.icon',['name'=>'award','size'=>15]) Terbitkan Semua
                </button>
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:16px;">
        <div style="overflow-x:auto;">
            <table class="admin-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Peserta</th>
                        <th style="padding:14px 14px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Status Pendaftaran</th>
                        <th style="padding:14px 14px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">No. Sertifikat</th>
                        <th style="padding:14px 14px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Tgl Terbit</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $pd)
                    @php $sert = $pd->sertifikat; @endphp
                    <tr class="tbl-row" style="border-top:1px solid #F0F1F3;">
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:700;color:#131218;">{{ $pd->peserta->nama }}</p>
                            <p style="margin:0;font-size:11.5px;color:#6B7280;">{{ $pd->peserta->email }}</p>
                        </td>
                        <td style="padding:14px 14px;vertical-align:middle;">
                            @php $sc=match($pd->status_pendaftaran){'terdaftar'=>['#10B981','Terdaftar'],'menunggu_verifikasi'=>['#F59E0B','Menunggu'],default=>['#9CA3B0','Lainnya']}; @endphp
                            <span style="font-size:10px;font-weight:800;padding:3px 8px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">{{ $sc[1] }}</span>
                        </td>
                        <td style="padding:14px 14px;font-size:13px;font-family:monospace;font-weight:700;color:{{ $sert?'#3B82F6':'#9CA3B0' }};vertical-align:middle;">
                            {{ $sert?->nomor_sertifikat ?? '—' }}
                        </td>
                        <td style="padding:14px 14px;text-align:center;font-size:13px;color:#6B7280;vertical-align:middle;">
                            {{ $sert?->tgl_terbit?->format('d M Y') ?? '—' }}
                        </td>
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            @if($pd->status_pendaftaran === 'terdaftar' && !$sert)
                            <form action="{{ route('admin.sertifikat.terbitkan', $pd) }}" method="POST" style="display:inline-flex;gap:6px;align-items:center;justify-content:center;">
                                @csrf
                                <input type="date" name="tgl_terbit" value="{{ date('Y-m-d') }}" required class="fcc-input" style="width:auto;font-size:12px;padding:5px 8px;height:32px;">
                                <button type="submit" class="fcc-btn-gold" style="padding:6px 12px;font-size:12px;font-weight:800;border-radius:8px;cursor:pointer;white-space:nowrap;border:none;">
                                    Terbitkan
                                </button>
                            </form>
                            @elseif($sert)
                            <a href="{{ route('admin.cetak.sertifikat', $sert) }}" target="_blank" class="fcc-btn-outline-dark" style="padding:6px 12px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;border-radius:8px;font-weight:700;">
                                @include('components.icon',['name'=>'printer','size'=>13]) Lihat PDF
                            </a>
                            @else
                            <span style="font-size:11px;color:#9CA3B0;">Belum terdaftar</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#9CA3B0;">
                            <p style="font-size:14px;font-weight:700;margin:0;">Belum ada peserta yang terdaftar pada kegiatan ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
