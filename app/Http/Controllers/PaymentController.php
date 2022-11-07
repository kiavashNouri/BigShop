<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart = Cart::instance('kia-cart');
        $cartItems = $cart->all();
        if ($cartItems->count()) {
            $price = $cartItems->sum(function ($cart) {
                return $cart['product']->price * $cart['quantity'];
            });

            $orderItems = $cartItems->mapWithKeys(function ($cart) {
                return [$cart['product']->id => ['quantity' => $cart['quantity']]];
            });


            $order = auth()->user()->orders()->create([
                'price' => $price,
                'status' => 'unpaid',
            ]);

//            هر order شامل چه سفارش هایی میشه و چند تا تعداد داره؟
            $order->products()->attach($orderItems);


            $token = "dFd3p3izFFts_NasHcp29_a-0s7hezLwrUKXFQye7l4";
            $res_number=Str::random();
            $args = [
                "amount" => 1000,
                "payerName" => Auth::user()->name,
                "description" => "توضیحات",
                "returnUrl" => route('payment.callback'),
                "clientRefId" => $res_number
            ];

            $payment = new \PayPing\Payment($token);

            try {
                $payment->pay($args);
            } catch (\Exception $e) {
                throw $e;
            }
//echo $payment->getPayUrl();
            $order->payments()->create([
                'renumber' => $res_number,
                'price'=>$price
            ]);

            $cart->flush();

            header('Location: ' . $payment->getPayUrl());

            return 'ok';
        }

        // alert()->error();
        return back();
    }

    public function callback()
    {

    }
}
