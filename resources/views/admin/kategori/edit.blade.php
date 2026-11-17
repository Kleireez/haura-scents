@extends('layouts.admin')

@section('title', 'Ubah Kategori')
@section('judul_halaman', 'Ubah Kategori')

@section('content')
<form action="{{ route('admin.kategori.update', $kategori) }}" method="POST" style="max-width:480px">
    @csrf
    @method('PUT')
    @include('admin.kategori._form')
</form>
@endsection
