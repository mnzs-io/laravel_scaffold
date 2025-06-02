<?php

namespace App\Log;

use App\Enums\AuditLogLevel;
use App\Enums\AuditLogType;
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
            $level = AuditLogLevel::from(strtolower($record->level->name));

            $log = LogEntry::make()
                ->system($context['origin'] ?? config('app.name'))
                ->user($context['user'] ?? 'system')
                ->description($record->message)
                ->level($level)
                ->ip(request()->ip() ?? '127.0.0.1')
                ->resources($context['resources'] ?? []);

            if (!empty($context['fake_collection'])) {
                $table = config('app.log.collection') . '_fake_log_collection';
                $log->setTable($table);
            }

            $type = $context['type'] instanceof AuditLogType
            ? $context['type']
            : AuditLogType::tryFrom($context['type'] ?? 'raw') ?? AuditLogType::RAW;
            match ($type) {
                AuditLogType::RAW => $log->raw($context['data']['message'] ?? 'Message not provided'),
                AuditLogType::INSERT => $log->insert($context['data']['after'] ?? []),
                AuditLogType::BEFORE_AFTER => $log->beforeAfter(
                    $context['data']['before'] ?? [],
                    $context['data']['after'] ?? []
                ),
                AuditLogType::REMOVE => $log->remove($context['data']['before'] ?? []),
                AuditLogType::READ => $log->read(
                    $context['data']['profiles'] ?? [],
                    $context['data']['reason'] ?? 'not informed'
                ),
                AuditLogType::EVENT => $log->event(
                    $context['data']['event'] ?? 'unknown',
                    $context['data'] ?? []
                ),
            };

            $log->commit();
        } catch (Exception $e) {
            Log::error('Failed to write audit log: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
        }
    }
}
