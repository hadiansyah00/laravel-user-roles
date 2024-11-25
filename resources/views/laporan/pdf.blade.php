<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekap Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            display: flex;
            align-items: center; /* Membuat logo dan teks sejajar vertikal */
            justify-content: space-between; /* Membuat logo dan teks menjauh satu sama lain */
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header .logo {
            width: 80px; /* Ukuran logo */
        }

        .header .text {
            text-align: right; /* Rata kanan untuk teks header */
            flex: 1; /* Membuat elemen teks fleksibel */
        }

        .header .text h1 {
            margin: 0;
            font-size: 1.2em; /* Ukuran teks judul utama */
        }

        .header .text h2 {
            margin: 0;
            font-size: 1em; /* Ukuran teks subjudul */
            color: #555; /* Warna abu-abu */
        }

        hr {
            margin: 20px 0;
        }

        .content p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
         .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.8em;
        }

        .footer img {
            margin-top: 10px;
            width: 100px; /* Atur ukuran barcode */
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Logo -->
        @if($logoBase64)
            <img src="data:image/png;base64,{{ $logoBase64 }}" alt="Logo" class="logo">
        @endif

        <!-- Teks Header -->
        <div class="text">
            <h1>Laporan Rekap Absensi</h1>
            <h2>{{ $settings ? $settings->name : 'Nama Aplikasi' }}</h2>
        </div>
    </div>

    <div class="content">
        <p><strong>Mata Kuliah:</strong> {{ $jadwal->mataKuliah->name }}</p>
        <p><strong>Periode:</strong> {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
        <p><strong>Total Pertemuan:</strong> {{ $totalPertemuan }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Mahasiswa</th>
                @for ($i = 1; $i <= $totalPertemuan; $i++)
                    <th>P{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($rekapAbsensi as $row)
                <tr>
                    <td>{{ $row['nama'] }}</td>
                    @foreach ($row['absensi'] as $status)
                        <td>{{ $status }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <!-- Copyright -->
        <p>&copy; {{ date('Y') }} {{ $settings ? $settings->footer_name : 'Nama Aplikasi' }}.
           {{ $settings ? $settings->copyright : 'All rights reserved.' }}
        </p>

        <!-- QR Code -->
        @if(!empty($qrCodePath))
            <img src="{{ $qrCodePath }}" alt="QR Code">
        @endif
    </div>
</body>
</html>
