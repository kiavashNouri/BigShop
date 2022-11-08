<?php

namespace App\Http\Controllers\Profile;

use App\Helpers\Cart\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->paginate(12);
        return view('profile.orders-list' , compact('orders'));
    }
    public function showDetails(Order $order)
    {
        $this->authorize('view' , $order);

        return view('profile.order-detail' , compact('order'));
    }

    public function payment(Order $order)
    {
        $this->authorize('view' , $order);

        // $order->price
//        $invoice = (new Invoice)->amount(1000);
//
//        return ShetabitPayment::callbackUrl(route('payment.callback'))->purchase($invoice, function($driver, $transactionId) use ($order,$invoice) {
//
//            $order->payments()->create([
//                'resnumber' => $transactionId,
//            ]);
//
//        })->pay()->render();
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


//            مکان پرداخت کردن
        return redirect($payment->getPayUrl());

    }
}
