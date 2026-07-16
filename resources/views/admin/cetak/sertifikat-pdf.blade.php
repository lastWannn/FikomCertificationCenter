<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<style>
  @page { margin:0; size:A4 landscape; }
  *{ box-sizing:border-box; margin:0; padding:0; }
  body{ font-family:'DejaVu Sans',Arial,sans-serif; width:297mm; height:210mm; overflow:hidden; position:relative; }
  .bg-layer{ position:absolute; inset:0; width:100%; height:100%;
    background:linear-gradient(135deg,#131218 0%,#1C1B22 60%,#131218 100%); }
  .grid-overlay{ position:absolute; inset:0; opacity:.04;
    background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),
                     linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);
    background-size:20mm 20mm; }
  @if($sertifikat->gambar_latar)
  .custom-bg{ position:absolute; inset:0; width:100%; height:100%; object-fit:cover; z-index:1; }
  .overlay{ position:absolute; inset:0; background:rgba(19,18,24,.75); z-index:2; }
  @endif
  .content{ position:relative; z-index:10; height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:14mm 22mm; }
  .border-frame{ position:absolute; inset:8mm; border:2px solid rgba(255,200,26,.3); border-radius:3mm; pointer-events:none; }
  .border-inner{ position:absolute; inset:10mm; border:1px solid rgba(255,200,26,.15); border-radius:2mm; pointer-events:none; }
  /* Ornamen sudut */
  .corner{ position:absolute; width:18mm; height:18mm; }
  .corner-tl{ top:7mm; left:7mm; border-top:3px solid #FFC81A; border-left:3px solid #FFC81A; border-radius:2mm 0 0 0; }
  .corner-tr{ top:7mm; right:7mm; border-top:3px solid #FFC81A; border-right:3px solid #FFC81A; border-radius:0 2mm 0 0; }
  .corner-bl{ bottom:7mm; left:7mm; border-bottom:3px solid #FFC81A; border-left:3px solid #FFC81A; border-radius:0 0 0 2mm; }
  .corner-br{ bottom:7mm; right:7mm; border-bottom:3px solid #FFC81A; border-right:3px solid #FFC81A; border-radius:0 0 2mm 0; }

  .logo-row{ display:flex; align-items:center; gap:4mm; margin-bottom:6mm; }
  .logo-icon{ width:14mm; height:14mm; background:linear-gradient(135deg,#FFC81A,#FFD84D); border-radius:3mm; display:flex; align-items:center; justify-content:center; }
  .logo-text{ color:#FFF; font-size:11pt; font-weight:700; }
  .logo-sub{ color:#FFC81A; font-size:7pt; letter-spacing:2pt; text-transform:uppercase; }

  .divider{ width:60mm; height:1px; background:linear-gradient(90deg,transparent,#FFC81A,transparent); margin:4mm auto; }
  .label{ color:rgba(255,255,255,.55); font-size:9pt; letter-spacing:3pt; text-transform:uppercase; margin-bottom:3mm; }
  .nama{ color:#FFF; font-size:28pt; font-weight:900; text-align:center; margin:3mm 0; line-height:1.2; }
  .kegiatan{ color:#FFC81A; font-size:13pt; font-weight:700; text-align:center; margin-bottom:2mm; }
  .keterangan{ color:rgba(255,255,255,.5); font-size:9pt; text-align:center; margin-bottom:8mm; max-width:180mm; }

  .info-row{ display:flex; gap:20mm; justify-content:center; margin-bottom:10mm; }
  .info-box{ text-align:center; }
  .info-label{ color:rgba(255,255,255,.4); font-size:7pt; letter-spacing:2pt; text-transform:uppercase; margin-bottom:1mm; }
  .info-val{ color:#FFF; font-size:9pt; font-weight:700; }

  .ttd-row{ display:flex; gap:40mm; justify-content:center; margin-top:4mm; }
  .ttd-box{ text-align:center; }
  .ttd-line{ width:50mm; height:0.5px; background:#FFC81A; margin:12mm auto 3mm; }
  .ttd-name{ color:#FFF; font-size:9pt; font-weight:700; }
  .ttd-role{ color:rgba(255,255,255,.45); font-size:7.5pt; }

  .nomor{ position:absolute; bottom:12mm; right:20mm; color:rgba(255,255,255,.25); font-size:7pt; font-family:monospace; }
</style>
</head>
<body>
<div class="bg-layer"></div>
<div class="grid-overlay"></div>
@if($sertifikat->gambar_latar)
<img class="custom-bg" src="{{ public_path('storage/'.$sertifikat->gambar_latar) }}" alt="latar">
<div class="overlay"></div>
@endif

<div class="corner corner-tl"></div>
<div class="corner corner-tr"></div>
<div class="corner corner-bl"></div>
<div class="corner corner-br"></div>

<div class="content">
  <div class="logo-row">
    <div class="logo-icon">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5" stroke-linecap="round">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
    </div>
    <div>
      <div class="logo-text">FIKOM Certification Center</div>
      <div class="logo-sub">Universitas Muslim Indonesia</div>
    </div>
  </div>

  <div class="divider"></div>
  <div class="label">Sertifikat Kelulusan</div>
  <div class="divider"></div>

  <p style="color:rgba(255,255,255,.55);font-size:9pt;margin-bottom:3mm;">Diberikan kepada:</p>
  <div class="nama">{{ $sertifikat->pendaftaran->peserta->nama }}</div>

  <p style="color:rgba(255,255,255,.45);font-size:9pt;margin-bottom:2mm;">atas keberhasilan menyelesaikan</p>
  <div class="kegiatan">{{ $sertifikat->pendaftaran->kegiatan->judul }}</div>
  <div class="keterangan">
    Program {{ ucfirst($sertifikat->pendaftaran->kegiatan->jenis_kegiatan) }} yang diselenggarakan oleh
    FIKOM Certification Center, Universitas Muslim Indonesia, Makassar.
  </div>

  <div class="info-row">
    <div class="info-box">
      <div class="info-label">Tanggal Terbit</div>
      <div class="info-val">{{ $sertifikat->tgl_terbit->format('d F Y') }}</div>
    </div>
    <div class="info-box">
      <div class="info-label">No. Sertifikat</div>
      <div class="info-val" style="font-family:monospace;color:#FFC81A;">{{ $sertifikat->nomor_sertifikat }}</div>
    </div>
    <div class="info-box">
      <div class="info-label">Pelaksanaan</div>
      <div class="info-val">{{ $sertifikat->pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? '-' }}</div>
    </div>
  </div>

  <div class="ttd-row">
    <div class="ttd-box">
      <div class="ttd-line"></div>
      <div class="ttd-name">Dekan FIKOM UMI</div>
      <div class="ttd-role">Penanggung Jawab</div>
    </div>
    <div class="ttd-box">
      <div class="ttd-line"></div>
      <div class="ttd-name">Direktur FCC</div>
      <div class="ttd-role">Ketua Penyelenggara</div>
    </div>
  </div>
</div>

<div class="nomor">{{ $sertifikat->nomor_sertifikat }}</div>
</body>
</html>
