<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<style>
  @page{ margin:10mm; size:A5; }
  *{ box-sizing:border-box; margin:0; padding:0; }
  body{ font-family:'DejaVu Sans',Arial,sans-serif; font-size:9pt; color:#131218; }
  .header{ background:#131218; color:#fff; padding:6mm 7mm; margin-bottom:5mm; border-radius:2mm; display:flex; justify-content:space-between; align-items:center; }
  .logo-title{ font-size:12pt; font-weight:700; }
  .logo-sub{ color:#FFC81A; font-size:7pt; letter-spacing:1.5pt; text-transform:uppercase; }
  .invoice-no{ text-align:right; }
  .inv-label{ color:rgba(255,255,255,.5); font-size:7pt; text-transform:uppercase; letter-spacing:1pt; }
  .inv-val{ color:#FFC81A; font-size:11pt; font-weight:900; font-family:monospace; }
  .section-title{ font-size:8pt; font-weight:700; color:#9CA3B0; text-transform:uppercase; letter-spacing:1pt; margin:4mm 0 2mm; }
  .info-box{ background:#F7F8FA; border:1px solid #E2E4EB; border-radius:1.5mm; padding:3mm 4mm; margin-bottom:3mm; }
  .info-row{ display:flex; justify-content:space-between; padding:1.5mm 0; border-bottom:1px solid #E2E4EB; }
  .info-row:last-child{ border-bottom:none; }
  .lbl{ color:#9CA3B0; font-size:8pt; }
  .val{ font-weight:700; font-size:8.5pt; }
  .rekening-box{ background:#131218; color:#fff; border-radius:2mm; padding:4mm 5mm; margin:3mm 0; }
  .rek-label{ color:rgba(255,255,255,.5); font-size:7pt; text-transform:uppercase; letter-spacing:1pt; margin-bottom:1mm; }
  .rek-no{ color:#FFC81A; font-size:14pt; font-weight:900; font-family:monospace; letter-spacing:2pt; }
  .rek-bank{ color:#FFF; font-size:9pt; font-weight:700; }
  .total-box{ background:#FFC81A; border-radius:2mm; padding:4mm 5mm; display:flex; justify-content:space-between; align-items:center; margin:3mm 0; }
  .total-label{ font-weight:700; font-size:9pt; color:#131218; }
  .total-val{ font-size:14pt; font-weight:900; color:#131218; }
  .footer{ margin-top:5mm; text-align:center; color:#9CA3B0; font-size:7pt; border-top:1px solid #E2E4EB; padding-top:3mm; }
  .warning{ background:rgba(245,158,11,.1); border:1px solid rgba(245,158,11,.3); border-radius:1.5mm; padding:2.5mm 3.5mm; color:#B45309; font-size:7.5pt; margin-top:3mm; }
</style>
</head>
<body>
<div class="header">
  <div>
    <div class="logo-title">FCC — Invoice</div>
    <div class="logo-sub">Universitas Muslim Indonesia</div>
  </div>
  <div class="invoice-no">
    <div class="inv-label">Kode Pembayaran</div>
    <div class="inv-val">{{ $pembayaran->kode_pembayaran }}</div>
  </div>
</div>

<div class="section-title">Informasi Peserta</div>
<div class="info-box">
  <div class="info-row"><span class="lbl">Nama</span><span class="val">{{ $pembayaran->pendaftaran->peserta->nama }}</span></div>
  <div class="info-row"><span class="lbl">Email</span><span class="val">{{ $pembayaran->pendaftaran->peserta->email }}</span></div>
  <div class="info-row"><span class="lbl">No. HP</span><span class="val">{{ $pembayaran->pendaftaran->peserta->no_hp }}</span></div>
</div>

<div class="section-title">Detail Kegiatan</div>
<div class="info-box">
  <div class="info-row"><span class="lbl">Kegiatan</span><span class="val">{{ Str::limit($pembayaran->pendaftaran->kegiatan->judul,40) }}</span></div>
  <div class="info-row"><span class="lbl">Tanggal</span><span class="val">{{ $pembayaran->pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}</span></div>
  <div class="info-row"><span class="lbl">Jenis Biaya</span><span class="val">{{ $pembayaran->pendaftaran->biaya?->nama_jenis ?? 'Gratis' }}</span></div>
  <div class="info-row"><span class="lbl">Tgl Invoice</span><span class="val">{{ $pembayaran->created_at->format('d M Y H:i') }}</span></div>
  <div class="info-row"><span class="lbl">Batas Bayar</span><span class="val" style="color:#EF4444;">{{ $pembayaran->tgl_kadaluarsa?->format('d M Y H:i') ?? '-' }}</span></div>
</div>

<div class="total-box">
  <span class="total-label">Total Tagihan</span>
  <span class="total-val">{{ $pembayaran->jumlah_bayar_format }}</span>
</div>

@if($rekening)
<div class="section-title">Transfer ke Rekening</div>
<div class="rekening-box">
  <div class="rek-label">No. Rekening</div>
  <div class="rek-no">{{ $rekening->no_rekening }}</div>
  <div class="rek-bank">{{ $rekening->bank }} &mdash; a.n. {{ $rekening->nama_pemilik }}</div>
</div>
@endif

<div class="warning">⚠ Kode pembayaran harus aktif sebelum transfer. Simpan invoice ini sebagai bukti tagihan.</div>

<div class="footer">
  <p>FIKOM Certification Center &mdash; Universitas Muslim Indonesia Makassar</p>
  <p>Dicetak: {{ now()->format('d M Y H:i') }} WITA</p>
</div>
</body>
</html>
