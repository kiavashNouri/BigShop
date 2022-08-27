<?php
use Illuminate\Support\Facades\Route;


Route::get('/',function (){
   return 'admin';
});

Route::get('/users',function (){
    return 'users';
});
