<?php

use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

Route::apiResource('kategoris', KategoriController::class);
Route::apiResource('bukus', BukuController::class);
Route::get('bukus/cari', [BukuController::class, 'cari']);
Route::get('bukus/{id}', [BukuController::class, 'show']);
Route::get('bukus/cari-kategori', [BukuController::class, 'cariBerdasarkanKategori']);
