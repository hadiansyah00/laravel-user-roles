@extends('layouts.mahasiswa')

@section('content')
<h3>Dashboard</h3>
<p>Selamat datang, {{ auth('mahasiswa')->user()->name }}</p>

<h4>Jadwal Kuliah Anda:</h4>
    <ul>
       @foreach($jadwalHariIni as $jadwal)
            <div class="col-md-4 mb-3">
                <div class="card {{ $jadwal->status_absensi == 0 ? 'bg-secondary text-white' : 'bg-success text-white' }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $jadwal->mataKuliah->name }}</h5>
                        <p class="card-text">
                            <strong>Hari:</strong> {{ $jadwal->hari }} <br>
                            <strong>Jam:</strong> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }} <br>
                        </p>

                        @if($jadwal->status_absensi == 0)
                            <p class="text-warning">Absensi Belum dibuka</p>
                        @else
                            <a href="{{ route('mahasiswa.absensi.index', $jadwal->jadwal_id) }}" class="btn btn-primary">Absen</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </ul>
<h5>Statistik Kehadiran</h5>
<ul>
    <li>Hadir: {{ $statistik->hadir ?? 0 }}</li>
    <li>Izin: {{ $statistik->izin ?? 0 }}</li>
    <li>Sakit: {{ $statistik->sakit ?? 0 }}</li>
    <li>Tidak Hadir: {{ $statistik->tidak_hadir ?? 0 }}</li>
</ul>

@endsection
