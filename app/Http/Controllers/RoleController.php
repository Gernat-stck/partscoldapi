<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
class RoleController extends Controller
{
    public function create(Request $request)
    {
        // Validar el request
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        // Crear el rol
     //   $role = Role::create(['name' => $request->name]);

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->back()->with('success', 'Rol creado exitosamente');
    }

    public function assign(Request $request)
    {
        // Validar el request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_name' => 'required|exists:roles,name',
        ]);

        // Obtener el usuario y el rol
        $user = User::findOrFail($request->user_id);
        $role = Role::findByName($request->role_name);

        // Asignar el rol al usuario
        $user->assignRole($role);

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->back()->with('success', 'Rol asignado exitosamente');
    }
}
