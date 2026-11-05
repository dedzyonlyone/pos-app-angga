<?php
namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [1,'MNM-001','Aqua 600ml','pcs',2000,3000,50,10],
            [1,'MNM-002','Teh Botol 350ml','pcs',3000,5000,40,10],
            [1,'MNM-003','Kopi Sachet','pcs',1500,2500,100,20],
            [1,'MNM-004','Susu Ultra 250ml','pcs',4000,6000,30,10],
            [2,'MKR-001','Chitato 68g','pcs',8000,11000,25,5],
            [2,'MKR-002','Taro 70g','pcs',7000,10000,3,5],
            [2,'MKR-003','Oreo 133g','pcs',9000,13000,20,5],
            [2,'MKR-004','Beng Beng','pcs',2000,3000,60,15],
            [3,'SMK-001','Beras 5kg','sak',60000,72000,15,5],
            [3,'SMK-002','Gula 1kg','kg',14000,17000,30,10],
            [3,'SMK-003','Minyak 1L','pcs',15000,18000,25,8],
            [3,'SMK-004','Telur 1kg','kg',25000,30000,20,5],
            [3,'SMK-005','Tepung 1kg','kg',10000,13000,40,10],
            [4,'ATK-001','Pulpen Standard','pcs',2000,3500,80,20],
            [4,'ATK-002','Buku Tulis','pcs',3000,5000,50,15],
            [4,'ATK-003','Pensil 2B','pcs',2000,3500,4,10],
            [5,'KBR-001','Sabun Mandi','pcs',4000,6500,35,10],
            [5,'KBR-002','Shampo Sachet','pcs',1000,2000,120,30],
            [5,'KBR-003','Pasta Gigi','pcs',8000,12000,18,5],
            [5,'KBR-004','Detergen 800g','pcs',18000,23000,22,8],
        ];
        foreach ($products as $p) {
            Product::create([
                'category_id' => $p[0], 'sku' => $p[1], 'name' => $p[2], 'unit' => $p[3],
                'purchase_price' => $p[4], 'selling_price' => $p[5],
                'stock' => $p[6], 'min_stock' => $p[7], 'is_active' => true,
            ]);
        }
    }
}