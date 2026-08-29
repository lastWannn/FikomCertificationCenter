<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<title>Bukti Pembayaran - {{ $pembayaran->kode_pembayaran }}</title>
<style>
  @page {
    margin: 0px;
    size: A5 portrait;
  }
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  body {
    font-family: 'Helvetica', 'Arial', sans-serif;
    font-size: 8.5pt;
    color: #1E293B;
    background: #FFFFFF;
    line-height: 1.35;
    padding: 22px 26px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
</style>
</head>
<body>

<!-- Header Card -->
<table style="width: 100%; background: #131218; border-radius: 8px; margin-bottom: 14px;">
  <tr>
    <td style="padding: 14px 18px; vertical-align: middle;">
      <div style="font-size: 13pt; font-weight: bold; color: #FFFFFF; letter-spacing: -0.3px; text-transform: uppercase;">BUKTI PEMBAYARAN</div>
      <div style="font-size: 7.5pt; font-weight: bold; color: #FFC81A; letter-spacing: 0.8px; text-transform: uppercase; margin-top: 2px;">
        FIKOM CERTIFICATION CENTER
      </div>
    </td>
    <td style="padding: 12px 18px; text-align: right; vertical-align: middle; width: 150px;">
      <table style="width: auto; float: right; background: #059669; border: 2px solid #34D399; border-radius: 6px;">
        <tr>
          <td style="padding: 6px 14px; text-align: center; white-space: nowrap;">
            <div style="font-size: 11pt; font-weight: bold; color: #FFFFFF; letter-spacing: 2px; text-transform: uppercase;">LUNAS</div>
            <div style="font-size: 6pt; font-weight: bold; color: #A7F3D0; letter-spacing: 1px; text-transform: uppercase; margin-top: 1px;">VERIFIED &bull; TERVERIFIKASI</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- Key Info Strip -->
<table style="width: 100%; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 6px; margin-bottom: 14px;">
  <tr>
    <td style="width: 38%; padding: 8px 10px; border-right: 1px solid #E2E8F0; vertical-align: top;">
      <div style="font-size: 7pt; font-weight: bold; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Kode Pembayaran</div>
      <div style="font-size: 9.5pt; font-weight: bold; color: #2563EB; font-family: monospace; margin-top: 2px;">{{ $pembayaran->kode_pembayaran }}</div>
    </td>
    <td style="width: 32%; padding: 8px 10px; border-right: 1px solid #E2E8F0; vertical-align: top;">
      <div style="font-size: 7pt; font-weight: bold; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">No. Kwitansi</div>
      <div style="font-size: 9pt; font-weight: bold; color: #0F172A; margin-top: 2px;">{{ $pembayaran->no_kwitansi ?: '-' }}</div>
    </td>
    <td style="width: 30%; padding: 8px 10px; vertical-align: top;">
      <div style="font-size: 7pt; font-weight: bold; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Tgl Verifikasi</div>
      <div style="font-size: 8.5pt; font-weight: bold; color: #0F172A; margin-top: 2px;">{{ $pembayaran->tgl_verifikasi?->format('d M Y H:i') ?? now()->format('d M Y H:i') }} WITA</div>
    </td>
  </tr>
</table>

<!-- Section 1: Informasi Peserta & Kegiatan -->
<div style="font-size: 7.5pt; font-weight: bold; color: #64748B; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 4px;">INFORMASI PESERTA &amp; KEGIATAN</div>
<table style="width: 100%; border: 1px solid #E2E8F0; border-radius: 6px; margin-bottom: 14px;">
  <tr style="border-bottom: 1px solid #F1F5F9;">
    <td style="width: 32%; padding: 7px 10px; font-size: 8pt; color: #64748B; font-weight: bold; background: #F8FAFC;">Nama Peserta</td>
    <td style="padding: 7px 10px; font-size: 8.5pt; font-weight: bold; color: #0F172A;">{{ $pembayaran->pendaftaran->peserta->nama }}</td>
  </tr>
  <tr style="border-bottom: 1px solid #F1F5F9;">
    <td style="padding: 7px 10px; font-size: 8pt; color: #64748B; font-weight: bold; background: #F8FAFC;">Kegiatan</td>
    <td style="padding: 7px 10px; font-size: 8.5pt; font-weight: bold; color: #0F172A;">{{ $pembayaran->pendaftaran->kegiatan->judul }}</td>
  </tr>
  <tr style="border-bottom: 1px solid #F1F5F9;">
    <td style="padding: 7px 10px; font-size: 8pt; color: #64748B; font-weight: bold; background: #F8FAFC;">Jenis Kegiatan</td>
    <td style="padding: 7px 10px; font-size: 8.5pt; font-weight: bold; color: #0F172A;">{{ ucfirst($pembayaran->pendaftaran->kegiatan->jenis_kegiatan ?? 'Kegiatan') }} &bull; {{ $pembayaran->pendaftaran->biaya?->nama_jenis ?? 'Umum' }}</td>
  </tr>
  <tr>
    <td style="padding: 7px 10px; font-size: 8pt; color: #64748B; font-weight: bold; background: #F8FAFC;">Tgl Pelaksanaan</td>
    <td style="padding: 7px 10px; font-size: 8.5pt; font-weight: bold; color: #0F172A;">{{ $pembayaran->pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->format('d F Y') ?? 'Jadwal Menyusul' }}</td>
  </tr>
</table>

<!-- Section 2: Rincian Transaksi Pembayaran -->
<div style="font-size: 7.5pt; font-weight: bold; color: #64748B; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 4px;">RINCIAN TRANSAKSI</div>
<table style="width: 100%; border: 1px solid #E2E8F0; border-radius: 6px; margin-bottom: 14px;">
  <tr style="border-bottom: 1px solid #F1F5F9;">
    <td style="width: 32%; padding: 7px 10px; font-size: 8pt; color: #64748B; font-weight: bold; background: #F8FAFC;">Metode Bayar</td>
    <td style="padding: 7px 10px; font-size: 8.5pt; font-weight: bold; color: #0F172A;">{{ $pembayaran->metode_pembayaran ? ucfirst($pembayaran->metode_pembayaran) : 'Transfer Bank' }}</td>
  </tr>
  <tr style="border-bottom: 1px solid #F1F5F9;">
    <td style="padding: 7px 10px; font-size: 8pt; color: #64748B; font-weight: bold; background: #F8FAFC;">Layanan Bank</td>
    <td style="padding: 7px 10px; font-size: 8.5pt; font-weight: bold; color: #0F172A;">{{ $pembayaran->nama_layanan_bank ?: '-' }}</td>
  </tr>
  <tr style="border-bottom: 1px solid #F1F5F9;">
    <td style="padding: 7px 10px; font-size: 8pt; color: #64748B; font-weight: bold; background: #F8FAFC;">Nama Pengirim</td>
    <td style="padding: 7px 10px; font-size: 8.5pt; font-weight: bold; color: #0F172A;">{{ $pembayaran->nama_pengirim ?: $pembayaran->pendaftaran->peserta->nama }}</td>
  </tr>
  <tr>
    <td style="padding: 7px 10px; font-size: 8pt; color: #64748B; font-weight: bold; background: #F8FAFC;">Waktu Transfer</td>
    <td style="padding: 7px 10px; font-size: 8.5pt; font-weight: bold; color: #0F172A;">
      {{ $pembayaran->tgl_transfer ? \Carbon\Carbon::parse($pembayaran->tgl_transfer)->format('d M Y').' '.$pembayaran->jam_transfer : '-' }}
    </td>
  </tr>
</table>

<!-- Total Diterima Green Highlight Box -->
<table style="width: 100%; background: #ECFDF5; border: 1.5px solid #A7F3D0; border-radius: 8px; margin-bottom: 14px;">
  <tr>
    <td style="padding: 10px 14px; vertical-align: middle;">
      <div style="font-size: 8.5pt; font-weight: bold; color: #047857; text-transform: uppercase; letter-spacing: 0.5px;">TOTAL LUNAS DITERIMA</div>
      <div style="font-size: 7.5pt; color: #065F46; margin-top: 1px;">Termasuk biaya registrasi &amp; kode unik transaksi</div>
    </td>
    <td style="padding: 10px 14px; text-align: right; vertical-align: middle;">
      <div style="font-size: 14pt; font-weight: bold; color: #047857; font-family: monospace;">{{ $pembayaran->nominal_transfer_format }}</div>
    </td>
  </tr>
</table>

<!-- Official Footer -->
<table style="width: 100%; margin-top: 6px;">
  <tr>
    <td style="text-align: center; font-size: 7.5pt; color: #64748B; border-top: 1.5px solid #FFC81A; padding-top: 8px;">
      <div>Dokumen bukti pembayaran ini diterbitkan secara sah dan resmi oleh FIKOM Certification Center.</div>
      <div style="font-weight: bold; margin-top: 2px;">Universitas Muslim Indonesia Makassar &bull; Dicetak: {{ now()->format('d M Y H:i') }} WITA</div>
    </td>
  </tr>
</table>

</body>
</html>
