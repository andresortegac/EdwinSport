<?php

namespace Database\Seeders;

use App\Models\Cancha;
use Illuminate\Database\Seeder;

class CanchaSeeder extends Seeder
{
    public function run(): void
    {
        $canchas = [
            [
                'nombre' => 'Cancha Central',
                'descripcion' => 'Cancha principal para partidos y reservas generales.',
                'num_canchas' => 2,
                'ubicacion' => 'Barranquilla, sede norte',
                'ciudad' => 'Barranquilla',
                'subdominio' => 'bombonera',
                'integration_identifier' => 'bombonera-main',
                'api_base_url' => 'http://127.0.0.1:8000',
                'integration_token' => 'bombonera-token',
                'telefono_contacto' => '3000000001',
                'hora_apertura' => '07:00:00',
                'hora_cierre' => '22:00:00',
            ],
            [
                'nombre' => 'Cancha Libertadores',
                'descripcion' => 'Espacio ideal para futbol 5 y entrenamientos.',
                'num_canchas' => 3,
                'ubicacion' => 'Barranquilla, sede centro',
                'ciudad' => 'Barranquilla',
                'subdominio' => 'champions',
                'integration_identifier' => 'champions-main',
                'api_base_url' => 'http://127.0.0.1:8000',
                'integration_token' => 'champions-token',
                'telefono_contacto' => '3000000002',
                'hora_apertura' => '08:00:00',
                'hora_cierre' => '23:00:00',
            ],
            [
                'nombre' => 'Cancha del Sol',
                'descripcion' => 'Cancha sintetica para reservas familiares y torneos cortos.',
                'num_canchas' => 2,
                'ubicacion' => 'Soledad, plaza deportiva',
                'ciudad' => 'Soledad',
                'subdominio' => 'delsol',
                'integration_identifier' => 'delsol-main',
                'api_base_url' => null,
                'integration_token' => null,
                'telefono_contacto' => '3000000003',
                'hora_apertura' => '06:00:00',
                'hora_cierre' => '21:00:00',
            ],
            [
                'nombre' => 'Cancha Titanes',
                'descripcion' => 'Escenario para escuelas deportivas y alquiler por horas.',
                'num_canchas' => 4,
                'ubicacion' => 'Malambo, complejo deportivo',
                'ciudad' => 'Malambo',
                'subdominio' => 'titanes',
                'integration_identifier' => 'titanes-main',
                'api_base_url' => null,
                'integration_token' => null,
                'telefono_contacto' => '3000000004',
                'hora_apertura' => '07:30:00',
                'hora_cierre' => '22:30:00',
            ],
            [
                'nombre' => 'Cancha Arena Sport',
                'descripcion' => 'Cancha multiproposito para amistosos y practicas.',
                'num_canchas' => 1,
                'ubicacion' => 'Puerto Colombia, zona deportiva',
                'ciudad' => 'Puerto Colombia',
                'subdominio' => 'arenasport',
                'integration_identifier' => 'arenasport-main',
                'api_base_url' => null,
                'integration_token' => null,
                'telefono_contacto' => '3000000005',
                'hora_apertura' => '09:00:00',
                'hora_cierre' => '20:00:00',
            ],
        ];

        foreach ($canchas as $cancha) {
            Cancha::updateOrCreate(
                ['nombre' => $cancha['nombre']],
                $cancha
            );
        }
    }
}
