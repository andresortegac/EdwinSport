<?php

use App\Http\Controllers\Api\ExternalReservationStatusController;
use Illuminate\Support\Facades\Route;

Route::post('/integraciones/reservas-externas/estado', [ExternalReservationStatusController::class, 'update']);
