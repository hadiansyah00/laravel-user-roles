@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Program  Studi</h2>
        </div>
        <div class="pull-right">
            @can('program-studi-create')
            <a class="btn btn-success btn-sm mb-2" href="{{ route('program-studi.create') }}"><i class="fa fa-plus"></i> Create Program Studi</a>
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
        <th width="280px">Action</th>
    </tr>
    @foreach ($programStudis as $r)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $r->name }}</td>
        <td>
             <form action="{{ route('program-studi.destroy',$r->program_studi_id) }}" method="POST">
                {{-- <a class="btn btn-info btn-sm" href="{{ route('program-studi.show',$r->id) }}"><i class="fa-solid fa-list"></i> Show</a> --}}
                @can('program-studi-edit')
                <a class="btn btn-primary btn-sm" href="{{ route('program-studi.edit',$r->program_studi_id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                @endcan

                @csrf
                @method('DELETE')

                @can('program-studi-delete')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                @endcan
            </form>
        </td>
    </tr>
    @endforeach
</table>

{!! $programStudis->links() !!}

@endsection
