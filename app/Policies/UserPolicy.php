<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        // Permite que solo los usuarios con el rol 'admin' puedan ver cualquier usuario
        return $user->hasRole('admin');
    }

    public function create(User $user): bool
    {
        // Permite que solo los usuarios con el rol 'admin' puedan crear usuarios
        return $user->hasRole('admin');
    }

    public function update(User $user, User $model): bool
    {
        // Permite que el usuario actualice su propia cuenta o que un administrador actualice cualquier cuenta
        return $user->id === $model->id || $user->hasRole('admin');
    }

    public function delete(User $user, User $model): bool
    {
        // Permite que el usuario elimine su propia cuenta o que un administrador elimine cualquier cuenta
        return $user->id === $model->id || $user->hasRole('admin');
    }
}
