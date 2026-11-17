@extends('layouts.admin')

@section('title', 'Pratinjau Layout')
@section('judul_halaman', 'Pratinjau Layout Admin')

@section('content')
    <div class="kartu-info p-4">
        <h1 class="h5">Layout admin sudah berjalan</h1>
        <p class="mb-2">
            Halaman ini hanya untuk menguji tampilan menu admin dan bersifat sementara.
            Login dan dashboard sebenarnya dibuat di Tahap 6.
        </p>
        <p class="mb-0 text-muted small">
            Menu di sebelah kiri (atau tombol Menu di HP) mengarah ke halaman yang dibuat di tahap-tahap berikutnya,
            jadi saat ini akan menampilkan halaman tidak ditemukan (404).
        </p>
    </div>
@endsection
