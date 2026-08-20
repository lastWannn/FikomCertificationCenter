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
    background: #0F172A;
    line-height: 1.6;
    padding-top: 74px;
    padding-bottom: 40px;
  }
  .paper-container {
    max-width: 800px;
    margin: 0 auto;
    background: #FFFFFF;
    padding: 45px 55px;
    box-shadow: 0 16px 40px rgba(0,0,0,0.4);
    border-radius: 12px;
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

  {{-- TOOLBAR NAVIGATION --}}
  <div class="no-print" style="position:fixed; top:0; left:0; right:0; background:#131218; padding:12px 24px; display:flex; justify-content:space-between; align-items:center; z-index:9999; border-bottom:1.5px solid rgba(255,200,26,0.3); font-family:'Inter',sans-serif;">
    <a href="{{ route('landing.arsip.show', $arsip, false) }}" style="color:#FFFFFF; text-decoration:none; font-size:13px; font-weight:700; background:rgba(255,255,255,0.08); padding:8px 16px; border-radius:8px; border:1px solid rgba(255,255,255,0.15); display:inline-flex; align-items:center; gap:6px;">
      &larr; Kembali ke Detail Arsip
    </a>

    <div style="display:flex; align-items:center; gap:10px;">
      {{-- Tombol Utama: Unduh PDF via iframe --}}
      <button type="button" id="btn-unduh-pdf-toolbar" onclick="unduhPdfToolbar()"
         style="color:#131218; font-size:13px; font-weight:900; background:#FFC81A; border:1.5px solid #131218; padding:8px 18px; border-radius:8px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 4px 12px rgba(255,200,26,0.35); cursor:pointer; transition:all 0.2s;"
         onmouseover="this.style.background='#FFFFFF';"
         onmouseout="this.style.background='#FFC81A';">
        <span id="btn-unduh-toolbar-text">📥 Unduh File PDF</span>
      </button>

      <button onclick="window.print()" style="color:#FFFFFF; text-decoration:none; font-size:13px; font-weight:700; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.25); padding:8px 16px; border-radius:8px; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
        🖨️ Cetak
      </button>
    </div>
  </div>

  <iframe id="download-frame-toolbar" style="display:none;"></iframe>
  <script>
  function unduhPdfToolbar() {
    var btn = document.getElementById('btn-unduh-pdf-toolbar');
    var txt = document.getElementById('btn-unduh-toolbar-text');
    btn.disabled = true;
    btn.style.opacity = '0.7';
    txt.innerText = 'Mengunduh...';
    document.getElementById('download-frame-toolbar').src = '{{ route("landing.arsip.download", $arsip, false) }}';
    setTimeout(function() {
      txt.innerText = '📥 Unduh File PDF';
      btn.disabled = false;
      btn.style.opacity = '1';
    }, 3000);
  }
  </script>

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
