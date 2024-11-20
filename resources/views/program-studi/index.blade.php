@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-lg-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Daftar Program Studi</h2>
        @can('program-studi-create')
        <a class="btn btn-success btn-sm" href="{{ route('admin.program-studi.create') }}">
            <i class="fa fa-plus"></i> Tambah Program Studi
        </a>
        @endcan
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th width="200px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($programStudis as $key => $r)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $r->name }}</td>
                    <td>
                        <form action="{{ route('admin.program-studi.destroy',$r->program_studi_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')

                            @can('program-studi-edit')
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.program-studi.edit',$r->program_studi_id) }}">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            @endcan

                            @can('program-studi-delete')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                            @endcan
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    {!! $programStudis->links() !!}
</div>

@endsection
