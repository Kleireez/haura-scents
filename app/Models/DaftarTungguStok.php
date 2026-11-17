<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarTungguStok extends Model
{
    protected $table = 'daftar_tunggu_stok';
    protected $primaryKey = 'id_tunggu';
    public $timestamps = false;

    protected $fillable = [
        'id_aroma',
        'nama_pembeli',
        'no_whatsapp',
        'tanggal_daftar',
        'status',
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
    ];

    public function aroma()
    {
        return $this->belongsTo(Aroma::class, 'id_aroma', 'id_aroma');
    }
}
