<?php

namespace App\Http\Controllers;

use App\Models\ActiveCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function manageTwoFactor()
    {
        return view('profile.two-factor-auth');
    }

    public function postManageTwoFactor(Request $request)
    {
        $data = $request->validate([
////            باید حتما type برابر با sms , off باشه که حتی توی inspect هم دستی تغییر ندن
            'type' => 'required|in:sms,off',
////            اگر type off بود،اعتبار سنجی نکن
            'phone' =>['required_unless:type,off']
//            Rule::unique('users,phone_number')->ignore($request->user()->id)  //برای پارامتر دوم phone
            // این unique:users,phone_number برای اینه که کاربر اگر در اکانت دیگه شماره تلفن اکانت دیگش رو گذاشت،بگه که باید شماره جدید بذاره میتونیم نذاریمش

            //این Rule::unique('users,phone_number')->ignore($request->user()->id) باعث میشه که زمانی که کاربر کنونی که آنلاینه
            //و تلفنش هم توی جدول قرار داره،موقع آپددیت کردن و گذاشتن روی حالت off ارور نده که شماره تلفن وجود داره
            //در واقع واسه کاربر کنونی که آنلاینه اینو نادیده میگیره


//

        ]);

        if ($data['type'] === 'sms') {
//            dd(Auth::user());
            if (Auth::user()->phone_number !== $data['phone']) {
//                یعنی اگه وجود نداشت یا عوض شد
                $code = ActiveCode::generateCode(Auth::user());

//                send code with notif(maybe sms or email or both of them)
                Auth::user()->notify(new \App\Notifications\ActiveCode($code));
                $request->session()->flash('phone', $data['phone']);
                return redirect(route('show.phone.setting'));
            } else {
                $request->user()->update([
                    'two_factor_type' => 'sms'
                ]);
            }

        }

        if ($data['type'] === 'off') {
            $request->user()->update([
                'two_factor_type' => 'off'
            ]);
        }
        return back();
    }

    public function getPhoneVerify(Request $request)
    {
        if (! $request->session()->has('phone')) {
            return redirect(route('profile.2fa-manage'));

        }
        $request->session()->reflash(); //reFlash phone number session for postPhoneVerify
        return view('profile.phone-verify');
    }

    public function postPhoneVerify(Request $request)
    {

        $request->validate([
            'token' => 'required'
        ]);
        if (! $request->session()->has('phone')) {
            return redirect(route('profile.2fa-manage'));
        }
        $status = ActiveCode::verifyCode($request->token, $request->user());

        if ($status) {
            $request->user()->activeCode()->delete();
            $request->user()->update([
                'phone_number' => $request->session()->get('phone'),
                'two_factor_type' => 'sms'
            ]);
            alert()->success('شماره تلفن شما و کدتان با موفقیت تایید شد', 'عملیات با موفقیت انجام شد');
        } else {
            alert()->error('شماره تلفن شما و کدتان تایید نشد', 'عملیات با موفقیت انجام نشد');
        }
        return redirect(route('profile.2fa-manage'));

    }
}
