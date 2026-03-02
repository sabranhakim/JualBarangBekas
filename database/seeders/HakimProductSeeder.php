<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class HakimProductSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $categories = Category::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            return;
        }

        $products = [
            ['name' => 'Laptop Bekas Lenovo', 'price' => 3500000, 'status' => 'tersedia', 'phone' => '082111111111'],
            ['name' => 'Novel Laskar Pelangi', 'price' => 45000, 'status' => 'tersedia', 'phone' => '083111111111'],
            ['name' => 'Jaket Denim', 'price' => 120000, 'status' => 'terjual', 'phone' => '084111111111'],
            ['name' => 'Kursi Lipat', 'price' => 90000, 'status' => 'tersedia', 'phone' => '085111111111'],
            ['name' => 'Kalkulator Saintifik', 'price' => 75000, 'status' => 'tersedia', 'phone' => '082111111111'],
            ['name' => 'Mouse Wireless', 'price' => 60000, 'status' => 'terjual', 'phone' => '083111111111'],
        ];

        foreach ($products as $index => $item) {
            $user = $users[$index % $users->count()];
            $category = $categories[$index % $categories->count()];

            Product::updateOrCreate(
                ['name' => $item['name'], 'user_id' => $user->id],
                [
                    'category_id' => $category->id,
                    'description' => $item['name'] . ' kondisi masih bagus dan layak pakai.',
                    'price' => $item['price'],
                    'status' => $item['status'],
                    'phone' => $item['phone'],
                ]
            );
        }
    }
}
