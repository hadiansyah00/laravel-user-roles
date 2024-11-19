@extends('layouts.mahasiswa')

@section('content')
<div class="container">
    <h2>Absensi Mata Kuliah: {{ $jadwal->mataKuliah->name }}</h2>
    <p><strong>Hari:</strong> {{ $jadwal->hari }} | <strong>Jam:</strong> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>

    <form action="{{ route('mahasiswa.absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="jadwal_id" value="{{ $jadwal->jadwal_id }}">
        <input type="hidden" name="mahasiswa_id" value="{{ $mahasiswa->mahasiswa_id }}">

        @if($absensi)
            <p>Status Absensi: <strong>{{ ucfirst($absensi->status) }}</strong></p>
            <p>Keterangan: {{ $absensi->keterangan }}</p>
        @else
            <div class="mb-3">
                <label for="status" class="form-label">Pilih Status Kehadiran</label>
                <select class="form-select" name="status" id="status" required>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="tidak hadir">Tidak Hadir</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Kirim Absensi</button>
        @endif
    </form>
</div>
@endsection
