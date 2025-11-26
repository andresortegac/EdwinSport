<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Principal y About
Route::controller(PrincipalController::class)->group(function () {
    Route::get('/', 'index')->name('principal');
    Route::get('/about', 'about')->name('about');
});

// Login
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'show')->name('login');
    Route::post('/login', 'login')->name('login.submit');
    Route::post('/logout', 'logout')->name('logout');
});

// Register (público)
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'index')->name('REGISTER.register');  // 👈 solo esta
    Route::post('/register', 'store')->name('REGISTER.store');
});

/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (solo logueados)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [PrincipalController::class, 'dashboard'])
        ->name('dashboard');

    // Contraseñas
    Route::get('/password/my', [PasswordController::class, 'editMy'])->name('password.my.edit');
    Route::post('/password/my', [PasswordController::class, 'updateMy'])->name('password.my.update');

    Route::get('/password/other', [PasswordController::class, 'editOther'])->name('password.other.edit');
    Route::post('/password/other', [PasswordController::class, 'updateOther'])->name('password.other.update');
});
