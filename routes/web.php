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

// ✅ IMPORT DEL CONTROLADOR NUEVO
use App\Http\Controllers\CrearEventoDeveloperController;

// ✅ IMPORT PARA EQUIPOS (CRUD)
use App\Http\Controllers\EquipoController;

// ✅ IMPORT PARA PATROCINADORES
use App\Http\Controllers\SponsorController;


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
// ABOUT: MISION / VISION / VALORES
// =======================
Route::get('/about/mision', fn () => view('about.mision'))->name('about.mision');
Route::get('/about/vision', fn () => view('about.vision'))->name('about.vision');
Route::get('/about/valores', fn () => view('about.valores'))->name('about.valores');


// =======================
// REGISTER (VISTA)
// =======================
Route::get('/register', function () {
    return view('REGISTER.register');
})->name('register');


// =======================
// LOGIN / LOGOUT
// =======================
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'show')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});


// =======================
// EVENTOS
// =======================

// ✅ RUTA NUEVA PARA TU VISTA VACÍA
// IMPORTANTE: VA ANTES DE /eventos/{event}
Route::get('/eventos/crear-evento-developer', [CrearEventoDeveloperController::class, 'index'])
    ->name('events.crear-evento-developer');

Route::get('/media/eventos/{path}', [EventController::class, 'media'])
    ->where('path', '.*')
    ->name('events.media');

Route::get('/media/sponsors/{path}', [SponsorController::class, 'media'])
    ->where('path', '.*')
    ->name('sponsors.media');

// ✅ Listado (filtrado por category vía query string: /eventos?category=futbol)
Route::get('/eventos', [EventController::class, 'index'])->name('events.index');


// ✅ Detalle
Route::get('/eventos/{event}', [EventController::class, 'show'])->name('events.show');

// ✅ Crear y guardar (mantengo tus rutas actuales)
Route::controller(EventController::class)->group(function () {
    Route::get('crear-evento', 'create')->name('crear-evento.create');
    Route::post('crear-evento/guardar', 'store')->name('crear-evento.store');
});

// ✅ Editar / Actualizar / Eliminar con nombres events.*
Route::get('/eventos/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
Route::put('/eventos/{event}', [EventController::class, 'update'])->name('events.update');
Route::delete('/eventos/{event}', [EventController::class, 'destroy'])->name('events.destroy');


// =======================
// CONTACTENOS
// =======================
Route::controller(ContactenosController::class)->group(function () {
    Route::get('contactenos', 'contactenos')->name('contactenos');
    Route::post('contactenos/guardar', 'store')->name('contactenos.store');
});

// VER NOTIFICACIONES
Route::get('/contactos/{id}', [ContactenosController::class, 'show'])->name('contactos.show');


// =======================
// PANEL USUARIO  ✅ (CORREGIDO PARA EVITAR INTERFERENCIA)
// =======================
Route::middleware('auth')->controller(PanelController::class)->group(function () {
    Route::get('/usuario-panel', 'index')->name('usuario.panel');

    // ✅ Antes estaban en "/{id}/editar-evento" (riesgo de choque en la raíz)
    Route::get('/usuario-panel/eventos/{id}/editar', 'edit')->name('editar-evento.edit');
    Route::put('/usuario-panel/eventos/{id}/actualizar', 'update')->name('actualizar-evento.update');
    Route::delete('/usuario-panel/eventos/{id}/eliminar', 'destroy')->name('eliminar-evento.destroy');
});



// =======================
// CANCHAS / RESERVAS
// =======================
Route::get('/canchas', [CanchaController::class, 'index'])->name('canchas.index');
Route::get('/canchas/{cancha}', [CanchaController::class, 'show'])->name('canchas.show');

Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
Route::delete('/reservas/{reserva}', [ReservaController::class, 'destroy'])->name('reservas.destroy');

// Nueva cancha
Route::get('/crear/nueva', [NuevaCanchaController::class, 'create'])->name('canchas.create');
Route::post('/canchas/nueva', [NuevaCanchaController::class, 'store'])->name('canchas.store');
Route::delete('/canchas/{cancha}', [CanchaController::class, 'destroy'])->name('canchas.destroy');

// Reservas usuario
Route::get('/separar/{cancha}', [UserReservaController::class, 'create'])->name('user_reservas.create');

// ⚠️ Ojo: "/sepaarweb" parece typo. No lo cambio para no romper tu front.
Route::post('/sepaarweb', [UserReservaController::class, 'store'])->name('user_reservas.store');


// =======================
// TORNEO / SORTEO
// =======================
Route::get('/torneo', [TournamentController::class, 'showForm'])->name('tournament.form');
Route::post('/torneo/generar', [TournamentController::class, 'generate'])->name('tournament.generate');
Route::post('/torneo/pdf', [TournamentController::class, 'exportPdf'])->name('tournament.pdf');
Route::get('/torneo/grupo/{id}/tabla', [TournamentController::class, 'groupStandings'])->name('tournament.standings');

Route::get('/distribusion/bracket', [TournamentController::class, 'bracket'])->name('torneo.bracket');

Route::get('/equipos/import', [TeamsController::class, 'importForm'])->name('equipos.import');
Route::post('/equipos/import', [TeamsController::class, 'import'])->name('equipos.import.process');

Route::post('/sorteo/guardar', [GrupoController::class, 'store'])->name('torneo.guardar');
Route::get('/sorteo/ver', [GrupoController::class, 'index'])->name('torneo.ver');


// =======================
// ✅ EQUIPOS (CRUD)
// =======================
// Debe ir DESPUÉS de /equipos/import para evitar choque con /equipos/{equipo}
Route::resource('equipos', EquipoController::class)->middleware('auth');


// =======================
// ✅ EXPORT / IMPORT PARTICIPANTES
// =======================

// Export general
Route::get('/participantes/export', [ParticipanteController::class, 'exportExcel'])
    ->middleware('auth')
    ->name('participantes.export');

// ✅ NUEVO: Planilla por equipo (Excel)
Route::get('/participantes/planilla-excel', [ParticipanteController::class, 'exportPlanillaExcel'])
    ->middleware('auth')
    ->name('participantes.planilla.excel');

// ✅ NUEVO: Planilla por equipo (PDF)
Route::get('/participantes/planilla-pdf', [ParticipanteController::class, 'exportPlanillaPdf'])
    ->middleware('auth')
    ->name('participantes.planilla.pdf');

Route::post('/participantes/import', [ParticipanteController::class, 'importExcel'])
    ->middleware('auth')
    ->name('participantes.import');


// =======================
// PARTICIPANTES
// =======================
Route::get('/registrar-participantes', [ParticipanteController::class, 'create'])
    ->middleware('auth')
    ->name('registrar.participantes');

Route::get('/participantes', [ParticipanteController::class, 'index'])
    ->middleware('auth')
    ->name('participantes.index');

Route::post('/participantes', [ParticipanteController::class, 'store'])
    ->middleware('auth')
    ->name('participantes.store');

// Solo admin: editar/actualizar/eliminar
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/participantes/{participante}/editar', [ParticipanteController::class, 'edit'])->name('participantes.edit');
    Route::put('/participantes/{participante}', [ParticipanteController::class, 'update'])->name('participantes.update');
    Route::delete('/participantes/{participante}', [ParticipanteController::class, 'destroy'])->name('participantes.destroy');
});


// =======================
// ADMINS / USUARIOS ADMIN
// =======================
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admins/crear', [AdminUserController::class, 'create'])->name('crear_usuario');
    Route::post('/admins', [AdminUserController::class, 'store'])->name('guardar_usuario');

    Route::get('/admins', [AdminUserController::class, 'index'])->name('admins.index');

    Route::delete('/admins/{id}', [AdminUserController::class, 'destroy'])->name('crear_usuario.destroy');
    Route::patch('/admins/{id}/password', [AdminUserController::class, 'updatePassword'])->name('crear_usuario.updatePassword');
});


// =======================
// ✅ PATROCINADORES / SPONSORS
// =======================
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors.index');
    Route::get('/sponsors/create', [SponsorController::class, 'create'])->name('sponsors.create');
    Route::post('/sponsors', [SponsorController::class, 'store'])->name('sponsors.store');
});


// =======================
// PASSWORD UPDATE (solo una vez)
// =======================
Route::post('/password/update', [PasswordsController::class, 'update'])
    ->middleware('auth')
    ->name('password.update');


// =======================
// COMPETICIONES
// =======================
Route::controller(CompeticionesController::class)->group(function () {

    // Ver competición de un evento
    Route::get('/competicion/{evento}', 'show')
        ->name('competicion');

    // Crear competición (una por evento)
    Route::post('/competicion/{evento}/crear', 'store')
        ->name('competicion.crear');

    // Generar grupos automáticamente
    Route::post('/competicion/{competicion}/grupos', 'generarGrupos')
        ->name('competicion.grupos');

});
