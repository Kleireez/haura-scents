@extends('layouts.app')

@section('title', 'Katalog Aroma')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-1">Katalog Aroma</h1>
    <p class="text-muted">Harga dihitung per mililiter. Kamu bisa bawa botol sendiri atau pakai botol dari toko.</p>

    <form method="GET" action="{{ route('aroma.index') }}" class="row g-2 mb-4">
        <div class="col-12 col-md-5">
            <label for="q" class="visually-hidden">Cari nama aroma</label>
            <input type="search" id="q" name="q" value="{{ $kata }}"
                   class="form-control" placeholder="Cari nama aroma" maxlength="100">
        </div>
        <div class="col-8 col-md-4">
            <label for="kategori" class="visually-hidden">Kategori</label>
            <select id="kategori" name="kategori" class="form-select">
                <option value="">Semua kategori</option>
                @foreach ($daftarKategori as $kategori)
                    <option value="{{ $kategori->id_kategori }}"
                        @selected($idKategori === (int) $kategori->id_kategori)>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-4 col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-dark flex-fill">Cari</button>
            @if ($kata !== '' || $idKategori > 0)
                <a href="{{ route('aroma.index') }}" class="btn btn-outline-haura">Reset</a>
            @endif
        </div>
    </form>

    @if ($daftarAroma->count() > 0)
        <p class="small text-muted">
            Menampilkan {{ $daftarAroma->firstItem() }}-{{ $daftarAroma->lastItem() }}
            dari {{ $daftarAroma->total() }} aroma
        </p>

        <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4">
            @foreach ($daftarAroma as $item)
                <div class="col">
                    @include('pembeli.katalog-kartu', ['a' => $item])
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $daftarAroma->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-light border text-center py-4">
            Aroma yang kamu cari tidak ditemukan. Coba kata lain atau pilih kategori lain.
        </div>
    @endif
</div>
@endsection
