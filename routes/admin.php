<?php

use App\Http\Controllers\Admin\KategoriController;
use Illuminate\Support\Facades\Route;

// Login admin menyusul di Tahap 6. Untuk sementara belum pakai middleware auth.
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('kategori', KategoriController::class)->except('show');
});
