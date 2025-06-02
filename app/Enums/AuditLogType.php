<?php

namespace App\Enums;

enum AuditLogType: string
{
    case RAW = 'raw';
    case BEFORE_AFTER = 'beforeAfter';
    case REMOVE = 'remove';
    case INSERT = 'insert';
    case EVENT = 'event';
    case READ = 'read';

    public function label(): string
    {
        return match ($this) {
            self::RAW => 'Bruto',
            self::BEFORE_AFTER => 'Antes/Depois',
            self::REMOVE => 'Remoção',
            self::EVENT => 'Evento',
            self::INSERT => 'Inserção',
            self::READ => 'Leitura',
        };
    }
}
