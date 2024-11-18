<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\Auth\MahasiswaLoginController;
use App\Http\Controllers\Auth\LoginController;


// Default route menuju ke login mahasiswa
Route::redirect('/', '/mahasiswa/login');

// Routes untuk login mahasiswa
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('login', [MahasiswaLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [MahasiswaLoginController::class, 'login']);
    Route::post('logout', [MahasiswaLoginController::class, 'logout'])->name('logout');

    // Rute yang dilindungi oleh middleware auth mahasiswa
    Route::middleware('auth:mahasiswa')->group(function () {
        Route::get('dashboard', function () {
            return view('mhs.dashboard'); // View untuk dashboard mahasiswa
        })->name('dashboard');
    });
});


Route::name('admin.')->group(function () {
    // Form login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

    // Proses login
    Route::post('login', [LoginController::class, 'login']);

    // Proses logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Routes yang memerlukan autentikasi
    Route::middleware('auth')->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        // Resource controllers
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::resource('program-studi', ProgramStudiController::class);
        Route::resource('mahasiswa', MahasiswaController::class);
        Route::resource('matakuliah', MatakuliahController::class);
        Route::resource('jadwal', JadwalController::class);
        Route::resource('absensi', AbsensiController::class);

        // Tambahan route untuk absensi
        Route::get(
            'absensi/{jadwalId}/detail',
            [AbsensiController::class, 'detail']
        )->name('absensi.detail');
        Route::get('absensi/open/{jadwalId}', [AbsensiController::class, 'openAbsensi'])->name('absensi.open');
        Route::get('absensi/close/{jadwalId}', [AbsensiController::class, 'closeAbsensi'])->name('absensi.close');
    });
});