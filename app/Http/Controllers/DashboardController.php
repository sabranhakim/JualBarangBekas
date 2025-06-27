<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('dashboard', [
            'myProductCount' => Product::where('user_id', $user->id)->count(),
            'soldCount' => Product::where('user_id', $user->id)->where('status', 'terjual')->count(),
            'userCount' => User::count(),
            'categoryCount' => Category::count(),
            'latestProducts' => Product::with('category')->latest()->take(6)->get(),
        ]);
    }
}
