<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\GuruPamongController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PenempatanController;
use App\Http\Controllers\MahasiswaAbsensiController;
use App\Http\Controllers\MahasiswaLogbookController;
use App\Http\Controllers\MahasiswaProfilController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AdminProfilController;
use App\Http\Controllers\GuruPamongMahasiswaController;
use App\Http\Controllers\GuruPamongLogbookController;
use App\Http\Controllers\GuruPamongProfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruPamongAbsensiController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Khusus Admin GTK
   Route::middleware(['role:admin_gtk'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('sekolah', SekolahController::class);
    Route::resource('guru-pamong', GuruPamongController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::get('/penempatan/export', [PenempatanController::class, 'export'])->name('penempatan.export');
    Route::resource('penempatan', PenempatanController::class);
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/export', [MonitoringController::class, 'export'])->name('monitoring.export');
    Route::get('/monitoring/{penempatan}', [MonitoringController::class, 'show'])->name('monitoring.show');
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::get('/profil', [AdminProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [AdminProfilController::class, 'update'])->name('profil.update');
    });
    
    // Khusus Guru Pamong
  Route::middleware(['role:guru_pamong'])->prefix('guru-pamong')->name('guru-pamong.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'guruPamong'])->name('dashboard');
    Route::get('/mahasiswa', [GuruPamongMahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/logbook', [GuruPamongLogbookController::class, 'index'])->name('logbook.index');
    Route::put('/logbook/{logbook}/approve', [GuruPamongLogbookController::class, 'approve'])->name('logbook.approve');
    Route::put('/logbook/{logbook}/revisi', [GuruPamongLogbookController::class, 'revisi'])->name('logbook.revisi');
    Route::get('/profil', [GuruPamongProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [GuruPamongProfilController::class, 'update'])->name('profil.update');
    Route::get('/absensi/{penempatan}', [GuruPamongAbsensiController::class, 'show'])->name('absensi.show');
    Route::post('/absensi/buka/{penempatan}', [GuruPamongAbsensiController::class, 'buka'])->name('absensi.buka');
    });

    // Khusus Mahasiswa
    Route::middleware(['role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'mahasiswa'])->name('dashboard');
        Route::get('/absensi', [MahasiswaAbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/absensi/create', [MahasiswaAbsensiController::class, 'create'])->name('absensi.create');
        Route::post('/absensi', [MahasiswaAbsensiController::class, 'store'])->name('absensi.store');
        Route::get('/absensi/{absensi}/edit', [MahasiswaAbsensiController::class, 'edit'])->name('absensi.edit');
        Route::put('/absensi/{absensi}', [MahasiswaAbsensiController::class, 'update'])->name('absensi.update');
        Route::get('/logbook', [MahasiswaLogbookController::class, 'index'])->name('logbook.index');
        Route::get('/logbook/create', [MahasiswaLogbookController::class, 'create'])->name('logbook.create');
        Route::post('/logbook', [MahasiswaLogbookController::class, 'store'])->name('logbook.store');
        Route::get('/logbook/{logbook}/edit', [MahasiswaLogbookController::class, 'edit'])->name('logbook.edit');
        Route::put('/logbook/{logbook}', [MahasiswaLogbookController::class, 'update'])->name('logbook.update');
        Route::delete('/logbook/{logbook}', [MahasiswaLogbookController::class, 'destroy'])->name('logbook.destroy');
        Route::get('/profil', [MahasiswaProfilController::class, 'index'])->name('profil.index');
        Route::put('/profil', [MahasiswaProfilController::class, 'update'])->name('profil.update');
    });
});

require __DIR__.'/auth.php';
