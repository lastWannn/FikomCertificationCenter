@extends('layouts.admin')
@section('title','Detail Presensi Peserta')
@section('page-title','Detail Presensi Peserta')

@section('page-content')
@php
    $isPel = $kegiatan->jenis_kegiatan === 'pelatihan';
    $jadwal = $kegiatan->jadwal;
@endphp

<div style="padding:24px;">

    {{-- Navigasi Kembali --}}
    <div style="margin-bottom:14px;">
        <a href="{{ route('admin.presensi.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;font-weight:600;transition:color 0.2s;"
           onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#6B7280'">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
        </a>
    </div>

    {{-- Header & Title --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:14px;">
        <div>
            <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">{{ $kegiatan->judul }}</h1>
            <p style="color:#6B7280;font-size:13.5px;margin:0;">Kelola daftar hadir dan verifikasi presensi peserta untuk kegiatan ini.</p>
        </div>

        {{-- Action Buttons --}}
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <a href="{{ route('admin.cetak.presensi', $kegiatan) }}" target="_blank" class="fcc-btn-gold"
               style="padding:9px 16px;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;border-radius:10px;font-weight:800;">
                @include('components.icon',['name'=>'printer','size'=>14]) Cetak Lembar Presensi (PDF)
            </a>
            <a href="{{ route('admin.presensi.export', $kegiatan) }}" class="fcc-btn-outline-dark"
               style="padding:9px 14px;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;border-radius:10px;font-weight:700;background:#FFF;border:1.5px solid #E2E4EB;">
                @include('components.icon',['name'=>'download','size'=>14]) Export CSV
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:16px;">
        <div style="overflow-x:auto;">
            <table class="admin-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;width:60px;">No</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Peserta</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Instansi / Unit</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">No. HP</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;width:220px;">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $index => $pd)
                    <tr class="tbl-row" style="border-top:1px solid #F0F1F3;transition:background .15s;" onmouseover="this.style.background='#FAFBFD'" onmouseout="this.style.background='transparent'">
                        
                        {{-- Nomor --}}
                        <td style="padding:14px 20px;text-align:center;font-size:13px;font-weight:700;color:#6B7280;vertical-align:middle;">
                            {{ $pendaftaran->firstItem() + $index }}
                        </td>

                        {{-- Peserta --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:700;color:#131218;">
                                {{ $pd->peserta->nama ?? '-' }}
                            </p>
                            <p style="margin:0;font-size:11.5px;color:#6B7280;">
                                {{ $pd->peserta->email ?? '-' }}
                            </p>
                        </td>

                        {{-- Instansi --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:13px;color:#374151;">
                            {{ $pd->peserta->instansi ?? '-' }}
                        </td>

                        {{-- No. HP --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:13px;color:#374151;">
                            {{ $pd->peserta->no_hp ?? '-' }}
                        </td>

                        {{-- Status Kehadiran --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <form action="{{ route('admin.presensi.hadir', $pd) }}" method="POST" style="margin:0;">
                                @csrf
                                <select name="status_kehadiran" class="fcc-input"
                                        style="font-size:12.5px;padding:4px 8px;height:34px;border-radius:8px;font-weight:700;cursor:pointer;
                                        background:{{ $pd->status_kehadiran === 'hadir' ? '#D1FAE5' : ($pd->status_kehadiran === 'tidak_hadir' ? '#FEE2E2' : '#F3F4F6') }};
                                        color:{{ $pd->status_kehadiran === 'hadir' ? '#047857' : ($pd->status_kehadiran === 'tidak_hadir' ? '#B91C1C' : '#4B5563') }};
                                        border:1px solid {{ $pd->status_kehadiran === 'hadir' ? '#A7F3D0' : ($pd->status_kehadiran === 'tidak_hadir' ? '#FCA5A5' : '#E5E7EB') }};"
                                        onchange="this.form.submit()">
                                    <option value="belum" {{ ($pd->status_kehadiran ?? 'belum') === 'belum' ? 'selected' : '' }}>— Belum Hadir</option>
                                    <option value="hadir" {{ $pd->status_kehadiran === 'hadir' ? 'selected' : '' }}>✓ Hadir</option>
                                    <option value="tidak_hadir" {{ $pd->status_kehadiran === 'tidak_hadir' ? 'selected' : '' }}>✕ Tidak Hadir</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#9CA3B0;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'users','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:700;color:#131218;margin:0 0 4px;">Belum Ada Peserta Terdaftar</p>
                            <p style="font-size:12.5px;color:#9CA3B0;margin:0;">Peserta yang terdaftar pada kegiatan ini akan muncul di sini.</p>
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
@endsection
