<?php

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

Route::prefix('discount')->group(function() {
    Route::post('discount/check',[\Modules\Discount\Http\Controllers\Frontend\DiscountController::class,'check'])->name('cart.discount.check');
});
