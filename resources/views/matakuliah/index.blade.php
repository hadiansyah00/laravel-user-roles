@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Daftar Mata Kuliah</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success btn-sm" href="{{ route('matakuliah.create') }}">
                <i class="fa fa-plus"></i> Tambah Mata Kuliah
            </a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kode</th>
            <th>Semester</th>
            <th>Program Studi</th>
            <th width="200px">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($matakuliah as $key => $mk)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $mk->name }}</td>
                <td>{{ $mk->code }}</td>
                <td>{{ $mk->semester }}</td>
                <td>{{ $mk->programStudi->name }}</td>
                <td>
                    <form action="{{ route('matakuliah.destroy', $mk->matakuliah_id) }}" method="POST">
                        {{-- <a class="btn btn-info btn-sm" href="{{ route('matakuliah.show', $mk->matakuliah_id) }}">
                            <i class="fa fa-eye"></i> Show
                        </a> --}}
                        <a class="btn btn-primary btn-sm" href="{{ route('matakuliah.edit', $mk->matakuliah_id) }}">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Data Mata Kuliah belum tersedia.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {!! $matakuliah->links() !!}
</div>

<p class="text-center text-primary"><small>Absensi Online</small></p>
@endsection
