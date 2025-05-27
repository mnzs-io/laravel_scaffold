<?php

namespace App\Actions;

use App\Enums\AuditLogType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Log;
use Throwable;

abstract class AuditableAction extends Controller
{
    abstract protected function audit(...$args): void;

    public static function log(string $class, string $message, mixed $data = [], string $level = 'info')
    {
        try {
            $auditText = [
                'class' => str_replace('\\', '/', $class),
                'message' => $message,
            ];

            if (!method_exists(Log::channel('auditoria'), $level)) {
                $level = 'info';

            }

            if (is_object($data) && method_exists($data, 'toArray')) {
                $data = $data->toArray();
            }

            if (!is_array($data)) {
                $data = ['data' => $data];
            }

            $user = Context::get('user');

            $data = array_merge($data, ['user' => [
                'id' => $user->id,
                'name' => $user->name,
            ]]);

            Log::channel('auditoria')->{$level}($auditText, [
                'class' => $class,
                'type' => 'audit',
                'data' => $data,
            ]);

        } catch (Throwable $e) {
            Log::channel('auditoria')->error('Erro ao atualizar dados de usuário', [
                'class' => get_class(),
                'type' => AuditLogType::EXCEPTION,
                'data' => [
                    'exception' => $e->getMessage(),
                ],
            ]);
            throw $e;
        }
    }
}
