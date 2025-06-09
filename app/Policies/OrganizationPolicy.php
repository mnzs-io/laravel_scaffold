<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\MemoryCards\Organization;
use App\Models\User;

class OrganizationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    public function view(User $user, Organization $organization): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    public function update(User $user, Organization $organization): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN) || $user->hasRole(Role::ADMIN, Organization::class, $organization->id);
    }

    public function deactivate(User $user, Organization $organization): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }
}
