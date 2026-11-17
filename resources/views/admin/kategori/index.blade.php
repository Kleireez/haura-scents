@extends('layouts.admin')

@section('title', 'Kategori Aroma')
@section('judul_halaman', 'Kategori Aroma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h5 mb-0">Daftar Kategori</h1>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
</div>

@if (session('sukses'))
    <div class="alert alert-success">{{ session('sukses') }}</div>
@endif
@if (session('galat'))
    <div class="alert alert-danger">{{ session('galat') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th style="width:60px">No</th>
                <th>Nama Kategori</th>
                <th style="width:120px">Jumlah Aroma</th>
                <th style="width:180px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($daftarKategori as $kategori)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>{{ $kategori->aroma_count }}</td>
                    <td>
                        <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn btn-sm btn-warning">Ubah</a>
                        <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
