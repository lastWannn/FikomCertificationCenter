<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Berita Acara - {{ $arsip->judul }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>

<style>
  @page {
    margin: 20mm;
    size: A4 portrait;
  }
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  body {
    font-family: 'Inter', 'Helvetica', 'Arial', sans-serif;
    font-size: 10pt;
    color: #0F172A;
    background: #FFFFFF;
    line-height: 1.6;
    margin: 0;
    padding: 0;
  }
  .paper-container {
    max-width: 800px;
    margin: 0 auto;
    background: #FFFFFF;
    padding: 20px;
    position: relative;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  .kop-table {
    width: 100%;
    border-bottom: 3px double #1E293B;
    padding-bottom: 14px;
    margin-bottom: 24px;
  }
  .kop-title {
    font-size: 14pt;
    font-weight: 900;
    color: #0F172A;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: center;
  }
  .kop-sub {
    font-size: 9pt;
    color: #475569;
    text-align: center;
    margin-top: 3px;
  }
  .doc-title {
    text-align: center;
    font-size: 13pt;
    font-weight: 900;
    text-transform: uppercase;
    color: #0F172A;
    margin-bottom: 4px;
    letter-spacing: 1px;
  }
  .doc-num {
    text-align: center;
    font-size: 9.5pt;
    color: #64748B;
    margin-bottom: 24px;
  }
  .meta-table {
    width: 100%;
    margin-bottom: 20px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    padding: 14px 18px;
  }
  .meta-table td {
    padding: 6px 8px;
    vertical-align: top;
  }
  .label {
    font-weight: 800;
    color: #334155;
    width: 160px;
  }
  .content-box {
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    padding: 18px;
    margin-bottom: 28px;
    background: #FFFFFF;
  }
  .content-title {
    font-size: 11pt;
    font-weight: 800;
    color: #0F172A;
    margin-bottom: 10px;
    border-bottom: 1px solid #E2E8F0;
    padding-bottom: 8px;
  }
  .signature-table {
    width: 100%;
    margin-top: 40px;
  }
  .signature-table td {
    width: 50%;
    text-align: center;
    vertical-align: top;
  }
  .signature-space {
    height: 75px;
  }
  .footer-note {
    margin-top: 36px;
    font-size: 8.5pt;
    color: #94A3B8;
    text-align: center;
    border-top: 1px solid #E2E8F0;
    padding-top: 12px;
  }

  /* MEDIA PRINT OVERRIDES */
  @media print {
    .no-print { display: none !important; }
    body { padding: 0 !important; background: #FFFFFF !important; }
    .paper-container { max-width: 100% !important; margin: 0 !important; padding: 0 !important; box-shadow: none !important; border-radius: 0 !important; }
  }
</style>
</head>
<body>

  {{-- PAPER CONTAINER --}}
  <div class="paper-container">
    {{-- KOP SURAT --}}
    <table class="kop-table">
      <tr>
        <td style="text-align: center;">
          <div class="kop-title">UNIVERSITAS MUSLIM INDONESIA</div>
          <div class="kop-title" style="font-size: 12pt; color: #0284C7; margin-top: 2px;">FAKULTAS ILMU KOMPUTER</div>
          <div class="kop-title" style="font-size: 11pt; font-weight: 800; margin-top: 2px;">FIKOM CERTIFICATION CENTER (FCC)</div>
          <div class="kop-sub">Jl. Urip Sumoharjo KM. 05 Kampus II UMI Makassar 90232 | Email: fcc@fikom.umi.ac.id</div>
        </td>
      </tr>
    </table>

    {{-- JUDUL DOKUMEN --}}
    <div class="doc-title">BERITA ACARA PELAKSANAAN KEGIATAN</div>
    <div class="doc-num">Nomor: {{ $arsip->hashid }}/BA-FCC/{{ date('Y', strtotime($arsip->created_at ?? now())) }}</div>

    {{-- INFORMASI KEGIATAN --}}
    <table class="meta-table">
      <tr>
        <td class="label">Nama Kegiatan</td>
        <td style="width: 10px;">:</td>
        <td><strong>{{ $arsip->judul }}</strong></td>
      </tr>
      <tr>
        <td class="label">Jenis Kegiatan</td>
        <td style="width: 10px;">:</td>
        <td>{{ ucfirst($arsip->kegiatan?->jenis_kegiatan ?? 'Pelatihan & Sertifikasi') }}</td>
      </tr>
      <tr>
        <td class="label">Tanggal Pelaksanaan</td>
        <td style="width: 10px;">:</td>
        <td>{{ $arsip->kegiatan?->jadwal?->tgl_pelaksanaan ? date('d F Y', strtotime($arsip->kegiatan->jadwal->tgl_pelaksanaan)) : date('d F Y', strtotime($arsip->created_at)) }}</td>
      </tr>
      <tr>
        <td class="label">Jumlah Peserta</td>
        <td style="width: 10px;">:</td>
        <td>{{ $arsip->kegiatan?->terisi ?? 0 }} Peserta Terdaftar</td>
      </tr>
    </table>

    {{-- RINGKASAN KEGIATAN --}}
    <div class="content-box">
      <div class="content-title">Ringkasan Laporan &amp; Berita Acara</div>
      <div style="font-size: 10pt; color: #334155; line-height: 1.7; text-align: justify;">
        {!! nl2br(e($arsip->ringkasan ?: 'Demikian Berita Acara pelaksanaan kegiatan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.')) !!}
      </div>
    </div>

    {{-- TANDA TANGAN --}}
    <table class="signature-table">
      <tr>
        <td>
          <div>Mengetahui,</div>
          <div style="font-weight: 800; margin-top: 2px;">Ketua FIKOM Certification Center</div>
          <div class="signature-space"></div>
          <div style="font-weight: 800; text-decoration: underline;">( Tim Sekretariat FCC )</div>
          <div style="font-size: 8.5pt; color: #64748B;">NIP / NIDN. FCC-UMI</div>
        </td>
        <td>
          <div>Makassar, {{ date('d F Y', strtotime($arsip->created_at ?? now())) }}</div>
          <div style="font-weight: 800; margin-top: 2px;">Penanggung Jawab Kegiatan</div>
          <div class="signature-space"></div>
          <div style="font-weight: 800; text-decoration: underline;">( Panitia Pelaksana )</div>
          <div style="font-size: 8.5pt; color: #64748B;">FIKOM UMI Makassar</div>
        </td>
      </tr>
    </table>

    <div class="footer-note">
      Dokumen ini diterbitkan secara resmi oleh FIKOM Certification Center (FCC) Universitas Muslim Indonesia Makassar.
    </div>
  </div>

</body>
</html>
