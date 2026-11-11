<?php

use App\Support\Rupiah;

if (! function_exists('rupiah')) {
    function rupiah($value): string
    {
        return Rupiah::format($value);
    }
}