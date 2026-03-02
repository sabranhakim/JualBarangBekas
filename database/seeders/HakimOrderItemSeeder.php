<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HakimOrderItemSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('hakim_order_items')->exists()) {
            return;
        }

        $orders = DB::table('hakim_orders')->orderBy('id')->get();
        $products = Product::orderBy('id')->take(4)->get();

        if ($orders->isEmpty() || $products->isEmpty()) {
            return;
        }

        $rows = [];
        foreach ($orders as $index => $order) {
            $product = $products[$index % $products->count()];
            $rows[] = [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 1 + ($index % 2),
                'price' => $product->price,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('hakim_order_items')->insert($rows);
    }
}
