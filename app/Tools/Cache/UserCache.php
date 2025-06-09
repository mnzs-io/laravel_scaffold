<?php

namespace App\Tools\Cache;

use App\Enums\Role;
use App\Models\Association;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserCache
{
    /**
     * Retorna as associações do usuário com cache.
     */
    public static function associations(User $user)
    {
        return Cache::flexible('user.associations.' . $user->id, [5, 10], function () use ($user) {
            return $user->associations->map(function ($a) {
                $associable = $a->associable;

                return [
                    'role' => $a->role->value,
                    'alias' => self::formattedAliases($a),
                    'associable' => $associable ? [
                        'id' => $associable->id,
                        'type' => class_basename($associable),
                        'name' => $associable->name ?? ($associable->title ?? null),
                        'slug' => $associable->slug ?? str($associable->name ?? ($associable->title ?? '#'))->slug(),
                    ] : null,
                ];
            });
        });
    }

    /**
     * Gera uma lista de aliases formatados para exibição.
     */
    public static function formattedAliases(Association $a): string
    {
        $label = $a->role->value;
        if ($a->role->value === Role::SUPER_ADMIN->value) {
            return 'Super Administrador';
        }

        if ($a->associable) {

            return match ($a->role->value) {
                Role::TEACHER->value => "Professor ({$a->associable->name}/{$a->associable->organization->name})",
                Role::ADMIN->value => "Administrador em {$a->associable->name}",
                Role::CLIENT->value => "Estudante em {$a->associable->name}",
                default => "$label em {$a->associable->name}",
            };
        }

        return $label;
    }

    public static function clear(User $user): void
    {
        Cache::forget('user.associations.' . $user->id);
    }
}
