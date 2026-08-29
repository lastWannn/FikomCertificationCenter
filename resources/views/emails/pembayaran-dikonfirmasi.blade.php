<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran Terverifikasi</title>
</head>
<body style="margin: 0; padding: 0; background-color: #F8FAFC; font-family: 'Segoe UI', Arial, sans-serif; -webkit-font-smoothing: antialiased;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #F8FAFC; padding: 30px 15px;">
    <tr>
      <td align="center">
        
        {{-- Main Container Card --}}
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background-color: #FFFFFF; border-radius: 16px; overflow: hidden; border: 1px solid #E2E8F0; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
          
          {{-- Header --}}
          <tr>
            <td style="background-color: #131218; padding: 24px 32px; border-bottom: 3px solid #FFC81A;">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td width="48" style="vertical-align: middle;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background-color: #FFC81A; text-align: center; line-height: 40px;">
                      <span style="font-size: 20px; font-weight: 900; color: #131218;">F</span>
                    </div>
                  </td>
                  <td style="vertical-align: middle; padding-left: 12px;">
                    <div style="font-size: 16px; font-weight: 800; color: #FFFFFF; letter-spacing: 0.3px;">FIKOM CERTIFICATION CENTER</div>
                    <div style="font-size: 10px; font-weight: 700; color: #FFC81A; letter-spacing: 1.5px; text-transform: uppercase; margin-top: 2px;">UNIVERSITAS MUSLIM INDONESIA</div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          {{-- Body Content --}}
          <tr>
            <td style="padding: 32px;">
              
              {{-- Status Banner --}}
              <div style="background-color: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td width="24" style="vertical-align: middle; color: #047857; font-size: 16px; font-weight: 900;">✓</td>
                    <td style="vertical-align: middle; font-size: 13.5px; font-weight: 700; color: #047857;">
                      Status: TERDAFTAR &mdash; Pembayaran Berhasil Terverifikasi
                    </td>
                  </tr>
                </table>
              </div>

              <h2 style="margin: 0 0 12px; font-size: 20px; font-weight: 800; color: #0F172A; letter-spacing: -0.3px;">
                Pembayaran Anda Telah Terverifikasi!
              </h2>

              <p style="margin: 0 0 16px; font-size: 14.5px; color: #334155; line-height: 1.6;">
                Halo <strong>{{ $pembayaran->pendaftaran->peserta->nama }}</strong>,
              </p>

              <p style="margin: 0 0 24px; font-size: 14.5px; color: #475569; line-height: 1.6;">
                Pembayaran Anda telah resmi diverifikasi oleh Tim Pengelola FCC. Anda kini resmi terdaftar sebagai peserta aktif dalam kegiatan ini. Bukti pembayaran resmi terlampir pada email ini.
              </p>

              {{-- Table Details Card --}}
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; margin-bottom: 24px;">
                <tr>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;" width="38%">
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Kegiatan</span>
                  </td>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;" width="62%">
                    <span style="font-size: 13.5px; font-weight: 700; color: #0F172A;">{{ $pembayaran->pendaftaran->kegiatan->judul }}</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;">
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Tgl Pelaksanaan</span>
                  </td>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;">
                    <span style="font-size: 13.5px; font-weight: 700; color: #0F172A;">{{ $pembayaran->pendaftaran->kegiatan->jadwal?->tgl_pelaksanaan?->format('d F Y') ?? 'TBA' }}</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;">
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Waktu</span>
                  </td>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;">
                    <span style="font-size: 13.5px; font-weight: 700; color: #0F172A;">{{ $pembayaran->pendaftaran->kegiatan->jadwal?->jam_mulai }} &ndash; {{ $pembayaran->pendaftaran->kegiatan->jadwal?->jam_selesai }} WITA</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;">
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Jumlah Bayar</span>
                  </td>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;">
                    <span style="font-size: 14px; font-weight: 800; color: #047857;">{{ $pembayaran->jumlah_bayar_format }}</span>
                  </td>
                </tr>
                @if($pembayaran->no_kwitansi)
                <tr>
                  <td style="padding: 14px 18px;">
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">No. Kwitansi</span>
                  </td>
                  <td style="padding: 14px 18px;">
                    <span style="font-size: 13.5px; font-weight: 800; color: #0F172A; font-family: monospace;">{{ $pembayaran->no_kwitansi }}</span>
                  </td>
                </tr>
                @endif
              </table>

              <p style="margin: 0; font-size: 13.5px; color: #64748B; line-height: 1.6;">
                Harap hadir tepat waktu saat sesi kegiatan berlangsung dan tunjukkan QR Code presensi yang ada pada portal peserta saat <em>check-in</em>.
              </p>

            </td>
          </tr>

          {{-- Footer --}}
          <tr>
            <td style="background-color: #F8FAFC; border-top: 1px solid #E2E8F0; padding: 20px 32px; text-align: center;">
              <div style="font-size: 12px; font-weight: 600; color: #64748B; margin-bottom: 4px;">
                &copy; {{ date('Y') }} FIKOM Certification Center &mdash; Universitas Muslim Indonesia
              </div>
              <div style="font-size: 11px; color: #94A3B8;">
                Pesan ini dikirim secara otomatis. Harap tidak membalas email ini.
              </div>
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>