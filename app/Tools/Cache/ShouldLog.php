<?php

namespace App\Tools\Cache;

use App\Contracts\LoggableEvent;
use App\Models\Settings;

class ShouldLog
{
    public static function event(LoggableEvent $event)
    {
        $key = class_basename(get_class($event));

        return Settings::test($key);
    }
}
