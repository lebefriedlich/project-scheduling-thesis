<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            margin: auto;
            text-align: center;
        }

        .header {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .info {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
            text-align: left;
        }

        .info p {
            margin: 8px 0;
            font-size: 16px;
            color: #34495e;
        }

        .highlight {
            font-weight: bold;
            color: #2980b9;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #7f8c8d;
        }

        .quote {
            font-style: italic;
            color: #16a085;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <p class="header">📢 Informasi {{ $data['exam_type'] }} 📢</p>
        <p><strong>Assalamu'alaikum warahmatullahi wabarakatuh.</strong></p>
        <p>Halo, <span class="highlight">{{ $data['user_name'] }}</span>! Berikut jadwal ujian Anda:</p>
        <div class="info">
            <p><strong>🎓 Nama Mahasiswa:</strong> <span class="highlight">{{ $data['user_name'] }}</span></p>
            <p><strong>📅 Tanggal:</strong> <span class="highlight">{{ $data['schedule_date'] }}</span></p>
            <p><strong>⏰ Waktu:</strong> <span class="highlight">{{ $data['start_time'] }} - {{ $data['end_time'] }}
                    WIB</span></p>
            <p><strong>📍 Lokasi:</strong> <span class="highlight">{{ $data['location'] }}</span></p>
            <p><strong>👨‍🏫 Ketua Penguji:</strong> <span class="highlight">{{ $data['master_lecturer'] }}</span></p>
            <p><strong>👨‍🏫 Penguji 1:</strong> <span class="highlight">{{ $data['examiner_1_lecturer'] }}</span></p>
            <p><strong>👨‍🏫 Penguji 2:</strong> <span class="highlight">{{ $data['examiner_2_lecturer'] }}</span></p>
            @if ($data['exam_type'] == 'Sidang Skripsi')
                <p><strong>👨‍🏫 Penguji 3:</strong> <span class="highlight">{{ $data['examiner_3_lecturer'] }}</span>
                </p>
            @endif
        </div>
        <p class="quote">"Percayalah pada dirimu sendiri. Setiap usaha yang telah kamu lakukan akan membuahkan hasil.
            Semangat dan sukses untuk {{ strtolower($data['exam_type']) }}mu!"</p>
        <p>Terima kasih.<br>
        </p>
        <p><strong>Wassalamu'alaikum warahmatullahi wabarakatuh.</strong></p>
    </div>
</body>

</html>
