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


    </style>
</head>
<body>
    <h1>Rekap Absensi</h1>
    <p><strong>Mata Kuliah:</strong> {{ $jadwal->mataKuliah->name }}</p>
    <p><strong>Periode:</strong> {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>


    <table>
        <thead>
            <tr>

                <th>Nama Mahasiswa</th>

                <!-- Header untuk 14 pertemuan -->
                @for ($i = 1; $i <= 14; $i++) <th>P{{ $i }}</th> <!-- P1, P2, ..., P14 -->
                    @endfor
                    </tr>
                    </thead>

        <tbody>
            <!-- Loop untuk setiap mahasiswa -->
            @foreach ($rekapAbsensi as $rekap)
            <tr>

                <td class="text-left">{{ $rekap['nama'] }}</td>
                <!-- Tampilkan status absensi -->
                @foreach ($rekap['absensi'] as $status)
                <td>{{ $status }}</td>
                @endforeach
                </tr>

            @endforeach
        </tbody>

    </table>

</body>
</html>

