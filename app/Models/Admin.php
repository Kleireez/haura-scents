<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'username',
        'password_hash',
        'peran',
        'aktif',
        'dibuat_pada',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'dibuat_pada' => 'datetime',
    ];

    /**
     * Tabel admin memakai kolom password_hash, bukan password.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /**
     * Tabel admin tidak punya kolom remember_token,
     * jadi fitur "ingat saya" dimatikan.
     */
    public function getRememberTokenName()
    {
        return '';
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_admin', 'id_admin');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_admin_verifikasi', 'id_admin');
    }

    public function struk()
    {
        return $this->hasMany(Struk::class, 'id_admin', 'id_admin');
    }
}
