<?php
use Illuminate\Support\Facades\Route;


Route::resource('discount' , \Modules\Discount\Http\Controllers\Admin\DiscountController::class);
