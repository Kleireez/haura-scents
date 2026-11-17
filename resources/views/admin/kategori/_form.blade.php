<div class="mb-3">
    <label for="nama_kategori" class="form-label">Nama Kategori</label>
    <input type="text" id="nama_kategori" name="nama_kategori"
           class="form-control @error('nama_kategori') is-invalid @enderror"
           value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}">
    @error('nama_kategori')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
