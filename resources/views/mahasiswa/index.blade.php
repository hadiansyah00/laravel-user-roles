@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Mahasiswa</h2>
        </div>
        <div class="pull-right">
            @can('mahasiswa-create')
            <a class="btn btn-success btn-sm mb-2" href="{{ route('admin.mahasiswa.create') }}"><i class="fa fa-plus"></i> Create Mahasiswa</a>
            @endcan
        </div>
    </div>
</div>

@session('success')
    <div class="alert alert-success" role="alert">
        {{ $value }}
    </div>
@endsession

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>NIM</th>
        <th>Program Studi</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($mahasiswa as $m)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $m->name }}</td>
        <td>{{ $m->email }}</td>
        <td>{{ $m->nim }}</td>
        <td>{{ $m->programStudi->name ?? '-' }}</td>
        <td>
            <form action="{{ route('admin.mahasiswa.destroy', $m->mahasiswa_id) }}" method="POST">
                {{-- <a class="btn btn-info btn-sm" href="{{ route('mahasiswa.show', $m->mahasiswa_id) }}"><i class="fa-solid fa-list"></i> Show</a> --}}
                @can('mahasiswa-edit')
                <a class="btn btn-primary btn-sm" href="{{ route('admin.mahasiswa.edit', $m->mahasiswa_id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                @endcan

                @csrf
                @method('DELETE')

                @can('mahasiswa-delete')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                @endcan
            </form>
        </td>
    </tr>
    @endforeach
</table>

{!! $mahasiswa->links() !!}

@endsection
