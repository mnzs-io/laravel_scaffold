<?php

namespace App\Tools;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DBListener
{
    public static function register()
    {
        DB::listen(
            function ($query) {
                $start = microtime(true);

                Log::channel('db')->info(
                    $query->sql,
                    $query->bindings,
                    $query->time
                );
                $time = microtime(true) - $start;
                $timeInMilliSec = round($time * 1000, 2);
                Log::channel('db')->info('Tempo de execução: ' . $timeInMilliSec . 'ms');
            }
        );
    }
}
