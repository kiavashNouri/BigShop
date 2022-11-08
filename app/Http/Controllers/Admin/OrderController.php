<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::query();

        if($search = \request('search')) {
            $orders->where('id' , $search)->orWhere('tracking_serial' , $search);
        }
        $orders = $orders->where('status' , request('type'))->latest()->paginate(30);
        return view('admin.orders.all' , compact('orders'));
    }




    public function show(Order $order)
    {
        $products = $order->products()->paginate(20);
        return view('admin.orders.details' , compact('products', 'order'));
    }


    public function payments(Order $order)
    {
        $payments = $order->payments()->latest()->paginate(20);
        return view('admin.orders.payments' , compact('payments' , 'order'));
    }
    public function edit(Order $order)
    {
        return view('admin.orders.edit' , compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $this->validate($request , [
            'status' => ['required' , Rule::in(['unpaid' , 'paid' , 'preparation' , 'posted' , 'received' , 'canceled'])],
            'tracking_serial' => 'required'
        ]);

        $order->update($data);
        // alert
        return redirect(route('admin.orders.index') . "?type=$order->status");
    }

    public function destroy(Order $order)
    {
        $order->delete();
        // alert()
        return back();
    }
}
