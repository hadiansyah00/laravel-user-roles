@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header Dashboard -->
    <div class="mb-4 text-center">
        <h2>{{ __('Dashboard') }}</h2>
        <p class="text-muted">Selamat datang di halaman dashboard</p>
    </div>


<div class="row">
    <!-- Jumlah Mahasiswa -->
    <div class="col-md-6 mb-3">
        <div class="p-4 bg-light rounded shadow-sm text-center">
            <h3 class="mb-2">{{ $jumlahMahasiswa }}</h3>
            <p class="text-muted">Jumlah Mahasiswa</p>
        </div>

</div>

<!-- Jumlah Program Studi -->
<div class="col-md-6 mb-3">
    <div class="p-4 bg-light rounded shadow-sm text-center">
        <h3 class="mb-2">{{ $jumlahProgramStudi }}</h3>
        <p class="text-muted">Jumlah Program Studi</p>
    </div>
</div>
</div>

<!-- Jadwal Terbaru -->
<div class="mb-4">
    <div class="p-4 bg-light rounded shadow-sm">
        <h4 class="mb-3">Jadwal Terbaru</h4>
        @if($jadwal->isEmpty())
        <p class="text-muted">Tidak ada jadwal tersedia.</p>
        @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Tanggal</th>
                    <th>Semester</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwal as $item)
                <tr>
                    <td>{{ $item->matakuliah->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ $item->matakuliah->semester }}</td>
                </tr>
                @endforeach
            </tbody>


        </table>


            @endif


</div>
</div>

<!-- Absensi Terbaru -->
<div class="mb-4">
    <div class="p-4 bg-light rounded shadow-sm">
        <h4 class="mb-3">Absensi Terbaru</h4>
        @if($absensi->isEmpty())
        <p class="text-muted">Tidak ada data absensi.</p>
        @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensi as $item)
                <tr>
                    <td>{{ $item->mahasiswa->name }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif


        </div>
    </div>
</div>
@endsection

