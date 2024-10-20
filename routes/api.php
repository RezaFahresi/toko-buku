<?php

use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

Route::get('bukus/search', [BukuController::class, 'search']);  // Endpoint pencarian buku
Route::apiResource('kategoris', KategoriController::class);
Route::apiResource('bukus', BukuController::class);

Route::get('bukus/{id}', [BukuController::class, 'show']);




