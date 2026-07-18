<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<style>
  @page{ margin:10mm; size:A5; }
  *{ box-sizing:border-box; margin:0; padding:0; }
  body{ font-family:'DejaVu Sans',Arial,sans-serif; font-size:9pt; color:#131218; }
  .header{ background:#131218; padding:6mm 7mm; margin-bottom:5mm; border-radius:2mm; display:flex; justify-content:space-between; align-items:center; }
  .logo-title{ color:#FFF; font-size:12pt; font-weight:700; }
  .logo-sub{ color:#FFC81A; font-size:7pt; letter-spacing:1.5pt; text-transform:uppercase; }
  .stamp{ text-align:right; }
  .stamp-text{ display:inline-block; background:rgba(16,185,129,.2); border:2px solid #10B981; color:#10B981; font-size:11pt; font-weight:900; padding:2mm 4mm; border-radius:2mm; letter-spacing:1pt; }
  .section-title{ font-size:8pt; font-weight:700; color:#9CA3B0; text-transform:uppercase; letter-spacing:1pt; margin:4mm 0 2mm; }
  .info-box{ background:#F7F8FA; border:1px solid #E2E4EB; border-radius:1.5mm; padding:3mm 4mm; margin-bottom:3mm; }
  .info-row{ display:flex; justify-content:space-between; padding:1.5mm 0; border-bottom:1px solid #E2E4EB; }
  .info-row:last-child{ border-bottom:none; }
  .lbl{ color:#9CA3B0; font-size:8pt; }
  .val{ font-weight:700; font-size:8.5pt; }
  .success-box{ background:rgba(16,185,129,.08); border:1.5px solid rgba(16,185,129,.3); border-radius:2mm; padding:4mm 5mm; display:flex; justify-content:space-between; align-items:center; margin:4mm 0; }
  .succ-label{ color:#059669; font-weight:700; font-size:9pt; }
  .succ-val{ color:#059669; font-size:14pt; font-weight:900; }
  .footer{ margin-top:5mm; text-align:center; color:#9CA3B0; font-size:7pt; border-top:1px solid #E2E4EB; padding-top:3mm; }
</style>
</head>
<body>
<div class="header">
  <div>
    <div class="logo-title">BUKTI PEMBAYARAN</div>
    <div class="logo-sub">FIKOM Certification Center — UMI</div>
  </div>
  <div class="stamp"><span class="stamp-text">✓ LUNAS</span></div>
</div>

<div class="info-box">
  <div class="info-row"><span class="lbl">Kode Pembayaran</span><span class="val" style="color:#3B82F6;font-family:monospace;">{{ $pembayaran->kode_pembayaran }}</span></div>
  <div class="info-row"><span class="lbl">No. Kwitansi</span><span class="val">{{ $pembayaran->no_kwitansi ?? '-' }}</span></div>
  <div class="info-row"><span class="lbl">Tgl Verifikasi</span><span class="val">{{ $pembayaran->tgl_verifikasi?->format('d M Y H:i') ?? now()->format('d M Y H:i') }}</span></div>
</div>

<div class="section-title">Penerima</div>
<div class="info-box">
  <div class="info-row"><span class="lbl">Nama</span><span class="val">{{ $pembayaran->pendaftaran->peserta->nama }}</span></div>
  <div class="info-row"><span class="lbl">Kegiatan</span><span class="val">{{ Str::limit($pembayaran->pendaftaran->kegiatan->judul,40) }}</span></div>
  <div class="info-row"><span class="lbl">Tanggal Kegiatan</span><span class="val">{{ $pembayaran->pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}</span></div>
</div>

<div class="section-title">Detail Transaksi</div>
<div class="info-box">
  <div class="info-row"><span class="lbl">Metode</span><span class="val">{{ $pembayaran->metode_pembayaran ?? 'Transfer Bank' }}</span></div>
  <div class="info-row"><span class="lbl">Bank/Layanan</span><span class="val">{{ $pembayaran->nama_layanan_bank ?? '-' }}</span></div>
  <div class="info-row"><span class="lbl">Tgl Transfer</span><span class="val">{{ $pembayaran->tgl_transfer ? \Carbon\Carbon::parse($pembayaran->tgl_transfer)->format('d M Y').' '.$pembayaran->jam_transfer : '-' }}</span></div>
</div>

<div class="success-box">
  <span class="succ-label">Jumlah Diterima</span>
  <span class="succ-val">{{ $pembayaran->jumlah_bayar_format }}</span>
</div>

<div class="footer">
  <p>Bukti ini diterbitkan secara resmi oleh FIKOM Certification Center</p>
  <p>Universitas Muslim Indonesia Makassar &mdash; Dicetak: {{ now()->format('d M Y H:i') }} WITA</p>
</div>
</body>
</html>
