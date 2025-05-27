<?php

namespace App\Log;

use App\Models\LogEntry;
use Exception;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class AuditLogHandler extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        try {
            $context = $record->context;

            $log = LogEntry::make()
                ->system($context['origin'] ?? config('app.name'))
                ->user($context['user'] ?? 'system')
                ->description($record->message)
                ->level($record->level->getName())
                ->ip(request()->ip() ?? '127.0.0.1')
                ->resources($context['resources'] ?? []);

            match ($context['type'] ?? 'raw') {
                'raw' => $log->raw($context['data']['message'] ?? 'Message not provided'),
                'insert' => $log->insert($context['data']['after'] ?? []),
                'beforeAfter' => $log->beforeAfter(
                    $context['data']['before'] ?? [],
                    $context['data']['after'] ?? []
                ),
                'remove' => $log->remove($context['data']['before'] ?? []),
                'read' => $log->read(
                    $context['data']['profiles'] ?? [],
                    $context['data']['reason'] ?? 'not informed'
                ),
                default => $log->raw(json_encode($context['data'] ?? [])),
            };

            $log->saveLog();
        } catch (Exception $e) {
            Log::error('Failed to write audit log: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
        }
    }
}
