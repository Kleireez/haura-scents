{{-- Kartu satu aroma. Dipakai di Beranda dan nanti di Katalog. Butuh variabel $aroma. --}}
@php($kosong = $aroma->status_stok === 'kosong')
<div class="card kartu-aroma h-100 {{ $kosong ? 'kosong' : '' }}">
    <div class="foto-aroma">
        @if ($aroma->foto)
            <img src="{{ asset('storage/' . $aroma->foto) }}" alt="{{ $aroma->nama_aroma }}">
        @else
            <div class="foto-kosong">{{ mb_substr($aroma->nama_aroma, 0, 1) }}</div>
        @endif

        <div class="lencana-foto d-flex gap-1">
            @if ($aroma->populer)
                <span class="badge text-bg-warning">Populer</span>
            @endif
            @if ($kosong)
                <span class="badge text-bg-secondary">Stok kosong</span>
            @endif
        </div>
    </div>

    <div class="card-body d-flex flex-column">
        @if ($aroma->kategori)
            <small class="text-muted">{{ $aroma->kategori->nama_kategori }}</small>
        @endif
        <h3 class="h6 card-title mb-1">{{ $aroma->nama_aroma }}</h3>
        <p class="harga-aroma mb-3">
            {{ \App\Support\Format::rupiah($aroma->harga_per_ml) }}<small class="fw-normal text-muted"> / ml</small>
        </p>
        <a href="{{ url('/aroma/' . $aroma->id_aroma) }}" class="btn btn-outline-haura btn-sm mt-auto">Lihat detail</a>
    </div>
</div>
