<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'kode_transaksi',
        'sumber',
        'nama_pembeli',
        'no_whatsapp',
        'tanggal_transaksi',
        'tanggal_ambil',
        'status',
        'total_harga',
        'catatan',
        'id_admin',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'tanggal_ambil' => 'date',
        'total_harga' => 'integer',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_transaksi', 'id_transaksi');
    }

    public function struk()
    {
        return $this->hasOne(Struk::class, 'id_transaksi', 'id_transaksi');
    }
}
