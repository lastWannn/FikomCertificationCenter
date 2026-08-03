<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<style>
  @page{ margin:12mm; size:A4; }
  *{ box-sizing:border-box; }
  body{ font-family:'DejaVu Sans',Arial,sans-serif; font-size:9pt; color:#131218; }
  .header{ display:flex; justify-content:space-between; align-items:flex-start; border-bottom:2.5px solid #131218; padding-bottom:5mm; margin-bottom:5mm; }
  .title{ font-size:14pt; font-weight:900; color:#131218; margin:0 0 1mm; }
  .subtitle{ color:#5A6275; font-size:9pt; }
  .info-grid{ display:flex; gap:12mm; margin-bottom:5mm; }
  .info-item{ flex:1; background:#F7F8FA; border:1px solid #E2E4EB; border-radius:1.5mm; padding:2.5mm 3.5mm; }
  .info-lbl{ color:#9CA3B0; font-size:7pt; text-transform:uppercase; letter-spacing:.5pt; margin-bottom:1mm; }
  .info-val{ font-weight:700; font-size:8.5pt; }
  table{ width:100%; border-collapse:collapse; margin-top:3mm; }
  thead tr{ background:#131218; color:#FFF; }
  th{ padding:2.5mm 3mm; text-align:left; font-size:8pt; font-weight:700; text-transform:uppercase; letter-spacing:.5pt; }
  td{ padding:2.5mm 3mm; border-bottom:0.5px solid #E2E4EB; font-size:8.5pt; vertical-align:middle; }
  tr:nth-child(even) td{ background:#F9FAFB; }
  .ttd-col{ width:40mm; border-right:1px dashed #E2E4EB; }
  .badge{ display:inline-block; padding:1mm 3mm; border-radius:20px; font-size:7.5pt; font-weight:700; }
  .badge-green{ background:rgba(16,185,129,.12); color:#059669; }
  .badge-red{ background:rgba(239,68,68,.1); color:#DC2626; }
  .badge-gray{ background:#F3F4F6; color:#9CA3B0; }
  .footer{ margin-top:8mm; display:flex; justify-content:space-between; }
  .ttd-box{ text-align:center; width:55mm; }
  .ttd-name-line{ border-bottom:1px solid #131218; margin:14mm 0 2mm; }
</style>
</head>
<body>
<div class="header">
  <div>
    <div class="title">DAFTAR PRESENSI</div>
    <div class="subtitle">FIKOM Certification Center — Universitas Muslim Indonesia</div>
  </div>
  <div style="text-align:right;">
    <div style="font-size:8pt;color:#9CA3B0;">Dicetak: {{ now()->format('d M Y H:i') }}</div>
  </div>
</div>

<div class="info-grid">
  <div class="info-item">
    <div class="info-lbl">Kegiatan</div>
    <div class="info-val">{{ $kegiatan->judul }}</div>
  </div>
  <div class="info-item">
    <div class="info-lbl">Tanggal Pelaksanaan</div>
    <div class="info-val">{{ $kegiatan->jadwal?->tgl_pelaksanaan?->format('d F Y') ?? 'TBA' }}</div>
  </div>
  <div class="info-item">
    <div class="info-lbl">Waktu</div>
    <div class="info-val">{{ $kegiatan->jadwal?->jam_mulai ? substr($kegiatan->jadwal->jam_mulai, 0, 5) : '-' }} &ndash; {{ $kegiatan->jadwal?->jam_selesai ? substr($kegiatan->jadwal->jam_selesai, 0, 5) : '-' }}</div>
  </div>
  <div class="info-item">
    <div class="info-lbl">Total Peserta</div>
    <div class="info-val">{{ $kegiatan->pendaftaran->where('status_pendaftaran','terdaftar')->count() }} orang</div>
  </div>
</div>

<table>
  <thead>
    <tr>
      <th style="width:8mm;">No</th>
      <th>Nama Peserta</th>
      <th>Instansi</th>
      <th>No. HP</th>
      <th>Status</th>
      <th class="ttd-col">Tanda Tangan</th>
    </tr>
  </thead>
  <tbody>
    @php $no=1; @endphp
    @foreach($kegiatan->pendaftaran->where('status_pendaftaran','terdaftar') as $pd)
    <tr>
      <td style="text-align:center;">{{ $no++ }}</td>
      <td>{{ $pd->peserta->nama }}</td>
      <td>{{ $pd->peserta->instansi ?? '-' }}</td>
      <td>{{ $pd->peserta->no_hp }}</td>
      <td>
        @if($pd->status_kehadiran === 'hadir')
          <span class="badge badge-green">✓ Hadir</span>
        @elseif($pd->status_kehadiran === 'tidak_hadir')
          <span class="badge badge-red">✗ Tidak</span>
        @else
          <span class="badge badge-gray">—</span>
        @endif
      </td>
      <td class="ttd-col">&nbsp;</td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="footer">
  <div class="ttd-box">
    <div class="ttd-name-line"></div>
    <div style="font-size:8pt;font-weight:700;">Instruktur / PIC</div>
    <div style="font-size:7.5pt;color:#9CA3B0;">Penanggungjawab Kegiatan</div>
  </div>
  <div class="ttd-box">
    <div class="ttd-name-line"></div>
    <div style="font-size:8pt;font-weight:700;">Direktur FCC</div>
    <div style="font-size:7.5pt;color:#9CA3B0;">Ketua Penyelenggara</div>
  </div>
</div>
</body>
</html>
