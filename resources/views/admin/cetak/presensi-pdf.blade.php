<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<title>Daftar Presensi - {{ $kegiatan->judul }}</title>
<style>
  @page {
    margin: 0px;
    size: A4 portrait;
  }
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  body {
    font-family: 'Helvetica', 'Arial', sans-serif;
    font-size: 9pt;
    color: #1E293B;
    background: #FFFFFF;
    line-height: 1.4;
    padding: 40px 45px 40px 45px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
</style>
</head>
<body>

<!-- Header Table -->
<table style="width:100%; border-bottom: 2.5px solid #131218; padding-bottom: 12px; margin-bottom: 16px;">
  <tr>
    <td style="vertical-align: middle;">
      <div style="font-size: 15pt; font-weight: bold; color: #131218; letter-spacing: -0.3px; text-transform: uppercase;">DAFTAR PRESENSI PESERTA</div>
      <div style="font-size: 8.5pt; color: #64748B; font-weight: bold; margin-top: 2px; text-transform: uppercase; letter-spacing: 0.5px;">FIKOM CERTIFICATION CENTER &bull; UNIVERSITAS MUSLIM INDONESIA</div>
    </td>
    <td style="text-align: right; vertical-align: bottom; font-size: 8.5pt; color: #64748B; font-weight: bold;">
      Dicetak: {{ now()->format('d M Y H:i') }} WITA
    </td>
  </tr>
</table>

@php
  $pendaftarans = $kegiatan->pendaftaran->filter(fn($p) => in_array($p->status_pendaftaran, ['terdaftar', 'lulus', 'tidak_lulus']));
@endphp

<!-- Info Summary Cards -->
<table style="width:100%; margin-bottom: 18px;">
  <tr>
    <td style="width:30%; padding-right: 6px; vertical-align: top;">
      <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px; padding: 8px 10px;">
        <div style="font-size: 7.5pt; font-weight: bold; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Kegiatan</div>
        <div style="font-size: 9.5pt; font-weight: bold; color: #131218; margin-top: 2px;">{{ $kegiatan->judul }}</div>
      </div>
    </td>
    <td style="width:25%; padding: 0 4px; vertical-align: top;">
      <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px; padding: 8px 10px;">
        <div style="font-size: 7.5pt; font-weight: bold; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Pelaksanaan</div>
        <div style="font-size: 9.5pt; font-weight: bold; color: #131218; margin-top: 2px;">{{ $kegiatan->jadwal?->tgl_pelaksanaan?->format('d F Y') ?? 'TBA' }}</div>
      </div>
    </td>
    <td style="width:25%; padding: 0 4px; vertical-align: top;">
      <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px; padding: 8px 10px;">
        <div style="font-size: 7.5pt; font-weight: bold; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Waktu</div>
        <div style="font-size: 9.5pt; font-weight: bold; color: #131218; margin-top: 2px;">{{ $kegiatan->jadwal?->jam_mulai ? substr($kegiatan->jadwal->jam_mulai, 0, 5) : '-' }} &ndash; {{ $kegiatan->jadwal?->jam_selesai ? substr($kegiatan->jadwal->jam_selesai, 0, 5) : '-' }} WITA</div>
      </div>
    </td>
    <td style="width:20%; padding-left: 6px; vertical-align: top;">
      <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px; padding: 8px 10px;">
        <div style="font-size: 7.5pt; font-weight: bold; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Total Peserta</div>
        <div style="font-size: 9.5pt; font-weight: bold; color: #131218; margin-top: 2px;">{{ $pendaftarans->count() }} orang</div>
      </div>
    </td>
  </tr>
</table>

<!-- Data Table -->
<table style="width:100%; border-collapse: collapse; border: 1px solid #131218; margin-bottom: 24px;">
  <thead>
    <tr style="background: #1E1D26; color: #FFFFFF;">
      <th style="width: 35px; text-align: center; padding: 9px 8px; font-size: 8.5pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">No</th>
      <th style="padding: 9px 10px; font-size: 8.5pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; text-align: left;">Nama Peserta</th>
      <th style="padding: 9px 10px; font-size: 8.5pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; text-align: left;">Instansi</th>
      <th style="padding: 9px 10px; font-size: 8.5pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; width: 110px;">No. HP</th>
      <th style="padding: 9px 10px; font-size: 8.5pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; text-align: center; width: 170px; border-left: 1px dashed #CBD5E1;">Tanda Tangan</th>
    </tr>
  </thead>
  <tbody>
    @php $no = 1; @endphp
    @forelse($pendaftarans as $pd)
    <tr style="{{ $loop->even ? 'background: #F8FAFC;' : '' }}">
      <td style="text-align: center; padding: 9px 8px; font-size: 8.5pt; border-bottom: 1px solid #E2E8F0;">{{ $no++ }}</td>
      <td style="padding: 9px 10px; font-size: 8.5pt; border-bottom: 1px solid #E2E8F0; font-weight: bold; color: #131218;">{{ $pd->peserta->nama ?? '-' }}</td>
      <td style="padding: 9px 10px; font-size: 8.5pt; border-bottom: 1px solid #E2E8F0; color: #475569;">{{ $pd->peserta->instansi ?? '-' }}</td>
      <td style="padding: 9px 10px; font-size: 8.5pt; border-bottom: 1px solid #E2E8F0; color: #475569;">{{ $pd->peserta->no_hp ?? '-' }}</td>
      <td style="padding: 9px 10px; font-size: 8.5pt; border-bottom: 1px solid #E2E8F0; border-left: 1px dashed #CBD5E1;">&nbsp;</td>
    </tr>
    @empty
    <tr>
      <td colspan="5" style="text-align: center; padding: 24px; color: #64748B; font-size: 9pt;">Belum ada peserta terdaftar untuk kegiatan ini.</td>
    </tr>
    @endforelse
  </tbody>
</table>

<!-- Signatures Area -->
<table style="width:100%; margin-top: 35px;">
  <tr>
    <td style="width:50%; text-align: center; vertical-align: top;">
      <div style="width: 170px; margin: 45px auto 6px auto; border-bottom: 1.5px solid #131218;"></div>
      <div style="font-size: 9pt; font-weight: bold; color: #131218;">Instruktur / PIC</div>
      <div style="font-size: 8pt; color: #64748B;">Penanggungjawab Kegiatan</div>
    </td>
    <td style="width:50%; text-align: center; vertical-align: top;">
      <div style="width: 170px; margin: 45px auto 6px auto; border-bottom: 1.5px solid #131218;"></div>
      <div style="font-size: 9pt; font-weight: bold; color: #131218;">Direktur FCC</div>
      <div style="font-size: 8pt; color: #64748B;">Ketua Penyelenggara</div>
    </td>
  </tr>
</table>

<!-- Footer Accent Line -->
<div style="margin-top: 40px; border-top: 2.5px solid #FFC81A; padding-top: 10px; text-align: center; font-size: 8pt; color: #64748B; font-weight: bold;">
  Gedung FIKOM UMI, Jl. Urip Sumoharjo KM 5, Makassar &nbsp;&bull;&nbsp; Website: fcc.fikom.umi.ac.id
</div>

</body>
</html>
