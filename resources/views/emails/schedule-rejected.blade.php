<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            text-align: center;
        }

        .header {
            font-size: 22px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .reason {
            background: #fdecea;
            padding: 20px;
            border-radius: 8px;
            color: #c0392b;
            text-align: left;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <div class="container">
        <p class="header">❌ Pengajuan Jadwal Ditolak ❌</p>
        <p>Assalamu'alaikum warahmatullahi wabarakatuh,</p>
        <p>Halo, <strong>{{ $data['user_name'] }}</strong>. Mohon maaf, pengajuan jadwal untuk <strong>{{ $data['exam_type'] }}</strong> Anda telah <strong>ditolak</strong>.</p>
        <div class="reason">
            <p><strong>Alasan Penolakan:</strong></p>
            <p>{{ $data['rejection_reason'] }}</p>
        </div>
        <p class="footer">
            Silakan periksa kembali pengajuan Anda dan ajukan ulang sesuai dengan ketentuan yang berlaku.<br>
            Terima kasih.
        </p>
        <p><strong>Wassalamu'alaikum warahmatullahi wabarakatuh.</strong></p>
    </div>
</body>

</html>
