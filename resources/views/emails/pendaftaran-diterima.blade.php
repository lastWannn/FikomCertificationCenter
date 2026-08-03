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
    <p class="greeting">Pendaftaran Berhasil! 🎉</p>
    <p class="text">Halo, <strong>{{ $pendaftaran->peserta->nama }}</strong>!</p>
    <p class="text">Pendaftaran kamu untuk kegiatan berikut telah diterima. {{ $pendaftaran->pembayaran ? 'Invoice pembayaran terlampir dalam email ini.' : 'Anda telah terdaftar pada kegiatan gratis ini.' }}</p>

    @if($pendaftaran->pembayaran)
    <div class="banner-success">✓ Invoice Pendaftaran Terlampir (PDF)</div>

    <table class="email-table">
      <tr>
        <td class="lbl">Kegiatan</td>
        <td class="val">{{ $pendaftaran->kegiatan->judul }}</td>
      </tr>
      <tr>
        <td class="lbl">Jenis Kegiatan</td>
        <td class="val">{{ ucfirst($pendaftaran->kegiatan->jenis_kegiatan) }}</td>
      </tr>
      <tr>
        <td class="lbl">Tanggal Pelaksanaan</td>
        <td class="val">{{ $pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->format('d F Y') ?? 'TBA' }}</td>
      </tr>
      <tr>
        <td class="lbl">Kode Pembayaran</td>
        <td class="val val-highlight">{{ $pendaftaran->pembayaran->kode_pembayaran }}</td>
      </tr>
      <tr>
        <td class="lbl">Biaya Kategori</td>
        <td class="val">{{ $pendaftaran->biaya?->nominal_format ?? 'Gratis' }}</td>
      </tr>
      @if($pendaftaran->pembayaran->kode_unik)
      <tr>
        <td class="lbl">Kode Unik Transfer</td>
        <td class="val val-highlight">{{ $pendaftaran->pembayaran->kode_unik }}</td>
      </tr>
      @endif
      <tr>
        <td class="lbl">Total Transfer</td>
        <td class="val val-total">{{ $pendaftaran->pembayaran->nominal_transfer_format }}</td>
      </tr>
      <tr>
        <td class="lbl">Batas Pembayaran</td>
        <td class="val val-danger">{{ $pendaftaran->pembayaran->tgl_kadaluarsa?->format('d M Y H:i') ?? '-' }} WITA</td>
      </tr>
    </table>

    <p class="text"><strong>Catatan Penting:</strong> Lampiran invoice resmi berupa dokumen PDF telah disertakan pada email ini. Harap transfer tepat nominal <strong>{{ $pendaftaran->pembayaran->nominal_transfer_format }}</strong> untuk mempermudah verifikasi.</p>

    <p class="text">Langkah berikutnya:</p>
    <ol style="color:#5A6275;padding-left:20px;margin-bottom:20px;">
      <li style="margin-bottom:6px">Unduh atau buka berkas Invoice PDF terlampir</li>
      <li style="margin-bottom:6px">Transfer sesuai nominal tepat ke rekening FCC</li>
      <li style="margin-bottom:6px">Upload foto bukti transfer di portal peserta</li>
    </ol>

    <a href="{{ config('app.url') }}/peserta/pembayaran" class="btn">Lihat Detail & Bayar &rarr;</a>
    @else
    <div class="banner-success">✓ Pendaftaran Gratis Berhasil — Langsung Terdaftar</div>
    <table class="email-table">
      <tr>
        <td class="lbl">Kegiatan</td>
        <td class="val">{{ $pendaftaran->kegiatan->judul }}</td>
      </tr>
      <tr>
        <td class="lbl">Jenis Kegiatan</td>
        <td class="val">{{ ucfirst($pendaftaran->kegiatan->jenis_kegiatan) }}</td>
      </tr>
      <tr>
        <td class="lbl">Status</td>
        <td class="val" style="color:#10B981;">Terdaftar</td>
      </tr>
    </table>
    <a href="{{ config('app.url') }}/peserta/pendaftaran" class="btn">Lihat Pendaftaran Saya &rarr;</a>
    @endif
  </div>

  <div class="footer">
    <p>&copy; {{ date('Y') }} FIKOM Certification Center &mdash; Universitas Muslim Indonesia Makassar</p>
    <p style="margin-top:6px">Email ini dikirim otomatis. Harap tidak membalas email ini.</p>
  </div>
</div>
</body>
</html>