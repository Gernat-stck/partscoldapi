<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Users;

class UserPolicy
{
    public function viewAny(Users $user): bool
    {
        // Permite que solo los usuarios con el rol 'admin' puedan ver cualquier usuario
        return $user->hasRole('admin');
    }

    public function create(Users $user): bool
    {
        // Permite que solo los usuarios con el rol 'admin' puedan crear usuarios
        return $user->hasRole('admin');
    }

    public function update(Users $user, Users $model): bool
    {
        // Permite que el usuario actualice su propia cuenta o que un administrador actualice cualquier cuenta
        return $user->id === $model->id || $user->hasRole('admin');
    }

    public function delete(Users $user, Users $model): bool
    {
        // Permite que el usuario elimine su propia cuenta o que un administrador elimine cualquier cuenta
        return $user->id === $model->id || $user->hasRole('admin');
    }
}
