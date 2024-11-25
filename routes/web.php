<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\Mahasiswa\ProfileController;
use App\Http\Controllers\Auth\MahasiswaLoginController;
use App\Http\Controllers\Mahasiswa\DashboardController;
use App\Http\Controllers\Mahasiswa\JadwalKuliahController;


// Default route menuju ke login mahasiswa
Route::redirect('/', '/mahasiswa/login');

// Routes untuk login mahasiswa

Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    // Rute untuk login dan logout mahasiswa
    Route::get('login', [MahasiswaLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [MahasiswaLoginController::class, 'login']);
    Route::post('logout', [MahasiswaLoginController::class, 'logout'])->name('logout');

    // Rute yang dilindungi oleh middleware auth mahasiswa
    Route::middleware('auth:mahasiswa')->group(function () {
        // Dashboard mahasiswa
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profil mahasiswa
        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');


        // Jadwal mahasiswa
        Route::get('jadwal', [JadwalKuliahController::class, 'index'])->name('jadwal.index');

        //Absensi
        Route::get('jadwal/{jadwalId}/absensi', [App\Http\Controllers\Mahasiswa\AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('absensi', [App\Http\Controllers\Mahasiswa\AbsensiController::class, 'store'])->name('absensi.store');
    });
});
Route::prefix('admin')->name('admin.')->group(function () {
    // Form login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

    // Proses login
    Route::post('login', [LoginController::class, 'login']);

    // Proses logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Routes yang memerlukan autentikasi
    Route::middleware('auth')->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        //Setingan

        Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Resource controllers
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::resource('program-studi', ProgramStudiController::class);
        Route::resource('mahasiswa', MahasiswaController::class);
        Route::resource('matakuliah', MatakuliahController::class);
        Route::resource('jadwal', JadwalController::class);
        Route::resource('absensi', AbsensiController::class);
        Route::post('absensi/tutup/{jadwalId}', [AbsensiController::class, 'tutupSesiAbsensi'])->name('absensi.tutupSesi');
        Route::get('rekap-absensi/{jadwalId}', [AbsensiController::class, 'rekapAbsensi'])->name('rekap.absensi');

        // Tambahan route untuk absensi
        Route::get(
            'absensi/{jadwalId}/detail',
            [AbsensiController::class, 'detail']
        )->name('absensi.detail');
        Route::get('absensi/open/{jadwalId}', [AbsensiController::class, 'openAbsensi'])->name('absensi.open');
        Route::get('absensi/close/{jadwalId}', [AbsensiController::class, 'closeAbsensi'])->name('absensi.close');
        Route::post('absensi/tutup/{jadwalId}', [AbsensiController::class, 'tutupSesiAbsensi'])->name('absensi.tutupSesi');
        Route::post('absensi/buka/{jadwalId}', [AbsensiController::class, 'bukaSesiAbsensi'])->name('absensi.bukaSesi');
        Route::put('absensi/update/{absensiId}', [AbsensiController::class, 'updateStatus'])->name('absensi.updateStatus');
        Route::get('absensi/riwayat', [AbsensiController::class, 'riwayat'])->name('absensi.riwayat');
        Route::get('absensi/detail/{jadwal_id}', [AbsensiController::class, 'show'])->name('admin.absensi.show');
        Route::get('/mahasiswa/data', [MahasiswaController::class, 'getMahasiswa'])->name('mahasiswa.data');


        //Import ke Excel

        Route::post('/admin/mahasiswa/import', [MahasiswaController::class, 'importExcel'])->name('mahasiswa.import');
        Route::get('/admin/mahasiswa/template', [MahasiswaController::class, 'downloadTemplate'])
        ->name('mahasiswa.download-template');


        //Laporan PDF
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan/generate-pdf', [LaporanController::class, 'generatePDF'])->name('laporan.generate-pdf');

    });
});