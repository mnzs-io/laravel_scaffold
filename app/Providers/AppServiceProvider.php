<?php

namespace App\Providers;

use App\Models\Settings;
use App\Tools\ApaPtBr;
use App\Tools\DBListener;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        $this->startWithSettingsCache();
        $this->logDbQueriesIfSetTo();
    }

    private function startWithSettingsCache()
    {
        // TODO: Aumentar tempo de cache
        if (Schema::hasTable('settings')) {
            Cache::flexible('settings', [5, 10], function () {
                return DB::table('settings')
                    ->pluck('value', 'key')
                    ->map(function ($value) {
                        if ($value === 'true') {
                            return true;
                        } elseif ($value === 'false') {
                            return false;
                        }
                        if (is_numeric($value)) {
                            return (int) $value;
                        }

                        return $value;
                    })
                    ->toArray();
            });
        }
    }

    private function logDbQueriesIfSetTo()
    {
        if (Settings::test('LOG_DB_QUERIES')) {
            DBListener::register();
        }
    }
}
