<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | Admin {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/haura.css') }}" rel="stylesheet">
</head>
<body>
<div class="d-lg-flex">

    {{-- ========== MENU ADMIN (samping di laptop, geser di HP) ========== --}}
    <aside class="admin-sidebar">
        <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="menuAdmin" aria-labelledby="judulMenuAdmin">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="judulMenuAdmin">{{ config('app.name') }}</h5>
                <button type="button" class="btn-close btn-close-white d-lg-none"
                        data-bs-dismiss="offcanvas" data-bs-target="#menuAdmin" aria-label="Tutup"></button>
            </div>
            <div class="offcanvas-body">
                <nav class="nav flex-column w-100">
                    <a class="nav-link {{ request()->is('admin') || request()->routeIs('admin.pratinjau') ? 'active' : '' }}" href="{{ url('/admin') }}">Dashboard</a>
                    <a class="nav-link {{ request()->is('admin/pesanan*') ? 'active' : '' }}" href="{{ url('/admin/pesanan') }}">Pesanan</a>
                    <a class="nav-link {{ request()->is('admin/penjualan*') ? 'active' : '' }}" href="{{ url('/admin/penjualan/baru') }}">Catat Penjualan</a>
                    <a class="nav-link {{ request()->is('admin/aroma*') ? 'active' : '' }}" href="{{ url('/admin/aroma') }}">Aroma</a>
                    <a class="nav-link {{ request()->is('admin/kategori*') ? 'active' : '' }}" href="{{ url('/admin/kategori') }}">Kategori</a>
                    <a class="nav-link {{ request()->is('admin/botol*') ? 'active' : '' }}" href="{{ url('/admin/botol') }}">Botol</a>
                    <a class="nav-link {{ request()->is('admin/tunggu*') ? 'active' : '' }}" href="{{ url('/admin/tunggu') }}">Daftar Tunggu</a>
                    <a class="nav-link {{ request()->is('admin/toko*') ? 'active' : '' }}" href="{{ url('/admin/toko') }}">Info Toko</a>
                    <hr class="border-secondary">
                    <a class="nav-link" href="{{ route('beranda') }}" target="_blank">Lihat Website</a>
                    {{-- Tombol keluar (logout) ditambahkan di Tahap 6 bersama login admin. --}}
                </nav>
            </div>
        </div>
    </aside>

    {{-- ========== ISI HALAMAN ADMIN ========== --}}
    <div class="admin-konten">
        <header class="admin-topbar d-flex align-items-center gap-2 px-3 py-2">
            <button class="btn btn-outline-haura btn-sm d-lg-none" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#menuAdmin" aria-controls="menuAdmin">
                Menu
            </button>
            <span class="fw-semibold">@yield('judul_halaman', 'Panel Admin')</span>
        </header>

        @include('partials.alert')

        <main class="container-fluid p-3 p-lg-4">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
