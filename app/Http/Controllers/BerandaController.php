<?php

namespace App\Http\Controllers;

use App\Models\Aroma;

class BerandaController extends Controller
{
    public function index()
    {
        $aromaPopuler = Aroma::with('kategori')
            ->where('aktif', 1)
            ->where('populer', 1)
            ->orderBy('nama_aroma')
            ->limit(6)
            ->get();

        return view('beranda', compact('aromaPopuler'));
    }
}
