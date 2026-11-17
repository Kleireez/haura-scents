<?php

namespace App\Http\Controllers;

use App\Models\Aroma;

class TokoController extends Controller
{
    public function index()
    {
        // Asal produk diambil dari data aroma yang aktif, bukan ditulis tetap di kode.
        $asalProduk = Aroma::where('aktif', 1)
            ->whereNotNull('asal_produk')
            ->where('asal_produk', '!=', '')
            ->distinct()
            ->orderBy('asal_produk')
            ->pluck('asal_produk');

        return view('toko', compact('asalProduk'));
    }
}
