@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Login Pengguna</h4>
                </div>
                <div class="card-body">
                    <!-- Form Login -->
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                id="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="Masukkan email Anda">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                id="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                required
                                placeholder="Masukkan password Anda">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>

                        <!-- Forgot Password Link -->

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
