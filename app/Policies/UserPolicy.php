<?php

namespace App\Policies;

use App\Enums\Roles;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function view(User $user, User $model): bool
    {
        return ($user->id === $model->id) || $user->hasRole(Roles::ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function update(User $user, User $model): bool
    {
        return ($user->id === $model->id) || $user->hasRole(Roles::ADMIN);
    }

    public function activate(User $user, User $model): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }
}
