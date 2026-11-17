<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\TokoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute pembeli (tanpa login)
|--------------------------------------------------------------------------
| Rute lain (/aroma, /pesan, /cek-pesanan, dst.) ditambahkan di tahap berikutnya.
*/
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/toko', [TokoController::class, 'index'])->name('toko');
require __DIR__.'/katalog.php';

/*
|--------------------------------------------------------------------------
| SEMENTARA: pratinjau layout admin
|--------------------------------------------------------------------------
| Hapus rute ini di Tahap 6 saat login dan dashboard admin sudah dibuat.
*/
Route::view('/pratinjau-admin', 'admin.pratinjau')->name('admin.pratinjau');
