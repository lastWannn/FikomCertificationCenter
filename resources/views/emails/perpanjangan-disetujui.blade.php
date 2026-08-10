<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpanjangan Waktu Disetujui</title>
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
                      Perpanjangan Disetujui &mdash; Batas Waktu Baru +2 Jam
                    </td>
                  </tr>
                </table>
              </div>

              <h2 style="margin: 0 0 12px; font-size: 20px; font-weight: 800; color: #0F172A; letter-spacing: -0.3px;">
                Permintaan Perpanjangan Waktu Disetujui
              </h2>

              <p style="margin: 0 0 16px; font-size: 14.5px; color: #334155; line-height: 1.6;">
                Halo <strong>{{ $pembayaran->pendaftaran->peserta->nama }}</strong>,
              </p>

              <p style="margin: 0 0 24px; font-size: 14.5px; color: #475569; line-height: 1.6;">
                Permintaan perpanjangan waktu pembayaran Anda telah <strong>disetujui</strong> oleh Admin FCC. Silakan selesaikan pembayaran sebelum batas waktu baru berakhir.
              </p>

              {{-- Table Details Card --}}
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; margin-bottom: 24px;">
                <tr>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;" width="35%">
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Kegiatan</span>
                  </td>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;" width="65%">
                    <span style="font-size: 13.5px; font-weight: 700; color: #0F172A;">{{ $pembayaran->pendaftaran->kegiatan->judul }}</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;">
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Kode Bayar</span>
                  </td>
                  <td style="padding: 14px 18px; border-bottom: 1px solid #E2E8F0;">
                    <span style="font-size: 13.5px; font-weight: 800; color: #0F172A; font-family: monospace;">{{ $pembayaran->kode_pembayaran }}</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 14px 18px;">
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px;">Batas Baru</span>
                  </td>
                  <td style="padding: 14px 18px;">
                    <span style="font-size: 13.5px; font-weight: 800; color: #B45309;">{{ $pembayaran->tgl_kadaluarsa?->format('d M Y, H:i') }} WITA</span>
                  </td>
                </tr>
              </table>

              @if($pembayaran->kode_unik)
              {{-- Transfer Amount Box --}}
              <div style="background-color: #131218; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 24px;">
                <div style="font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">
                  Total Transfer (Termasuk Kode Unik)
                </div>
                <div style="font-size: 24px; font-weight: 900; color: #FFC81A; font-family: monospace; letter-spacing: 1px;">
                  {{ $pembayaran->nominal_transfer_format }}
                </div>
                <div style="font-size: 11px; color: #94A3B8; margin-top: 6px;">
                  Pokok: {{ $pembayaran->jumlah_bayar_format }} + Kode Unik: {{ $pembayaran->kode_unik }}
                </div>
              </div>
              @endif

              {{-- CTA Button --}}
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td align="center" style="padding-top: 8px;">
                    <a href="{{ config('app.url') }}/peserta/pembayaran" target="_blank" style="display: inline-block; background-color: #131218; color: #FFC81A; font-size: 14px; font-weight: 800; text-decoration: none; padding: 14px 32px; border-radius: 10px; border: 1px solid #131218;">
                      Selesaikan Pembayaran Sekarang &rarr;
                    </a>
                  </td>
                </tr>
              </table>

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