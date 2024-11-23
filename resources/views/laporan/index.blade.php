@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Laporan Rekap Absensi</h3>
{{-- Tampilkan error jika ada --}}
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Tampilkan pesan sukses jika ada --}}
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

{{-- Tampilkan form jika data mata kuliah ada --}}
@if ($mataKuliah->isEmpty())
<div class="alert alert-warning">
    Tidak ada mata kuliah yang tersedia untuk dipilih.
</div>
@else

    <form action="{{ route('admin.laporan.generate-pdf') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="jadwal_id" class="form-label">Pilih Mata Kuliah</label>
            <select class="form-select" name="jadwal_id" id="jadwal_id" required>
                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>

                @foreach ($mataKuliah as $jadwal)
                <option value="{{ $jadwal->jadwal_id }}">
                    {{ $jadwal->mataKuliah->name }} - Semester {{ $jadwal->mataKuliah->semester }}
                </option>

                @endforeach
            </select>
        </div>
{{-- Input rentang tanggal --}}
<div class="mb-3">
    <label for="start_date" class="form-label">Tanggal Mulai</label>
    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
</div>
<div class="mb-3">
    <label for="end_date" class="form-label">Tanggal Selesai</label>
    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
</div>

{{-- Tombol submit --}}
<button type="submit" class="btn btn-primary" {{ session('processing') ? 'disabled' : '' }}>
    {{ session('processing') ? 'Sedang Memproses...' : 'Cetak Laporan PDF' }}
</button>

    </form>
    @endif

</div>
@endsection

