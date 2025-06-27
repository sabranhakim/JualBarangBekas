<?php

namespace App\Http\Controllers;

use App\Models\Product;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Product $product)
    {
        $user = Auth::user();
        if ($user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->detach($product->id);
        } else {
            $user->favorites()->attach($product->id);
        }

        return back();
    }

    public function index()
    {
        $favorites = Auth::user()->favorites()->with('images', 'category')->latest()->get();
        return view('favorites.index', compact('favorites'));
    }
}
