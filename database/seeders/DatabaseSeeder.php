<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1) Crear usuarios fijos (admin y developer)
        $this->call([
            FixedUsersSeeder::class,
        ]);

        // 2) Crear usuario de prueba con password conocido
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'), // <-- clave conocida
        ]);

        // (Opcional) crear más usuarios random
        // User::factory(10)->create();
    }
}
