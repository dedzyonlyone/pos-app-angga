<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $cats = ['Minuman','Makanan Ringan','Sembako','Alat Tulis','Kebersihan'];
        foreach ($cats as $c) {
            Category::create(['name' => $c, 'description' => "Kategori $c"]);
        }
    }
}