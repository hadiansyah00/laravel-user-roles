<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rekap Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-left {
            text-align: left;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .logo {
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="header">
        <!-- Logo dan Nama Website -->
        @if($settings && $settings->logo)
            <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" class="logo">
        @endif
        <h1>{{ $settings ? $settings->name : 'Nama Aplikasi' }}</h1>
    </div>

    <p><strong>Mata Kuliah:</strong> {{ $jadwal->mataKuliah->name }}</p>
    <p><strong>Periode:</strong> {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>

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
            @foreach ($rekapAbsensi as $rekap)
                <tr>
                    <td>{{ $rekap['nama'] }}</td>
                    @foreach ($rekap['absensi'] as $status)
                        <td>{{ $status }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <!-- Copyright -->
        <p>&copy; {{ date('Y') }} {{ $settings ? $settings->footer_name : 'Nama Aplikasi' }}. {{ $settings ? $settings->copyright : 'All rights reserved.' }}</p>
    </div>
</body>

</html>
