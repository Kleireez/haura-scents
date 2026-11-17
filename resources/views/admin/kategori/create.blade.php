@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('judul_halaman', 'Tambah Kategori')

@section('content')
<form action="{{ route('admin.kategori.store') }}" method="POST" style="max-width:480px">
    @csrf
    @include('admin.kategori._form')
</form>
@endsection
