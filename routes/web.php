<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordsController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ContactenosController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\NuevaCanchaController;
use App\Http\Controllers\GrupoController;


// Principal y About
Route::controller(PrincipalController::class)->group(function () {
    Route::get('/', 'index')->name('principal');
    Route::get('/about', 'about')->name('about');
});

Route::get('/register', function () {
    return view('REGISTER.register');
})->name('register');


Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'show')->name('login');        // formulario
    Route::post('/login', 'login')->name('login.post'); // procesa login
    Route::post('/logout', 'logout')->name('logout');
});
//------------Eventos-------------)
Route::get('/eventos', [EventController::class,'index'])->name('events.index');
Route::get('/eventos/{event}', [EventController::class,'show'])->name('events.show');
// filtro por deporte (query param o ruta)
Route::get('/eventos/deporte/{sport}', [EventController::class,'bySport'])->name('events.bySport');
Route::post('/password/update', [PasswordsController::class, 'update'])->name('password.update');

Route::controller(EventController::class)->group(function(){
    Route::get('crear-evento', 'create')->name('crear-evento.create');
    Route::post('crear-evento/guardar', 'store')->name('crear-evento.store');
});
//----------------fin------------)

//----contactenos formularios-------
Route::controller(ContactenosController::class)->group(function(){
    Route::get('contactenos', 'contactenos')->name('contactenos');
    Route::post('contactenos/guardar', 'store')->name('contactenos.store');
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

//--------------validar modal--------------)
Route::get('/usuario-panel', function () {
    return view('usuario.panel'); // o la vista que tengas
})->name('usuario.panel');
//------------------------fin-----------------------------)

//-----------convenio-----------------------------------)
Route::get('/canchas', [CanchaController::class, 'index'])->name('canchas.index');


Route::get('/canchas/{cancha}', [CanchaController::class, 'show'])->name('canchas.show');


Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');

// Mostrar formulario
Route::get('/crear/nueva', [NuevaCanchaController::class, 'create'])->name('canchas.create');

// Guardar formulario
Route::post('/canchas/nueva', [NuevaCanchaController::class, 'store'])->name('canchas.store');


//Eliminar Cancha
Route::delete('/canchas/{cancha}', [CanchaController::class, 'destroy'])->name('canchas.destroy');

Route::delete('/reservas/{reserva}', [ReservaController::class, 'destroy'])
    ->name('reservas.destroy');



//-------------fin------------------------------)

//-----------sorteo-------------------------------)
Route::get('/torneo', [TournamentController::class, 'showForm'])
    ->name('tournament.form');

Route::post('/torneo/generar', [TournamentController::class, 'generate'])
    ->name('tournament.generate');

Route::post('/torneo/pdf', [TournamentController::class, 'exportPdf'])->name('tournament.pdf');

Route::get('/torneo/grupo/{id}/tabla', [TournamentController::class,'groupStandings'])->name('tournament.standings');

Route::get('/equipos/import', [TeamsController::class, 'importForm'])->name('equipos.import');

Route::post('/equipos/import', [TeamsController::class, 'import'])->name('equipos.import.process');

Route::post('/torneo/pdf', [TournamentController::class, 'exportPdf'])
    ->name('tournament.pdf');

Route::post('/sorteo/guardar', [GrupoController::class, 'store'])->name('torneo.guardar');

Route::get('/sorteo/ver', [GrupoController::class, 'index'])->name('torneo.ver');

Route::get('/distribusion/bracket', [TournamentController::class, 'bracket'])
    ->name('torneo.bracket');

//----------------fin---------------------)

