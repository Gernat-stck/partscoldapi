<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        // Crear el rol de administrador
        Role::create(['name' => 'admin', 'guard_name' => 'api']);

        // Crear el usuario administrador
        User::create([
            'name' => 'Admin User',
            'user_name' => 'admin',
            'password' => bcrypt('contra152'), // Cambia 'password' por la contraseña que quieras
            'role' => 'admin'
        ]);

        // Asignar el rol de administrador al usuario administrador
        //  $admin->assignRole($adminRole);

    }
}
