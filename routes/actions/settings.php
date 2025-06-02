<?php

use App\Actions\Settings\UpdateSettingsAction;
use App\Http\Controllers\SettingsController;
use App\Models\Settings;

use function App\Support\get;
use function App\Support\middleware;
use function App\Support\put;

middleware('web.authenticated', function () {

    get('/config', [SettingsController::class, 'index'])
        ->name('get.settings.index')
        ->can('operate', Settings::class);

    put('/config/change/{setting}', UpdateSettingsAction::class)
        ->name('put.settings.update')
        ->can('operate', Settings::class);

});
