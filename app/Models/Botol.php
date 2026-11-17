<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Botol extends Model
{
    protected $table = 'botol';
    protected $primaryKey = 'id_botol';
    public $timestamps = false;

    protected $fillable = [
        'nama_botol',
        'ukuran_ml',
        'harga_botol',
        'aktif',
    ];

    protected $casts = [
        'ukuran_ml' => 'integer',
        'harga_botol' => 'integer',
        'aktif' => 'boolean',
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_botol', 'id_botol');
    }
}
