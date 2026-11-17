<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'metode',
        'jumlah_bayar',
        'status_bayar',
        'batas_waktu',
        'bukti_bayar',
        'waktu_bayar',
        'id_admin_verifikasi',
    ];

    protected $casts = [
        'jumlah_bayar' => 'integer',
        'batas_waktu' => 'datetime',
        'waktu_bayar' => 'datetime',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function adminVerifikasi()
    {
        return $this->belongsTo(Admin::class, 'id_admin_verifikasi', 'id_admin');
    }
}
