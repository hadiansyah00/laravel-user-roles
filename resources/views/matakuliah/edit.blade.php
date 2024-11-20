@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Mata Kuliah</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm" href="{{ route('admin.matakuliah.index') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.matakuliah.update', $matakuliah->matakuliah_id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Mata Kuliah Name -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nama Mata Kuliah:</strong>
                <input type="text" name="name" class="form-control" value="{{ $matakuliah->name }}" placeholder="Nama Mata Kuliah" required>
            </div>
        </div>

        <!-- Mata Kuliah Code -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Kode Mata Kuliah:</strong>
                <input type="text" name="code" class="form-control" value="{{ $matakuliah->code }}" placeholder="Kode Mata Kuliah" required>
            </div>
        </div>

        <!-- Semester -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Semester:</strong>
                <input type="number" name="semester" class="form-control" value="{{ $matakuliah->semester }}" placeholder="Semester" min="1" required>
            </div>
        </div>

        <!-- Program Studi -->
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Program Studi:</strong>
                <select name="program_studi_id" class="form-control" required>
                    <option value="">-- Pilih Program Studi --</option>
                    @foreach ($programStudi as $prodi)
                        <option value="{{ $prodi->program_studi_id }}" {{ $matakuliah->program_studi_id == $prodi->program_studi_id ? 'selected' : '' }}>
                            {{ $prodi->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mb-3 mt-2">
                <i class="fa-solid fa-floppy-disk"></i> Update
            </button>
        </div>
    </div>
</form>

<p class="text-center text-primary"><small>Absensi Online</small></p>
@endsection
