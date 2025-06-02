<?php

namespace App\Enums;

enum AuditLogLevel: string
{
    case EMERGENCY = 'emergency';
    case ALERT = 'alert';
    case CRITICAL = 'critical';
    case ERROR = 'error';
    case WARNING = 'warning';
    case NOTICE = 'notice';
    case INFO = 'info';
    case DEBUG = 'debug';

    public function label(): string
    {
        return match ($this) {
            self::EMERGENCY => 'Emergência',
            self::ALERT => 'Alerta Imediato',
            self::CRITICAL => 'Crítico',
            self::ERROR => 'Erro',
            self::WARNING => 'Aviso',
            self::NOTICE => 'Notificação',
            self::INFO => 'Informação',
            self::DEBUG => 'Depuração',
        };
    }
}
