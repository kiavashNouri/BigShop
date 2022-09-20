<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('home.products' , compact('products'));
    }

    public function single(Product $product)
    {
        return view('home.single-product' , compact('product'));
    }

}
