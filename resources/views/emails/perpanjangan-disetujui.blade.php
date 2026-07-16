<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8">
<style>
  body{font-family:'Segoe UI',Arial,sans-serif;background:#F7F8FA;color:#131218;font-size:15px;margin:0;padding:0}
  .wrap{max-width:600px;margin:40px auto;background:#FFF;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)}
  .hdr{background:#131218;padding:28px 36px;display:flex;align-items:center;gap:14px}
  .logo{width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center}
  .brand{color:#FFF;font-size:16px;font-weight:900}
  .sub-brand{color:#FFC81A;font-size:8px;letter-spacing:2px;text-transform:uppercase;display:block}
  .body{padding:32px 36px}
  .card{background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;padding:16px 18px;margin:18px 0}
  .row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #E2E4EB;font-size:13px}
  .row:last-child{border-bottom:none}
  .lbl{color:#9CA3B0;font-weight:700;text-transform:uppercase;font-size:10px;letter-spacing:.5px}
  .val{font-weight:700;color:#131218}
  .btn{display:inline-block;background:linear-gradient(135deg,#FFC81A,#FFD84D);color:#131218;font-weight:800;font-size:13px;padding:11px 24px;border-radius:10px;text-decoration:none;margin-top:8px}
  .badge-green{background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.25);border-radius:8px;padding:12px 16px;color:#059669;font-weight:700;font-size:13px}
  .badge-red{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:8px;padding:12px 16px;color:#DC2626;font-weight:700;font-size:13px}
  .big-nominal{background:#131218;border-radius:10px;padding:14px 20px;text-align:center;margin:16px 0}
  .big-nominal p{color:#FFC81A;font-size:24px;font-weight:900;font-family:monospace;letter-spacing:2px;margin:0}
  .big-nominal small{color:rgba(255,255,255,.5);font-size:10px;display:block;margin-top:4px}
  .kode-box{display:inline-block;border:2px dashed rgba(255,200,26,.5);border-radius:8px;padding:8px 18px;color:#FFC81A;font-weight:900;font-size:20px;font-family:monospace;letter-spacing:3px}
  .ft{background:#F7F8FA;border-top:1px solid #E2E4EB;padding:16px 36px;text-align:center;color:#9CA3B0;font-size:11px}
</style>
</head>
<body>
<div class="wrap">
  <div class="hdr">
    <div class="logo">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5" stroke-linecap="round">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
    </div>
    <div>
      <span class="brand">FIKOM Certification Center</span>
      <span class="sub-brand">Universitas Muslim Indonesia</span>
    </div>
  </div>
  <div class="body">
<p style="font-size:20px;font-weight:900;color:#131218;margin:0 0 8px">Perpanjangan Waktu Disetujui! ✓</p>
<p style="color:#5A6275;margin:0 0 16px">Halo, <strong>{{ $pembayaran->pendaftaran->peserta->nama }}</strong>!</p>
<p style="color:#5A6275;margin:0 0 18px">Permintaan perpanjangan waktu pembayaran kamu telah <strong>disetujui</strong> oleh Admin FCC. Segera selesaikan pembayaran sebelum batas waktu baru habis.</p>

<div class="badge-green">✓ Perpanjangan Disetujui — Batas Waktu Baru +2 Jam</div>

<div class="card">
  <div class="row"><span class="lbl">Kegiatan</span><span class="val">{{ $pembayaran->pendaftaran->kegiatan->judul }}</span></div>
  <div class="row"><span class="lbl">Kode Bayar</span><span class="val" style="color:#FFC81A;font-family:monospace">{{ $pembayaran->kode_pembayaran }}</span></div>
  <div class="row"><span class="lbl">Batas Baru</span><span class="val" style="color:#EF4444">{{ $pembayaran->tgl_kadaluarsa?->format('d M Y H:i') }} WITA</span></div>
</div>

@if($pembayaran->kode_unik)
<p style="color:#5A6275;font-size:13px;margin:16px 0 8px">Transfer <strong>tepat</strong> nominal berikut (termasuk kode unik):</p>
<div class="big-nominal">
  <p>{{ $pembayaran->nominal_transfer_format }}</p>
  <small>Nominal asli {{ $pembayaran->jumlah_bayar_format }} + kode unik {{ $pembayaran->kode_unik }}</small>
</div>
@endif

<a href="{{ config('app.url') }}/peserta/pembayaran" class="btn">Bayar Sekarang &rarr;</a>
</div>
  <div class="ft">
    <p>&copy; {{ date('Y') }} FIKOM Certification Center &mdash; Universitas Muslim Indonesia Makassar</p>
    <p>Email ini dikirim otomatis. Harap tidak membalas email ini.</p>
  </div>
</div>
</body>
</html>