<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class FixedUsersSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@eventos.com')],
            [
                'name' => 'Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin12345')),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => env('DEV_EMAIL', 'developer@eventos.com')],
            [
                'name' => 'Developer',
                'password' => Hash::make(env('DEV_PASSWORD', 'Dev12345')),
                'role' => 'developer',
            ]
        );
    }
}
