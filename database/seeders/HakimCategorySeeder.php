<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class HakimCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Elektronik', 'Buku', 'Pakaian', 'Alat Tulis', 'Rumah Tangga', 'Lainnya'];

        foreach ($categories as $category) {
            Category::updateOrCreate(['category_name' => $category], ['category_name' => $category]);
        }
    }
}
