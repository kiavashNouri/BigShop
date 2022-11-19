<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{

    public function index(Product $product)
    {
        $images = $product->gallery()->latest()->paginate(30);
        return view('admin.products.gallery.all' , compact('product' , 'images'));
    }


    public function create(Product $product)
    {
        return view('admin.products.gallery.create' , compact('product'));

    }


    public function store(Request $request,Product $product)
    {
        $validated = $request->validate([
            'images.*.image' => 'required',
            'images.*.alt' => 'required|min:3'
        ]);

        collect($validated['images'])->each(function($image) use ($product) {
            $product->gallery()->create($image);
        });

        // alert()->success()
        return redirect(route('admin.products.gallery.index' , ['product' => $product->id]));
    }


    public function edit(Product $product , ProductGallery $gallery)
    {
        return view('admin.products.gallery.edit', compact('product' , 'gallery'));

    }


    public function update(Request $request, Product $product , ProductGallery $gallery)
    {
        $validated = $request->validate([
            'image' => 'required',
            'alt' => 'required|min:3'
        ]);

        $gallery->update($validated);

        // alert()->success()
        return redirect(route('admin.products.gallery.index' , ['product' => $product->id]));
    }

    public function destroy(Product $product , ProductGallery $gallery)
    {
        $gallery->delete();
        // alert()->success()

        return redirect(route('admin.products.gallery.index' , ['product' => $product->id]));
    }
}
