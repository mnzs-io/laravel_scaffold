<?php

namespace App\Events;

use App\Contracts\LoggableEvent;
use App\Enums\AuditLogLevel;
use App\Models\LogEntry;
use App\Models\Settings;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SettingsUpdatedEvent implements LoggableEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(protected Settings $setting, protected array $before, protected array $after) {}

    public function log(): void
    {
        $log = new LogEntry;
        $log->description('Settings updated (' . $this->setting->key . ')')
            ->ip(request()->ip())
            ->level(AuditLogLevel::ALERT)
            ->user(Auth::user())
            ->beforeAfter($this->before, $this->after)
            ->commit();
    }
}
