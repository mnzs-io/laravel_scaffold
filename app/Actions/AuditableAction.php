<?php

namespace App\Actions;

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
            Log::channel('auditoria')->{$level}(json_encode([
                'header' => $auditText,
                'data' => $data,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                ],
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        } catch (Throwable $e) {
            info('Erro ao logar em auditoria: ' . $e->getMessage());
        }
    }
}
