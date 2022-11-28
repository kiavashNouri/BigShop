<?php

namespace Modules\Discount\Http\Controllers\Frontend;

use App\Helpers\Cart\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Discount\Entities\Discount;

class DiscountController extends Controller
{
    public function check(Request $request)
    {
        $validated =  $request->validate([
            'discount' => 'required|exists:discounts,code',
            'cart' => 'required'
        ]);

        if( ! auth()->check() ) {
            return back()->withErrors([
                'discount' => 'برای اعمال کد تخفیف لطفا ابتدا وارد سایت شوید'
            ]);
        }

        $discount = Discount::where('code' , $validated['discount'])->first();

        if( $discount->expired_at < now() ) {
            return back()->withErrors([
                'discount' => 'مهلت استفاده از این کد تخفیف به پایان رسیده است'
            ]);
        }

        if( $discount->users()->count() ) {
            if(! in_array( auth()->user()->id ,  $discount->users->pluck('id')->toArray() ) ) {
                return back()->withErrors([
                    'discount' => 'شما قادر به استفاده از این کد تخفیف نیستید'
                ]);
            }
        }

        $cart = Cart::instance($validated['cart']);
        $cart->addDiscount($discount->code);

        return back();
    }

    public function destroy(Request $request)
    {
        $cart = Cart::instance($request->cart);
        $cart->addDiscount(null);

        // alert()->success();

        return back();
    }

}
