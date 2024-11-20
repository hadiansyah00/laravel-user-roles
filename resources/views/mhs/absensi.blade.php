@extends('layouts.mahasiswa')

@section('content')
<div class="container">
    <h2>Absensi Mata Kuliah: {{ $jadwal->mataKuliah->name }}</h2>
    <p><strong>Hari:</strong> {{ $jadwal->hari }} | <strong>Jam:</strong> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>

    <form action="{{ route('mahasiswa.absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="jadwal_id" value="{{ $jadwal->jadwal_id }}">
        <input type="hidden" name="mahasiswa_id" value="{{ $mahasiswa->mahasiswa_id }}">

        <div class="mb-3">
            <label for="status" class="form-label">Pilih Status Kehadiran</label>
            <select class="form-select" name="status" id="status" required>
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="tidak hadir">Tidak Hadir</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Absensi</button>
    </form>

    <hr>

   <h3>Riwayat Absensi</h3>
@if($riwayatAbsensi->isEmpty())
    <p>Belum ada data absensi.</p>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayatAbsensi as $index => $absen)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mahasiswa->name }}</td>
                    <td>{{ ucfirst($absen->status) }}</td>
                    <td>{{ $absen->keterangan ?? 'Tidak ada' }}</td>
                    <td>{{ $absen->created_at->translatedFormat('l, d F Y H:i') }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</div>
@endsection
