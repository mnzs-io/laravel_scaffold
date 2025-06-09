<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class SettingsPolicy
{
    public function operate(User $user): bool
    {
        return $user->hasRole(Role::ADMIN);
    }
}
