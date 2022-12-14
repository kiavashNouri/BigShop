<?php
use Illuminate\Support\Facades\Route;


Route::get('/',function (){
   return view('admin.index');
});

Route::resource('users',\App\Http\Controllers\Admin\User\UserController::class)->parameters(['users'=>'id']);
Route::get('/users/{user}/permissions',[\App\Http\Controllers\Admin\User\PermissionController::class,'create'])->name('users.permissions');
Route::post('/users/{user}/permissions',[\App\Http\Controllers\Admin\User\PermissionController::class,'store'])->name('users.permissions.store');
Route::resource('permissions',\App\Http\Controllers\Admin\PermissionController::class);
Route::resource('roles',\App\Http\Controllers\Admin\RoleController::class);

Route::resource('products',\App\Http\Controllers\Admin\ProductController::class);
Route::get('comment/unapproved',[\App\Http\Controllers\Admin\CommentController::class,'unapproved'])->name('comments.unapproved');
Route::resource('comments',\App\Http\Controllers\Admin\CommentController::class);
Route::resource('categories',\App\Http\Controllers\Admin\CategoryController::class);


Route::post('attribute/values',[\App\Http\Controllers\Admin\AttributeController::class,'getValues']);
Route::resource('orders',\App\Http\Controllers\Admin\OrderController::class);
Route::get('orders/{order}/payments',[\App\Http\Controllers\Admin\OrderController::class,'payments'])->name('orders.payment');


Route::resource('products.gallery',\App\Http\Controllers\Admin\ProductGalleryController::class);
