<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #F3F4F6; color: #1F2937; font-size: 14px; line-height: 1.6; }
  .wrap { max-width: 580px; margin: 30px auto; background: #FFFFFF; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #E5E7EB; }
  .header { background: #131218; padding: 32px 36px; text-align: center; }
  .logo-title { color: #FFFFFF; font-size: 20px; font-weight: 800; letter-spacing: 0.5px; }
  .logo-sub { color: #FFC81A; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; margin-top: 4px; font-weight: 700; }
  .body { padding: 36px; }
  .greeting { font-size: 22px; font-weight: 800; color: #111827; margin-bottom: 12px; }
  .text { color: #4B5563; font-size: 14px; margin-bottom: 16px; line-height: 1.6; }
  
  .banner-success { background: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 10px; padding: 14px 18px; color: #059669; font-weight: 700; font-size: 14px; margin-bottom: 24px; text-align: center; }
  
  .email-table { width: 100%; border-collapse: collapse; background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 12px; margin: 20px 0; overflow: hidden; }
  .email-table td { padding: 12px 18px; font-size: 13px; border-bottom: 1px solid #E5E7EB; }
  .email-table tr:last-child td { border-bottom: none; }
  .lbl { color: #6B7280; font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; width: 40%; vertical-align: middle; }
  .val { color: #111827; font-weight: 700; text-align: right; width: 60%; vertical-align: middle; }
  
  .btn { display: inline-block; background: #FFC81A; color: #131218; font-weight: 800; font-size: 14px; padding: 14px 32px; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 14px rgba(255,200,26,0.35); margin-top: 12px; text-align: center; }
  .footer { background: #F9FAFB; border-top: 1px solid #E5E7EB; padding: 24px 36px; text-align: center; color: #9CA3B0; font-size: 12px; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="logo-title">FIKOM CERTIFICATION CENTER</div>
    <div class="logo-sub">Universitas Muslim Indonesia</div>
  </div>
  
  <div class="body">
    <h2 class="greeting">Pembayaran Terverifikasi! ✅</h2>
    <p class="text">Halo, <strong>{{ $pembayaran->pendaftaran->peserta->nama }}</strong>!</p>
    <p class="text">Pembayaran kamu telah diverifikasi oleh tim FCC. Selamat, kamu resmi terdaftar sebagai peserta!</p>

    <div class="banner-success">✓ Status: TERDAFTAR — Kamu siap mengikuti kegiatan</div>

    <table class="email-table">
      <tr>
        <td class="lbl">Kegiatan</td>
        <td class="val">{{ $pembayaran->pendaftaran->kegiatan->judul }}</td>
      </tr>
      <tr>
        <td class="lbl">Tanggal Pelaksanaan</td>
        <td class="val">{{ $pembayaran->pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->format('d F Y') ?? 'TBA' }}</td>
      </tr>
      <tr>
        <td class="lbl">Waktu</td>
        <td class="val">{{ $pembayaran->pendaftaran->kegiatan->jadwal?->jam_mulai }} – {{ $pembayaran->pendaftaran->kegiatan->jadwal?->jam_selesai }} WITA</td>
      </tr>
      <tr>
        <td class="lbl">Jumlah Bayar</td>
        <td class="val" style="color:#059669;font-size:15px;">{{ $pembayaran->jumlah_bayar_format }}</td>
      </tr>
      @if($pembayaran->no_kwitansi)
      <tr>
        <td class="lbl">No. Kwitansi</td>
        <td class="val">{{ $pembayaran->no_kwitansi }}</td>
      </tr>
      @endif
    </table>

    <p class="text">Jangan lupa untuk hadir tepat waktu. Tunjukkan QR Code kehadiran kamu saat check-in di lokasi.</p>
    <div style="text-align: center; margin-top: 20px;">
      <a href="{{ config('app.url') }}/peserta/pendaftaran" class="btn">Lihat Detail Kegiatan &rarr;</a>
    </div>
  </div>

  <div class="footer">
    <p>&copy; {{ date('Y') }} FIKOM Certification Center &bull; Universitas Muslim Indonesia Makassar</p>
    <p style="margin-top: 6px; font-size: 11px;">Email ini dikirimkan secara otomatis oleh sistem FCC UMI.</p>
  </div>
</div>
</body>
</html>