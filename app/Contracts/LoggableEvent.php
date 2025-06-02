<?php

namespace App\Contracts;

interface LoggableEvent
{
    public function log(): void;
}
