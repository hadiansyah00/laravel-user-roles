@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Jadwal</h2>
        @can('jadwal-create')
        <a class="btn btn-primary" href="{{ route('admin.jadwal.create') }}">Tambah Jadwal</a>
        @endcan
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Ruangan</th>
                    <th width="200px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwal as $item)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $item->mataKuliah->name ?? '-' }}</td>
                        <td>{{ $item->hari }}</td>
                        <td>{{ $item->jam_mulai }}</td>
                        <td>{{ $item->jam_selesai }}</td>
                        <td>{{ $item->ruangan }}</td>
                        <td>
                            @can('jadwal-edit')
                            <a class="btn btn-warning btn-sm" href="{{ route('admin.jadwal.edit', $item->jadwal_id) }}">Edit</a>
                            @endcan
                            @can('jadwal-delete')
                            <form action="{{ route('admin.jadwal.destroy', $item->jadwal_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">Hapus</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Data jadwal belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $jadwal->links() }}
    </div>
</div>
@endsection
