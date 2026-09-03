<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<title>Daftar Hadir - {{ $kegiatan->judul }}</title>
<style>
  @page {
    size: A4 landscape;
    margin: 0px;
  }
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  body {
    font-family: 'Helvetica', 'Arial', sans-serif;
    font-size: 9.5pt;
    color: #000000;
    background: #FFFFFF;
    line-height: 1.25;
    padding: 24px 36px 20px 36px;
  }

  @media screen {
    body {
      background: #FFFFFF;
      padding: 0;
    }
    .pdf-page {
      background: #FFFFFF;
      max-width: 297mm;
      margin: 0 auto;
      padding: 24px 36px 20px 36px;
      box-shadow: none;
      border-radius: 0;
    }
  }

  @media print {
    body {
      background: #FFFFFF;
      padding: 24px 36px 20px 36px;
    }
    .pdf-page {
      padding: 0;
      box-shadow: none;
      background: #FFFFFF;
    }
  }

  /* Header Table */
  .header-table {
    width: 100%;
    margin-bottom: 8px;
    border-collapse: collapse;
    table-layout: fixed;
  }
  .header-table td {
    vertical-align: middle;
  }
  .logo-img {
    height: 42px;
    width: auto;
    display: block;
  }
  .doc-title {
    font-size: 14pt;
    font-weight: bold;
    text-align: center;
    color: #000000;
    letter-spacing: 0.4px;
    text-transform: uppercase;
    font-family: 'Helvetica', 'Arial', sans-serif;
    line-height: 1.2;
  }

  /* Date Info Box Table */
  .info-box-table {
    width: 460px;
    margin: 0 auto 10px auto;
    border: 1.5px solid #000000;
    border-collapse: collapse;
    table-layout: fixed;
  }
  .info-box-table td {
    padding: 4px 10px;
    font-size: 9.5pt;
    vertical-align: middle;
    border: 1.5px solid #000000;
  }
  .info-label {
    width: 40%;
    font-weight: normal;
    background: #FFFFFF;
  }
  .info-value {
    width: 60%;
    font-weight: normal;
    background: #FFFFFF;
  }

  /* Main Attendance Table */
  .attendance-table {
    width: 100%;
    border-collapse: collapse;
    border: 1.5px solid #000000;
    margin-bottom: 10px;
    table-layout: fixed;
  }
  .attendance-table th {
    background-color: #C0C0C0; /* Standard gray matching original template */
    color: #000000;
    font-weight: bold;
    font-size: 8pt;
    text-transform: uppercase;
    border: 1.5px solid #000000;
    padding: 5px 3px;
    vertical-align: middle;
    text-align: center;
    line-height: 1.2;
  }
  .attendance-table td {
    border: 1.5px solid #000000;
    padding: 3px 5px;
    font-size: 8.5pt;
    vertical-align: middle;
    height: 24px;
  }

  /* Column Widths (Sum = 100%) */
  .col-no      { width: 4%;  text-align: center; font-weight: normal; }
  .col-nama    { width: 28%; text-align: left; font-weight: normal; padding-left: 8px !important; }
  .col-kode    { width: 9%;  text-align: center; font-weight: normal; }
  .col-jam-in  { width: 8%;  text-align: center; }
  .col-ttd-in  { width: 14%; text-align: center; }
  .col-jam-out { width: 8%;  text-align: center; }
  .col-ttd-out { width: 14%; text-align: center; }
  .col-verif   { width: 15%; text-align: center; }

  /* Subtext inside TH */
  .th-subtext {
    font-size: 6.8pt;
    font-weight: normal;
    text-transform: none;
    display: block;
    line-height: 1.1;
    margin-top: 2px;
  }

  /* Footer Section */
  .footer-table {
    width: 100%;
    margin-top: 8px;
    border-collapse: collapse;
    table-layout: fixed;
  }
  .footer-statement {
    width: 60%;
    vertical-align: top;
    font-size: 8.5pt;
    font-weight: bold;
    line-height: 1.3;
    color: #000000;
    padding-right: 15px;
  }
  .footer-signature {
    width: 40%;
    vertical-align: top;
    text-align: center;
    font-size: 9pt;
  }
  .proktor-title {
    font-weight: bold;
    color: #000000;
    margin-bottom: 4px;
  }
  .proktor-ttd-container {
    height: 55px;
    width: 100%;
    text-align: center;
    margin: 2px 0 4px 0;
  }
  .proktor-ttd-img {
    height: 55px;
    max-height: 55px;
    width: auto;
    max-width: 180px;
    display: inline-block;
  }
  .proktor-name {
    font-weight: bold;
    color: #000000;
    margin-top: 4px;
  }
</style>
</head>
<body>

<div class="pdf-page">

@php
  // Helper logo base64 conversion
  $getLogoBase64 = function($filename) {
      $path = public_path('images/' . $filename);
      if (!file_exists($path)) return null;
      
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      if ($ext === 'webp' && function_exists('imagecreatefromwebp') && function_exists('imagepng')) {
          $img = @imagecreatefromwebp($path);
          if ($img) {
              ob_start();
              imagepng($img);
              $pngData = ob_get_clean();
              imagedestroy($img);
              return 'data:image/png;base64,' . base64_encode($pngData);
          }
      }
      
      $mime = $ext === 'svg' ? 'image/svg+xml' : ($ext === 'webp' ? 'image/webp' : 'image/png');
      return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
  };

  $logoUmi = $getLogoBase64('logo_umi.webp');
  $logoFikom = $getLogoBase64('logo_fikom.webp');
  $logoHitamKuning = $getLogoBase64('Hitam_KuningUtama.png') ?: $getLogoBase64('Hitam_KuningUtama.webp') ?: $getLogoBase64('logo_hitamkuning.svg') ?: $getLogoBase64('logo.png');

  // Filter pendaftaran terdaftar/lulus/tidak_lulus
  $pendaftarans = $kegiatan->pendaftaran
      ->filter(fn($p) => in_array($p->status_pendaftaran, ['terdaftar', 'lulus', 'tidak_lulus']))
      ->values();

  // Minimal 7 baris untuk formulir fisik yang rapi
  $totalRows = max(7, $pendaftarans->count());

  // Format Tanggal Ujian / Pelaksanaan (Bahasa Indonesia)
  $tglPelaksanaan = $kegiatan->jadwal?->tgl_pelaksanaan;
  if ($tglPelaksanaan) {
      $c = \Carbon\Carbon::parse($tglPelaksanaan)->locale('id');
      $days = [
          'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
          'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
      ];
      $months = [
          'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
          'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
          'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
          'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
      ];
      $dayEng = $c->format('l');
      $monthEng = $c->format('F');
      $dayId = $days[$dayEng] ?? $dayEng;
      $monthId = $months[$monthEng] ?? $monthEng;
      $tanggalStr = $dayId . ', ' . $c->format('d') . ' ' . $monthId . ' ' . $c->format('Y');
  } else {
      $tanggalStr = 'Rabu, 26 Agustus 2026';
  }

  // Kode Ujian
  $kodeUjian = $kegiatan->detail?->kode ?? 'DP-900';

  // Nama & TTD Proktor (dari TandaTangan aktif atau default)
  $ttdAktif = \App\Models\TandaTangan::getAktif();
  $rawProktor = $ttdAktif?->proktor_nama ?: ($ttdAktif?->ketua_nama ? "Ir. {$ttdAktif->ketua_nama}, S.Kom., M.T., MTA., MCF" : "Ir. Abdul Rachman Manga', S.Kom., M.T., MTA., MCF");
  $namaProktor = str_starts_with($rawProktor, '(') ? $rawProktor : "({$rawProktor})";

  $proktorTtdImg = null;
  if ($ttdAktif?->proktor_ttd) {
      $storagePath = storage_path('app/public/' . $ttdAktif->proktor_ttd);
      if (file_exists($storagePath)) {
          $mime = mime_content_type($storagePath) ?: 'image/png';
          $proktorTtdImg = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($storagePath));
      }
  }
@endphp

<!-- Header Logos Table (Logos at the top: UMI + FIKOM on left, Hitam_KuningUtama on right) -->
<table class="header-logos-table" style="width: 100%; border-collapse: collapse; margin-bottom: 14px;">
  <tr>
    <td style="text-align: left; vertical-align: middle; border: none;">
      <table style="width: auto; border-collapse: collapse; border: none;">
        <tr>
          @if($logoUmi)
            <td style="padding: 0 8px 0 0; vertical-align: middle; border: none;">
              <img src="{{ $logoUmi }}" style="height: 48px; width: auto; display: block;" alt="Logo UMI">
            </td>
          @endif
          @if($logoFikom)
            <td style="padding: 0; vertical-align: middle; border: none;">
              <img src="{{ $logoFikom }}" style="height: 44px; width: auto; display: block;" alt="Logo FIKOM">
            </td>
          @endif
        </tr>
      </table>
    </td>
    <td style="text-align: right; vertical-align: middle; border: none;">
      @if($logoHitamKuning)
        <img src="{{ $logoHitamKuning }}" style="height: 48px; width: auto; display: inline-block; vertical-align: middle;" alt="Logo FCC">
      @endif
    </td>
  </tr>
</table>

<!-- Document Title (Centered below the header logos) -->
<div class="doc-title-container" style="text-align: center; margin-bottom: 16px;">
  <div class="doc-title" style="font-size: 16pt; font-weight: bold; color: #000000; letter-spacing: 0.5px; text-transform: uppercase; font-family: 'Helvetica', 'Arial', sans-serif;">
    {{ $kegiatan->jenis_kegiatan === 'sertifikasi' ? 'DAFTAR HADIR UJIAN SERTIFIKASI INTERNASIONAL' : 'DAFTAR HADIR PELATIHAN KOMPETENSI' }}
  </div>
</div>

<!-- Date Box Table -->
<table class="info-box-table">
  <tr>
    <td class="info-label">Hari / Tanggal Ujian :</td>
    <td class="info-value">{{ $tanggalStr }}</td>
  </tr>
</table>

<!-- Attendance Table -->
<table class="attendance-table">
  <thead>
    <tr>
      <th class="col-no">NO</th>
      <th class="col-nama">NAMA PESERTA</th>
      <th class="col-kode">KODE<br>UJIAN</th>
      <th class="col-jam-in">JAM<br>MASUK</th>
      <th class="col-ttd-in">TANDA<br>TANGAN</th>
      <th class="col-jam-out">JAM<br>KELUAR</th>
      <th class="col-ttd-out">TANDA<br>TANGAN</th>
      <th class="col-verif">
        VERIFIKASI ID CARD
        <span class="th-subtext">(beri tanda centang jika peserta sudah diverifikasi sesuai dengan ID Card)</span>
      </th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < $totalRows; $i++)
      @php
        $pd = $pendaftarans->get($i);
      @endphp
      <tr>
        <td class="col-no">{{ $i + 1 }}</td>
        <td class="col-nama">
          {{ $pd && $pd->peserta ? Str::upper($pd->peserta->nama) : '' }}
        </td>
        <td class="col-kode">
          {{ $pd ? $kodeUjian : '' }}
        </td>
        <td class="col-jam-in"></td>
        <td class="col-ttd-in"></td>
        <td class="col-jam-out"></td>
        <td class="col-ttd-out"></td>
        <td class="col-verif"></td>
      </tr>
    @endfor
  </tbody>
</table>

<!-- Footer & Signature Section -->
<table class="footer-table">
  <tr>
    <td class="footer-statement">
      Bersama ini, Saya yang bertanda tangan dibawah ini menyatakan dengan sesungguhnya bahwa semua peserta ujian sudah di verifikasi sesuai dengan ID Card yang disertakan
    </td>
    <td class="footer-signature">
      <div class="proktor-title">{{ $ttdAktif?->proktor_jabatan ?? 'Proktor Ujian' }}</div>
      <div class="proktor-ttd-container">
        @if($proktorTtdImg)
          <img src="{{ $proktorTtdImg }}" class="proktor-ttd-img" alt="TTD Proktor">
        @endif
      </div>
      <div class="proktor-name">{{ $namaProktor }}</div>
    </td>
  </tr>
</table>

</div>

</body>
</html>
