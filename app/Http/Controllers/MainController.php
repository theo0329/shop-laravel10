<?php

namespace App\Http\Controllers;

use App\Models\Product;

class MainController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('main.index', ['products' => $products]);
    }
}
