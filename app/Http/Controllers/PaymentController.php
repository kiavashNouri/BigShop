<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Payment;
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
                return $cart['discount_percent']==0
                    ?$cart['product']->price * $cart['quantity']
                    :($cart['product']->price-($cart['product']->price*$cart['discount_percent']))*$cart['quantity'];
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


            $token = "O0F8s_4O7cMyTrs4-cqpd3qDWxsgXGndzwfKtLGXHBA";
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
                'resnumber' => $res_number,
            ]);

            $cart->flush();

//            مکان پرداخت کردن
            return redirect($payment->getPayUrl());

        }

        // alert()->error();
        return back();
    }

    public function callback(Request $request)
    {
//       شماره فاکتوری که ثبت شده باید با شماره فاکتوری که توی payping ثبت کردیم برابر باشه تا پرداخت fake نباشه
        $payment = Payment::where('resnumber', $request->clientrefid)->firstOrFail();

//        $token = "config('services.payping.token')";
        $token ="O0F8s_4O7cMyTrs4-cqpd3qDWxsgXGndzwfKtLGXHBA";

        $payping = new \PayPing\Payment($token);

        try {
            // $payment->price
            if($payping->verify($request->refid, 1000)){
                $payment->update([
                    'status' => 1
                ]);

                $payment->order()->update([
                    'status' => 'paid'
                ]);

                alert()->success('پرداخت شما موفق بود');
                return redirect('/products');
            }else{
                alert()->error('پرداخت شما تایید نشد');
                return redirect('/products');
            }
        } catch (\Exception $e) {
//            لغو شدن تراکنش توسط خود شخص
            $errors = collect(json_decode($e->getMessage() , true));

            alert()->error($errors->first());
            return redirect('/products');
        }
    }

}
