<?php

namespace App\Enums;

enum AuditLogType: string
{
    case NORMAL = 'normal';
    case BEFORE_AFTER = 'before_after';
    case EXCEPTION = 'exception';

    public function label(): string
    {
        return match ($this) {
            self::NORMAL => 'Normal',
            self::BEFORE_AFTER => 'Antes/Depois',
            self::EXCEPTION => 'Exceção',
        };
    }
}
