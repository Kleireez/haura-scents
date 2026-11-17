<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aroma extends Model
{
    protected $table = 'aroma';
    protected $primaryKey = 'id_aroma';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'nama_aroma',
        'deskripsi',
        'ketahanan',
        'harga_per_ml',
        'asal_produk',
        'status_stok',
        'populer',
        'foto',
        'aktif',
    ];

    protected $casts = [
        'harga_per_ml' => 'integer',
        'populer' => 'boolean',
        'aktif' => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriAroma::class, 'id_kategori', 'id_kategori');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_aroma', 'id_aroma');
    }

    public function daftarTunggu()
    {
        return $this->hasMany(DaftarTungguStok::class, 'id_aroma', 'id_aroma');
    }
}
