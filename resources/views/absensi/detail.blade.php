@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-light mb-4">
                <div class="card-header">
                    <h3 class="text-center">Detail Absensi</h3>
                    <h4 class="text-center text-muted">{{ $jadwal->mataKuliah->name }} ({{ $jadwal->hari }})</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4 p-3 rounded bg-white shadow-sm">
                        <h5 class="fw-bold">Jadwal Kuliah</h5>
                        <p><strong>Hari:</strong> {{ $jadwal->hari }}</p>
                        <p><strong>Jam:</strong> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
                    </div>

                    <div class="mb-4 p-3 rounded bg-white shadow-sm">
                        <h5 class="fw-bold">Absensi Hari Ini</h5>

                        <!-- Form untuk memilih tanggal -->
                        <form id="filterForm" action="{{ route('admin.absensi.detail', $jadwal->jadwal_id) }}" method="GET">
                            <div class="form-group">
                                <label for="tanggal" class="fw-bold">Pilih Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control"
                                       value="{{ $tanggal }}"
                                       onchange="document.getElementById('filterForm').submit();">
                            </div>
                        </form>
                    </div>

                    <!-- Tabel absensi -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Status Kehadiran</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($absensi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->mahasiswa->name }}</td>
                                        <td>{{ ucfirst($item->status) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                                        <td>
                                            <form action="{{ route('admin.absensi.updateStatus', $item->jadwal_id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-control" required>
                                                    <option value="hadir" {{ $item->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                    <option value="tidak hadir" {{ $item->status == 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                                    <option value="sakit" {{ $item->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data absensi untuk tanggal ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Tombol Tutup/Buka Sesi Absensi -->
                    @if($jadwal->status_absensi == 1)
                        <form action="{{ route('admin.absensi.tutupSesi', $jadwal->jadwal_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Tutup Sesi Absensi</button>
                        </form>
                    @else
                        <div class="alert alert-danger mt-3">
                            Sesi absensi sudah ditutup.
                        </div>
                        <form action="{{ route('admin.absensi.bukaSesi', $jadwal->jadwal_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success mt-3">Buka Sesi Absensi</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>

@endsection
