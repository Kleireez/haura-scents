@extends('layouts.app')

@section('title', 'Info Toko')

@section('content')
    @php
        $linkWa = $toko?->linkWhatsapp('Halo, saya mau tanya soal aroma parfum refill.');
    @endphp

    <div class="container py-4">
        <h1 class="h3 judul-seksi mb-1">Info Toko</h1>
        <p class="text-muted mb-4">{{ $toko->nama_toko ?? config('app.name') }}</p>

        @if ($toko?->deskripsi)
            <p class="mb-4">{{ $toko->deskripsi }}</p>
        @endif

        <div class="row g-3">
            {{-- Alamat dan jam buka --}}
            <div class="col-md-6">
                <div class="kartu-info p-3 h-100">
                    <h2 class="h6">Alamat</h2>
                    <p class="mb-3">{{ $toko->alamat ?? '-' }}</p>
                    <h2 class="h6">Jam buka</h2>
                    <p class="mb-0">{{ $toko->jam_buka ?? '-' }}</p>
                </div>
            </div>

            {{-- Kontak --}}
            <div class="col-md-6">
                <div class="kartu-info p-3 h-100">
                    <h2 class="h6">Hubungi kami</h2>
                    <p class="mb-3">
                        WhatsApp: {{ $toko->no_whatsapp ?? '-' }}
                    </p>
                    @if ($linkWa)
                        <a href="{{ $linkWa }}" target="_blank" rel="noopener" class="btn btn-wa">Chat via WhatsApp</a>
                    @else
                        <p class="small text-muted mb-0">Nomor WhatsApp belum diisi oleh pemilik toko.</p>
                    @endif
                </div>
            </div>

            {{-- Asal produk --}}
            <div class="col-12">
                <div class="kartu-info p-3">
                    <h2 class="h6">Asal produk</h2>
                    @if ($asalProduk->isEmpty())
                        <p class="mb-0 text-muted">Keterangan asal produk belum diisi.</p>
                    @else
                        <ul class="mb-0">
                            @foreach ($asalProduk as $asal)
                                <li>{{ $asal }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            {{-- Cara bayar --}}
            <div class="col-12">
                <div class="kartu-info p-3">
                    <h2 class="h6 mb-3">Cara bayar</h2>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <h3 class="h6">QRIS</h3>
                            @if ($toko?->gambar_qris)
                                <img src="{{ asset('storage/' . $toko->gambar_qris) }}" alt="QRIS {{ $toko->nama_toko }}" class="gambar-qris img-fluid border rounded">
                            @else
                                <p class="small text-muted mb-0">QRIS belum diatur.</p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h3 class="h6">Transfer bank</h3>
                            @if ($toko?->no_rekening)
                                <p class="mb-0">
                                    {{ $toko->nama_bank }}<br>
                                    <strong>{{ $toko->no_rekening }}</strong><br>
                                    a.n. {{ $toko->atas_nama }}
                                </p>
                            @else
                                <p class="small text-muted mb-0">Rekening belum diatur.</p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h3 class="h6">Tunai</h3>
                            <p class="small mb-0">Bayar langsung di toko.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
