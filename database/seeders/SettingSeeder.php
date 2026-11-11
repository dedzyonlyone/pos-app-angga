<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'store_name' => 'Toko Sejahtera',
            'store_address' => 'Jl. Merdeka No. 10, Jakarta',
            'store_phone' => '081234567890',
            'receipt_footer' => 'Terima kasih telah berbelanja',
        ];

        foreach ($defaults as $key => $value) {
            Setting::create(['key' => $key, 'value' => $value]);
        }
    }
}