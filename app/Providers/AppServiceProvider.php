<?php

namespace App\Providers;

use App\Models\InfoToko;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Data toko dimuat sekali per request, lalu dipakai ulang oleh semua view.
        $this->app->singleton('info_toko', function () {
            try {
                return InfoToko::ambil();
            } catch (\Throwable $e) {
                return null; // database belum siap: halaman tetap tampil
            }
        });
    }

    public function boot(): void
    {
        // $toko tersedia di semua view (layout maupun halaman).
        View::composer('*', function ($view) {
            $view->with('toko', app('info_toko'));
        });
    }
}
