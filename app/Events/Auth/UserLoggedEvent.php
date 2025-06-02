<?php

namespace App\Events\Auth;

use App\Contracts\LoggableEvent;
use App\Models\LogEntry;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLoggedEvent implements LoggableEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(protected User $user) {}

    public function handle(): void
    {
        info('User logged event handle');
    }

    public function log(): void
    {
        $log = new LogEntry;
        $log->description("User's login ({$this->user->name})")
            ->ip(request()->ip())
            ->user($this->user)
            ->raw("User {$this->user->email} logged")
            ->commit();
    }
}
