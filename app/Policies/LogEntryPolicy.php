<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class LogEntryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::ADMIN);
    }
}
