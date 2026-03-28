<?php

namespace App\Services;

use App\Models\Cancha;
use App\Models\UserReserva;
use Illuminate\Support\Facades\Http;
use Throwable;

class ExternalReservationDispatchService
{
    public function dispatch(UserReserva $reserva): void
    {
        $cancha = $reserva->cancha;

        if (!$cancha instanceof Cancha) {
            return;
        }

        if (
            blank($cancha->api_base_url)
            || blank($cancha->integration_identifier)
            || blank($cancha->integration_token)
        ) {
            $reserva->forceFill([
                'external_sync_status' => 'sin_integracion',
                'external_sync_message' => 'La cancha no tiene configuracion de integracion completa.',
            ])->save();

            return;
        }

        $reference = $reserva->external_reference ?: 'ews-'.$reserva->id;

        try {
            $response = Http::asJson()
                ->acceptJson()
                ->timeout(10)
                ->withHeaders([
                    'X-Integration-Identifier' => $cancha->integration_identifier,
                    'X-Integration-Token' => $cancha->integration_token,
                ])
                ->post(rtrim((string) $cancha->api_base_url, '/').'/api/integraciones/reservas-externas', [
                    'external_reference' => $reference,
                    'nombre_cliente' => $reserva->nombre_cliente,
                    'telefono_cliente' => $reserva->telefono_cliente,
                    'fecha' => $reserva->fecha,
                    'hora' => substr((string) $reserva->hora, 0, 5),
                    'numero_subcancha' => (int) $reserva->numero_subcancha,
                ]);

            if ($response->successful()) {
                $reserva->forceFill([
                    'external_reference' => $reference,
                    'external_sync_status' => 'enviada',
                    'external_sync_message' => $response->json('message') ?: 'Solicitud enviada correctamente.',
                    'external_sent_at' => now(),
                ])->save();

                return;
            }

            $reserva->forceFill([
                'external_reference' => $reference,
                'external_sync_status' => 'fallida',
                'external_sync_message' => $response->json('message') ?: $response->body(),
            ])->save();
        } catch (Throwable $exception) {
            report($exception);

            $reserva->forceFill([
                'external_reference' => $reference,
                'external_sync_status' => 'fallida',
                'external_sync_message' => $exception->getMessage(),
            ])->save();
        }
    }
}
