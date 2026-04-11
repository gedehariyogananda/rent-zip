<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Verifikasi Login</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f7f4; padding: 20px; color: #333;">

    <div style="max-w: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <div style="text-center; margin-bottom: 20px;">
            <h1 style="color: #4a6741; margin: 0;">Noctoriagorasrent</h1>
        </div>

        <p>Halo <b>{{ $user->username }}</b>,</p>

        <p>Anda menerima email ini karena ada permintaan login ke akun Anda. Berikut adalah kode OTP (One-Time Password) Anda:</p>

        <div style="text-align: center; margin: 30px 0;">
            <span style="display: inline-block; background-color: #e2e8d3; color: #2c3e26; font-size: 32px; font-weight: bold; letter-spacing: 5px; padding: 15px 30px; border-radius: 8px;">
                {{ $otp }}
            </span>
        </div>

        <p style="color: #e53e3e; font-size: 14px;"><i>*Kode ini hanya berlaku selama 5 menit. Jangan berikan kode ini kepada siapapun!</i></p>

        <p>Jika Anda tidak merasa melakukan permintaan login ini, abaikan saja email ini.</p>

        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; font-size: 12px; color: #888;">
            <p>&copy; {{ date('Y') }} Noctoriagorasrent. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
