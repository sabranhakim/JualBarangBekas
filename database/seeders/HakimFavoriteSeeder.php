<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class HakimFavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach ($users as $index => $user) {
            $firstProduct = $products[$index % $products->count()];
            $secondProduct = $products[($index + 1) % $products->count()];

            $user->favorites()->syncWithoutDetaching([$firstProduct->id, $secondProduct->id]);
        }
    }
}
