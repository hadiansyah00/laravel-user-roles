<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body>
    <div id="app">
        @auth
      <nav class="navbar navbar-expand-lg navbar-light bg-warning">
    <div class="container">
          <a class="navbar-brand" href="#">
                    <i class="fas fa-graduation-cap"></i> Absensi Mahasiswa
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav text-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i> Manage Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.roles.index') }}">
                            <i class="fas fa-user-tag"></i> Manage Role
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dataMasterDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-database"></i> Data Master
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dataMasterDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.program-studi.index') }}"><i class="fas fa-school"></i> Program Studi</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.mahasiswa.index') }}"><i class="fas fa-user-graduate"></i> Mahasiswa</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.matakuliah.index') }}"><i class="fas fa-book"></i> Matakuliah</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="akademikDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-chalkboard-teacher"></i> Akademik
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="akademikDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.jadwal.index') }}"><i class="fas fa-calendar-alt"></i> Jadwal Kuliah</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.absensi.index') }}"><i class="fab fa-times-circle"></i> Absensi</a></li>
                        </ul>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                            <i class="fas fa-box"></i> Laporan Absensi
                        </a>
                    </li>
                </ul>
            </div>
        <ul class="navbar-nav ms-auto">

        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="fas fa-user"></i> {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    @endauth
</ul>

    </div>
</nav>


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

    </div>


</body>
</html>
