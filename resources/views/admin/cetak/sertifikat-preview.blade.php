<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Preview Sertifikat</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap');

  @page { size: 297mm 210mm; margin: 0; }
  html, body {
    width: 297mm;
    height: 210mm;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background: #e5e7eb;
    font-family: Arial, Helvetica, sans-serif;
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
  .custom-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 297mm;
    height: 210mm;
    object-fit: cover;
    z-index: 0;
  }
  .overlay-content {
    position: absolute;
    top: 0;
    left: 0;
    width: 297mm;
    height: 210mm;
    z-index: 2;
  }

  /* 1. Judul SERTIFIKAT */
  .title-block {
    position: absolute;
    top: {{ $layout['title']['top'] ?? 40 }}mm;
    left: 0;
    right: 0;
    text-align: center;
  }
  .cert-title {
    font-family: 'Times New Roman', Georgia, serif;
    font-size: {{ $layout['title']['font_size'] ?? 32 }}pt;
    font-weight: bold;
    letter-spacing: 5px;
    color: #000000;
    text-transform: uppercase;
    margin: 0;
    line-height: 1;
  }

  /* 2. Label DIBERIKAN KEPADA */
  .label-block {
    position: absolute;
    top: {{ $layout['label']['top'] ?? 63 }}mm;
    left: 0;
    right: 0;
    text-align: center;
  }
  .given-to-label {
    font-family: Arial, Helvetica, sans-serif;
    font-size: {{ $layout['label']['font_size'] ?? 8.5 }}pt;
    font-weight: 800;
    letter-spacing: 3.5px;
    color: #333333;
    text-transform: uppercase;
    margin: 0;
  }

  /* 3. Nama Peserta */
  .name-block {
    position: absolute;
    top: {{ $layout['name']['top'] ?? 71 }}mm;
    left: 0;
    right: 0;
    text-align: center;
  }
  .recipient-name {
    font-family: 'Great Vibes', 'Brush Script MT', 'Dancing Script', 'Monotype Corsiva', Georgia, cursive, serif;
    font-size: {{ $layout['name']['font_size'] ?? 36 }}pt;
    font-weight: normal;
    color: #0F172A;
    margin: 0;
    line-height: 1.1;
  }

  /* 4. Deskripsi Partisipasi & Nama Kegiatan */
  .desc-block {
    position: absolute;
    top: {{ $layout['desc']['top'] ?? 109 }}mm;
    left: 0;
    right: 0;
    text-align: center;
  }
  .desc-line {
    font-family: Arial, Helvetica, sans-serif;
    font-size: {{ $layout['desc']['font_size'] ?? 10 }}pt;
    color: #475569;
    font-weight: 500;
    margin-bottom: 3px;
  }
  .course-title {
    font-family: Arial, Helvetica, sans-serif;
    font-size: {{ $layout['desc']['title_font_size'] ?? 14 }}pt;
    font-weight: 900;
    color: #B45309;
    margin-bottom: 3px;
  }
  .course-date {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11pt;
    font-weight: 800;
    color: #0F172A;
  }

  /* 5. Lokasi & Tanggal Terbit */
  .date-block {
    position: absolute;
    top: {{ $layout['date']['top'] ?? 146 }}mm;
    right: {{ $layout['date']['right'] ?? 46 }}mm;
    width: 68mm;
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: {{ $layout['date']['font_size'] ?? 9.5 }}pt;
    font-weight: 700;
    color: #0F172A;
    line-height: 1.35;
  }

  /* 6a. Penandatangan Kiri (Dekan) */
  .sig1-block {
    position: absolute;
    top: {{ $layout['sig1']['top'] ?? 167.5 }}mm;
    left: {{ $layout['sig1']['left'] ?? 60 }}mm;
    width: 68mm;
    text-align: center;
  }
  .sig1-name {
    font-family: Arial, Helvetica, sans-serif;
    font-size: {{ $layout['sig1']['font_size'] ?? 10 }}pt;
    font-weight: 900;
    color: #0F172A;
  }
  .sig1-role {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 8.5pt;
    font-weight: 900;
    color: #B45309;
    letter-spacing: 1.5px;
    margin-top: 1px;
    text-transform: uppercase;
  }

  /* 6b. Penandatangan Kanan (Ketua Unit) */
  .sig2-block {
    position: absolute;
    top: {{ $layout['sig2']['top'] ?? 167.5 }}mm;
    right: {{ $layout['sig2']['right'] ?? 46 }}mm;
    width: 68mm;
    text-align: center;
  }
  .sig2-name {
    font-family: Arial, Helvetica, sans-serif;
    font-size: {{ $layout['sig2']['font_size'] ?? 10 }}pt;
    font-weight: 900;
    color: #0F172A;
  }
  .sig2-role {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 8.5pt;
    font-weight: 900;
    color: #B45309;
    letter-spacing: 1.5px;
    margin-top: 1px;
    text-transform: uppercase;
  }

  .no-print {
    position: fixed;
    top: 12px;
    left: 12px;
    z-index: 10;
    padding: 9.5px 18px;
    background: #10B981;
    color: #fff;
    border: 0;
    border-radius: 30px;
    font-weight: 800;
    font-size: 13px;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(16,185,129,0.3);
  }
  @media print {
    .no-print { display: none; }
    body { background: #fff; }
  }
</style>
</head>
<body>
<button class="no-print" onclick="window.print()">Cetak / Simpan PDF</button>
<div class="stage">
  <div class="sheet">
    @if($bgSrc)
      <img class="custom-bg" src="{{ $bgSrc }}" alt="Latar Sertifikat">
    @else
      <div class="custom-bg" style="background:#FFF;"></div>
    @endif

    <div class="overlay-content">
      <div class="title-block">
        <h1 class="cert-title">SERTIFIKAT</h1>
      </div>

      <div class="label-block">
        <div class="given-to-label">D I B E R I K A N   K E P A D A</div>
      </div>

      <div class="name-block">
        <div class="recipient-name">{{ $sertifikat->pendaftaran->peserta->nama }}</div>
      </div>

      <div class="desc-block">
        <div class="desc-line">atas partisipasi sebagai peserta dalam kegiatan</div>
        <div class="course-title">“{{ $sertifikat->pendaftaran->kegiatan->judul }}”</div>
        <div class="desc-line">yang dilaksanakan pada</div>
        <div class="course-date">{{ $tglPelaksanaanFormat ?? ($sertifikat->pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->translatedFormat('d F Y') ?? '-') }}</div>
      </div>

      <div class="date-block">
        Makassar,<br>
        <strong>{{ $tglTerbitFormat ?? ($sertifikat->tgl_terbit?->translatedFormat('d F Y') ?? '-') }}</strong>
      </div>

      {{-- Penandatangan Kiri (Dekan) --}}
      <div class="sig1-block">
        <div class="sig1-name">Purnawansyah</div>
        <div class="sig1-role">DEKAN</div>
      </div>

      {{-- Penandatangan Kanan (Ketua Unit) --}}
      <div class="sig2-block">
        <div class="sig2-name">Abdul Rachman Manga'</div>
        <div class="sig2-role">KETUA UNIT</div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
