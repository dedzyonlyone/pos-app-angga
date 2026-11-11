<?php

namespace App\Support;

use App\Models\Purchase;
use App\Models\Sale;

class DocumentNumber
{
    public static function generatePurchaseNumber(): string
    {
        $date = now()->format('Ymd');
        $prefix = "PB-{$date}-";
        
        $last = Purchase::where('purchase_number', 'like', $prefix . '%')
            ->orderBy('purchase_number', 'desc')
            ->first();

        $sequence = $last ? (int) substr($last->purchase_number, -4) + 1 : 1;

        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}