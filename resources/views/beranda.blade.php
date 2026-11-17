@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    @php
        $linkWa = $toko?->linkWhatsapp('Halo, saya mau tanya soal aroma parfum refill.');
    @endphp

    {{-- ========== HERO ========== --}}
    <section class="hero">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <p class="hero-kicker mb-2">Parfum refill per mililiter</p>
                    <h1 class="display-6 mb-3">Pilih aroma, pesan dari rumah, ambil di toko.</h1>
                    <p class="lead mb-4">
                        {{ $toko->deskripsi ?? 'Bawa botol sendiri atau pakai botol dari toko. Harga dihitung per ml, sesuai aroma yang kamu pilih.' }}
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ url('/pesan') }}" class="btn btn-haura btn-lg">Pesan Sekarang</a>
                        <a href="{{ url('/aroma') }}" class="btn btn-outline-haura btn-lg">Lihat Aroma</a>
                        @if ($linkWa)
                            <a href="{{ $linkWa }}" target="_blank" rel="noopener" class="btn btn-wa btn-lg">Tanya via WhatsApp</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== AROMA POPULER ========== --}}
    <section class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-3">
            <h2 class="h4 judul-seksi mb-0">Aroma Populer</h2>
            <a href="{{ url('/aroma') }}" class="small">Lihat semua</a>
        </div>

        @if ($aromaPopuler->isEmpty())
            <div class="alert alert-light border">Belum ada aroma populer yang ditandai.</div>
        @else
            <div class="row g-3">
                @foreach ($aromaPopuler as $aroma)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('partials.kartu-aroma', ['aroma' => $aroma])
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ========== CARA PESAN ========== --}}
    <section class="container pb-4">
        <h2 class="h4 judul-seksi mb-3">Cara Memesan</h2>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="kartu-info p-3 h-100">
                    <span class="langkah-nomor mb-2">1</span>
                    <h3 class="h6">Pilih aroma</h3>
                    <p class="mb-0 small text-muted">Lihat deskripsi dan harga per ml, lalu tentukan jumlah ml dan jenis botol.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="kartu-info p-3 h-100">
                    <span class="langkah-nomor mb-2">2</span>
                    <h3 class="h6">Bayar</h3>
                    <p class="mb-0 small text-muted">Bayar lewat QRIS atau transfer bank lalu unggah bukti, atau pilih bayar tunai di toko.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="kartu-info p-3 h-100">
                    <span class="langkah-nomor mb-2">3</span>
                    <h3 class="h6">Ambil di toko</h3>
                    <p class="mb-0 small text-muted">Pantau status pesanan dengan kode pesanan. Setelah siap, ambil di toko.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
