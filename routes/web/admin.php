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


