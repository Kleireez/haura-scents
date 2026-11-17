<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriAroma;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    private function aturan(?int $idSaatIni = null): array
    {
        return [
            'nama_kategori' => [
                'required', 'string', 'max:50',
                Rule::unique('kategori_aroma', 'nama_kategori')->ignore($idSaatIni, 'id_kategori'),
            ],
        ];
    }

    private function pesan(): array
    {
        return [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max'      => 'Nama kategori maksimal 50 karakter.',
            'nama_kategori.unique'   => 'Nama kategori ini sudah ada.',
        ];
    }

    // READ
    public function index()
    {
        $daftarKategori = KategoriAroma::withCount('aroma')->orderBy('nama_kategori')->get();
        return view('admin.kategori.index', compact('daftarKategori'));
    }

    // CREATE (form)
    public function create()
    {
        return view('admin.kategori.create');
    }

    // CREATE (simpan)
    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), $this->pesan());
        KategoriAroma::create($data);

        return redirect()->route('admin.kategori.index')
            ->with('sukses', 'Kategori berhasil ditambahkan.');
    }

    // UPDATE (form)
    public function edit(KategoriAroma $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    // UPDATE (simpan)
    public function update(Request $request, KategoriAroma $kategori)
    {
        $data = $request->validate($this->aturan($kategori->id_kategori), $this->pesan());
        $kategori->update($data);

        return redirect()->route('admin.kategori.index')
            ->with('sukses', 'Kategori berhasil diubah.');
    }

    // DELETE
    public function destroy(KategoriAroma $kategori)
    {
        if ($kategori->aroma()->exists()) {
            return redirect()->route('admin.kategori.index')
                ->with('galat', 'Kategori tidak bisa dihapus karena masih dipakai oleh aroma.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('sukses', 'Kategori berhasil dihapus.');
    }
}
