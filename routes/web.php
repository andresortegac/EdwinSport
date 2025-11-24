<?php

use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', [PrincipalController::class, 'index']);




Route::controller(LoginController::class)->group(function(){
    Route::get('login', 'show');
});