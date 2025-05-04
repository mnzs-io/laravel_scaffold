<?php

namespace App\Tools\Cache;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserCache
{
    public static function rolesFrom(User $user)
    {
        // TODO: ADJUST TIME
        return Cache::flexible('roles.user' . $user->id, [5, 10], function () use ($user) {
            return $user->roles->pluck('name');
        });
    }
}
