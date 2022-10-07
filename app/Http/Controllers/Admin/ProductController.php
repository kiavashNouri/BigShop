<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::query();

        if($keyword = request('search')) {
            $products->where('title' , 'LIKE' , "%{$keyword}%")->orWhere('id' , 'LIKE' , "%{$keyword}%" );
        }

        $products = $products->latest()->paginate(20);
        return view('admin.products.all' , compact('products'));
    }


    public function create()
    {
        return view('admin.products.create');

    }


    public function store(Request $request)
    {
        $validData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'inventory' => 'required',
            'categories' => 'required',
        ]);

        $product=auth()->user()->products()->create($validData);
        $product->categories()->sync($validData['categories']);
        alert()->success('محصول مورد نظر با موفقیت ثبت شد' , 'با تشکر');
        return redirect(route('admin.products.index'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit' , compact('product'));
    }


    public function update(Request $request, Product $product)
    {
        $validData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'inventory' => 'required',
            'categories' => 'required',
        ]);

        $product->update($validData);
        $product->categories()->sync($validData['categories']);
        alert()->success('محصول مورد نظر با موفقیت ویرایش شد' , 'با تشکر');
        return redirect(route('admin.products.index'));
    }


    public function destroy(Product $product)
    {
        $product->delete();

        alert()->success('محصول مورد نظر با موفقیت حذف شد' , 'با تشکر');
        return back();    }
}
