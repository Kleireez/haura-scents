<?php

use App\Http\Controllers\AromaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute katalog aroma (pembeli, tanpa login) - milik Anggota 2
|--------------------------------------------------------------------------
*/
Route::get('/aroma', [AromaController::class, 'index'])->name('aroma.index');
Route::get('/aroma/{aroma}', [AromaController::class, 'show'])->name('aroma.show');
