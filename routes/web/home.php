<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//   return \Illuminate\Support\Facades\Auth::user()->ActiveCode()->create([
//       'code' =>111111,
//        'expired_at'=>now()->addMinute(10)
//    ]);
    if (\Illuminate\Support\Facades\Gate::allows('edit')){
        return view('welcome');
    }else{
        return 'ok';

    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/auth/google', [\App\Http\Controllers\GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\GoogleAuthController::class, 'callback'])->name('auth.callback');
Route::get('/auth/token', [\App\Http\Controllers\Auth\AuthTokenController::class, 'getToken'])->name('2fa.token');
Route::post('/auth/token', [\App\Http\Controllers\Auth\AuthTokenController::class, 'postToken']);

Route::get('/secret',function (){
    return 'secret';
})->middleware(['auth','password.confirm']);


Route::middleware('auth')->group(function (){
    Route::get('/profile',[ProfileController::class,'index']);
    Route::get('/profile/two-factor',[ProfileController::class,'manageTwoFactor'])->name('profile.2fa-manage');
    Route::post('/profile/two-factor',[ProfileController::class,'postManageTwoFactor'])->name('post.twoFactor-option');
    Route::get('profile/two-factor/phone',[ProfileController::class,'getPhoneVerify'])->name('show.phone.setting');
    Route::post('profile/two-factor/phone',[ProfileController::class,'postPhoneVerify'])->name('profile.2fa.phone');
});

