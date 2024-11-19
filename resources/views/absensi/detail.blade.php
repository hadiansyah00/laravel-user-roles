@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Detail Absensi - {{ $jadwal->mataKuliah->name }} ({{ $jadwal->hari }})</h3>
                    </div>
                    <div class="card-body">
                        <h4>Jadwal Kuliah</h4>
                        <p>Hari: {{ $jadwal->hari }}</p>
                        <p>Jam: {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>

                        <h4>Absensi Hari Ini</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Status Kehadiran</th>
                                    <th>Tanggal</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($absensi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->mahasiswa->name }}</td>
                                        <td>{{ ucfirst($item->status) }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                         <td>
                                            <form action="{{ route('admin.absensi.updateStatus', $item->absensi_id) }}" method="POST">
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
                                        <td colspan="4" class="text-center">Belum ada data absensi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>


                        {{-- Tombol Tutup Sesi Absensi --}}
                        @if($jadwal->status_absensi == 1)  <!-- Jika status absensi masih aktif -->
                            <form action="{{ route('admin.absensi.tutupSesi', $jadwal->jadwal_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Tutup Sesi Absensi</button>
                            </form>
                        @else
                            <div class="alert alert-danger mt-3">
                                Sesi absensi sudah ditutup.
                            </div>
                            {{-- Tombol Buka Sesi Absensi --}}
                            <form action="{{ route('admin.absensi.bukaSesi', $jadwal->jadwal_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success mt-3">Buka Sesi Absensi</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>


    <h4 class="mt-5">Riwayat Absensi Mahasiswa</h4>
    @forelse ($riwayat as $mahasiswaId => $records)
        <div class="mb-4">
            <h5>Mahasiswa: {{ $records->first()->mahasiswa->nama }}</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $index => $record)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $record->tanggal }}</td>
                            <td>{{ ucfirst($record->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <p>Belum ada riwayat absensi mahasiswa.</p>
    @endforelse

    <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
