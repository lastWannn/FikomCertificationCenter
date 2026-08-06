<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Daftar Presensi - {{ $kegiatan->judul }}</title>
<style>
  @page { margin: 12mm 15mm; size: A4 portrait; }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 9pt; color: #131218; background: #F3F4F6; line-height: 1.4; padding: 20px; }
  
  .print-card { background: #FFFFFF; max-width: 850px; margin: 0 auto; padding: 20mm 15mm; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
  
  .action-bar { max-width: 850px; margin: 0 auto 16px auto; display: flex; justify-content: space-between; align-items: center; }
  .btn-print { background: #FFC81A; color: #131218; border: none; padding: 9px 20px; border-radius: 8px; font-weight: bold; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
  .btn-back { background: #E5E7EB; color: #374151; border: none; padding: 9px 18px; border-radius: 8px; font-weight: bold; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; }
  
  table { width: 100%; border-collapse: collapse; }
  
  .header-table { width: 100%; border-bottom: 2px solid #131218; padding-bottom: 12px; margin-bottom: 16px; }
  .title { font-size: 16pt; font-weight: 800; color: #131218; letter-spacing: -0.5px; }
  .subtitle { color: #4B5563; font-size: 9pt; margin-top: 2px; }
  
  .info-table { width: 100%; margin-bottom: 16px; }
  .info-table td { width: 25%; padding: 4px; vertical-align: top; }
  .info-box { background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 6px; padding: 10px 12px; }
  .info-lbl { color: #6B7280; font-size: 7.5pt; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 2px; }
  .info-val { font-weight: 700; font-size: 9pt; color: #111827; }
  
  .data-table { width: 100%; margin-top: 8px; border: 1px solid #131218; }
  .data-table th { background: #131218; color: #FFFFFF; padding: 8px 10px; text-align: left; font-size: 8.5pt; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
  .data-table td { padding: 8px 10px; border-bottom: 1px solid #E5E7EB; font-size: 8.5pt; vertical-align: middle; }
  .data-table tr:nth-child(even) td { background: #F9FAFB; }
  .ttd-col { width: 140px; border-left: 1px dashed #D1D5DB; }
  
  .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 7.5pt; font-weight: 700; }
  .badge-green { background: #D1FAE5; color: #047857; }
  .badge-red { background: #FEE2E2; color: #B91C1C; }
  .badge-gray { background: #F3F4F6; color: #6B7280; }
  
  .footer-table { width: 100%; margin-top: 40px; }
  .footer-table td { width: 50%; vertical-align: top; text-align: center; }
  .ttd-line { width: 180px; margin: 55px auto 6px auto; border-bottom: 1px solid #131218; }
  
  @media print {
    body { background: #FFFFFF; padding: 0; }
    .action-bar { display: none !important; }
    .print-card { box-shadow: none; padding: 0; max-width: 100%; border-radius: 0; }
    @page { margin: 10mm 12mm; }
  }
</style>
</head>
<body>

<div class="action-bar">
  <button onclick="window.close()" class="btn-back">← Tutup Tab</button>
  <button onclick="window.print()" class="btn-print">🖨️ Cetak / Simpan PDF</button>
</div>

<div class="print-card">

  <table class="header-table">
    <tr>
      <td>
        <div class="title">DAFTAR PRESENSI PESERTA</div>
        <div class="subtitle">FIKOM Certification Center — Universitas Muslim Indonesia</div>
      </td>
      <td style="text-align: right; vertical-align: bottom; color: #6B7280; font-size: 8.5pt;">
        Dicetak: {{ now()->format('d M Y H:i') }}
      </td>
    </tr>
  </table>

  @php
    $pendaftarans = $kegiatan->pendaftaran->filter(fn($p) => in_array($p->status_pendaftaran, ['terdaftar', 'lulus', 'tidak_lulus']));
  @endphp

  <table class="info-table">
    <tr>
      <td>
        <div class="info-box">
          <div class="info-lbl">Kegiatan</div>
          <div class="info-val">{{ $kegiatan->judul }}</div>
        </div>
      </td>
      <td>
        <div class="info-box">
          <div class="info-lbl">Tanggal Pelaksanaan</div>
          <div class="info-val">{{ $kegiatan->jadwal?->tgl_pelaksanaan?->format('d F Y') ?? 'TBA' }}</div>
        </div>
      </td>
      <td>
        <div class="info-box">
          <div class="info-lbl">Waktu</div>
          <div class="info-val">{{ $kegiatan->jadwal?->jam_mulai ? substr($kegiatan->jadwal->jam_mulai, 0, 5) : '-' }} &ndash; {{ $kegiatan->jadwal?->jam_selesai ? substr($kegiatan->jadwal->jam_selesai, 0, 5) : '-' }}</div>
        </div>
      </td>
      <td>
        <div class="info-box">
          <div class="info-lbl">Total Peserta</div>
          <div class="info-val">{{ $pendaftarans->count() }} orang</div>
        </div>
      </td>
    </tr>
  </table>

  <table class="data-table">
    <thead>
      <tr>
        <th style="width: 35px; text-align: center;">No</th>
        <th>Nama Peserta</th>
        <th>Instansi</th>
        <th>No. HP</th>
        <th style="text-align: center; width: 100px;">Status</th>
        <th class="ttd-col" style="text-align: center;">Tanda Tangan</th>
      </tr>
    </thead>
    <tbody>
      @php $no = 1; @endphp
      @forelse($pendaftarans as $pd)
      <tr>
        <td style="text-align: center;">{{ $no++ }}</td>
        <td><strong>{{ $pd->peserta->nama ?? '-' }}</strong></td>
        <td>{{ $pd->peserta->instansi ?? '-' }}</td>
        <td>{{ $pd->peserta->no_hp ?? '-' }}</td>
        <td style="text-align: center;">
          @if($pd->status_kehadiran === 'hadir')
            <span class="badge badge-green">✓ Hadir</span>
          @elseif($pd->status_kehadiran === 'tidak_hadir')
            <span class="badge badge-red">✕ Tidak Hadir</span>
          @else
            <span class="badge badge-gray">— Belum</span>
          @endif
        </td>
        <td class="ttd-col">&nbsp;</td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align: center; padding: 20px; color: #6B7280;">Belum ada peserta terdaftar untuk kegiatan ini.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <table class="footer-table">
    <tr>
      <td>
        <div class="ttd-line"></div>
        <div style="font-size: 9pt; font-weight: 700;">Instruktur / PIC</div>
        <div style="font-size: 8pt; color: #6B7280;">Penanggungjawab Kegiatan</div>
      </td>
      <td>
        <div class="ttd-line"></div>
        <div style="font-size: 9pt; font-weight: 700;">Direktur FCC</div>
        <div style="font-size: 8pt; color: #6B7280;">Ketua Penyelenggara</div>
      </td>
    </tr>
  </table>

</div>

<script>
  window.onload = function() {
    setTimeout(function() {
      window.print();
    }, 350);
  };
</script>

</body>
</html>
