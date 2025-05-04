<?php

namespace App\Providers;

use App\Tools\ApaPtBr;
use App\Tools\DBListener;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment('local')) {
        }
    }

    public function boot(): void
    {
        ApaPtBr::register();
        DBListener::register();
    }
}
