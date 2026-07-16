<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:'Segoe UI',Arial,sans-serif;background:#F7F8FA;color:#131218;font-size:15px;line-height:1.7}
  .wrap{max-width:600px;margin:40px auto;background:#FFF;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)}
  .header{background:#131218;padding:32px 40px;text-align:center}
  .logo-box{display:inline-flex;align-items:center;gap:12px;margin-bottom:6px}
  .logo-icon{width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center}
  .logo-text{color:#FFF;font-size:18px;font-weight:900;text-align:left}
  .logo-sub{color:#FFC81A;font-size:9px;letter-spacing:2px;text-transform:uppercase}
  .body{padding:36px 40px}
  .greeting{font-size:22px;font-weight:900;color:#131218;margin-bottom:8px}
  .text{color:#5A6275;margin-bottom:16px}
  .card{background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;padding:18px 20px;margin:20px 0}
  .card-row{display:flex;justify-content:space-between;padding:7px 0;border-top:1px solid #E2E4EB}
  .card-row:first-child{border-top:none}
  .lbl{color:#9CA3B0;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px}
  .val{color:#131218;font-size:14px;font-weight:700}
  .btn{display:inline-block;background:linear-gradient(135deg,#FFC81A,#FFD84D);color:#131218;font-weight:800;font-size:14px;padding:12px 28px;border-radius:10px;text-decoration:none;box-shadow:0 4px 14px rgba(255,200,26,.3);margin-top:8px}
  .footer{background:#F7F8FA;border-top:1px solid #E2E4EB;padding:20px 40px;text-align:center;color:#9CA3B0;font-size:12px}
  .highlight{color:#FFC81A;font-weight:800}
  .success-banner{background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.25);border-radius:10px;padding:14px 18px;color:#059669;font-weight:700;font-size:14px;margin-bottom:20px}
  .danger-banner{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);border-radius:10px;padding:14px 18px;color:#DC2626;font-weight:700;font-size:14px;margin-bottom:20px}
  .warning-banner{background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.25);border-radius:10px;padding:14px 18px;color:#D97706;font-weight:700;font-size:14px;margin-bottom:20px}
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="logo-box">
      <div class="logo-icon">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5" stroke-linecap="round">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
      </div>
      <div class="logo-text">
        <div>FIKOM Certification</div>
        <div class="logo-sub">Center &middot; UMI</div>
      </div>
    </div>
  </div>
  
  <div class="body">
    <p class="greeting">Pembayaran Perlu Diulang</p>
    <p class="text">Halo, <strong>{{ $pembayaran->pendaftaran->peserta->nama }}</strong>!</p>
    <p class="text">Maaf, pembayaran kamu untuk kegiatan berikut <strong>tidak dapat diverifikasi</strong> oleh tim FCC.</p>

    <div class="danger-banner">✗ Pembayaran Ditolak — Upload ulang bukti transfer</div>

    <div class="card">
      <div class="card-row"><span class="lbl">Kegiatan</span><span class="val">{{ $pembayaran->pendaftaran->kegiatan->judul }}</span></div>
      <div class="card-row"><span class="lbl">Kode Bayar</span><span class="val">{{ $pembayaran->kode_pembayaran }}</span></div>
      @if($alasan)<div class="card-row"><span class="lbl">Alasan</span><span class="val" style="color:#EF4444;">{{ $alasan }}</span></div>@endif
    </div>

    <p class="text">Kemungkinan penyebab penolakan:</p>
    <ul style="color:#5A6275;padding-left:20px;margin-bottom:20px;">
      <li style="margin-bottom:5px">Bukti transfer tidak terbaca / buram</li>
      <li style="margin-bottom:5px">Nominal transfer tidak sesuai</li>
      <li>Nama pengirim tidak cocok dengan data pendaftaran</li>
    </ul>

    <p class="text">Hubungi Admin FCC atau upload ulang bukti transfer yang valid.</p>
    <a href="{{ config('app.url') }}/peserta/pembayaran" class="btn">Upload Ulang Bukti &rarr;</a>
  </div>

  <div class="footer">
    <p>&copy; {{ date('Y') }} FIKOM Certification Center &mdash; Universitas Muslim Indonesia Makassar</p>
    <p style="margin-top:6px">Email ini dikirim otomatis. Harap tidak membalas email ini.</p>
  </div>
</div>
</body>
</html>