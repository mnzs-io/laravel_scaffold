<?php

namespace App\Enums;

class Roles
{
    public const ADMIN = 'ADMIN';

    public const CLIENT = 'CLIENT';

    public static function all(): array
    {
        return [
            self::ADMIN,
            self::CLIENT,
        ];
    }
}
