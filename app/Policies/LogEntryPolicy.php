<?php

namespace App\Policies;

use App\Enums\Roles;
use App\Models\User;

class LogEntryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }
}
