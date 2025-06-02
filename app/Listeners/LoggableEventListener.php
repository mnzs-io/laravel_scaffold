<?php

namespace App\Listeners;

use App\Contracts\LoggableEvent;
use App\Tools\Cache\ShouldLog;

class LoggableEventListener
{
    public function handle(LoggableEvent $event): void
    {
        if (ShouldLog::event($event)) {
            $event->log();
        }
    }
}
