<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class LikeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public function __construct(public string $name) {}

    public function broadcastOn(): Channel
    {
        return new Channel('likes');
    }

    public function broadcastWith(): array
    {
        return ['name' => $this->name];
    }

    public function broadcastAs(): string
    {
        return 'like.received';
    }
}
