@extends('layouts.mahasiswa')

@section('content')
<div class="container">


    <h3>Dashboard</h3>
    <p>Selamat datang, {{ auth('mahasiswa')->user()->name }}</p>


{{-- Tanggal dan Jam Sekarang --}}
<div class="alert alert-info">
    <strong>Tanggal:</strong> {{ now()->format('l, d F Y') }} <br>
    <strong>Jam:</strong> <span id="current-time">{{ now()->format('H:i:s') }}</span>
</div>


 <h4>Jadwal Kuliah Anda:</h4>

<div class="row">
    @foreach($jadwalHariIni as $jadwal)
    <div class="col-md-4 mb-3">
        <div class="card {{ $jadwal->status_absensi == 0 ? 'bg-secondary text-white' : 'bg-success text-white' }}">
            <div class="card-body">
                <h5 class="card-title">{{ $jadwal->mataKuliah->name }}</h5>
                <p class="card-text">
                    <strong>Hari:</strong> {{ $jadwal->hari }} <br>

<strong>Jam:</strong> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
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

</div>
</div>


{{-- Script untuk Jam Real-Time --}}
<script>
    setInterval(() => {
        const currentTimeElement = document.getElementById('current-time');
        const now = new Date();
        currentTimeElement.textContent = now.toLocaleTimeString();
    }, 1000);

</script>



@endsection

