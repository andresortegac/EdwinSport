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
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ParticipanteController;
use App\Http\Controllers\UserReservaController;
use App\Http\Controllers\CompeticionesController;

// ✅ IMPORT DEL CONTROLADOR NUEVO (SOLO IMPORT, NO CLASE AQUÍ)
use App\Http\Controllers\CrearEventoDeveloperController;

// ✅ IMPORT PARA EQUIPOS (NUEVO)
use App\Http\Controllers\EquipoController;


// =======================
// PRINCIPAL Y ABOUT
// =======================
Route::controller(PrincipalController::class)->group(function () {
    Route::get('/', 'index')->name('principal');
    Route::get('/about', 'about')->name('about');
    // Alias opcional
    Route::get('/panel-principal', 'index')->name('panel_principal');
});


// =======================
// REGISTER (VISTA)
// =======================
Route::get('/register', function () {
    return view('REGISTER.register');
})->name('register');


// =======================
// LOGIN / LOGOUT
// =======================
Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'show')->name('login');          // formulario
    Route::post('/login', 'login')->name('login.post');  // procesa login
    Route::post('/logout', 'logout')->name('logout');
});


// =======================
// EVENTOS
// =======================

// ✅ RUTA NUEVA PARA TU VISTA VACÍA
// IMPORTANTE: VA ANTES DE /eventos/{event}
Route::get('/eventos/crear-evento-developer', [CrearEventoDeveloperController::class, 'index'])
    ->name('events.crear-evento-developer');

Route::get('/eventos', [EventController::class,'index'])->name('events.index');
Route::get('/eventos/{event}', [EventController::class,'show'])->name('events.show');

// filtro por deporte
Route::get('/eventos/deporte/{sport}', [EventController::class,'bySport'])->name('events.bySport');

Route::controller(EventController::class)->group(function(){
    Route::get('crear-evento', 'create')->name('crear-evento.create');
    Route::post('crear-evento/guardar', 'store')->name('crear-evento.store');
});


// =======================
// CONTACTENOS
// =======================
Route::controller(ContactenosController::class)->group(function(){
    Route::get('contactenos', 'contactenos')->name('contactenos');
    Route::post('contactenos/guardar', 'store')->name('contactenos.store');
});


// =======================
// ABOUT: MISION / VISION / VALORES
// =======================
Route::get('/about/mision', function () {
    return view('about.mision');
})->name('about.mision');

Route::get('/about/vision', function () {
    return view('about.vision');
})->name('about.vision');

Route::get('/about/valores', function () {
    return view('about.valores');
})->name('about.valores');


// =======================
// PANEL USUARIO
// =======================
Route::controller(PanelController::class)->group(function(){
    Route::get('/usuario-panel', 'index')->name('usuario.panel');
    Route::get('/{id}/editar-evento', 'edit')->name('editar-evento.edit');
    Route::put('/{id}/actualizar-evento', 'update')->name('actualizar-evento.update');
    Route::delete('/{id}/eliminar-evento', 'destroy')->name('eliminar-evento.destroy');
});


// =======================
// CANCHAS / RESERVAS
// =======================
Route::get('/canchas', [CanchaController::class, 'index'])->name('canchas.index');
Route::get('/canchas/{cancha}', [CanchaController::class, 'show'])->name('canchas.show');

Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');

// Mostrar formulario nueva cancha
Route::get('/crear/nueva', [NuevaCanchaController::class, 'create'])->name('canchas.create');

// Guardar cancha
Route::post('/canchas/nueva', [NuevaCanchaController::class, 'store'])->name('canchas.store');

// Eliminar cancha
Route::delete('/canchas/{cancha}', [CanchaController::class, 'destroy'])->name('canchas.destroy');

// Eliminar reserva
Route::delete('/reservas/{reserva}', [ReservaController::class, 'destroy'])
    ->name('reservas.destroy');

Route::get('/separar/{cancha}', [UserReservaController::class, 'create'])
    ->name('user_reservas.create');   // nombre único

Route::post('/sepaarweb', [UserReservaController::class, 'store'])
    ->name('user_reservas.store');    // nombre único



// =======================
// TORNEO / SORTEO
// =======================
Route::get('/torneo', [TournamentController::class, 'showForm'])
    ->name('tournament.form');

Route::post('/torneo/generar', [TournamentController::class, 'generate'])
    ->name('tournament.generate');

Route::post('/torneo/pdf', [TournamentController::class, 'exportPdf'])
    ->name('tournament.pdf');

Route::get('/torneo/grupo/{id}/tabla', [TournamentController::class,'groupStandings'])
    ->name('tournament.standings');

Route::get('/equipos/import', [TeamsController::class, 'importForm'])
    ->name('equipos.import');

Route::post('/equipos/import', [TeamsController::class, 'import'])
    ->name('equipos.import.process');

Route::post('/sorteo/guardar', [GrupoController::class, 'store'])
    ->name('torneo.guardar');

Route::get('/sorteo/ver', [GrupoController::class, 'index'])
    ->name('torneo.ver');

Route::get('/distribusion/bracket', [TournamentController::class, 'bracket'])
    ->name('torneo.bracket');


// =======================
// ✅ EQUIPOS (NUEVO PARA CRUD)
// =======================
// Se pone DESPUÉS de /equipos/import para evitar choque con /equipos/{equipo}
Route::resource('equipos', EquipoController::class)
    ->middleware('auth');


// =======================
// ✅ EXPORT / IMPORT PARTICIPANTES
// =======================
// IMPORTANTE: van antes de /participantes/{participante} para evitar conflicto

// Export general a Excel (si lo sigues usando)
Route::get('/participantes/export', [ParticipanteController::class, 'exportExcel'])
    ->middleware('auth')
    ->name('participantes.export');

// ✅ NUEVO: Exportar planilla por equipo (Excel)
Route::get('/participantes/planilla-excel', [ParticipanteController::class, 'exportPlanillaExcel'])
    ->middleware('auth')
    ->name('participantes.planilla.excel');

// ✅ NUEVO: Exportar planilla por equipo (PDF)
Route::get('/participantes/planilla-pdf', [ParticipanteController::class, 'exportPlanillaPdf'])
    ->middleware('auth')
    ->name('participantes.planilla.pdf');

Route::post('/participantes/import', [ParticipanteController::class, 'importExcel'])
    ->middleware('auth')
    ->name('participantes.import');


// =======================
// PARTICIPANTES
// =======================
Route::get('/participantes', [ParticipanteController::class, 'index'])
    ->middleware('auth')
    ->name('participantes.index');

Route::get('/participantes/crear', [ParticipanteController::class, 'create'])
    ->middleware('auth')
    ->name('participantes.create');

Route::post('/participantes', [ParticipanteController::class, 'store'])
    ->middleware('auth')
    ->name('participantes.store');

// solo admin
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/participantes/{participante}/editar', [ParticipanteController::class, 'edit'])
        ->name('participantes.edit');

    Route::put('/participantes/{participante}', [ParticipanteController::class, 'update'])
        ->name('participantes.update');

    Route::delete('/participantes/{participante}', [ParticipanteController::class, 'destroy'])
        ->name('participantes.destroy');
});


// =======================
// ADMINS / USUARIOS ADMIN
// =======================
Route::middleware(['auth', 'admin'])->group(function () {

    // formulario crear admin
    Route::get('/admins/crear', [AdminUserController::class, 'create'])
        ->name('crear_usuario');

    // guardar admin
    Route::post('/admins', [AdminUserController::class, 'store'])
        ->name('guardar_usuario');

    // listar admins (opcional)
    Route::get('/admins', [AdminUserController::class, 'index'])
        ->name('admins.index');

    Route::delete('/admins/{id}', [AdminUserController::class, 'destroy'])
        ->name('crear_usuario.destroy');  

    Route::patch('/admins/{id}/password', [AdminUserController::class, 'updatePassword'])
        ->name('crear_usuario.updatePassword');
});


// =======================
// PASSWORD UPDATE (solo una vez)
// =======================
Route::post('/password/update', [PasswordsController::class, 'update'])
    ->middleware('auth')
    ->name('password.update');


// =======================
// VER NOTIFICACIONES
// =======================
Route::get('/contactos/{id}', [ContactenosController::class, 'show'])
    ->name('contactos.show');


    // =======================
// PASSWORD UPDATE (solo una vez)
// =======================

Route::controller(CompeticionesController::class)->group(function () {
    // Rutas del menu
    Route::get('/competicion', 'competicion')->name('competicion');
    Route::get('/partidos', 'partidos')->name('partidos');
});