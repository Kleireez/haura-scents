<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'id_aroma',
        'jenis_botol',
        'id_botol',
        'jumlah_ml',
        'harga_per_ml',
        'harga_botol',
        'subtotal',
    ];

    protected $casts = [
        'jumlah_ml' => 'integer',
        'harga_per_ml' => 'integer',
        'harga_botol' => 'integer',
        'subtotal' => 'integer',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function aroma()
    {
        return $this->belongsTo(Aroma::class, 'id_aroma', 'id_aroma');
    }

    public function botol()
    {
        return $this->belongsTo(Botol::class, 'id_botol', 'id_botol');
    }
}
