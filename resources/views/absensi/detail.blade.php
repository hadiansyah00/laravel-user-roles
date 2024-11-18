@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Absensi</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Jadwal</h5>
            <p><strong>Mata Kuliah:</strong> {{ $jadwal->mataKuliah->name }}</p>
            <p><strong>Hari:</strong> {{ $jadwal->hari }}</p>
            <p><strong>Jam:</strong> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
        </div>
    </div>

    <h4>Daftar Absensi Mahasiswa</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Mahasiswa</th>
                <th>Status Kehadiran</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($absensi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->mahasiswa->nama }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->tanggal }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data absensi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4 class="mt-5">Riwayat Absensi Mahasiswa</h4>
    @forelse ($riwayat as $mahasiswaId => $records)
        <div class="mb-4">
            <h5>Mahasiswa: {{ $records->first()->mahasiswa->nama }}</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $index => $record)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $record->tanggal }}</td>
                            <td>{{ ucfirst($record->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <p>Belum ada riwayat absensi mahasiswa.</p>
    @endforelse

    <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
