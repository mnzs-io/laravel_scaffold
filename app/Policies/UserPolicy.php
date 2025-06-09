<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    public function view(User $user, User $model): bool
    {
        return ($user->id === $model->id) || $user->hasRole(Role::ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    public function update(User $user, User $model): bool
    {
        return ($user->id === $model->id) || $user->hasRole(Role::ADMIN);
    }

    public function activate(User $user, User $model): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasRole(Role::ADMIN);
    }
}
