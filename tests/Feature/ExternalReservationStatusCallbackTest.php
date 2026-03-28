<?php

namespace Tests\Feature;

use App\Models\Cancha;
use App\Models\Reserva;
use App\Models\UserReserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExternalReservationStatusCallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_callback_updates_external_request_status_and_clears_local_hold_when_cancelled(): void
    {
        config()->set('app.key', 'base64:ION01hAXZkRlp8xEe+GYLSCGvtyT9BjnzXZdxeM62CM=');

        $cancha = Cancha::create([
            'nombre' => 'Bombonera',
            'ubicacion' => 'Barranquilla',
            'ciudad' => 'Barranquilla',
            'subdominio' => 'bombonera',
            'integration_identifier' => 'bombonera-main',
            'integration_token' => 'bombonera-token',
            'hora_apertura' => '07:00:00',
            'hora_cierre' => '22:00:00',
            'num_canchas' => 2,
        ]);

        $solicitud = UserReserva::create([
            'cancha_id' => $cancha->id,
            'nombre_cliente' => 'Laura Gomez',
            'telefono_cliente' => '3010000000',
            'fecha' => '2026-04-01',
            'hora' => '11:00',
            'numero_subcancha' => 1,
            'estado_solicitud' => 'pendiente',
            'external_reference' => 'ews-10',
            'external_sync_status' => 'enviada',
        ]);

        Reserva::create([
            'cancha_id' => $cancha->id,
            'fecha' => '2026-04-01',
            'hora_inicio' => '11:00',
            'nombre_cliente' => 'Laura Gomez',
            'telefono_cliente' => '3010000000',
        ]);

        $response = $this
            ->withHeaders([
                'X-EdwinSport-Callback-Token' => 'edwinsport-callback-token',
                'X-Integration-Identifier' => 'bombonera-main',
                'X-Integration-Token' => 'bombonera-token',
            ])
            ->postJson('/api/integraciones/reservas-externas/estado', [
                'external_reference' => 'ews-10',
                'estado_solicitud' => 'cancelada',
                'motivo' => 'No fue posible confirmar con el cliente.',
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('user_reservas', [
            'id' => $solicitud->id,
            'estado_solicitud' => 'cancelada',
            'external_sync_status' => 'sincronizada',
        ]);

        $this->assertDatabaseMissing('reservas', [
            'cancha_id' => $cancha->id,
            'fecha' => '2026-04-01',
            'hora_inicio' => '11:00',
        ]);
    }
}
