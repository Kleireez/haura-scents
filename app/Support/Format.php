<?php

namespace App\Support;

class Format
{
    /**
     * 2500 -> "Rp2.500"
     */
    public static function rupiah(int|float|string|null $angka): string
    {
        return 'Rp' . number_format((float) $angka, 0, ',', '.');
    }
}
