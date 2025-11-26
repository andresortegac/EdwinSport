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
Route::get('/about/mision', function () {
    return view('about.mision');
})->name('about.mision');

Route::get('/about/vision', function () {
    return view('about.vision');
})->name('about.vision');

Route::get('/about/valores', function () {
    return view('about.valores');
})->name('about.valores');
//---------------------fin-----------------------------)