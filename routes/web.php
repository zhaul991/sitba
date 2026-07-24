<?php

use App\Http\Controllers\LaporanController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BandaraController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\InspeksiController;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\FotoTemuanController;
use App\Http\Controllers\TindakLanjutController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('bandara', BandaraController::class);

    Route::resource('petugas', PetugasController::class);

    Route::resource('inspeksi', InspeksiController::class);
    Route::resource('temuan', TemuanController::class);

    Route::resource('laporan', LaporanController::class);

    Route::get(
        '/tindaklanjut/create',
        [TindakLanjutController::class, 'create']
    )->name('tindaklanjut.create');

    Route::post(
        '/tindaklanjut',
        [TindakLanjutController::class, 'store']
    )->name('tindaklanjut.store');

    Route::get(
        '/tindaklanjut/{tindaklanjut}/edit',
        [TindakLanjutController::class, 'edit']
    )->name('tindaklanjut.edit');

    Route::put(
        '/tindaklanjut/{tindaklanjut}',
        [TindakLanjutController::class, 'update']
    )->name('tindaklanjut.update');

    Route::delete(
        '/tindaklanjut/{tindaklanjut}',
        [TindakLanjutController::class, 'destroy']
    )->name('tindaklanjut.destroy');


    Route::get(
        '/fototemuan/create',
        [FotoTemuanController::class, 'create']
    )->name('fototemuan.create');

    Route::post(
        '/fototemuan',
        [FotoTemuanController::class, 'store']
    )->name('fototemuan.store');

    Route::delete(
        '/fototemuan/{fototemuan}',
        [FotoTemuanController::class, 'destroy']
    )->name('fototemuan.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
