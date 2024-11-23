@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Laporan Rekap Absensi</h3>
    <form action="{{ route('admin.laporan.generate-pdf') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="jadwal_id" class="form-label">Pilih Mata Kuliah</label>
            <select class="form-select" name="jadwal_id" id="jadwal_id" required>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach ($mataKuliah as $jadwal)
                    <option value="{{ $jadwal->jadwal_id }}">
                        {{ $jadwal->mataKuliah->name }} - Semester {{ $jadwal->mataKuliah->semester }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cetak Laporan PDF</button>
    </form>
</div>
@endsection
