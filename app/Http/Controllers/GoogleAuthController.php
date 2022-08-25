<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\TwoFactorAuthenticate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Psy\Util\Str;

class GoogleAuthController extends Controller
{
    use TwoFactorAuthenticate;

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {

        try {
            $userGoogle = Socialite::driver('google')->user();

            $user = User::where('email', $userGoogle->email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $userGoogle->name,
                    'email' => $userGoogle->email,
                    'password' => bcrypt(\Illuminate\Support\Str::random(16)),
                ]);
            }
            Auth::loginUsingId($user->id);

//            return redirect('/'); instead of redirect we use loggedin method from  TwoFactorAuthenticate trait for two factor auth
            return $this->loggedin($request, $user) ?: redirect('/');   //<=========
        } catch (\Exception $e) {

            return view('welcome');
        }
//        return 'test';
    }
}
