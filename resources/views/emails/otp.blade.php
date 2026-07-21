<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP Anda</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 40px 0;">
    <table align="center" width="100%" max-width="600" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e2e4eb; margin: auto;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="background-color: #131218; padding: 25px 30px; text-align: center; border-bottom: 3px solid #ffc81a;">
                <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 800;">FIKOM <span style="color: #ffc81a;">FCC</span></h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 40px 30px; text-align: center;">
                @if($type === 'register')
                    <h2 style="color: #131218; margin-top: 0; font-size: 20px;">Verifikasi Email Anda</h2>
                    <p style="color: #6b7280; font-size: 15px; line-height: 1.6; margin-bottom: 25px;">Terima kasih telah mendaftar di FIKOM Certification Center. Gunakan kode OTP 4 digit berikut untuk menyelesaikan pendaftaran Anda:</p>
                @else
                    <h2 style="color: #131218; margin-top: 0; font-size: 20px;">Permintaan Reset Password</h2>
                    <p style="color: #6b7280; font-size: 15px; line-height: 1.6; margin-bottom: 25px;">Kami menerima permintaan untuk mereset kata sandi Anda. Masukkan kode OTP 4 digit berikut untuk melanjutkan:</p>
                @endif

                <div style="background-color: #f8f9fb; border: 2px dashed #ffc81a; padding: 20px; border-radius: 10px; display: inline-block; margin-bottom: 25px;">
                    <span style="font-size: 32px; font-weight: 900; color: #131218; letter-spacing: 6px;">{{ $otp }}</span>
                </div>

                <p style="color: #ef4444; font-size: 13px; margin-top: 0; margin-bottom: 30px;">Kode ini hanya berlaku selama 10 menit. Jangan beritahu kode ini kepada siapa pun.</p>
                
                <p style="color: #9ca3b0; font-size: 13px; margin: 0; line-height: 1.5;">Jika Anda tidak merasa melakukan tindakan ini, abaikan email ini atau hubungi administrator.</p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f7f8fa; padding: 20px 30px; text-align: center; border-top: 1px solid #e2e4eb;">
                <p style="color: #9ca3b0; font-size: 12px; margin: 0;">&copy; {{ date('Y') }} FIKOM Certification Center - Universitas Muslim Indonesia</p>
            </td>
        </tr>
    </table>
</body>
</html>
