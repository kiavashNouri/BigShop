<?php
use Illuminate\Support\Facades\Route;


Route::get('/',function (){
   return view('admin.master');
});

Route::get('/users',function (){
    return 'users';
});
