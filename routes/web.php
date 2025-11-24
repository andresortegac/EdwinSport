<?php

use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;



Route::controller(PrincipalController::class)->group(function(){
    Route::get('/', 'index')->name('principal');
});


Route::controller(LoginController::class)->group(function(){
    Route::get('login', 'show')->name('login');
});
