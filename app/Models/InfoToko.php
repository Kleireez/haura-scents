<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoToko extends Model
{
    protected $table = 'info_toko';
    protected $primaryKey = 'id_toko';
    public $incrementing = false; // id_toko selalu 1, bukan auto increment
    public $timestamps = false;

    protected $fillable = [
        'id_toko',
        'nama_toko',
        'alamat',
        'jam_buka',
        'no_whatsapp',
        'deskripsi',
        'nama_bank',
        'no_rekening',
        'atas_nama',
        'gambar_qris',
    ];

    /**
     * Ambil satu-satunya baris data toko (id_toko = 1).
     */
    public static function ambil(): ?self
    {
        return static::find(1);
    }

    /**
     * Nomor WhatsApp dalam format internasional tanpa tanda (mis. 6281234567890).
     * Mengembalikan null jika nomor belum diisi atau masih placeholder.
     */
    public function nomorWhatsappBersih(): ?string
    {
        $digit = preg_replace('/\D+/', '', (string) $this->no_whatsapp);

        if ($digit === '' || $digit === null) {
            return null;
        }

        if (str_starts_with($digit, '0')) {
            $digit = '62' . substr($digit, 1);
        } elseif (str_starts_with($digit, '8')) {
            $digit = '62' . $digit;
        }

        return $digit;
    }

    /**
     * Tautan https://wa.me/<nomor>?text=... atau null jika nomor belum valid.
     */
    public function linkWhatsapp(?string $teks = null): ?string
    {
        $nomor = $this->nomorWhatsappBersih();

        if (! $nomor) {
            return null;
        }

        $url = 'https://wa.me/' . $nomor;

        if ($teks) {
            $url .= '?text=' . rawurlencode($teks);
        }

        return $url;
    }
}
