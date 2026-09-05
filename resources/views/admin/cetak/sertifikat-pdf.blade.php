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
    margin: 0;
    padding: 0;
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
  .sheet-page2 {
    page-break-before: always;
    background: #FFFFFF;
    color: #131218;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  }
  .page2-container {
    width: 215mm;
    margin: 0 auto;
    padding-top: 14mm;
  }
  .page2-container .logo-header {
    margin-bottom: 15px;
  }
  .page2-container .title-section {
    margin-bottom: 15px;
  }
  .page2-container .title-section h3 {
    margin: 0 0 5px 0;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
    color: #131218;
  }
  .page2-container .title-section p {
    margin: 0;
    font-size: 12px;
    color: #374151;
  }
  .page2-container .participant-name {
    font-size: 16px;
    font-weight: bold;
    margin-top: 12px;
    margin-bottom: 12px;
    text-transform: uppercase;
    color: #131218;
  }
  .page2-container .score-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
    font-size: 13.5px;
  }
  .page2-container .score-table th,
  .page2-container .score-table td {
    border-bottom: 1px solid #131218;
    padding: 7px 10px;
    text-align: left;
  }
  .page2-container .score-table th {
    font-weight: bold;
    font-size: 13px;
  }
  .page2-container .text-center { text-align: center !important; }
  .page2-container .text-right { text-align: right !important; }
  .page2-container .footer-sig-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  .page2-container .footer-sig {
    width: 50%;
    vertical-align: top;
    font-size: 12px;
    color: #131218;
  }
  .page2-container .footer-sig p {
    margin: 0 0 45px;
    font-size: 12px;
    color: #131218;
    line-height: 1.4;
  }
  .page2-container .footer-sig .name {
    font-weight: bold;
    font-size: 13px;
    color: #131218;
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
    top: {{ $layout['title']['top'] ?? 36 }}mm;
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

  /* 2. Sub-Judul PENGHARGAAN */
  .subtitle-block {
    position: absolute;
    top: {{ $layout['subtitle']['top'] ?? 48 }}mm;
    left: {{ $layout['subtitle']['left'] ?? 0 }}mm;
    width: 297mm;
    text-align: center;
  }
  .cert-subtitle {
    font-family: {!! !empty($layout['subtitle']['font_family']) ? "'" . addslashes($layout['subtitle']['font_family']) . "', " : "" !!}'Montserrat', Arial, sans-serif;
    font-size: {{ $layout['subtitle']['font_size'] ?? 11 }}pt;
    font-weight: 900;
    letter-spacing: 6px;
    color: #B45309;
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
    margin: 0 0 {{ max(0, (float)($layout['desc']['line_gap'] ?? 0)) }}mm 0;
    line-height: {{ $layout['desc']['line_height'] ?? 0.9 }};
  }
  .course-title {
    font-family: {!! !empty($layout['desc']['font_family']) ? "'" . addslashes($layout['desc']['font_family']) . "', " : "" !!}'Poppins', Arial, sans-serif;
    font-size: {{ $layout['desc']['title_font_size'] ?? 14 }}pt;
    font-weight: 900;
    color: #B45309;
    margin: 0 0 {{ max(0, (float)($layout['desc']['line_gap'] ?? 0)) }}mm 0;
    line-height: {{ $layout['desc']['line_height'] ?? 0.9 }};
  }
  .course-date {
    font-family: {!! !empty($layout['desc']['font_family']) ? "'" . addslashes($layout['desc']['font_family']) . "', " : "" !!}'Poppins', Arial, sans-serif;
    font-size: 11pt;
    font-weight: 800;
    color: #0F172A;
    margin: 0;
    line-height: {{ $layout['desc']['line_height'] ?? 0.9 }};
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

    <div class="subtitle-block">
      <div class="cert-subtitle">PENGHARGAAN</div>
    </div>

    <div class="label-block">
      <div class="given-to-label">DIBERIKAN KEPADA</div>
    </div>

    <div class="name-block">
      <div class="recipient-name">{{ \Illuminate\Support\Str::title(mb_strtolower($sertifikat->pendaftaran->peserta->nama)) }}</div>
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

    {{-- Penandatangan Kiri (Dekan) & Kanan (Ketua Unit) --}}
    @php
      $snap = $sertifikat->ttd_snapshot;
      $hasSnap = !empty($snap) && is_array($snap) && (array_key_exists('dekan_nama', $snap) || array_key_exists('ketua_nama', $snap));

      if ($hasSnap) {
          $dekanNama = $snap['dekan_nama'] ?? '';
          $dekanJabatan = $snap['dekan_jabatan'] ?? '';
          $dekanTtd = $snap['dekan_ttd'] ?? null;

          $ketuaNama = $snap['ketua_nama'] ?? '';
          $ketuaJabatan = $snap['ketua_jabatan'] ?? '';
          $ketuaTtd = $snap['ketua_ttd'] ?? null;
      } else {
          $activeTtd = \App\Models\TandaTangan::getAktif();
          $dekanNama = $activeTtd->dekan_nama;
          $dekanJabatan = $activeTtd->dekan_jabatan;
          $dekanTtd = $activeTtd->dekan_ttd;

          $ketuaNama = $activeTtd->ketua_nama;
          $ketuaJabatan = $activeTtd->ketua_jabatan;
          $ketuaTtd = $activeTtd->ketua_ttd;
      }

      $dekanTtdSrc = ($dekanTtd && file_exists(public_path('storage/' . $dekanTtd))) ? public_path('storage/' . $dekanTtd) : null;
      $ketuaTtdSrc = ($ketuaTtd && file_exists(public_path('storage/' . $ketuaTtd))) ? public_path('storage/' . $ketuaTtd) : null;
    @endphp

    {{-- Penandatangan Kiri (Dekan) --}}
    <div class="sig1-block">
      <div style="height: 44px; margin-bottom: 4px;">
        @if($dekanTtdSrc)
          <img src="{{ $dekanTtdSrc }}" style="height: 42px; max-width: 100%; object-fit: contain;">
        @endif
      </div>
      <div class="sig1-name">{{ $dekanNama }}</div>
      <div class="sig1-role">{{ $dekanJabatan }}</div>
    </div>

    {{-- Penandatangan Kanan (Ketua Unit) --}}
    <div class="sig2-block">
      <div style="height: 44px; margin-bottom: 4px;">
        @if($ketuaTtdSrc)
          <img src="{{ $ketuaTtdSrc }}" style="height: 42px; max-width: 100%; object-fit: contain;">
        @endif
      </div>
      <div class="sig2-name">{{ $ketuaNama }}</div>
      <div class="sig2-role">{{ $ketuaJabatan }}</div>
    </div>
  </div>
</div>

{{-- ========================================================================= --}}
{{-- HALAMAN 2: LEMBAR PENILAIAN / POINT PESERTA                             --}}
{{-- ========================================================================= --}}
@php
    $pendaftaran = $sertifikat->pendaftaran;
    $isPel = $pendaftaran->kegiatan->jenis_kegiatan === 'pelatihan';
    if ($isPel) {
        $jadwal = $pendaftaran->kegiatan->kegiatanPelatihan?->jadwalPelatihan;
        $program = $jadwal?->pelatihan;
        $labelProgram = 'POINT PESERTA PELATIHAN';
        $labelMateri = 'Materi Pelatihan';
        $materiList = $program?->materi ?? collect();
    } else {
        $jadwal = $pendaftaran->kegiatan->kegiatanSertifikasi?->jadwalSertifikasi;
        $program = $jadwal?->sertifikasi;
        $labelProgram = 'POINT PESERTA SERTIFIKASI';
        $labelMateri = 'Modul Sertifikasi / Uji Kompetensi';
        $materiList = $program?->materi ?? collect();
    }
    $tglPelaksanaan = $jadwal?->tgl_pelaksanaan ? \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d F Y') : '-';
    $activeTtd = \App\Models\TandaTangan::getAktif();
    $avgScore = $pendaftaran->nilai->count() > 0 ? round($pendaftaran->nilai->avg('nilai'), 1) : null;
@endphp

<div class="sheet-page2">
  <div class="page2-container">
    <div class="logo-header">
      @if(!empty($logoSrc))
        <img src="{{ $logoSrc }}" style="height: 52px; width: auto; object-fit: contain;">
      @elseif(file_exists(public_path('images/logo.png')))
        <img src="{{ public_path('images/logo.png') }}" style="height: 52px; width: auto; object-fit: contain;">
      @else
        <div style="font-weight: bold; font-size: 14pt; color: #131218;">FCC UMI</div>
      @endif
    </div>

    <div class="title-section">
      <h3>{{ $labelProgram }} <span style="font-weight: normal; color: #6B7280; font-size: 14px; text-transform: none;">FIKOM Certification Center</span></h3>
      <p>Program: <strong>{{ $program->judul ?? $pendaftaran->kegiatan->judul ?? '-' }}</strong> | Pelaksanaan: {{ $tglPelaksanaan }}</p>
    </div>

    <div class="participant-name">
      NAMA PESERTA: {{ $pendaftaran->peserta->nama ?? '-' }}
    </div>

    <table class="score-table">
      <thead>
        <tr>
          <th style="width: 8%; text-align: center;">No</th>
          <th>{{ $labelMateri }}</th>
          <th class="text-center" style="width: 25%;">Point / Nilai</th>
        </tr>
      </thead>
      <tbody>
        @if($materiList->count() > 0)
          @foreach($materiList as $index => $mat)
            @php
              $nilaiObj = $isPel
                  ? $pendaftaran->nilai->where('materi_pelatihan_id', $mat->id)->first()
                  : $pendaftaran->nilai->where('materi_sertifikasi_id', $mat->id)->first();
              $nilai = $nilaiObj ? $nilaiObj->nilai : null;
            @endphp
            <tr>
              <td style="text-align: center;">{{ $index + 1 }}</td>
              <td><strong>{{ $mat->judul_materi }}</strong></td>
              <td class="text-center">{{ $nilai !== null ? round($nilai) : '-' }}</td>
            </tr>
          @endforeach

          @if($avgScore !== null)
          <tr style="background: #F8FAFC; font-weight: bold;">
            <td colspan="2" style="text-align: right; padding-right: 16px;">RATA-RATA NILAI AKHIR:</td>
            <td class="text-center">{{ $avgScore }}</td>
          </tr>
          @endif
        @else
          <tr>
            <td colspan="3" class="text-center" style="padding: 16px; color: #94A3B8;">Belum ada modul / materi terdaftar untuk kegiatan ini.</td>
          </tr>
        @endif
      </tbody>
    </table>

    <table class="footer-sig-table">
      <tr>
        <td class="footer-sig">
          <p>Makassar, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>{{ $activeTtd->ketua_jabatan ?? 'Ketua Unit FCC UMI' }}</p>
          <div class="name">{{ $activeTtd->ketua_nama ?? 'Abdul Rachman Manga\'' }}</div>
        </td>
        <td class="footer-sig" style="text-align: right;">
          <p><br>{{ $activeTtd->proktor_jabatan ?? 'Proktor / Instruktur Ujian' }}</p>
          <div class="name">{{ $activeTtd->proktor_nama ?? 'Ir. Abdul Rachman Manga\', S.Kom., M.T.' }}</div>
        </td>
      </tr>
    </table>
  </div>
</div>
</body>
</html>
