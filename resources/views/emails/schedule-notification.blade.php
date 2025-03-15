<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        .header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info p {
            margin: 5px 0;
            font-size: 16px;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <p class="header">Kepada Yth. {{ $data['user_name'] }},</p>
        <p>Berikut kami informasikan jadwal {{ $data['exam_type'] }} Anda:</p>

        <div class="info">
            <p><strong>📌 Nama Mahasiswa:</strong> {{ $data['user_name'] }}</p>
            <p><strong>📅 Tanggal:</strong> {{ $data['schedule_date'] }}</p>
            <p><strong>⏰ Waktu:</strong> {{ $data['start_time'] }} - {{ $data['end_time'] }} WIB</p>
            <p><strong>📍 Lokasi:</strong> {{ $data['location'] }}</p>
            <p><strong>👨‍🎓 Ketua Penguji:</strong> {{ $data['master_lecturer'] }}</p>
            <p><strong>👨‍🎓 Penguji 1:</strong> {{ $data['examiner_1_lecturer'] }}</p>
            <p><strong>👨‍🎓 Penguji 2:</strong> {{ $data['examiner_2_lecturer'] }}</p>
            @if ($data['exam_type'] == 'Sidang Skripsi')
                <p><strong>👨‍🎓 Penguji 3:</strong> {{ $data['examiner_3_lecturer'] }}</p>
            @endif
        </div>

        <p>Mohon hadir tepat waktu dan mempersiapkan segala keperluan yang dibutuhkan.</p>

        <p><em>"Percayalah pada dirimu sendiri, kerja keras dan persiapanmu akan membuahkan hasil yang luar biasa! Semangat dan sukses untuk {{ strtolower($data['exam_type']) }}mu!"</em></p>
        
        <p>Terima kasih.<br>
            Salam,<br>
            <strong>Panitia {{ $data['exam_type'] }}</strong>
        </p>
    </div>
</body>

</html>
