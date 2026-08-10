<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kode OTP Keamanan</title>
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
            <td style="padding: 36px 32px; text-align: center;">
              
              @if($type === 'register')
                <h2 style="margin: 0 0 12px; font-size: 20px; font-weight: 800; color: #0F172A; letter-spacing: -0.3px;">
                  Verifikasi Alamat Email Anda
                </h2>
                <p style="margin: 0 0 24px; font-size: 14.5px; color: #475569; line-height: 1.6;">
                  Gunakan kode OTP 4-digit di bawah ini untuk menyelesaikan proses pendaftaran akun peserta Anda:
                </p>
              @else
                <h2 style="margin: 0 0 12px; font-size: 20px; font-weight: 800; color: #0F172A; letter-spacing: -0.3px;">
                  Konfirmasi Reset Password
                </h2>
                <p style="margin: 0 0 24px; font-size: 14.5px; color: #475569; line-height: 1.6;">
                  Gunakan kode OTP 4-digit di bawah ini untuk melanjutkan pemulihan kata sandi Anda:
                </p>
              @endif

              {{-- OTP Box --}}
              <div style="background-color: #F8FAFC; border: 2px dashed #CBD5E1; border-radius: 12px; padding: 18px 36px; display: inline-block; margin-bottom: 24px;">
                <span style="font-size: 34px; font-weight: 900; color: #0F172A; font-family: monospace; letter-spacing: 8px;">{{ $otp }}</span>
              </div>

              <div style="background-color: #FFFBEB; border: 1px solid #FDE68A; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px; display: inline-block; max-width: 440px;">
                <div style="font-size: 12.5px; font-weight: 700; color: #B45309;">
                  ⏰ Kode OTP ini berlaku selama 10 menit. Jangan berikan kode ini kepada siapapun.
                </div>
              </div>

              <p style="margin: 0; font-size: 12.5px; color: #94A3B8; line-height: 1.5;">
                Jika Anda tidak merasa meminta kode verifikasi ini, silakan abaikan email ini secara aman.
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
