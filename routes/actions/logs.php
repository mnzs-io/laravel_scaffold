<?php

use App\Actions\Logs\LogsIndexAction;
use App\Http\Controllers\PageController;
use App\Models\LogEntry;

use function App\Support\{get, middleware};

middleware('web.authenticated', function () {

    get('/logs/lista', LogsIndexAction::class)
        ->can('viewAny', LogEntry::class)
        ->name('get.logs.index');

    get('/log', [PageController::class, 'log']);

});
