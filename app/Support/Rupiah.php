<?php

namespace App\Support;

class Rupiah
{
    public static function format($value): string
    {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    }
}