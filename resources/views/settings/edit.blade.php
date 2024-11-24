@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pengaturan Aplikasi</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Aplikasi:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $setting->name }}" required>
        </div>

        <div class="form-group">
            <label for="logo">Logo:</label>
            <input type="file" name="logo" id="logo" class="form-control">
            @if($setting->logo)
                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" width="100">
            @endif
        </div>

        <div class="form-group">
            <label for="favicon">Favicon:</label>
            <input type="file" name="favicon" id="favicon" class="form-control">
            @if($setting->favicon)
                <img src="{{ asset('storage/' . $setting->favicon) }}" alt="Favicon" width="50">
            @endif
        </div>

        <div class="form-group">
            <label for="footer_name">Footer Name:</label>
            <input type="text" name="footer_name" id="footer_name" class="form-control" value="{{ $setting->footer_name }}" required>
        </div>

        <div class="form-group">
            <label for="copyright">Copyright:</label>
            <textarea name="copyright" id="copyright" class="form-control" required>{{ $setting->copyright }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    <br>
    <a href="{{ route('admin.home') }}" class="btn btn-secondary">Kembali ke Beranda</a>
</div>
@endsection
