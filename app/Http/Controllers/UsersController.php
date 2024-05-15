<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function search($field, $query)
    {
        $user = User::where($field, $query)->first();

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function store(Request $request)
    {
        // Define las reglas de validación
        $validator = Validator::make($request->all(), [
            '*.name' => 'required|string|max:255',
            '*.user_name' => 'required|string|max:255|unique:users,user_name',
            '*.password' => 'required|string|min:8',
        ]);

        // Verifica si la validación falla
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $createdUsers = [];

        // Itera sobre cada conjunto de datos del usuario
        foreach ($request->all() as $userData) {
            // Hashea la contraseña antes de crear el usuario
            $userData['password'] = Hash::make($userData['password']);
            $user = User::create($userData);
            $createdUsers[] = $user;
        }

        return response()->json($createdUsers, 201);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Define las reglas de validación para la actualización
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'user_name' => 'sometimes|required|string|max:255|unique:users,user_name,' . $user->id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        // Verifica si la validación falla
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Hashea la nueva contraseña si se proporciona
        if ($request->has('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        // Actualizar los datos del usuario
        $user->update($request->all());

        return response()->json($user);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
