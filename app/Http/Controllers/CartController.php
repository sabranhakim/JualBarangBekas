<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $items = collect($request->session()->get('cart', []));

        return view('cart.index', compact('items'));
    }
}
