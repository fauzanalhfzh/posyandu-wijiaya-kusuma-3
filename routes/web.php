<?php

use App\Http\Controllers\AnakController;
use App\Http\Controllers\IbuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemeriksaanAnakController;
use App\Http\Controllers\PemeriksaanIbuController;

Route::get('/pemeriksaan-anak/{id}/cetak', [PemeriksaanAnakController::class, 'cetakKMS'])->name('pemeriksaan-anak.cetak');
Route::get('/laporan/pemeriksaan-anak', [PemeriksaanAnakController::class, 'cetakLaporan'])->name('laporan.pemeriksaan-anak');

Route::get('/pemeriksaan-ibu/{id}/cetak', [PemeriksaanIbuController::class, 'cetakKartu'])->name('pemeriksaan-ibu.cetak');
Route::get('/laporan/pemeriksaan-ibu', [PemeriksaanIbuController::class, 'cetakLaporan'])->name('laporan.pemeriksaan-ibu');

Route::get('/cetak-pemeriksaan/{id}', [AnakController::class, 'cetak'])->name('cetak.pemeriksaan');
<<<<<<< HEAD
Route::get('/cetak-pemeriksaan/{id}', [IbuController::class, 'cetak'])->name('cetak.pemeriksaan-ibu');
=======
Route::get('/laporan-pemeriksaan-ibu/{id}', [IbuController::class, 'cetak'])->name('laporan-pemeriksaan-ibu');
>>>>>>> 0fbf759737bd40f7413851dda78264887e454d63
