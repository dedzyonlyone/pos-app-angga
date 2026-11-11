<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['Minuman', 'MNM-001', 'Air Mineral 600ml', 'botol', 2500, 4000, 50, 10],
            ['Minuman', 'MNM-002', 'Teh Botol 350ml', 'botol', 3500, 5000, 40, 10],
            ['Minuman', 'MNM-003', 'Kopi Sachet', 'sachet', 1200, 2000, 100, 20],
            ['Minuman', 'MNM-004', 'Susu UHT 250ml', 'kotak', 4500, 6500, 30, 10],
            ['Makanan Ringan', 'MKR-001', 'Keripik Kentang', 'bungkus', 8000, 12000, 25, 5],
            ['Makanan Ringan', 'MKR-002', 'Biskuit Coklat', 'bungkus', 6000, 9000, 20, 5],
            ['Makanan Ringan', 'MKR-003', 'Kacang Goreng', 'bungkus', 5000, 7500, 15, 5],
            ['Makanan Ringan', 'MKR-004', 'Wafer Vanilla', 'bungkus', 4000, 6000, 35, 8],
            ['Sembako', 'SMB-001', 'Beras 5kg', 'karung', 55000, 65000, 10, 3],
            ['Sembako', 'SMB-002', 'Minyak Goreng 1L', 'botol', 14000, 18000, 18, 5],
            ['Sembako', 'SMB-003', 'Gula Pasir 1kg', 'pack', 13000, 16000, 22, 5],
            ['Sembako', 'SMB-004', 'Telur 1kg', 'kg', 24000, 29000, 12, 4],
            ['Sembako', 'SMB-005', 'Tepung Terigu 1kg', 'pack', 10000, 13000, 16, 5],
            ['Alat Tulis', 'ATK-001', 'Pulpen Hitam', 'pcs', 1500, 2500, 60, 15],
            ['Alat Tulis', 'ATK-002', 'Buku Tulis 40 Lembar', 'pcs', 3000, 4500, 45, 10],
            ['Alat Tulis', 'ATK-003', 'Pensil 2B', 'pcs', 2000, 3000, 50, 12],
            ['Alat Tulis', 'ATK-004', 'Penghapus', 'pcs', 1000, 2000, 40, 10],
            ['Perawatan Diri', 'PRW-001', 'Sabun Mandi Batang', 'pcs', 3000, 4500, 30, 8],
            ['Perawatan Diri', 'PRW-002', 'Sampo Sachet', 'sachet', 800, 1500, 120, 30],
            ['Perawatan Diri', 'PRW-003', 'Pasta Gigi 100g', 'tube', 7000, 10000, 20, 6],
        ];

        $categoryMap = Category::pluck('id', 'name');

        foreach ($products as $p) {
            Product::create([
                'category_id' => $categoryMap[$p[0]],
                'sku' => $p[1],
                'name' => $p[2],
                'unit' => $p[3],
                'purchase_price' => $p[4],
                'selling_price' => $p[5],
                'stock' => $p[6],
                'min_stock' => $p[7],
                'is_active' => true,
            ]);
        }
    }
}