<?php

namespace App\Policies;

use App\Models\User;

class LogEntryPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // $user->hasRole(Roles::ADMIN);
    }
}
