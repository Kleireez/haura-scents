<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') | {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/haura.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- ========== MENU PEMBELI ========== --}}
    <nav class="navbar navbar-expand-lg navbar-haura sticky-top">
        <div class="container">
            <a class="navbar-brand brand-haura" href="{{ route('beranda') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#menuUtama" aria-controls="menuUtama"
                    aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuUtama">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('aroma*') ? 'active' : '' }}" href="{{ url('/aroma') }}">Aroma</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pesan') ? 'active' : '' }}" href="{{ url('/pesan') }}">Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cek-pesanan*', 'pesanan*') ? 'active' : '' }}" href="{{ url('/cek-pesanan') }}">Cek Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('toko') ? 'active' : '' }}" href="{{ route('toko') }}">Info Toko</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- ========== ISI HALAMAN ========== --}}
    <main class="flex-grow-1">
        @include('partials.alert')
        @yield('content')
    </main>

    {{-- ========== FOOTER ========== --}}
    <footer class="footer-haura py-4 mt-5">
        <div class="container">
            <div class="row gy-3">
                <div class="col-md-6">
                    <h2 class="h6 text-white">{{ $toko->nama_toko ?? config('app.name') }}</h2>
                    <p class="mb-0 small">{{ $toko->alamat ?? '' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 small"><strong class="text-white">Jam buka:</strong> {{ $toko->jam_buka ?? '-' }}</p>
                    @php($linkWaFooter = $toko?->linkWhatsapp())
                    <p class="mb-0 small">
                        <strong class="text-white">WhatsApp:</strong>
                        @if ($linkWaFooter)
                            <a href="{{ $linkWaFooter }}" target="_blank" rel="noopener">{{ $toko->no_whatsapp }}</a>
                        @else
                            {{ $toko->no_whatsapp ?? '-' }}
                        @endif
                    </p>
                </div>
            </div>
            <hr class="border-secondary">
            <p class="small mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
