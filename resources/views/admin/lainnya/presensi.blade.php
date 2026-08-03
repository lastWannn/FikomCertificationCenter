@extends('layouts.admin')
@section('title','Presensi Per Kegiatan')
@section('page-content')
<div style="padding:24px;">

    {{-- ── HEADER & SEARCH FILTER ─────────────────────────────── --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Presensi Per Kegiatan</h1>
            <p style="color:#6B7280;font-size:14px;margin:0;">Pilih kegiatan untuk mencetak lembar presensi fisik (kertas) atau mengunduh data peserta.</p>
        </div>
        <form method="GET" action="{{ route('admin.presensi.index') }}" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
            {{-- Filter Jenis --}}
            <select name="jenis" class="fcc-input" style="width:auto;font-size:13px;" onchange="this.form.submit()">
                <option value="">Semua Jenis Kegiatan</option>
                <option value="pelatihan" {{ request('jenis')==='pelatihan'?'selected':'' }}>Pelatihan</option>
                <option value="sertifikasi" {{ request('jenis')==='sertifikasi'?'selected':'' }}>Sertifikasi</option>
            </select>
            {{-- Input Cari --}}
            <div style="display:flex;gap:6px;">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kegiatan..." class="fcc-input" style="width:200px;font-size:13px;">
                <button type="submit" class="fcc-btn-gold" style="padding:8px 14px;font-size:13px;">Cari</button>
            </div>
        </form>
    </div>

    {{-- ── DAFTAR KEGIATAN TABEL ───────────────────────────────── --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                    <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.5px;">Nama Kegiatan</th>
                    <th style="padding:14px 14px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.5px;">Jenis</th>
                    <th style="padding:14px 14px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.5px;">Jadwal Pelaksanaan</th>
                    <th style="padding:14px 14px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.5px;">Peserta Terdaftar</th>
                    <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.5px;">Aksi Presensi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kegiatanList as $kegiatan)
                @php
                    $isPel = $kegiatan->jenis_kegiatan === 'pelatihan';
                    $jadwal = $kegiatan->jadwal;
                @endphp
                <tr class="tbl-row" style="border-top:1px solid #F0F1F3;">
                    {{-- Nama Kegiatan --}}
                    <td style="padding:14px 20px;">
                        <p style="margin:0;font-size:14px;font-weight:800;color:#0F0F14;">
                            {{ $kegiatan->judul }}
                        </p>
                    </td>

                    {{-- Jenis --}}
                    <td style="padding:14px 14px;">
                        <span style="font-size:11px;font-weight:800;padding:3px 10px;border-radius:6px;
                            background:{{ $isPel ? 'rgba(255,200,26,.15)' : 'rgba(59,130,246,.12)' }};
                            color:{{ $isPel ? '#B45309' : '#1D4ED8' }};">
                            {{ ucfirst($kegiatan->jenis_kegiatan) }}
                        </span>
                    </td>

                    {{-- Jadwal --}}
                    <td style="padding:14px 14px;font-size:13px;color:#374151;">
                        <p style="margin:0 0 2px;font-weight:700;color:#131218;">
                            {{ $jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}
                        </p>
                        <p style="margin:0;font-size:11px;color:#6B7280;">
                            {{ $jadwal?->jam_mulai ? substr($jadwal->jam_mulai, 0, 5) : '-' }} &ndash; {{ $jadwal?->jam_selesai ? substr($jadwal->jam_selesai, 0, 5) : '-' }}
                        </p>
                    </td>

                    {{-- Total Peserta --}}
                    <td style="padding:14px 14px;text-align:center;">
                        <span style="font-size:14px;font-weight:900;color:#10B981;background:rgba(16,185,129,.1);padding:4px 12px;border-radius:20px;display:inline-block;">
                            {{ $kegiatan->total_peserta }} Peserta
                        </span>
                    </td>

                    {{-- Tombol Cetak / Export / Detail --}}
                    <td style="padding:14px 20px;text-align:center;">
                        <div style="display:flex;gap:8px;justify-content:center;align-items:center;flex-wrap:wrap;">

                            {{-- Cetak PDF Presensi Kertas --}}
                            <a href="{{ route('admin.cetak.presensi', $kegiatan) }}" target="_blank" class="fcc-btn-gold"
                               style="padding:8px 14px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;border-radius:8px;font-weight:800;">
                                @include('components.icon',['name'=>'printer','size'=>14]) Cetak Lembar Presensi (PDF)
                            </a>

                            {{-- Export CSV --}}
                            <a href="{{ route('admin.presensi.export', $kegiatan) }}" class="fcc-btn-outline-dark"
                               style="padding:8px 12px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;border-radius:8px;">
                                @include('components.icon',['name'=>'download','size'=>13]) Export CSV
                            </a>

                            {{-- Detail Peserta --}}
                            <a href="{{ route('admin.presensi.show', $kegiatan) }}" class="fcc-btn-dark"
                               style="padding:8px 12px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;border-radius:8px;">
                                @include('components.icon',['name'=>'users','size'=>13]) Peserta
                            </a>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:40px;text-align:center;color:#A0A3AD;font-size:14px;">
                        Tidak ada kegiatan ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($kegiatanList->hasPages())
        <div style="padding:16px 20px;border-top:1px solid #E2E4EB;">
            {{ $kegiatanList->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
