<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $myProductCount = Product::count();
        $userCount = User::count();
        $categoryCount = Category::count();
        $latestProducts = Product::with('category')->latest()->take(6)->get();
        $soldCount = Product::where('status', 'terjual')->count();
        $productsPerCategory = Category::withCount('products')->get();

        $soldPerMonth = Product::select(DB::raw('MONTH(updated_at) as month_num'), DB::raw("DATE_FORMAT(updated_at, '%M') as month_name"), DB::raw('COUNT(*) as total'))->where('status', 'terjual')->whereYear('updated_at', now()->year)->groupBy(DB::raw('MONTH(updated_at)'), DB::raw("DATE_FORMAT(updated_at, '%M')"))->orderBy('month_num')->get();

        return view('dashboard', compact('myProductCount', 'userCount', 'categoryCount', 'latestProducts', 'soldCount', 'productsPerCategory', 'soldPerMonth'));

        // return view('dashboard', [
        //     'myProductCount'      => Product::count(),
        //     'soldCount'           => Product::where('status', 'terjual')->count(),
        //     'userCount'           => User::count(),
        //     'categoryCount'       => Category::count(),
        //     'latestProducts'      => Product::with('category')->latest()->take(6)->get(),
        //     'productsPerCategory' => Category::withCount('products')->get(),
        // ]);
    }
}
