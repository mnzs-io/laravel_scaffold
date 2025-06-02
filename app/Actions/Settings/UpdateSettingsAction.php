<?php

namespace App\Actions\Settings;

use App\Events\SettingsUpdatedEvent;
use App\Models\Settings;
use App\Models\User;
use App\Traits\ApiResponses;
use App\Traits\HybridResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UpdateSettingsAction
{
    use ApiResponses, HybridResponse;

    private User $user;

    public function __invoke(Settings $setting, Request $request)
    {
        try {
            DB::beginTransaction();
            $antes = $setting->toArray();
            $setting->value = $request->value;
            $setting->save();
            $depois = $setting->toArray();
            if ($setting->key === 'SettingsUpdatedEvent') {
                (new SettingsUpdatedEvent($setting, $antes, $depois))->log();
            } else {
                SettingsUpdatedEvent::dispatch($setting, $antes, $depois);
            }
            $this->refreshSettingsCache();
            DB::commit();

            return $this->respond($request);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->error($e->getMessage());
        }
    }

    protected function inertia()
    {
        return back()->with([
            'success' => true,
        ]);
    }

    protected function json()
    {
        return response()->json([
            'success' => true,
        ]);
    }

    private function refreshSettingsCache(): void
    {
        Cache::forget('settings');

        Cache::rememberForever('settings', function () {
            return Settings::query()
                ->get()
                ->mapWithKeys(fn ($setting) => [$setting->key => $setting->value])
                ->toArray();
        });
    }
}
