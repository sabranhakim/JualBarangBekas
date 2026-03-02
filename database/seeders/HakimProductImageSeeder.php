<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class HakimProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $index => $product) {
            ProductImage::updateOrCreate(
                ['product_id' => $product->id, 'image_path' => 'products/sample-' . ($index + 1) . '.jpg'],
                ['product_id' => $product->id, 'image_path' => 'products/sample-' . ($index + 1) . '.jpg']
            );
        }
    }
}
