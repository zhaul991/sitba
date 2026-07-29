<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BandaraController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\InspeksiController;
use App\Http\Controllers\PemantauanController;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\TindakLanjutController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\FotoTemuanController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\HasilPengawasanController;
use App\Http\Controllers\WarningCenterController;


Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Dashboard & Monitoring
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'verified',
    'role:admin,inspektur,pimpinan'
])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    Route::get('/search', GlobalSearchController::class)
        ->name('search');


    Route::get('/aktivitas', [ActivityLogController::class, 'index'])
        ->name('aktivitas.index');


    Route::get(
        '/warning-center',
        [WarningCenterController::class, 'index']
    )->name('warning-center.index');


    /*
    |--------------------------------------------------------------------------
    | Pimpinan bisa melihat temuan
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/temuan',
        [TemuanController::class, 'index']
    )->name('temuan.index');


    Route::get(
        '/temuan/{temuan}',
        [TemuanController::class, 'show']
    )->name('temuan.show');


    Route::get(
        '/hasil-pengawasan/pemantauan',
        [HasilPengawasanController::class, 'index']
    )
        ->defaults('jenis', 'pemantauan')
        ->name('hasil-pengawasan.pemantauan');


    Route::get(
        '/hasil-pengawasan/pengamatan',
        [HasilPengawasanController::class, 'index']
    )
        ->defaults('jenis', 'pengamatan')
        ->name('hasil-pengawasan.pengamatan');


    Route::get(
        '/hasil-pengawasan/audit',
        [HasilPengawasanController::class, 'index']
    )
        ->defaults('jenis', 'audit')
        ->name('hasil-pengawasan.audit');



    Route::get(
        '/laporan',
        [LaporanController::class, 'index']
    )->name('laporan.index');


    Route::get(
        '/laporan/{laporan}',
        [LaporanController::class, 'show']
    )->name('laporan.show');

});


/*
|--------------------------------------------------------------------------
| Operator
|--------------------------------------------------------------------------
| Admin dan Inspektur
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'verified',
    'role:admin,inspektur'
])->group(function () {


    Route::resource('bandara', BandaraController::class);


    Route::resource('petugas', PetugasController::class);


    Route::resource('inspeksi', InspeksiController::class);


    Route::resource('pemantauan', PemantauanController::class)
        ->parameters([
            'pemantauan' => 'inspeksi',
        ]);


    Route::resource('temuan', TemuanController::class)
        ->except([
            'index',
            'show'
        ]);


    Route::post(
        '/temuan/{temuan}/close',
        [TemuanController::class, 'close']
    )->name('temuan.close');


    Route::get(
        '/api/inspeksi/tahun/{bandara}',
        [TemuanController::class, 'getTahunInspeksi']
    );


    Route::get(
        '/api/inspeksi/bulan/{bandara}/{tahun}',
        [TemuanController::class, 'getBulanInspeksi']
    );


    Route::get(
        '/api/inspeksi/list/{bandara}/{tahun}/{bulan}',
        [TemuanController::class, 'getListInspeksi']
    );


    Route::get(
        '/laporan/temuan-by-bandara/{bandara}',
        [LaporanController::class, 'temuanByBandara']
    )->name('laporan.temuan-by-bandara');




    Route::post(
        '/laporan',
        [LaporanController::class, 'store']
    )->name('laporan.store');


    Route::get(
        '/laporan/create',
        [LaporanController::class, 'create']
    )->name('laporan.create');


    Route::get(
        '/laporan/{laporan}/edit',
        [LaporanController::class, 'edit']
    )->name('laporan.edit');


    Route::put(
        '/laporan/{laporan}',
        [LaporanController::class, 'update']
    )->name('laporan.update');


    Route::delete(
        '/laporan/{laporan}',
        [LaporanController::class, 'destroy']
    )->name('laporan.destroy');


    Route::get(
        '/tindaklanjut/create',
        [TindakLanjutController::class, 'create']
    )->name('tindaklanjut.create');


    Route::post(
        '/tindaklanjut',
        [TindakLanjutController::class, 'store']
    )->name('tindaklanjut.store');


    Route::get(
        '/tindaklanjut/{tindakLanjut}/edit',
        [TindakLanjutController::class, 'edit']
    )->name('tindaklanjut.edit');


    Route::put(
        '/tindaklanjut/{tindakLanjut}',
        [TindakLanjutController::class, 'update']
    )->name('tindaklanjut.update');


    Route::delete(
        '/tindaklanjut/{tindakLanjut}',
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
        '/fototemuan/{fotoTemuan}',
        [FotoTemuanController::class, 'destroy']
    )->name('fototemuan.destroy');


    Route::view('/pengamatan', 'coming-soon', [
        'judul' => 'Pengamatan',
        'ikon' => '🔎',
        'deskripsi' => 'Modul Pengamatan sedang dalam tahap pengembangan.',
    ])->name('pengamatan.index');


    Route::view('/audit', 'coming-soon', [
        'judul' => 'Audit',
        'ikon' => '📝',
        'deskripsi' => 'Modul Audit sedang dalam tahap pengembangan.',
    ])->name('audit.index');

});


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');


    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Draft Center
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'verified',
    'role:admin,inspektur'
])->group(function () {


    Route::get('/draft', [DraftController::class, 'index'])
        ->name('draft.index');


    Route::get('/draft/create', [DraftController::class, 'create'])
        ->name('draft.create')
        ->middleware('role:admin');


    Route::post('/draft', [DraftController::class, 'store'])
        ->name('draft.store')
        ->middleware('role:admin');


    Route::get('/draft/{draft}/preview', [DraftController::class, 'preview'])
        ->name('draft.preview');


    Route::get('/draft/{draft}/download', [DraftController::class, 'download'])
        ->name('draft.download');


    Route::delete('/draft/{draft}', [DraftController::class, 'destroy'])
        ->name('draft.destroy')
        ->middleware('role:admin');

});

