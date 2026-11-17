<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriAroma extends Model
{
    protected $table = 'kategori_aroma';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
    ];

    public function aroma()
    {
        return $this->hasMany(Aroma::class, 'id_kategori', 'id_kategori');
    }
}
