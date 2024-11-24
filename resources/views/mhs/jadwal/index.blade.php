@extends('layouts.mahasiswa')

@section('content')
<div class="container">
    <h1 class="my-4">Statistik Kehadiran</h1>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="card-title">Statistik</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Mata Kuliah</th>
                                <th>Total Kehadiran</th>
                                <th>Total Ketidakhadiran</th>
                                <th>Total Pertemuan</th>
                                <th>Persentase Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistikKehadiran as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data->matakuliah }}</td>
                                    <td>{{ $data->total_hadir }}</td>
                                    <td>{{ $data->total_tidak_hadir }}</td>
                                    <td>{{ $data->total_pertemuan }}</td>
                                    <td>
                                        {{ $data->total_pertemuan > 0
                                            ? round(($data->total_hadir / $data->total_pertemuan) * 100, 2)
                                            : 0 }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
