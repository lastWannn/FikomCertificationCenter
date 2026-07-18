<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>QR Scan — FCC</title>
<style>
  body{font-family:'Segoe UI',Arial,sans-serif;background:#F7F8FA;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;padding:16px;}
  .card{background:#FFF;border-radius:20px;padding:40px 32px;max-width:380px;width:100%;text-align:center;box-shadow:0 8px 32px rgba(0,0,0,.08);}
  .icon{width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;}
  .success .icon{background:rgba(16,185,129,.12);border:2px solid rgba(16,185,129,.3);}
  .already .icon,.invalid .icon{background:rgba(245,158,11,.1);border:2px solid rgba(245,158,11,.25);}
  .belum-bayar .icon{background:rgba(239,68,68,.1);border:2px solid rgba(239,68,68,.2);}
  h2{font-size:22px;font-weight:900;margin:0 0 8px;}
  .success h2{color:#059669;}
  .already h2,.invalid h2{color:#D97706;}
  .belum-bayar h2{color:#DC2626;}
  p{color:#5A6275;font-size:14px;line-height:1.7;margin:0 0 20px;}
  .info{background:#F7F8FA;border-radius:10px;padding:14px 16px;text-align:left;margin-bottom:18px;}
  .row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #E2E4EB;font-size:13px;}
  .row:last-child{border-bottom:none;}
  .lbl{color:#9CA3B0;}
  .val{font-weight:700;color:#131218;}
  .time{font-size:12px;color:#9CA3B0;margin-top:16px;}
  .logo{margin-bottom:24px;}
  .logo span{font-size:12px;font-weight:900;color:#131218;}
  .logo small{color:#FFC81A;font-size:8px;display:block;letter-spacing:2px;text-transform:uppercase;}
</style>
</head>
<body>
<div class="card {{ $status }}">
  <div class="logo">
    <div style="width:44px;height:44px;border-radius:12px;background:#131218;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5" stroke-linecap="round">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
    </div>
    <span>FCC UMI</span>
    <small>Certification Center</small>
  </div>

  @if($status === 'success')
  <div class="icon"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></div>
  <h2>Kehadiran Tercatat!</h2>
  <div class="info">
    <div class="row"><span class="lbl">Peserta</span><span class="val">{{ $pendaftaran->peserta->nama }}</span></div>
    <div class="row"><span class="lbl">Kegiatan</span><span class="val">{{ Str::limit($pendaftaran->kegiatan->judul,30) }}</span></div>
    <div class="row"><span class="lbl">Status</span><span class="val" style="color:#10B981;">✓ HADIR</span></div>
  </div>

  @elseif($status === 'already')
  <div class="icon"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
  <h2>Sudah Tercatat</h2>
  <p>Kehadiran <strong>{{ $pendaftaran->peserta->nama }}</strong> sudah tercatat sebelumnya.</p>

  @elseif($status === 'belum_bayar')
  <div class="icon"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg></div>
  <h2>Belum Terdaftar</h2>
  <p>Peserta <strong>{{ $pendaftaran->peserta->nama }}</strong> belum menyelesaikan pembayaran.</p>

  @else
  <div class="icon"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
  <h2>QR Tidak Valid</h2>
  <p>Kode QR ini tidak ditemukan atau sudah kadaluarsa.</p>
  @endif

  <div class="time">{{ now()->format('d M Y • H:i') }} WITA</div>
</div>
</body>
</html>
