<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<title>QR Sheet — {{ $kegiatan->judul }}</title>
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<style>
  *{ box-sizing:border-box; margin:0; padding:0; }
  body{ font-family:'Segoe UI',Arial,sans-serif; background:#FFF; padding:10mm; }
  .page-title{ text-align:center; margin-bottom:8mm; border-bottom:2px solid #131218; padding-bottom:4mm; }
  .page-title h1{ font-size:16pt; font-weight:900; color:#131218; }
  .page-title p{ color:#5A6275; font-size:9pt; margin-top:2mm; }
  .grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:6mm; }
  .card{ border:1px solid #E2E4EB; border-radius:3mm; padding:5mm; text-align:center; page-break-inside:avoid; }
  .qr-box{ width:55mm; height:55mm; margin:0 auto 3mm; display:flex; align-items:center; justify-content:center; background:#FFF; }
  .nama{ font-size:9.5pt; font-weight:700; color:#131218; margin-bottom:1.5mm; }
  .kegiatan{ font-size:7.5pt; color:#5A6275; margin-bottom:1.5mm; }
  .url{ font-size:7pt; color:#9CA3B0; word-break:break-all; font-family:monospace; }
  @media print{
    button{ display:none!important; }
    .card{ border:1px solid #CCC; }
  }
</style>
</head>
<body>
<div class="page-title">
  <h1>QR Code Presensi</h1>
  <p>{{ $kegiatan->judul }} &mdash; {{ $kegiatan->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}</p>
</div>
<button onclick="window.print()" style="position:fixed;top:10px;right:10px;padding:8px 18px;background:#131218;color:#FFC81A;border:none;border-radius:8px;font-weight:700;cursor:pointer;font-size:13px;z-index:999;">&#128438; Cetak</button>
<div class="grid">
  @foreach($pendaftaran as $pd)
  <div class="card">
    <div class="qr-box" id="qr-{{ $pd->id }}"></div>
    <div class="nama">{{ $pd->peserta->nama }}</div>
    <div class="kegiatan">{{ Str::limit($kegiatan->judul,36) }}</div>
    <div class="url">{{ route('qr.scan',$pd->qr_token) }}</div>
  </div>
  @endforeach
</div>
<script>
const qrData = @json($pendaftaran->map(fn($p) => ['id'=>$p->id,'url'=>route('qr.scan',$p->qr_token ?? '__')])->values());
document.addEventListener('DOMContentLoaded', () => {
  qrData.forEach(item => {
    const el = document.getElementById('qr-'+item.id);
    if(el) new QRCode(el, {text:item.url, width:180, height:180, colorDark:'#131218', colorLight:'#FFF'});
  });
});
</script>
</body>
</html>
