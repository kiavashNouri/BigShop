<?php

namespace Modules\Discount\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Discount\Entities\Discount;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $discounts=Discount::latest()->paginate(20);
        return view('discount::admin.all',compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('discount::admin.create');

    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:discounts,code',
            'percent' => 'required|integer|between:1,99',
            'users' => 'nullable|array|exists:users,id',
            'products' => 'nullable|array|exists:products,id',
            'categories' => 'nullable|array|exists:categories,id',
            'expired_at' => 'required'
        ]);

        $discount = Discount::create($validated);

        $discount->users()->attach($validated['users']);
        $discount->products()->attach($validated['products']);
        $discount->categories()->attach($validated['categories']);

        return redirect(route('admin.discount.index'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('discount::show');
    }


    public function edit(Discount $discount)
    {
        return view('discount::admin.edit' , compact('discount'));

    }


    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => ['required' , Rule::unique('discounts' , 'code')->ignore($discount->id)],
            'percent' => 'required|integer|between:1,99',
            'users' => 'nullable|array|exists:users,id',
            'products' => 'nullable|array|exists:products,id',
            'categories' => 'nullable|array|exists:categories,id',
            'expired_at' => 'required'
        ]);

        $discount->update($validated);

        isset($validated['users'])
            ? $discount->users()->sync($validated['users'])
            : $discount->users()->detach();

        isset($validated['products'])
            ? $discount->products()->sync($validated['products'])
            : $discount->products()->detach();

        isset($validated['categories'])
            ? $discount->categories()->sync($validated['categories'])
            : $discount->categories()->detach();


        return redirect(route('admin.discount.index'));
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
