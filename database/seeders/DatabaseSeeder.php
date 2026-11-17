<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Aroma;
use App\Models\Botol;
use App\Models\InfoToko;
use App\Models\KategoriAroma;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Semua data di sini hanyalah CONTOH / placeholder.
 * Seeder memakai firstOrCreate, jadi aman dijalankan berulang
 * dan tidak menimpa data yang sudah diubah lewat admin atau SQL.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori aroma
        foreach (['Fresh', 'Floral', 'Woody', 'Manis'] as $nama) {
            KategoriAroma::firstOrCreate(['nama_kategori' => $nama]);
        }

        // 2. Botol contoh
        Botol::firstOrCreate(
            ['nama_botol' => 'Botol contoh 30 ml'],
            ['ukuran_ml' => 30, 'harga_botol' => 0]
        );

        // 3. Info toko (placeholder, isi asli lewat admin atau tabel info_toko)
        InfoToko::firstOrCreate(
            ['id_toko' => 1],
            [
                'nama_toko'   => '[Nama Toko]',
                'alamat'      => '[Alamat]',
                'jam_buka'    => '[Jam buka]',
                'no_whatsapp' => '[Nomor WhatsApp]',
            ]
        );

        // 4. Tiga aroma contoh (harga 2500, 3000, 4000 per ml)
        $aromaContoh = [
            ['kategori' => 'Fresh',  'nama' => 'Aroma Contoh A', 'harga' => 2500, 'populer' => false],
            ['kategori' => 'Floral', 'nama' => 'Aroma Contoh B', 'harga' => 3000, 'populer' => true],
            ['kategori' => 'Woody',  'nama' => 'Aroma Contoh C', 'harga' => 4000, 'populer' => false],
        ];

        foreach ($aromaContoh as $a) {
            $kategori = KategoriAroma::where('nama_kategori', $a['kategori'])->first();

            Aroma::firstOrCreate(
                ['nama_aroma' => $a['nama']],
                [
                    'id_kategori'  => $kategori->id_kategori,
                    'deskripsi'    => 'Isi deskripsi/notes aroma',
                    'harga_per_ml' => $a['harga'],
                    'asal_produk'  => 'Diimpor dari Bandung',
                    'populer'      => $a['populer'],
                ]
            );
        }

        // 5. Akun admin sementara (password di-hash)
        Admin::firstOrCreate(
            ['username' => 'pemilik'],
            [
                'nama'          => 'Pemilik',
                'password_hash' => Hash::make('GantiPasswordIni123'),
                'peran'         => 'pemilik',
            ]
        );

        $this->command?->info('Seeder selesai.');
        $this->command?->warn('Admin sementara -> username: pemilik | password: GantiPasswordIni123 (segera ganti).');
    }
}
