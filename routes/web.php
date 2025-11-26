<?php

use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContactenosController;


Route::controller(PrincipalController::class)->group(function(){
    Route::get('/', 'index')->name('principal');
});

Route::controller(PrincipalController::class)->group(function(){
    Route::get('/about', 'about')->name('about');
});

Route::controller(LoginController::class)->group(function(){
    Route::get('login', 'show')->name('login');
});
//------------Eventos-------------)
Route::get('/eventos', [EventController::class,'index'])->name('events.index');
Route::get('/eventos/{event}', [EventController::class,'show'])->name('events.show');
// filtro por deporte (query param o ruta)
Route::get('/eventos/deporte/{sport}', [EventController::class,'bySport'])->name('events.bySport');
//----------------fin------------)

//----contactenos formularios-------)
Route::controller(ContactenosController::class)->group(function(){
    Route::get('contactenos', 'contactenos')->name('contactenos');
});

//----------------fin---------------------)

//funcion para mision, vision, valores no tocar)
Route::get('/Hover/mision', function () {
    return view('Hover.mision');
})->name('Hover.mision');

Route::get('/Hover/vision', function () {
    return view('Hover.vision');
})->name('Hover.vision');

Route::get('/Hover/valores', function () {
    return view('Hover.valores');
})->name('Hover.valores');
//---------------------fin-----------------------------)