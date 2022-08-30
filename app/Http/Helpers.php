<?php

use Illuminate\Support\Facades\Route;

if(! function_exists('isActive') ) {

    function isActive($key , $activeClassName = 'active') {

        if(is_array($key)) {
            return in_array(Route::currentRouteName() , $key) ? $activeClassName : '';
        }

        return Route::currentRouteName() == $key ? $activeClassName :  '';
    }

}
