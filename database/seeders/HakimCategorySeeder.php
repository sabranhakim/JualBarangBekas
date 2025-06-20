<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class HakimCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Elektronik', 'Buku', 'Pakaian', 'Alat Tulis', 'Lainnya'];

        foreach ($categories as $category) {
            Category::create(['category_name' => $category]);
        }
    }
}

