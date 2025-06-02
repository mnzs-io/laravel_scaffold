<?php

namespace App\Policies;

use App\Enums\Roles;
use App\Models\User;

class SettingsPolicy
{
    public function operate(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }
}
