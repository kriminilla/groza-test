<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Admin GROZA</title>
    <!-- Google Fonts (Font Family: Saira) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Saira:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Saira', sans-serif;
            background-color: #f5f6fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f5f6fa;
            padding: 30px 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .email-header {
            background-color: #181717;
            padding: 20px;
            text-align: center;
        }
        .email-header img {
            max-height: 60px;
        }
        .email-header h1 {
            color: #ffffff;
            font-size: 20px;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .email-body {
            padding: 30px 40px;
        }
        .email-body h2 {
            color: #ff6600;
            font-size: 20px;
            margin-bottom: 15px;
        }
        .email-body p {
            line-height: 1.6;
            font-size: 15px;
            margin: 10px 0;
        }
        .btn-reset {
            display: inline-block;
            background-color: #ff6600;
            color: #ffffff !important;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin: 20px 0;
        }
        .btn-reset:hover {
            background-color: #ff9966;
        }
        .email-footer {
            background-color: #f1f3f5;
            text-align: center;
            padding: 15px;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            
            <!-- Header -->
            <div class="email-header">
                {{-- Kalau punya logo, bisa aktifkan ini --}}
                {{-- <img src="{{ asset('img/logo-groza.png') }}" alt="GROZA Logo"> --}}
                <h1>GROZA INDONESIA</h1>
            </div>

            <!-- Body -->
            <div class="email-body">
                <h2>Permintaan Reset Password</h2>
                <p>Halo,</p>
                <p>Kami menerima permintaan untuk mereset password akun admin Anda.</p>
                <p>Silakan klik tombol di bawah untuk mengatur ulang password Anda:</p>

                <p style="text-align:center;">
                    <a href="{{ url('/admin/reset-password/' . $token) }}" class="btn-reset">
                        Reset Password
                    </a>
                </p>

                <p>Link ini akan kedaluwarsa dalam waktu tertentu atau setelah digunakan.</p>
                <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>

                <br>
                <p>Terima kasih,</p>
                <p><strong>Tim GROZA INDONESIA</strong></p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                © {{ date('Y') }} GROZA INDONESIA. Semua Hak Dilindungi.
            </div>
        </div>
    </div>
</body>
</html>
