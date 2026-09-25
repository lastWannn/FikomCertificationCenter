<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<title>Sertifikat - {{ $sertifikat->nomor_sertifikat }}</title>
<style>
  @php
    $customFonts = [
      'Great Vibes'      => 'great_vibes.ttf',
      'Alex Brush'       => 'alex_brush.ttf',
      'Allura'           => 'allura.ttf',
      'Dancing Script'   => 'dancing_script.ttf',
      'Cinzel'           => 'cinzel.ttf',
      'Playfair Display' => 'playfair_display.ttf',
      'Poppins'          => 'poppins.ttf',
      'Montserrat'       => 'montserrat.ttf',
      'Roboto'           => 'roboto.ttf',
      'Inter'            => 'inter.ttf',
    ];

    $getFontFamilyCss = function (?string $fontName, string $fallback = 'Arial, Helvetica, sans-serif'): string {
        $font = trim((string)$fontName);
        if ($font === 'Great Vibes') return "'Great Vibes', 'Brush Script MT', cursive, serif";
        if ($font === 'Allura') return "'Allura', 'Great Vibes', cursive, serif";
        if ($font === 'Alex Brush') return "'Alex Brush', 'Brush Script MT', cursive, serif";
        if ($font === 'Dancing Script') return "'Dancing Script', cursive, serif";
        if ($font === 'Cinzel') return "'Cinzel', 'Times New Roman', Georgia, serif";
        if ($font === 'Playfair Display') return "'Playfair Display', Georgia, serif";
        if ($font === 'Times New Roman') return "'Times New Roman', Georgia, serif";
        if ($font === 'Georgia') return "Georgia, 'Times New Roman', serif";
        if ($font === 'Poppins') return "'Poppins', Arial, sans-serif";
        if ($font === 'Montserrat') return "'Montserrat', Arial, sans-serif";
        if ($font === 'Roboto') return "'Roboto', Arial, sans-serif";
        if ($font === 'Inter') return "'Inter', Arial, sans-serif";
        if ($font === 'Arial') return "Arial, Helvetica, sans-serif";
        if (!empty($font)) return "'{$font}', {$fallback}";
        return $fallback;
    };
  @endphp
  @foreach ($customFonts as $fontName => $fontFile)
    @php $fontLocalPath = str_replace('\\', '/', public_path('fonts/' . $fontFile)); @endphp
    @font-face {
      font-family: '{{ $fontName }}';
      src: url('{{ $fontLocalPath }}') format('truetype');
      font-weight: normal;
      font-style: normal;
    }
    @font-face {
      font-family: '{{ $fontName }}';
      src: url('{{ $fontLocalPath }}') format('truetype');
      font-weight: bold;
      font-style: normal;
    }
  @endforeach

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
  /* ═══ HALAMAN 2: TRANSKRIP NILAI (CLEAN & MINIMALIST) ═══ */
  .sheet-page2 {
    page-break-before: always;
    background: #FFFFFF;
    color: #1E293B;
    font-family: Arial, Helvetica, sans-serif;
  }
  .page2-clean-wrapper {
    width: 255mm;
    margin: 12mm auto 0;
  }

  /* HEADER */
  .p2-header-tbl {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 5mm;
  }
  .p2-header-tbl td {
    vertical-align: middle;
  }
  .p2-brand-col img {
    height: 34px;
    vertical-align: middle;
    margin-right: 8px;
  }
  .p2-title-col {
    text-align: right;
  }
  .p2-doc-title {
    font-size: 13pt;
    font-weight: bold;
    color: #0F172A;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin: 0;
  }
  .p2-doc-sub {
    font-size: 7.5pt;
    color: #64748B;
    letter-spacing: 0.8px;
    margin: 2px 0 0 0;
    text-transform: uppercase;
  }

  .p2-divider-line {
    border-bottom: 1.5px solid #0F172A;
    margin-bottom: 5mm;
  }

  /* PARTICIPANT METADATA */
  .p2-meta-tbl {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 6mm;
    font-size: 8.5pt;
  }
  .p2-meta-tbl td {
    padding: 2.5px 0;
    vertical-align: top;
  }
  .p2-meta-lbl {
    width: 16%;
    color: #64748B;
    font-size: 8pt;
  }
  .p2-meta-sep {
    width: 2%;
    color: #94A3B8;
  }
  .p2-meta-val {
    width: 32%;
    color: #0F172A;
    font-weight: bold;
  }

  /* TABLE */
  .p2-score-tbl {
    width: 100%;
    border-collapse: collapse;
    font-size: 8.5pt;
    margin-bottom: 6mm;
  }
  .p2-score-tbl th {
    background: #F8FAFC;
    border-top: 1.5px solid #0F172A;
    border-bottom: 1.5px solid #0F172A;
    color: #0F172A;
    font-size: 7.8pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 7px 10px;
  }
  .p2-score-tbl td {
    padding: 7px 10px;
    border-bottom: 1px solid #E2E8F0;
  }
  .p2-score-tbl tr.p2-row-total td {
    background: #F8FAFC;
    border-top: 1.5px solid #0F172A;
    border-bottom: 1.5px solid #0F172A;
    font-weight: bold;
    color: #0F172A;
    font-size: 8.5pt;
    padding: 8px 10px;
  }

  /* FOOTER */
  .p2-footer-tbl {
    width: 100%;
    border-collapse: collapse;
    margin-top: 3mm;
  }
  .p2-footer-tbl td {
    vertical-align: top;
  }
  .p2-qr-side {
    width: 50%;
  }
  .p2-qr-img {
    width: 48px;
    height: 48px;
    display: inline-block;
    vertical-align: middle;
    margin-right: 10px;
  }
  .p2-qr-info {
    display: inline-block;
    vertical-align: middle;
    font-size: 7.2pt;
    color: #64748B;
    line-height: 1.35;
  }
  .p2-scale-note {
    font-size: 7pt;
    color: #94A3B8;
    margin-top: 3mm;
  }
  .p2-sig-side {
    width: 50%;
  }
  .p2-sig-side table {
    width: 220px;
    margin-left: auto;
    border-collapse: collapse;
  }
  .p2-sig-side td {
    text-align: center;
    vertical-align: top;
  }
  .p2-sig-date {
    font-size: 8pt;
    color: #64748B;
    margin: 0 0 2px 0;
  }
  .p2-sig-role {
    font-size: 8pt;
    font-weight: bold;
    color: #0F172A;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin: 0;
  }
  .p2-sig-img-wrap {
    height: 60px;
    margin: 3px 0;
  }
  .p2-sig-name {
    font-size: 8.5pt;
    font-weight: bold;
    color: #0F172A;
    margin: 0;
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
    top: {{ $layout['title']['top'] ?? 37.5 }}mm;
    left: {{ $layout['title']['left'] ?? 0 }}mm;
    width: 297mm;
    text-align: center;
  }
  .cert-title {
    font-family: {!! $getFontFamilyCss($layout['title']['font_family'] ?? 'Times New Roman', "'Times New Roman', Georgia, serif") !!};
    font-size: {{ $layout['title']['font_size'] ?? 50 }}pt;
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
    top: {{ $layout['subtitle']['top'] ?? 57 }}mm;
    left: {{ $layout['subtitle']['left'] ?? 0 }}mm;
    width: 297mm;
    text-align: center;
  }
  .cert-subtitle {
    font-family: {!! $getFontFamilyCss($layout['subtitle']['font_family'] ?? 'Arial', 'Arial, Helvetica, sans-serif') !!};
    font-size: {{ $layout['subtitle']['font_size'] ?? 24 }}pt;
    font-weight: bold;
    letter-spacing: 5px;
    color: #B45309;
    text-transform: uppercase;
    margin: 0;
    line-height: 1;
  }

  /* 2. Label DIBERIKAN KEPADA */
  .label-block {
    position: absolute;
    top: {{ $layout['label']['top'] ?? 72 }}mm;
    left: {{ $layout['label']['left'] ?? 0 }}mm;
    width: 297mm;
    text-align: center;
  }
  .given-to-label {
    font-family: {!! $getFontFamilyCss($layout['label']['font_family'] ?? 'Poppins', 'Arial, Helvetica, sans-serif') !!};
    font-size: {{ $layout['label']['font_size'] ?? 9.5 }}pt;
    font-weight: bold;
    letter-spacing: 1.5px;
    color: #333333;
    text-transform: uppercase;
    margin: 0;
  }

  /* 3. Nama Peserta */
  .name-block {
    position: absolute;
    top: {{ $layout['name']['top'] ?? 72.5 }}mm;
    left: {{ $layout['name']['left'] ?? 0 }}mm;
    width: 297mm;
    text-align: center;
  }
  .recipient-name {
    font-family: {!! $getFontFamilyCss($layout['name']['font_family'] ?? 'Allura', "'Allura', 'Great Vibes', cursive, serif") !!};
    font-size: {{ $layout['name']['font_size'] ?? 60 }}pt;
    font-weight: normal;
    color: #0F172A;
    margin: 0;
    line-height: 1.1;
  }

  /* 4. Deskripsi Partisipasi & Nama Kegiatan */
  .desc-block {
    position: absolute;
    top: {{ $layout['desc']['top'] ?? 110.5 }}mm;
    left: {{ $layout['desc']['left'] ?? 0 }}mm;
    width: 297mm;
    text-align: center;
  }
  .desc-line {
    font-family: {!! $getFontFamilyCss($layout['desc']['font_family'] ?? 'Poppins', 'Arial, Helvetica, sans-serif') !!};
    font-size: {{ $layout['desc']['font_size'] ?? 16.5 }}pt;
    color: #475569;
    font-weight: normal;
    margin: 0 0 {{ max(0, (float)($layout['desc']['line_gap'] ?? 0)) }}mm 0;
    line-height: {{ $layout['desc']['line_height'] ?? 0.9 }};
  }
  .course-title {
    font-family: {!! $getFontFamilyCss($layout['desc']['font_family'] ?? 'Poppins', 'Arial, Helvetica, sans-serif') !!};
    font-size: {{ $layout['desc']['title_font_size'] ?? 16.5 }}pt;
    font-weight: bold;
    color: #B45309;
    margin: 0 0 {{ max(0, (float)($layout['desc']['line_gap'] ?? 0)) }}mm 0;
    line-height: {{ $layout['desc']['line_height'] ?? 0.9 }};
  }
  .course-date {
    font-family: {!! $getFontFamilyCss($layout['desc']['font_family'] ?? 'Poppins', 'Arial, Helvetica, sans-serif') !!};
    font-size: 10.5pt;
    font-weight: bold;
    color: #0F172A;
    margin: 0;
    line-height: {{ $layout['desc']['line_height'] ?? 0.9 }};
  }

  /* 5. Lokasi & Tanggal Terbit */
  .date-block {
    position: absolute;
    top: {{ $layout['date']['top'] ?? 140.5 }}mm;
    right: {{ $layout['date']['right'] ?? 60.5 }}mm;
    width: 68mm;
    text-align: center;
    font-family: {!! $getFontFamilyCss($layout['date']['font_family'] ?? 'Arial', 'Arial, Helvetica, sans-serif') !!};
    font-size: {{ $layout['date']['font_size'] ?? 9.5 }}pt;
    font-weight: bold;
    color: #0F172A;
    line-height: 1.35;
  }

  /* 6a. Penandatangan Kiri (Dekan) */
  .sig1-block {
    position: absolute;
    top: {{ $layout['sig1']['top'] ?? 150 }}mm;
    left: {{ $layout['sig1']['left'] ?? 63 }}mm;
    width: 68mm;
    text-align: center;
  }
  .sig1-name {
    font-family: {!! $getFontFamilyCss($layout['sig1']['font_family'] ?? 'Arial', 'Arial, Helvetica, sans-serif') !!};
    font-size: {{ $layout['sig1']['font_size'] ?? 10 }}pt;
    font-weight: bold;
    color: #0F172A;
  }
  .sig1-role {
    font-family: {!! $getFontFamilyCss($layout['sig1']['font_family'] ?? 'Arial', 'Arial, Helvetica, sans-serif') !!};
    font-size: 8.5pt;
    font-weight: bold;
    color: #B45309;
    letter-spacing: 1.5px;
    margin-top: {{ max(0, (float)($layout['sig1']['line_gap'] ?? 1)) }}mm;
    text-transform: uppercase;
  }

  /* 6b. Penandatangan Kanan (Ketua Unit) */
  .sig2-block {
    position: absolute;
    top: {{ $layout['sig2']['top'] ?? 147.5 }}mm;
    right: {{ $layout['sig2']['right'] ?? 59.5 }}mm;
    width: 68mm;
    text-align: center;
  }
  .sig2-name {
    font-family: {!! $getFontFamilyCss($layout['sig2']['font_family'] ?? 'Arial', 'Arial, Helvetica, sans-serif') !!};
    font-size: {{ $layout['sig2']['font_size'] ?? 10 }}pt;
    font-weight: bold;
    color: #0F172A;
  }
  .sig2-role {
    font-family: {!! $getFontFamilyCss($layout['sig2']['font_family'] ?? 'Arial', 'Arial, Helvetica, sans-serif') !!};
    font-size: 8.5pt;
    font-weight: bold;
    color: #B45309;
    letter-spacing: 1.5px;
    margin-top: {{ max(0, (float)($layout['sig2']['line_gap'] ?? 0.5)) }}mm;
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
      $sig1Height = (int)($layout['sig1']['sig_height'] ?? 60);
      $sig2Height = (int)($layout['sig2']['sig_height'] ?? 70);
      $sig1ImgGap = max(0, (float)($layout['sig1']['img_gap'] ?? 0));
      $sig2ImgGap = max(0, (float)($layout['sig2']['img_gap'] ?? 0));
    @endphp

    {{-- Penandatangan Kiri (Dekan) --}}
    <div class="sig1-block">
      <div style="height: {{ $sig1Height + 4 }}px; margin-bottom: {{ $sig1ImgGap }}mm;">
        @if($dekanTtdSrc)
          <img src="{{ $dekanTtdSrc }}" style="height: {{ $sig1Height }}px; max-width: 100%; object-fit: contain;">
        @endif
      </div>
      <div class="sig1-name">{{ $dekanNama }}</div>
      <div class="sig1-role">{{ $dekanJabatan }}</div>
    </div>

    {{-- Penandatangan Kanan (Ketua Unit) --}}
    <div class="sig2-block">
      <div style="height: {{ $sig2Height + 4 }}px; margin-bottom: {{ $sig2ImgGap }}mm;">
        @if($ketuaTtdSrc)
          <img src="{{ $ketuaTtdSrc }}" style="height: {{ $sig2Height }}px; max-width: 100%; object-fit: contain;">
        @endif
      </div>
      <div class="sig2-name">{{ $ketuaNama }}</div>
      <div class="sig2-role">{{ $ketuaJabatan }}</div>
    </div>
  </div>
</div>

{{-- ========================================================================= --}}
{{-- HALAMAN 2: LEMBAR PENILAIAN / TRANSKRIP CAPAIAN KOMPETENSI               --}}
{{-- ========================================================================= --}}
@php
    $pendaftaran = $sertifikat->pendaftaran;
    $isPel = $pendaftaran->kegiatan->jenis_kegiatan === 'pelatihan';
    if ($isPel) {
        $jadwal = $pendaftaran->kegiatan->kegiatanPelatihan?->jadwalPelatihan;
        $program = $jadwal?->pelatihan;
        $labelProgram = 'Pelatihan Kompetensi';
        $labelMateri = 'Unit Materi Pelatihan';
        $materiList = $program?->materi ?? collect();
    } else {
        $jadwal = $pendaftaran->kegiatan->kegiatanSertifikasi?->jadwalSertifikasi;
        $program = $jadwal?->sertifikasi;
        $labelProgram = 'Sertifikasi Kompetensi';
        $labelMateri = 'Unit Kompetensi / Modul Ujian';
        $materiList = $program?->materi ?? collect();
    }
    $tglPelaksanaan = $jadwal?->tgl_pelaksanaan ? \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d F Y') : '-';
    $tglTerbit = $sertifikat->tgl_terbit ? \Carbon\Carbon::parse($sertifikat->tgl_terbit)->translatedFormat('d F Y') : \Carbon\Carbon::now()->translatedFormat('d F Y');
    $activeTtd = \App\Models\TandaTangan::getAktif();

    // Snapshot atau active signatures
    $snap = $sertifikat->ttd_snapshot ?? [];
    $p2KetuaNama = $snap['ketua_nama'] ?? $activeTtd->ketua_nama;
    $p2KetuaJabatan = $snap['ketua_jabatan'] ?? $activeTtd->ketua_jabatan;
    $p2KetuaTtd = $snap['ketua_ttd'] ?? $activeTtd->ketua_ttd;
    $p2KetuaTtdSrc = ($p2KetuaTtd && file_exists(public_path('storage/' . $p2KetuaTtd)))
        ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/' . $p2KetuaTtd)))
        : null;

    $p2ProktorNama = $snap['proktor_nama'] ?? $activeTtd->proktor_nama;
    $p2ProktorJabatan = $snap['proktor_jabatan'] ?? $activeTtd->proktor_jabatan;
    $p2ProktorTtd = $snap['proktor_ttd'] ?? $activeTtd->proktor_ttd;
    $p2ProktorTtdSrc = ($p2ProktorTtd && file_exists(public_path('storage/' . $p2ProktorTtd)))
        ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/' . $p2ProktorTtd)))
        : null;

    // Logos in base64
    $p2LogoUmiSrc = file_exists(public_path('images/logo_umi.webp'))
        ? 'data:image/webp;base64,' . base64_encode(file_get_contents(public_path('images/logo_umi.webp')))
        : null;

    $p2LogoFikomSrc = file_exists(public_path('images/logo_fikom.webp'))
        ? 'data:image/webp;base64,' . base64_encode(file_get_contents(public_path('images/logo_fikom.webp')))
        : null;

    $p2LogoFccSrc = file_exists(public_path('images/Hitam_KuningUtama.png'))
        ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/Hitam_KuningUtama.png')))
        : (file_exists(public_path('images/logo.png')) ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo.png'))) : null);

    // QR Code
    $verifyUrl = route('sertifikat.verifikasi', $sertifikat->hashid ?? $sertifikat->id);
    $p2QrSvgSrc = null;
    try {
        if (class_exists(\SimpleSoftwareIO\QrCode\Facades\QrCode::class)) {
            $p2QrSvgSrc = 'data:image/svg+xml;base64,' . base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(70)->margin(0)->generate($verifyUrl));
        }
    } catch (\Throwable $e) {}

    // Calculation & Predicate
    $avgScore = $pendaftaran->nilai->count() > 0 ? round($pendaftaran->nilai->avg('nilai'), 1) : null;
    $getPredicate = function ($score) {
        if ($score === null) return ['grade' => '-', 'text' => '-', 'status' => '-'];
        $s = (float)$score;
        if ($s >= 85) return ['grade' => 'A', 'text' => 'Sangat Baik', 'status' => 'KOMPETEN'];
        if ($s >= 75) return ['grade' => 'B', 'text' => 'Baik', 'status' => 'KOMPETEN'];
        if ($s >= 65) return ['grade' => 'C', 'text' => 'Cukup', 'status' => 'KOMPETEN'];
        return ['grade' => 'D', 'text' => 'Kurang', 'status' => 'BELUM KOMPETEN'];
    };
    $finalPred = $getPredicate($avgScore);
@endphp

<div class="sheet-page2">
  <div class="page2-clean-wrapper">

    <!-- HEADER: Minimalist Branding + Title -->
    <table class="p2-header-tbl">
      <tr>
        <td class="p2-brand-col">
          @if($p2LogoUmiSrc)
            <img src="{{ $p2LogoUmiSrc }}">
          @endif
          @if($p2LogoFikomSrc)
            <img src="{{ $p2LogoFikomSrc }}">
          @endif
          @if($p2LogoFccSrc)
            <img src="{{ $p2LogoFccSrc }}">
          @endif
        </td>
        <td class="p2-title-col">
          <h1 class="p2-doc-title">Transkrip Nilai</h1>
          <p class="p2-doc-sub">FIKOM Certification Center &bull; Universitas Muslim Indonesia</p>
        </td>
      </tr>
    </table>

    <div class="p2-divider-line"></div>

    <!-- METADATA PESERTA: Bersih & Ringkas -->
    <table class="p2-meta-tbl">
      <tr>
        <td class="p2-meta-lbl">Nama Peserta</td>
        <td class="p2-meta-sep">:</td>
        <td class="p2-meta-val">{{ $pendaftaran->peserta->nama ?? '-' }}</td>
        <td class="p2-meta-lbl">Nomor Sertifikat</td>
        <td class="p2-meta-sep">:</td>
        <td class="p2-meta-val">{{ $sertifikat->nomor_sertifikat }}</td>
      </tr>
      <tr>
        <td class="p2-meta-lbl">Program Kegiatan</td>
        <td class="p2-meta-sep">:</td>
        <td class="p2-meta-val">{{ $program->judul ?? $pendaftaran->kegiatan->judul ?? '-' }}</td>
        <td class="p2-meta-lbl">Tanggal Pelaksanaan</td>
        <td class="p2-meta-sep">:</td>
        <td class="p2-meta-val">{{ $tglPelaksanaan }}</td>
      </tr>
    </table>

    <!-- TABEL NILAI -->
    <table class="p2-score-tbl">
      <thead>
        <tr>
          <th style="width: 7%; text-align: center;">No</th>
          <th style="width: 59%; text-align: left;">{{ $labelMateri }}</th>
          <th style="width: 17%; text-align: center;">Nilai</th>
          <th style="width: 17%; text-align: center;">Predikat</th>
        </tr>
      </thead>
      <tbody>
        @if($materiList->count() > 0)
          @foreach($materiList as $idx => $mat)
            @php
              $nilaiObj = $isPel
                  ? $pendaftaran->nilai->where('materi_pelatihan_id', $mat->id)->first()
                  : $pendaftaran->nilai->where('materi_sertifikasi_id', $mat->id)->first();
              $nilai = $nilaiObj ? round($nilaiObj->nilai, 1) : null;
              $pred = $getPredicate($nilai);
              $scoreVal = $nilai !== null ? $nilai : '-';
            @endphp
            <tr>
              <td style="text-align: center; color: #64748B;">{{ $idx + 1 }}</td>
              <td style="color: #1E293B;">{{ $mat->judul_materi }}</td>
              <td style="text-align: center; font-weight: bold; color: #0F172A;">{{ $scoreVal }}</td>
              <td style="text-align: center; color: #475569;">{{ $pred['text'] }}</td>
            </tr>
          @endforeach

          @if($avgScore !== null)
            <tr class="p2-row-total">
              <td colspan="2" style="text-align: right; padding-right: 14px;">Rata-rata Nilai Akhir:</td>
              <td style="text-align: center;">{{ $avgScore }}</td>
              <td style="text-align: center;">{{ $finalPred['text'] }}</td>
            </tr>
          @endif
        @else
          <tr>
            <td colspan="4" style="text-align: center; padding: 18px; color: #94A3B8;">Tidak ada unit kompetensi terdaftar untuk kegiatan ini.</td>
          </tr>
        @endif
      </tbody>
    </table>

    <!-- FOOTER: QR Verifikasi + Tanda Tangan Ringkas -->
    <table class="p2-footer-tbl">
      <tr>
        <td class="p2-qr-side">
          @if($p2QrSvgSrc)
            <img src="{{ $p2QrSvgSrc }}" class="p2-qr-img">
            <div class="p2-qr-info">
              <strong style="color: #0F172A;">Verifikasi Keabsahan</strong><br>
              Pindai untuk memeriksa keabsahan transkrip.<br>
              <span style="font-size: 6.8pt; color: #94A3B8;">sertifikasi.fikom.umi.ac.id</span>
            </div>
          @endif
          <div class="p2-scale-note">
            *Acuan Nilai: A (85–100) &bull; B (75–84.9) &bull; C (65–74.9) &bull; D (&lt;65)
          </div>
        </td>
        <td class="p2-sig-side">
          <table>
            <tr>
              <td style="text-align: center; vertical-align: top;">
                <p class="p2-sig-date">Makassar, {{ $tglTerbit }}</p>
                <p class="p2-sig-role">{{ $p2KetuaJabatan ?? 'Ketua Unit FCC UMI' }}</p>
                @php
                  $p2SigHeight = (int)($layout['sig2']['sig_height'] ?? 70);
                  $p2ImgGap = max(0, (float)($layout['sig2']['img_gap'] ?? 0));
                  $p2LineGap = max(0, (float)($layout['sig2']['line_gap'] ?? 0.5));
                @endphp
                <div class="p2-sig-img-wrap" style="height: {{ $p2SigHeight + 2 }}px; margin-top: {{ $p2LineGap }}mm; margin-bottom: {{ $p2ImgGap }}mm;">
                  @if($p2KetuaTtdSrc)
                    <img src="{{ $p2KetuaTtdSrc }}" style="height: {{ $p2SigHeight }}px; max-width: 100%; object-fit: contain;">
                  @endif
                </div>
                <p class="p2-sig-name">{{ $p2KetuaNama ?? 'Abdul Rachman Manga\'' }}</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

  </div>
</div>
</body>
</html>
