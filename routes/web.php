<?php

use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventController;


Route::controller(PrincipalController::class)->group(function(){
    Route::get('/', 'index')->name('principal');
});

Route::controller(PrincipalController::class)->group(function(){
    Route::get('/about', 'about')->name('about');
});


Route::get('/eventos', [EventController::class,'index'])->name('events.index');
Route::get('/eventos/{event}', [EventController::class,'show'])->name('events.show');
// filtro por deporte (query param o ruta)
Route::get('/eventos/deporte/{sport}', [EventController::class,'bySport'])->name('events.bySport');
