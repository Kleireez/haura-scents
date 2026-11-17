<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Struk extends Model
{
    protected $table = 'struk';
    protected $primaryKey = 'id_struk';
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'nomor_struk',
        'tanggal_terbit',
        'id_admin',
    ];

    protected $casts = [
        'tanggal_terbit' => 'datetime',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
