<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemeriksaanAnakController;
use App\Http\Controllers\PemeriksaanIbuController;

Route::get('/pemeriksaan-anak/{id}/cetak', [PemeriksaanAnakController::class, 'cetakKMS'])->name('pemeriksaan-anak.cetak');
Route::get('/laporan/pemeriksaan-anak', [PemeriksaanAnakController::class, 'cetakLaporan'])->name('laporan.pemeriksaan-anak');

Route::get('/pemeriksaan-ibu/{id}/cetak', [PemeriksaanIbuController::class, 'cetakKartu'])->name('pemeriksaan-ibu.cetak');
Route::get('/laporan/pemeriksaan-ibu', [PemeriksaanIbuController::class, 'cetakLaporan'])->name('laporan.pemeriksaan-ibu');
