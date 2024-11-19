@extends('layouts.mahasiswa')

@section('content')
<div class="container">
    <h1 class="my-4">Jadwal Kuliah</h1>

    @if($jadwalKuliah->isEmpty())
        <div class="alert alert-info">
            Tidak ada jadwal kuliah yang tersedia.
        </div>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwalKuliah as $key => $jadwal)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $jadwal->hari }}</td>
                        <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                        <td>{{ $jadwal->mataKuliah->name }}</td>
                        <td>{{ $jadwal->user->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
</div>
@endsection
