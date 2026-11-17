<?php

namespace App\Http\Controllers;

use App\Models\Aroma;
use App\Models\InfoToko;
use App\Models\KategoriAroma;
use Illuminate\Http\Request;

class AromaController extends Controller
{
    /** Katalog: hanya aroma aktif, dengan pencarian nama dan filter kategori. */
    public function index(Request $request)
    {
        $kata = trim((string) $request->query('q', ''));
        $kata = mb_substr($kata, 0, 100);
        $idKategori = (int) $request->query('kategori', 0);

        $daftarAroma = Aroma::with('kategori')
            ->where('aktif', 1)
            ->when($kata !== '', function ($query) use ($kata) {
                $aman = addcslashes($kata, '%_\\');
                $query->where('nama_aroma', 'like', '%' . $aman . '%');
            })
            ->when($idKategori > 0, fn ($query) => $query->where('id_kategori', $idKategori))
            ->orderByDesc('populer')
            ->orderBy('nama_aroma')
            ->paginate(12)
            ->withQueryString();

        $daftarKategori = KategoriAroma::orderBy('nama_kategori')->get();

        return view('pembeli.katalog', [
            'daftarAroma'    => $daftarAroma,
            'daftarKategori' => $daftarKategori,
            'kata'           => $kata,
            'idKategori'     => $idKategori,
        ]);
    }

    /** Detail satu aroma. */
    public function show(Aroma $aroma)
    {
        abort_unless($aroma->aktif, 404);

        $aroma->load('kategori');
        $toko = InfoToko::find(1);

        $teks = 'Halo, saya mau tanya tentang aroma ' . $aroma->nama_aroma . '.';

        return view('pembeli.detail', [
            'aroma'  => $aroma,
            'toko'   => $toko,
            'linkWa' => $this->linkWhatsapp($toko?->no_whatsapp, $teks),
        ]);
    }

    /**
     * Bentuk https://wa.me/<nomor>?text=... dari nomor di info_toko.
     * Mengembalikan null jika nomor belum diisi atau masih placeholder.
     */
    private function linkWhatsapp(?string $nomor, string $teks): ?string
    {
        $angka = preg_replace('/\D+/', '', (string) $nomor);

        if ($angka === '' || strlen($angka) < 8) {
            return null;
        }

        if (str_starts_with($angka, '0')) {
            $angka = '62' . substr($angka, 1);
        } elseif (str_starts_with($angka, '8')) {
            $angka = '62' . $angka;
        }

        return 'https://wa.me/' . $angka . '?text=' . rawurlencode($teks);
    }
}
