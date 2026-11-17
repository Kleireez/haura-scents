@php
    $kosong = $a->status_stok === 'kosong';
@endphp

<div class="card h-100 shadow-sm {{ $kosong ? 'opacity-75' : '' }}">
    <a href="{{ route('aroma.show', $a) }}" class="text-decoration-none text-reset">
        <div class="ratio ratio-1x1 bg-light">
            @if ($a->foto)
                <img src="{{ asset('storage/' . $a->foto) }}" alt="Foto aroma {{ $a->nama_aroma }}"
                     class="card-img-top object-fit-cover" loading="lazy">
            @else
                <div class="d-flex align-items-center justify-content-center display-4 text-secondary">
                    {{ mb_strtoupper(mb_substr($a->nama_aroma, 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="mb-2 d-flex flex-wrap gap-1">
                @if ($a->populer)
                    <span class="badge text-bg-warning">Populer</span>
                @endif
                @if ($kosong)
                    <span class="badge text-bg-secondary">Stok kosong</span>
                @endif
            </div>
            <h2 class="h6 card-title mb-1">{{ $a->nama_aroma }}</h2>
            <p class="small text-muted mb-2">{{ $a->kategori->nama_kategori ?? '-' }}</p>
            <p class="fw-semibold mb-0">
                Rp{{ number_format($a->harga_per_ml, 0, ',', '.') }}
                <span class="small fw-normal text-muted">/ ml</span>
            </p>
        </div>
    </a>
</div>
