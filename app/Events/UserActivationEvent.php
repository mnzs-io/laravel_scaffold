<?php

namespace App\Events;

use App\Contracts\LoggableEvent;
use App\Models\LogEntry;
use App\Models\User;
use App\Notifications\UserActivationNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActivationEvent implements LoggableEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(protected User $user)
    {
        $this->user->notify(new UserActivationNotification($this->user));
    }

    public function log(): void
    {
        $log = new LogEntry;
        $log->description("User activation ({$this->user->name})")
            ->ip(request()->ip())
            ->user($this->user)
            ->raw("User {$this->user->email} has been activated")
            ->commit();
    }
}
