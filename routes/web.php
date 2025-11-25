<?php

use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;



Route::controller(PrincipalController::class)->group(function(){
    Route::get('/', 'index');
});

Route::get('/about', function () {
    return view('PRINCIPAL.about');
})->name('about');


Route::controller(LoginController::class)->group(function(){
    Route::get('login', 'show');
});
