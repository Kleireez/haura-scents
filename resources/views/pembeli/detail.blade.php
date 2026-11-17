@extends('layouts.app')

@section('title', $aroma->nama_aroma)

@section('content')
@php
    $kosong = $aroma->status_stok === 'kosong';
    $linkPesan = \Illuminate\Support\Facades\Route::has('pesan.create')
        ? route('pesan.create', ['aroma' => $aroma->id_aroma])
        : url('/pesan?aroma=' . $aroma->id_aroma);
@endphp

<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('aroma.index') }}">Aroma</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $aroma->nama_aroma }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-12 col-md-5">
            <div class="ratio ratio-1x1 bg-light rounded overflow-hidden">
                @if ($aroma->foto)
                    <img src="{{ asset('storage/' . $aroma->foto) }}"
                         alt="Foto aroma {{ $aroma->nama_aroma }}" class="object-fit-cover">
                @else
                    <div class="d-flex align-items-center justify-content-center display-1 text-secondary">
                        {{ mb_strtoupper(mb_substr($aroma->nama_aroma, 0, 1)) }}
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-md-7">
            <div class="mb-2 d-flex flex-wrap gap-1">
                <span class="badge text-bg-light border">{{ $aroma->kategori->nama_kategori ?? '-' }}</span>
                @if ($aroma->populer)
                    <span class="badge text-bg-warning">Populer</span>
                @endif
                @if ($kosong)
                    <span class="badge text-bg-secondary">Stok kosong</span>
                @else
                    <span class="badge text-bg-success">Tersedia</span>
                @endif
            </div>

            <h1 class="h3">{{ $aroma->nama_aroma }}</h1>
            <p class="fs-4 fw-semibold mb-3">
                Rp{{ number_format($aroma->harga_per_ml, 0, ',', '.') }}
                <span class="fs-6 fw-normal text-muted">per ml</span>
            </p>

            <dl class="row mb-3">
                <dt class="col-sm-4">Ketahanan</dt>
                <dd class="col-sm-8">{{ $aroma->ketahanan ?: 'Belum ada keterangan. Tanyakan ke penjual.' }}</dd>

                <dt class="col-sm-4">Asal produk</dt>
                <dd class="col-sm-8">{{ $aroma->asal_produk ?: '-' }}</dd>
            </dl>

            <h2 class="h6">Tentang aroma ini</h2>
            <p>{!! nl2br(e($aroma->deskripsi ?: 'Belum ada deskripsi.')) !!}</p>

            <div class="d-flex flex-wrap gap-2 mt-4">
                @if ($kosong)
                    <button type="button" class="btn btn-dark" disabled>Stok sedang kosong</button>
                @else
                    <a href="{{ $linkPesan }}" class="btn btn-dark">Pesan aroma ini</a>
                @endif

                @if ($linkWa)
                    <a href="{{ $linkWa }}" target="_blank" rel="noopener" class="btn btn-outline-haura">
                        Tanya penjual via WhatsApp
                    </a>
                @else
                    <button type="button" class="btn btn-outline-secondary" disabled>
                        WhatsApp toko belum tersedia
                    </button>
                @endif
            </div>

            @if ($kosong)
                <p class="small text-muted mt-3 mb-0">
                    Aroma ini sedang kosong. Kamu tetap bisa menanyakan kapan tersedia lewat WhatsApp.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
