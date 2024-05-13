<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear el rol de administrador

        // Crear el usuario administrador
        User::create([
            'name' => 'Admin User',
            'user_name' => 'admin',
            'password' => bcrypt('contra152'), // Cambia 'password' por la contraseña que quieras
            'role' => 'admin'
        ]);
    }
}
