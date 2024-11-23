<!DOCTYPE html>
<html>
<head>
    <title>Rekap Absensi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Rekap Absensi</h1>
    <p><strong>Mata Kuliah:</strong> {{ $jadwal->mataKuliah->nama }}</p>
    <p><strong>Jadwal:</strong> {{ $jadwal->hari }} {{ $jadwal->jam }}</p>

   <table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Mahasiswa</th>
            @for ($i = 1; $i <= 14; $i++) <!-- Kolom untuk 14 pertemuan -->
                <th>{{ $i }}</th>
            @endfor
        </tr>
    </thead>
    @if (!empty($mahasiswa) && $mahasiswa->count())
        <tbody>
            @foreach ($mahasiswa as $index => $mhs)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mhs->name }}</td>
                    @for ($i = 1; $i <= 14; $i++) <!-- Iterasi untuk setiap pertemuan -->
                        <td>
                            @php
                                // Ambil data absensi untuk mahasiswa saat ini
                                $absensiMahasiswa = $rekapAbsensi[$mhs->mahasiswa_id] ?? null;
                                // Ambil status absensi untuk pertemuan saat ini
                                $statusAbsensi = $absensiMahasiswa?->where('status', $i)->first();
                            @endphp
                            @if ($statusAbsensi)
                                @if ($statusAbsensi->status == 'hadir')
                                    H
                                @elseif ($statusAbsensi->status == 'tidak hadir')
                                    A
                                @elseif ($statusAbsensi->status == 'izin')
                                    I
                                @elseif ($statusAbsensi->status == 'sakit')
                                    S
                                @else
                                    -
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    @else
        <tbody>
            <tr>
                <td colspan="16" class="text-center">Data tidak tersedia.</td>
            </tr>
        </tbody>
    @endif
</table>

</body>
</html>
