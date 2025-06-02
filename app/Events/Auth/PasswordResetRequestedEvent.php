<?php

namespace App\Events\Auth;

use App\Enums\AuditLogLevel;
use App\Events\LoggableEvent;
use App\Models\LogEntry;
use App\Models\User;
use App\Notifications\PasswordResetSignedNotification;
use App\Tools\Cache\ShouldLog;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordResetRequestedEvent extends LoggableEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(protected User $user)
    {
        $this->user->notify(new PasswordResetSignedNotification($this->user));
    }

    protected function log()
    {
        info('will log password reset');
        // if (ShouldLog::event(PasswordResetRequestedEvent::class)) {
        //     $log = new LogEntry;
        //     $log->level(AuditLogLevel::INFO)
        //         ->ip(request()->ip())
        //         ->event('password_reset', [
        //             'user' => [
        //                 'id' => $user->id,
        //                 'name' => $user->name,
        //                 'email' => $user->email,
        //             ],
        //         ]);
        // }
    }
}
