<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Minuman', 'description' => 'Minuman kemasan dan sachet'],
            ['name' => 'Makanan Ringan', 'description' => 'Snack dan camilan'],
            ['name' => 'Sembako', 'description' => 'Kebutuhan pokok sehari-hari'],
            ['name' => 'Alat Tulis', 'description' => 'Kebutuhan sekolah dan kantor'],
            ['name' => 'Perawatan Diri', 'description' => 'Sabun, sampo, pasta gigi'],
        ];

        foreach ($data as $row) {
            Category::create($row);
        }
    }
}