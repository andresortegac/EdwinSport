<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cancha;
use App\Models\Reserva;
use App\Models\UserReserva;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExternalReservationStatusController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        if ((string) $request->header('X-EdwinSport-Callback-Token') !== (string) env('EDWINSPORT_CALLBACK_TOKEN', 'edwinsport-callback-token')) {
            return response()->json([
                'message' => 'Callback no autorizado.',
            ], 401);
        }

        $identifier = (string) $request->header('X-Integration-Identifier');
        $token = (string) $request->header('X-Integration-Token');

        $cancha = Cancha::query()
            ->where('integration_identifier', $identifier)
            ->where('integration_token', $token)
            ->first();

        if (!$cancha) {
            return response()->json([
                'message' => 'Cancha de integracion no encontrada.',
            ], 404);
        }

        $data = $request->validate([
            'external_reference' => ['required', 'string', 'max:120'],
            'estado_solicitud' => ['required', 'in:pendiente,confirmada,cancelada'],
            'motivo' => ['nullable', 'string'],
            'reserva_id' => ['nullable', 'integer'],
        ]);

        $reserva = UserReserva::where('cancha_id', $cancha->id)
            ->where('external_reference', $data['external_reference'])
            ->first();

        if (!$reserva) {
            return response()->json([
                'message' => 'Solicitud externa no encontrada.',
            ], 404);
        }

        $reserva->update([
            'estado_solicitud' => $data['estado_solicitud'],
            'external_sync_message' => $data['motivo'] ?? $reserva->external_sync_message,
            'external_sync_status' => 'sincronizada',
        ]);

        if ($data['estado_solicitud'] === 'cancelada') {
            Reserva::query()
                ->where('cancha_id', $reserva->cancha_id)
                ->where('fecha', $reserva->fecha)
                ->where('hora_inicio', $reserva->hora)
                ->delete();
        }

        return response()->json([
            'message' => 'Estado de solicitud actualizado correctamente.',
        ]);
    }
}
