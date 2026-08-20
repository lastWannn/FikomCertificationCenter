<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<title>Sertifikat - {{ $sertifikat->nomor_sertifikat }}</title>
<style>
  @page { size: 297mm 210mm; margin: 0; }
  html, body {
    width: 297mm;
    height: 210mm;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background: #e5e7eb;
    color: #0F172A;
    font-family: Helvetica, Arial, sans-serif;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }
  .stage { width: 100%; height: 100%; }
  .sheet {
    position: relative;
    width: 297mm;
    height: 210mm;
    overflow: hidden;
    background: #fff;
    color: #0F172A;
  }
  .custom-bg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 0;
  }
  .overlay { position: absolute; inset: 0; z-index: 1; }
  .border-outer, .border-inner, .corner {
    position: absolute;
    pointer-events: none;
    z-index: 2;
  }
  .border-outer { top: 6mm; left: 6mm; right: 6mm; bottom: 6mm; border: 1.5px solid #D1D5DB; border-radius: 2mm; }
  .border-inner { top: 8mm; left: 8mm; right: 8mm; bottom: 8mm; border: 1px solid rgba(245, 158, 11, 0.18); border-radius: 1mm; }
  .corner { width: 14mm; height: 14mm; }
  .corner-tl { top: 5mm; left: 5mm; border-top: 2px solid #F59E0B; border-left: 2px solid #F59E0B; }
  .corner-tr { top: 5mm; right: 5mm; border-top: 2px solid #F59E0B; border-right: 2px solid #F59E0B; }
  .corner-bl { bottom: 5mm; left: 5mm; border-bottom: 2px solid #F59E0B; border-left: 2px solid #F59E0B; }
  .corner-br { bottom: 5mm; right: 5mm; border-bottom: 2px solid #F59E0B; border-right: 2px solid #F59E0B; }

  .content {
    position: absolute;
    inset: 18mm 24mm 20mm 24mm;
    z-index: 3;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
  .main {
    width: 100%;
    flex: 1;
    display: flex;
    align-items: center;
  }
  .content-block {
    width: 100%;
    transform: translateY(16mm);
  }

  .header-table, .info-table, .signature-table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
  }
  .header-table { margin-bottom: 4mm; }
  .institution-name {
    font-size: 17pt;
    font-weight: 900;
    color: #0F172A;
    letter-spacing: 1px;
    line-height: 1.2;
    text-transform: uppercase;
  }
  .institution-sub {
    font-size: 8.5pt;
    font-weight: 800;
    color: #64748B;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    margin-top: 2px;
  }
  .title-wrapper { margin-top: 2mm; margin-bottom: 3mm; }
  .cert-heading {
    font-size: 14.5pt;
    font-weight: 900;
    color: #1E293B;
    letter-spacing: 3px;
    text-transform: uppercase;
  }
  .gold-divider-line {
    width: 70mm;
    height: 2px;
    background: linear-gradient(90deg, rgba(245,158,11,0) 0%, #F59E0B 50%, rgba(245,158,11,0) 100%);
    margin: 3.5mm auto 0 auto;
    border-radius: 1px;
  }
  .recipient-label {
    font-size: 9pt;
    color: #64748B;
    font-weight: 500;
    margin-top: 3mm;
  }
  .recipient-name {
    font-size: 29.5pt;
    font-weight: 900;
    color: #0F172A;
    line-height: 1.2;
    margin: 2.5mm 0 4.5mm 0;
    letter-spacing: -0.4px;
  }
  .achievement-label {
    font-size: 9pt;
    color: #64748B;
    font-weight: 500;
    margin-bottom: 2mm;
  }
  .course-name {
    font-size: 17pt;
    font-weight: 800;
    color: #7C5E10;
    line-height: 1.3;
    margin-bottom: 2.5mm;
  }
  .course-description {
    font-size: 9pt;
    color: #64748B;
    max-width: 180mm;
    margin: 0 auto;
    line-height: 1.55;
  }
  .info-table { margin-top: 8mm; margin-bottom: 8mm; }
  .info-label {
    font-size: 7.5pt;
    font-weight: 700;
    color: #64748B;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 1.5mm;
  }
  .info-value {
    font-size: 10pt;
    font-weight: 800;
    color: #0F172A;
  }
  .info-value-highlight {
    font-size: 10pt;
    font-weight: 800;
    color: #B45309;
    font-family: 'Courier New', Courier, monospace;
  }
  .signature-table {
    width: 88%;
    margin: 10mm auto 0 auto;
  }
  .signature-table td:first-child { padding-right: 12mm; }
  .signature-table td:last-child { padding-left: 12mm; }
  .sig-space { height: 20mm; }
  .sig-line {
    width: 52mm;
    height: 1px;
    background: #F59E0B;
    margin: 0 auto 2.5mm auto;
  }
  .sig-name {
    font-size: 9.5pt;
    font-weight: 800;
    color: #0F172A;
  }
  .sig-role {
    font-size: 8.5pt;
    color: #64748B;
    font-weight: 500;
    margin-top: 1px;
  }
  .footer-serial {
    display: none;
  }
</style>
</head>
<body>
<div class="stage">
  <div class="sheet">
    @if($bgSrc)
      <img class="custom-bg" src="{{ $bgSrc }}" alt="Latar Sertifikat">
    @else
      <div class="custom-bg" style="background:linear-gradient(135deg,#FFFFFF 0%,#FFFDF7 50%,#FFF4CC 100%);"></div>
    @endif
    <div class="overlay"></div>
    <div class="border-outer"></div>
    <div class="border-inner"></div>
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    <div class="content">
      <div class="main">
        <div class="content-block">
          <table class="header-table">
            <tr>
              <td align="center">
                <div class="institution-name">FIKOM Certification Center</div>
                <div class="institution-sub">Universitas Muslim Indonesia</div>
              </td>
            </tr>
          </table>

          <div class="title-wrapper">
            <div class="cert-heading">Sertifikat Kelulusan</div>
            <div class="gold-divider-line"></div>
          </div>

          <div class="recipient-label">Diberikan Kepada:</div>
          <div class="recipient-name">{{ $sertifikat->pendaftaran->peserta->nama }}</div>

          <div class="achievement-label">Atas keberhasilan menyelesaikan:</div>
          <div class="course-name">{{ $sertifikat->pendaftaran->kegiatan->judul }}</div>
          <div class="course-description">
            Program {{ ucfirst($sertifikat->pendaftaran->kegiatan->jenis_kegiatan) }} yang diselenggarakan oleh
            FIKOM Certification Center, Universitas Muslim Indonesia.
          </div>

          <table class="info-table">
            <tr>
              <td width="33.33%" align="center">
                <div class="info-label">Tanggal Terbit</div>
                <div class="info-value">{{ optional($sertifikat->tgl_terbit)->format('d F Y') ?? '-' }}</div>
              </td>
              <td width="33.33%" align="center">
                <div class="info-label">No. Sertifikat</div>
                <div class="info-value-highlight">{{ $sertifikat->nomor_sertifikat }}</div>
              </td>
              <td width="33.33%" align="center">
                <div class="info-label">Pelaksanaan</div>
                <div class="info-value">{{ $sertifikat->pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? '-' }}</div>
              </td>
            </tr>
          </table>

          <table class="signature-table">
            <tr>
              <td width="50%" align="center">
                <div class="sig-space"></div>
                <div class="sig-line"></div>
                <div class="sig-name">Dekan FIKOM UMI</div>
                <div class="sig-role">Penanggung Jawab</div>
              </td>
              <td width="50%" align="center">
                <div class="sig-space"></div>
                <div class="sig-line"></div>
                <div class="sig-name">Direktur FCC</div>
                <div class="sig-role">Ketua Penyelenggara</div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
