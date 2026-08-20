<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Preview Sertifikat</title>
<style>
  @page { size: 297mm 210mm; margin: 0; }
  html, body {
    width: 297mm;
    height: 210mm;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background: #e5e7eb;
    font-family: Helvetica, Arial, sans-serif;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }
  .stage {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .sheet {
    position: relative;
    width: 297mm;
    height: 210mm;
    overflow: hidden;
    background: #fff;
    color: #0F172A;
  }
  .bg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 0;
  }
  .overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
  }
  .border-outer, .border-inner, .corner { position: absolute; pointer-events: none; z-index: 2; }
  .border-outer { top: 6mm; left: 6mm; right: 6mm; bottom: 6mm; border: 2px solid #D97706; border-radius: 2mm; }
  .border-inner { top: 8mm; left: 8mm; right: 8mm; bottom: 8mm; border: 1px solid rgba(15,23,42,.12); border-radius: 1mm; }
  .corner { width: 14mm; height: 14mm; }
  .corner-tl { top: 5mm; left: 5mm; border-top: 3px solid #D97706; border-left: 3px solid #D97706; }
  .corner-tr { top: 5mm; right: 5mm; border-top: 3px solid #D97706; border-right: 3px solid #D97706; }
  .corner-bl { bottom: 5mm; left: 5mm; border-bottom: 3px solid #D97706; border-left: 3px solid #D97706; }
  .corner-br { bottom: 5mm; right: 5mm; border-bottom: 3px solid #D97706; border-right: 3px solid #D97706; }
  .content {
    position: absolute;
    inset: 18mm 24mm 20mm 24mm;
    z-index: 3;
    text-align: center;
    box-sizing: border-box;
  }
  .main {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
  }
  .header-table, .info-table, .signature-table { width: 100%; table-layout: fixed; border-collapse: collapse; }
  .header-table { margin-bottom: 4mm; }
  .institution-name { font-size: 15pt; font-weight: 900; letter-spacing: 1px; line-height: 1.2; text-transform: uppercase; }
  .institution-sub { font-size: 8.5pt; font-weight: 800; color: #B91C1C; letter-spacing: 2.5px; text-transform: uppercase; margin-top: 2px; }
  .title-wrapper { margin-top: 2mm; margin-bottom: 3mm; }
  .cert-heading { font-size: 14pt; font-weight: 900; color: #B45309; letter-spacing: 4px; text-transform: uppercase; }
  .gold-divider-line { width: 70mm; height: 2px; background: #D97706; margin: 3mm auto 0 auto; border-radius: 1px; }
  .recipient-label { font-size: 9pt; color: #64748B; font-weight: 500; margin-top: 2mm; }
  .recipient-name { font-size: 28pt; font-weight: 900; line-height: 1.2; margin: 2mm 0 4mm 0; letter-spacing: -0.4px; }
  .achievement-label { font-size: 9pt; color: #64748B; font-weight: 500; margin-bottom: 1.5mm; }
  .course-name { font-size: 16pt; font-weight: 800; color: #B45309; line-height: 1.3; margin-bottom: 2mm; }
  .course-description { font-size: 8.5pt; color: #475569; max-width: 190mm; margin: 0 auto; line-height: 1.45; }
  .info-table { margin-top: 6mm; margin-bottom: 6mm; }
  .info-label { font-size: 7.5pt; font-weight: 700; color: #64748B; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 1.5mm; }
  .info-value { font-size: 10pt; font-weight: 800; }
  .info-value-highlight { font-size: 10pt; font-weight: 800; color: #B45309; font-family: 'Courier New', Courier, monospace; }
  .signature-table { width: 82%; margin: 6mm auto 0 auto; }
  .sig-space { height: 16mm; }
  .sig-line { width: 52mm; height: 1px; background: #94A3B8; margin: 0 auto 2.5mm auto; }
  .sig-name { font-size: 9.5pt; font-weight: 800; }
  .sig-role { font-size: 8.5pt; color: #64748B; font-weight: 500; margin-top: 1px; }
  .footer-serial { position: absolute; bottom: 6mm; left: 0; right: 0; text-align: center; font-size: 7.5pt; font-family: 'Courier New', Courier, monospace; color: #94A3B8; letter-spacing: 1.5px; z-index: 3; }
  .no-print { position: fixed; top: 12px; left: 12px; z-index: 10; padding: 8px 12px; background: rgba(15,23,42,.9); color: #fff; border: 0; border-radius: 8px; }
  @media print { .no-print { display: none; } body { background: #fff; } }
</style>
</head>
<body>
<button class="no-print" onclick="window.print()">Cetak / Simpan PDF</button>
<div class="stage">
  <div class="sheet">
    <img class="bg" src="{{ $bgSrc }}" alt="Latar Sertifikat">
    <div class="overlay"></div>
    <div class="border-outer"></div>
    <div class="border-inner"></div>
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    <div class="content">
      <div class="main">
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

      <div class="footer-serial">NO: {{ $sertifikat->nomor_sertifikat }}</div>
    </div>
  </div>
</div>
</body>
</html>
