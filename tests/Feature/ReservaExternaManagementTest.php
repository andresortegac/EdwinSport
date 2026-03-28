<?php

namespace Tests\Feature;

use App\Models\Cancha;
use App\Models\Reserva;
use App\Models\Subcancha;
use App\Models\User;
use App\Models\UserReserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservaExternaManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_external_reservations(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $cancha = Cancha::create([
            'nombre' => 'Cancha Central',
            'num_canchas' => 2,
            'hora_apertura' => '07:00:00',
            'hora_cierre' => '22:00:00',
        ]);

        UserReserva::create([
            'cancha_id' => $cancha->id,
            'nombre_cliente' => 'Carlos Perez',
            'telefono_cliente' => '3001234567',
            'fecha' => '2026-03-30',
            'hora' => '10:00',
            'numero_subcancha' => 1,
        ]);

        $response = $this->actingAs($admin)->get('/reservas-externas');

        $response->assertOk();
        $response->assertSee('Carlos Perez');
        $response->assertSee('Reservas externas');
    }

    public function test_store_external_reservation_also_updates_internal_schedule(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $cancha = Cancha::create([
            'nombre' => 'Cancha Norte',
            'num_canchas' => 2,
            'hora_apertura' => '07:00:00',
            'hora_cierre' => '22:00:00',
        ]);

        $subcancha = Subcancha::create([
            'cancha_id' => $cancha->id,
            'nombre' => 'Cancha 1',
        ]);

        $response = $this->actingAs($admin)->post('/reservas-externas', [
            'cancha_id' => $cancha->id,
            'numero_subcancha' => 1,
            'nombre_cliente' => 'Laura Gomez',
            'telefono_cliente' => '3010000000',
            'fecha' => '2026-03-31',
            'hora' => '11:00',
        ]);

        $response->assertRedirect('/reservas-externas');

        $this->assertDatabaseHas('user_reservas', [
            'cancha_id' => $cancha->id,
            'nombre_cliente' => 'Laura Gomez',
            'fecha' => '2026-03-31',
            'hora' => '11:00',
            'numero_subcancha' => 1,
        ]);

        $this->assertDatabaseHas('reservas', [
            'cancha_id' => $cancha->id,
            'subcancha_id' => $subcancha->id,
            'nombre_cliente' => 'Laura Gomez',
            'fecha' => '2026-03-31',
            'hora_inicio' => '11:00',
        ]);
    }
}
