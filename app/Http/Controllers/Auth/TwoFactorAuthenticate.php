<?php


namespace App\Http\Controllers\Auth;


use App\Models\ActiveCode;
use App\Notifications\LoginToWebsiteNotification;
use Illuminate\Http\Request;

trait TwoFactorAuthenticate
{
    public function loggedin(Request $request,$user)
    {
        if ($user->hasTwoFactorAuthenticationEnabled()){
            auth()->logout();
            $request->session()->flash('auth',[
                'user_id' => $user->id,
                'using_sms'=>false,
                'remember'=>$request->has('remember')  //name of remember field(checkbox) in login form
            ]);
            if ($user->two_factor_type='sms'){
                $code = ActiveCode::generateCode($user);
                // Todo send sms
                // دسترسی پیدا میکنیم به auth session (auth.using_sms) و برابر با true قرارش میدیم
                $request->session()->push('auth.using_sms',true);
            }
            return redirect(route('2fa.token'));
        }
        $user->notify(new LoginToWebsiteNotification());
        return false;
    }

}
