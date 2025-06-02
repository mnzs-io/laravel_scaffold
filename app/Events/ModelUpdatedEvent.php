<?php

namespace App\Events;

use App\Contracts\LoggableEvent;
use App\Models\LogEntry;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ModelUpdatedEvent implements LoggableEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(protected Model $model, protected array $before, protected array $after) {}

    public function log(): void
    {
        $log = new LogEntry;
        $log->description('Model updated (' . get_class($this->model) . ')')
            ->ip(request()->ip())
            ->user(Auth::user())
            ->beforeAfter($this->before, $this->after)
            ->commit();
    }
}
