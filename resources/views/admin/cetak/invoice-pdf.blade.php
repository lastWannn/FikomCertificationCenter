<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<style>
  @page {
    margin: 8mm;
    size: A5 portrait;
  }
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  body {
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 8.5pt;
    color: #1F2937;
    background: #FFFFFF;
    line-height: 1.4;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  .header-table {
    background: #131218;
    color: #FFFFFF;
    border-radius: 4px;
    margin-bottom: 4mm;
  }
  .header-table td {
    padding: 5mm 6mm;
    vertical-align: middle;
  }
  .brand-title {
    font-size: 11pt;
    font-weight: bold;
    color: #FFFFFF;
    letter-spacing: 0.5px;
  }
  .brand-sub {
    font-size: 7.5pt;
    color: #FFC81A;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 1mm;
  }
  .inv-title {
    font-size: 7pt;
    color: #9CA3B0;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-align: right;
  }
  .inv-code {
    font-size: 11pt;
    font-weight: bold;
    color: #FFC81A;
    font-family: 'Courier', monospace;
    text-align: right;
    margin-top: 1mm;
  }

  .section-heading {
    font-size: 7.5pt;
    font-weight: bold;
    color: #6B7280;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-top: 3mm;
    margin-bottom: 1.5mm;
  }

  .data-table {
    border: 1px solid #E5E7EB;
    border-radius: 4px;
    margin-bottom: 3mm;
  }
  .data-table td {
    padding: 2.5mm 4mm;
    border-bottom: 1px solid #F3F4F6;
    font-size: 8pt;
  }
  .data-table tr:last-child td {
    border-bottom: none;
  }
  .label-col {
    color: #6B7280;
    width: 35%;
  }
  .value-col {
    color: #111827;
    font-weight: bold;
    text-align: right;
  }

  .total-table {
    background: #FFC81A;
    border-radius: 4px;
    margin: 3mm 0;
  }
  .total-table td {
    padding: 4mm 5mm;
    vertical-align: middle;
  }
  .total-lbl {
    font-size: 8.5pt;
    font-weight: bold;
    color: #131218;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .total-val {
    font-size: 13pt;
    font-weight: bold;
    color: #131218;
    text-align: right;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  }

  .bank-table {
    background: #131218;
    color: #FFFFFF;
    border-radius: 4px;
    margin-bottom: 3mm;
  }
  .bank-table td {
    padding: 4mm 5mm;
  }
  .bank-lbl {
    font-size: 7pt;
    color: #9CA3B0;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1mm;
  }
  .bank-no {
    font-size: 13pt;
    font-weight: bold;
    color: #FFC81A;
    font-family: 'Courier', monospace;
    letter-spacing: 1.5px;
  }
  .bank-name {
    font-size: 8pt;
    color: #E5E7EB;
    margin-top: 1mm;
  }

  .alert-box {
    background: #FFFBEB;
    border: 1px solid #FCD34D;
    border-radius: 4px;
    padding: 2.5mm 3.5mm;
    color: #92400E;
    font-size: 7pt;
    margin-top: 2.5mm;
  }

  .footer {
    margin-top: 4mm;
    border-top: 1px solid #E5E7EB;
    padding-top: 2mm;
    text-align: center;
    color: #9CA3B0;
    font-size: 6.5pt;
  }
</style>
</head>
<body>

<!-- Header -->
<table class="header-table">
  <tr>
    <td>
      <table style="width: auto; border: none;">
        <tr>
          <td style="padding: 0; border: none; vertical-align: middle;">
            <img src="{{ public_path('images/logo.png') }}" style="height: 32px; width: auto; margin-right: 10px; vertical-align: middle;">
          </td>
          <td style="padding: 0; border: none; vertical-align: middle;">
            <div class="brand-title">FIKOM CERTIFICATION CENTER</div>
            <div class="brand-sub">Universitas Muslim Indonesia</div>
          </td>
        </tr>
      </table>
    </td>
    <td style="text-align: right;">
      <div class="inv-title">Kode Pembayaran</div>
      <div class="inv-code">{{ $pembayaran->kode_pembayaran }}</div>
    </td>
  </tr>
</table>

<!-- Informasi Peserta -->
<div class="section-heading">Informasi Peserta</div>
<table class="data-table">
  <tr>
    <td class="label-col">Nama Peserta</td>
    <td class="value-col">{{ $pembayaran->pendaftaran->peserta->nama }}</td>
  </tr>
  <tr>
    <td class="label-col">Email</td>
    <td class="value-col">{{ $pembayaran->pendaftaran->peserta->email }}</td>
  </tr>
  <tr>
    <td class="label-col">No. Telepon / HP</td>
    <td class="value-col">{{ $pembayaran->pendaftaran->peserta->no_hp }}</td>
  </tr>
</table>

<!-- Detail Pendaftaran -->
<div class="section-heading">Detail Pendaftaran & Tagihan</div>
<table class="data-table">
  <tr>
    <td class="label-col">Kegiatan</td>
    <td class="value-col">{{ Str::limit($pembayaran->pendaftaran->kegiatan->judul, 40) }}</td>
  </tr>
  <tr>
    <td class="label-col">Tanggal Pelaksanaan</td>
    <td class="value-col">{{ $pembayaran->pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}</td>
  </tr>
  <tr>
    <td class="label-col">Kategori Biaya</td>
    <td class="value-col">{{ $pembayaran->pendaftaran->biaya?->nama_jenis ?? 'Gratis' }}</td>
  </tr>
  @if($pembayaran->kode_unik)
  <tr>
    <td class="label-col">Kode Unik Transfer</td>
    <td class="value-col" style="color: #D97706;">{{ $pembayaran->kode_unik }}</td>
  </tr>
  @endif
  <tr>
    <td class="label-col">Tanggal Invoice</td>
    <td class="value-col">{{ $pembayaran->created_at->format('d M Y H:i') }} WITA</td>
  </tr>
  <tr>
    <td class="label-col">Batas Pembayaran</td>
    <td class="value-col" style="color: #DC2626;">{{ $pembayaran->tgl_kadaluarsa?->format('d M Y H:i') ?? '-' }} WITA</td>
  </tr>
</table>

<!-- Total Box -->
<table class="total-table">
  <tr>
    <td class="total-lbl">Total Tagihan Transfer</td>
    <td class="total-val">{{ $pembayaran->nominal_transfer_format }}</td>
  </tr>
</table>

<!-- Rekening Bank -->
@if($rekening)
<div class="section-heading">Tujuan Transfer Bank</div>
<table class="bank-table">
  <tr>
    <td>
      <div class="bank-lbl">Nomor Rekening Tujuan</div>
      <div class="bank-no">{{ $rekening->no_rekening }}</div>
      <div class="bank-name">{{ $rekening->bank }} &mdash; a.n. {{ $rekening->nama_pemilik }}</div>
    </td>
  </tr>
</table>
@endif

<!-- Warning -->
<div class="alert-box">
  <strong>Catatan Penting:</strong> Harap lakukan transfer sesuai nominal persis di atas (termasuk kode unik jika ada) sebelum batas waktu kadaluarsa. Simpan invoice ini sebagai bukti pendaftaran resmi Anda.
</div>

<!-- Footer -->
<div class="footer">
  FIKOM Certification Center &bull; Fakultas Ilmu Komputer Universitas Muslim Indonesia Makassar<br/>
  Dokumen Invoice Otomatis &bull; Dicetak: {{ now()->format('d M Y H:i') }} WITA
</div>

</body>
</html>
