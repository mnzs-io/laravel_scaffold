<?php

namespace App\Enums;

enum Role: string
{
    case SUPER_ADMIN = 'SUPER_ADMIN';
    case ADMIN = 'ADMIN';
    case CLIENT = 'CLIENT';
    case TEACHER = 'TEACHER';
    case STUDENT = 'STUDENT';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Administrador',
            self::ADMIN => 'Administrador da Organização',
            self::CLIENT => 'Cliente',
            self::TEACHER => 'Professor',
            self::STUDENT => 'Estudante',
        };
    }

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
