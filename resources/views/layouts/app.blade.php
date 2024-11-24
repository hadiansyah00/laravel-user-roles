<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title & Favicon -->
    @php
        $settings = \App\Models\Setting::first();
    @endphp
    <title>{{ $settings->name ?? config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ $settings->favicon ? asset('storage/' . $settings->favicon) : asset('default/favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div id="app">
        @auth
        <nav class="navbar navbar-expand-lg navbar-light bg-warning">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('admin.home') }}">
                    @if($settings && $settings->logo)
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" width="50" class="me-2">
                    @endif
                    {{ $settings->name ?? 'Absensi Mahasiswa' }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav text-center">
                         <!-- Manage Users and Roles Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-users"></i> Manage
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users"></i> Manage Users
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.roles.index') }}">
                                <i class="fas fa-user-tag"></i> Manage Role
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cogs"></i> Settings
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="settingsDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.settings.edit') }}">
                                <i class="fas fa-cogs"></i> General Settings
                            </a>
                        </li>
                    </ul>
                </li>

                        <!-- Data Master -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dataMasterDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-database"></i> Data Master
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dataMasterDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.program-studi.index') }}">
                                        <i class="fas fa-school"></i> Program Studi
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.mahasiswa.index') }}">
                                        <i class="fas fa-user-graduate"></i> Mahasiswa
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.matakuliah.index') }}">
                                        <i class="fas fa-book"></i> Matakuliah
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Akademik -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="akademikDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-chalkboard-teacher"></i> Akademik
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="akademikDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.jadwal.index') }}">
                                        <i class="fas fa-calendar-alt"></i> Jadwal Kuliah
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.absensi.index') }}">
                                        <i class="fas fa-check-circle"></i> Absensi
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Laporan Absensi -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                                <i class="fas fa-box"></i> Laporan Absensi
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- User Dropdown -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        @endauth

        <!-- Main Content -->
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-light text-center py-3">
            <small>{{ $settings->footer_name ?? 'Aplikasi Absensi Footer' }}</small>
            <br>
            <small>{!! $settings->copyright ?? '© 2024 Aplikasi Absensi' !!}</small>
        </footer>
    </div>
</body>
</html>
