<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<title>Sertifikat - {{ $sertifikat->nomor_sertifikat }}</title>
<style>
  @font-face { font-family: 'Great Vibes'; src: url('file:///{{ str_replace('\\', '/', public_path('fonts/great_vibes.ttf')) }}') format('truetype'); }
  @font-face { font-family: 'Alex Brush'; src: url('file:///{{ str_replace('\\', '/', public_path('fonts/alex_brush.ttf')) }}') format('truetype'); }
  @font-face { font-family: 'Allura'; src: url('file:///{{ str_replace('\\', '/', public_path('fonts/allura.ttf')) }}') format('truetype'); }
  @font-face { font-family: 'Dancing Script'; src: url('file:///{{ str_replace('\\', '/', public_path('fonts/dancing_script.ttf')) }}') format('truetype'); }
  @font-face { font-family: 'Cinzel'; src: url('file:///{{ str_replace('\\', '/', public_path('fonts/cinzel.ttf')) }}') format('truetype'); }
  @font-face { font-family: 'Playfair Display'; src: url('file:///{{ str_replace('\\', '/', public_path('fonts/playfair_display.ttf')) }}') format('truetype'); }
  @font-face { font-family: 'Poppins'; src: url('file:///{{ str_replace('\\', '/', public_path('fonts/poppins.ttf')) }}') format('truetype'); }
  @font-face { font-family: 'Montserrat'; src: url('file:///{{ str_replace('\\', '/', public_path('fonts/montserrat.ttf')) }}') format('truetype'); }
  @font-face { font-family: 'Roboto'; src: url('file:///{{ str_replace('\\', '/', public_path('fonts/roboto.ttf')) }}') format('truetype'); }
  @font-face { font-family: 'Inter'; src: url('file:///{{ str_replace('\\', '/', public_path('fonts/inter.ttf')) }}') format('truetype'); }

  @page { size: 297mm 210mm; margin: 0; }
  html, body {
    width: 297mm;
    height: 210mm;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background: #FFFFFF;
    color: #0F172A;
    font-family: Arial, Helvetica, sans-serif;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }
  .sheet {
    position: relative;
    width: 297mm;
    height: 210mm;
    overflow: hidden;
    background: #FFFFFF;
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
    left: {{ $layout['title']['left'] ?? 0 }}mm;
    width: 297mm;
    text-align: center;
  }
  .cert-title {
    font-family: {!! !empty($layout['title']['font_family']) ? "'" . addslashes($layout['title']['font_family']) . "', " : "" !!}'Times New Roman', Georgia, serif;
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
    left: {{ $layout['label']['left'] ?? 0 }}mm;
    width: 297mm;
    text-align: center;
  }
  .given-to-label {
    font-family: {!! !empty($layout['label']['font_family']) ? "'" . addslashes($layout['label']['font_family']) . "', " : "" !!}'Arial', Helvetica, sans-serif;
    font-size: {{ $layout['label']['font_size'] ?? 8.5 }}pt;
    font-weight: 800;
    letter-spacing: 1px;
    color: #333333;
    text-transform: uppercase;
    margin: 0;
  }

  /* 3. Nama Peserta */
  .name-block {
    position: absolute;
    top: {{ $layout['name']['top'] ?? 71 }}mm;
    left: {{ $layout['name']['left'] ?? 0 }}mm;
    width: 297mm;
    text-align: center;
  }
  .recipient-name {
    font-family: {!! !empty($layout['name']['font_family']) ? "'" . addslashes($layout['name']['font_family']) . "', " : "" !!}'Great Vibes', 'Brush Script MT', 'Dancing Script', 'Monotype Corsiva', Georgia, cursive, serif;
    font-size: {{ $layout['name']['font_size'] ?? 36 }}pt;
    font-weight: normal;
    color: #0F172A;
    margin: 0;
    line-height: 1;
  }

  /* 4. Deskripsi Partisipasi & Nama Kegiatan */
  .desc-block {
    position: absolute;
    top: {{ $layout['desc']['top'] ?? 109 }}mm;
    left: {{ $layout['desc']['left'] ?? 0 }}mm;
    width: 297mm;
    text-align: center;
  }
  .desc-line {
    font-family: {!! !empty($layout['desc']['font_family']) ? "'" . addslashes($layout['desc']['font_family']) . "', " : "" !!}'Poppins', Arial, sans-serif;
    font-size: {{ $layout['desc']['font_size'] ?? 10 }}pt;
    color: #475569;
    font-weight: 500;
    margin-bottom: {{ $layout['desc']['line_gap'] ?? 0 }}mm;
    line-height: {{ $layout['desc']['line_height'] ?? 1 }};
  }
  .course-title {
    font-family: {!! !empty($layout['desc']['font_family']) ? "'" . addslashes($layout['desc']['font_family']) . "', " : "" !!}'Poppins', Arial, sans-serif;
    font-size: {{ $layout['desc']['title_font_size'] ?? 14 }}pt;
    font-weight: 900;
    color: #B45309;
    margin-bottom: {{ $layout['desc']['line_gap'] ?? 0 }}mm;
    line-height: {{ $layout['desc']['line_height'] ?? 1 }};
  }
  .course-date {
    font-family: {!! !empty($layout['desc']['font_family']) ? "'" . addslashes($layout['desc']['font_family']) . "', " : "" !!}'Poppins', Arial, sans-serif;
    font-size: 11pt;
    font-weight: 800;
    color: #0F172A;
    line-height: {{ $layout['desc']['line_height'] ?? 1 }};
  }

  /* 5. Lokasi & Tanggal Terbit */
  .date-block {
    position: absolute;
    top: {{ $layout['date']['top'] ?? 146 }}mm;
    right: {{ $layout['date']['right'] ?? 46 }}mm;
    width: 68mm;
    text-align: center;
    font-family: {!! !empty($layout['date']['font_family']) ? "'" . addslashes($layout['date']['font_family']) . "', " : "" !!}'Arial', Helvetica, sans-serif;
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
    font-family: {!! !empty($layout['sig1']['font_family']) ? "'" . addslashes($layout['sig1']['font_family']) . "', " : "" !!}'Arial', Helvetica, sans-serif;
    font-size: {{ $layout['sig1']['font_size'] ?? 10 }}pt;
    font-weight: 900;
    color: #0F172A;
  }
  .sig1-role {
    font-family: {!! !empty($layout['sig1']['font_family']) ? "'" . addslashes($layout['sig1']['font_family']) . "', " : "" !!}'Arial', Helvetica, sans-serif;
    font-size: 8.5pt;
    font-weight: 900;
    color: #B45309;
    letter-spacing: 1.5px;
    margin-top: 0;
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
    font-family: {!! !empty($layout['sig2']['font_family']) ? "'" . addslashes($layout['sig2']['font_family']) . "', " : "" !!}'Arial', Helvetica, sans-serif;
    font-size: {{ $layout['sig2']['font_size'] ?? 10 }}pt;
    font-weight: 900;
    color: #0F172A;
  }
  .sig2-role {
    font-family: {!! !empty($layout['sig2']['font_family']) ? "'" . addslashes($layout['sig2']['font_family']) . "', " : "" !!}'Arial', Helvetica, sans-serif;
    font-size: 8.5pt;
    font-weight: 900;
    color: #B45309;
    font-family: {!! !empty($layout['sig1']['font_family']) ? "'" . addslashes($layout['sig1']['font_family']) . "', " : "" !!}'Arial', Helvetica, sans-serif;
    font-size: 8.5pt;
    font-weight: 900;
    color: #B45309;
    letter-spacing: 1.5px;
    margin-top: 0;
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
    font-family: {!! !empty($layout['sig2']['font_family']) ? "'" . addslashes($layout['sig2']['font_family']) . "', " : "" !!}'Arial', Helvetica, sans-serif;
    font-size: {{ $layout['sig2']['font_size'] ?? 10 }}pt;
    font-weight: 900;
    color: #0F172A;
  }
  .sig2-role {
    font-family: {!! !empty($layout['sig2']['font_family']) ? "'" . addslashes($layout['sig2']['font_family']) . "', " : "" !!}'Arial', Helvetica, sans-serif;
    font-size: 8.5pt;
    font-weight: 900;
    color: #B45309;
    letter-spacing: 1.5px;
    margin-top: 0;
    text-transform: uppercase;
  }

  .cert-title,
  .given-to-label,
  .date-block,
  .sig1-name,
  .sig1-role,
  .sig2-name,
  .sig2-role {
    line-height: 1;
    white-space: nowrap;
  }

  .desc-line,
  .course-title,
  .course-date {
    white-space: nowrap;
  }
</style>
</head>
<body>
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
      <div class="given-to-label">DIBERIKAN KEPADA</div>
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
</body>
</html>






