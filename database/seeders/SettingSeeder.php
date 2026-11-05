<?php
namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('store_name', 'Toko Sejahtera', 'store');
        Setting::set('store_address', 'Jl. Merdeka No. 1, Jakarta', 'store');
        Setting::set('store_phone', '021-1234567', 'store');
        Setting::set('receipt_footer', 'Terima kasih atas kunjungan Anda', 'receipt');
    }
}