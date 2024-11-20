@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="row mb-4">
    <div class="col-lg-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Daftar Mahasiswa</h2>
        @can('mahasiswa-create')
            <a class="btn btn-primary btn-sm" href="{{ route('admin.mahasiswa.create') }}">
                <i class="fa fa-plus"></i> Tambah Mahasiswa
            </a>
        @endcan
    </div>
</div>
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">Import Data Mahasiswa</h5>
    </div>

    <div class="card-body">
        <!-- Import Form -->
        <form action="{{ route('admin.mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- File Upload Section -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <label for="file" class="form-label fw-bold">Upload File Excel</label>
                    <div class="input-group">
                        <input type="file" name="file" id="file" class="form-control" required>
                        <label class="input-group-text" for="file">Choose file</label>
                    </div>
                    <small class="text-muted">Pastikan file berformat .xlsx atau .csv</small>
                </div>
            </div>

            <!-- Submit and Download Buttons on the Same Row -->
            <div class="row">
                <div class="col-md-8">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa fa-upload"></i> Import Mahasiswa
                    </button>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <a href="{{ route('admin.mahasiswa.download-template') }}" class="btn btn-outline-info w-100">
                        <i class="fa fa-download"></i> Download Contoh File
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<div class="table-responsive">
    <table id="mahasiswaTable" class="table table-bordered table-striped dt-responsive nowrap" style="width: 100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>NIM</th>
                <th>Program Studi</th>
                <th width="200px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswa as $key => $m)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $m->name }}</td>
                    <td>{{ $m->email }}</td>
                    <td>{{ $m->nim }}</td>
                    <td>{{ $m->programStudi->name ?? '-' }}</td>
                    <td>
                        <form action="{{ route('admin.mahasiswa.destroy', $m->mahasiswa_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')

                            @can('mahasiswa-edit')
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.mahasiswa.edit', $m->mahasiswa_id) }}">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            @endcan

                            @can('mahasiswa-delete')
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
    {{ $mahasiswa->links('pagination::bootstrap-4') }}
</div>

@endsection
<script>
    $(document).ready(function() {
        $('#mahasiswaTable').DataTable({
            responsive: true
        });
    });
</script>
